<?php
declare(strict_types=1);

namespace App\Core;

use RuntimeException;

/**
 * Secure image uploads.
 *
 * - Validates the upload error code, size, real MIME type (finfo) and image dimensions.
 * - Re-encodes every image with GD (strips metadata and any embedded payload).
 * - Saves an optimised WebP (max 1600px) plus 600px and 300px variants for srcset,
 *   and a 600px JPEG used for e-mails and social sharing.
 * - Generates random filenames; the original filename is never used on disk.
 */
final class Uploader
{
    private const ALLOWED = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
    ];

    /**
     * Normalise $_FILES['x'] (single or multiple) into a list of file arrays.
     * @return array<int, array{name:string,type:string,tmp_name:string,error:int,size:int}>
     */
    public static function files(string $field): array
    {
        $f = $_FILES[$field] ?? null;
        if (!$f) {
            return [];
        }
        if (!is_array($f['name'])) {
            return ($f['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE ? [] : [$f];
        }
        $out = [];
        foreach ($f['name'] as $i => $name) {
            if (($f['error'][$i] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
                continue;
            }
            $out[] = [
                'name' => $name,
                'type' => $f['type'][$i],
                'tmp_name' => $f['tmp_name'][$i],
                'error' => $f['error'][$i],
                'size' => $f['size'][$i],
            ];
        }
        return $out;
    }

    public static function has(string $field): bool
    {
        return self::files($field) !== [];
    }

    /**
     * Upload a single image from $_FILES[$field] into uploads/$dir.
     * Returns the stored relative path, or null when no file was sent.
     * @throws RuntimeException with a user-friendly message on invalid files.
     */
    public static function image(string $field, string $dir, int $maxWidth = 1600): ?string
    {
        $files = self::files($field);
        if (!$files) {
            return null;
        }
        return self::store($files[0], $dir, $maxWidth);
    }

    /** @return string[] */
    public static function images(string $field, string $dir, int $maxWidth = 1600): array
    {
        $paths = [];
        foreach (self::files($field) as $file) {
            $paths[] = self::store($file, $dir, $maxWidth);
        }
        return $paths;
    }

    public static function store(array $file, string $dir, int $maxWidth = 1600, bool $isUpload = true): string
    {
        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            throw new RuntimeException(self::errorMessage((int) $file['error']));
        }
        $max = (int) config('upload_max_bytes', 5 * 1024 * 1024);
        if ($file['size'] > $max) {
            throw new RuntimeException('Image is too large. Maximum size is ' . round($max / 1048576, 1) . ' MB.');
        }
        if ($isUpload && !is_uploaded_file($file['tmp_name'])) {
            throw new RuntimeException('Invalid upload.');
        }
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        if (!isset(self::ALLOWED[$mime])) {
            throw new RuntimeException('Only JPG, PNG, WebP or GIF images are allowed.');
        }
        $info = @getimagesize($file['tmp_name']);
        if (!$info || $info[0] < 1 || $info[1] < 1 || $info[0] > 8000 || $info[1] > 8000) {
            throw new RuntimeException('The file is not a valid image (max 8000×8000 px).');
        }
        $src = match ($mime) {
            'image/jpeg' => @imagecreatefromjpeg($file['tmp_name']),
            'image/png' => @imagecreatefrompng($file['tmp_name']),
            'image/webp' => @imagecreatefromwebp($file['tmp_name']),
            'image/gif' => @imagecreatefromgif($file['tmp_name']),
        };
        if (!$src) {
            throw new RuntimeException('The image could not be processed.');
        }
        if ($mime === 'image/jpeg') {
            $src = self::fixOrientation($src, $file['tmp_name']);
        }
        $dir = trim(preg_replace('~[^a-z0-9/_-]~', '', strtolower($dir)), '/');
        $target = UPLOAD_PATH . '/' . $dir;
        if (!is_dir($target) && !mkdir($target, 0755, true) && !is_dir($target)) {
            throw new RuntimeException('Upload directory is not writable.');
        }
        $name = date('Ym') . '-' . bin2hex(random_bytes(8));
        self::saveVariants($src, $target . '/' . $name, $maxWidth);
        imagedestroy($src);
        return $dir . '/' . $name . '.webp';
    }

    /** Write <base>.webp, <base>-600.webp, <base>-300.webp and <base>-600.jpg. */
    public static function saveVariants(\GdImage $src, string $base, int $maxWidth = 1600): void
    {
        $full = self::resize($src, $maxWidth);
        imagewebp($full, $base . '.webp', 84);
        $mid = self::resize($src, 600);
        imagewebp($mid, $base . '-600.webp', 82);
        $jpg = self::flatten($mid);
        imagejpeg($jpg, $base . '-600.jpg', 82);
        $thumb = self::resize($src, 300);
        imagewebp($thumb, $base . '-300.webp', 80);
        foreach ([$full, $mid, $jpg, $thumb] as $im) {
            if ($im !== $src) {
                imagedestroy($im);
            }
        }
    }

    /** Delete an uploaded image and all of its variants. */
    public static function delete(?string $path): void
    {
        if (!$path || str_contains($path, '..')) {
            return;
        }
        $base = UPLOAD_PATH . '/' . preg_replace('~\.webp$~', '', $path);
        foreach (['.webp', '-600.webp', '-300.webp', '-600.jpg'] as $suffix) {
            if (is_file($base . $suffix)) {
                @unlink($base . $suffix);
            }
        }
    }

    private static function resize(\GdImage $src, int $maxWidth): \GdImage
    {
        $w = imagesx($src);
        $h = imagesy($src);
        if ($w <= $maxWidth) {
            $copy = imagecreatetruecolor($w, $h);
            imagealphablending($copy, false);
            imagesavealpha($copy, true);
            imagecopy($copy, $src, 0, 0, 0, 0, $w, $h);
            return $copy;
        }
        $nh = (int) round($h * $maxWidth / $w);
        $dst = imagecreatetruecolor($maxWidth, $nh);
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $maxWidth, $nh, $w, $h);
        return $dst;
    }

    private static function flatten(\GdImage $im): \GdImage
    {
        $w = imagesx($im);
        $h = imagesy($im);
        $bg = imagecreatetruecolor($w, $h);
        imagefill($bg, 0, 0, imagecolorallocate($bg, 237, 235, 221));
        imagealphablending($bg, true);
        imagecopy($bg, $im, 0, 0, 0, 0, $w, $h);
        return $bg;
    }

    private static function fixOrientation(\GdImage $im, string $file): \GdImage
    {
        if (!function_exists('exif_read_data')) {
            return $im;
        }
        $exif = @exif_read_data($file);
        $o = (int) ($exif['Orientation'] ?? 1);
        $rotated = match ($o) {
            3 => imagerotate($im, 180, 0),
            6 => imagerotate($im, -90, 0),
            8 => imagerotate($im, 90, 0),
            default => null,
        };
        return $rotated ?: $im;
    }

    private static function errorMessage(int $code): string
    {
        return match ($code) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'Image is larger than the server allows.',
            UPLOAD_ERR_PARTIAL => 'The image was only partially uploaded. Please try again.',
            default => 'The image could not be uploaded.',
        };
    }
}
