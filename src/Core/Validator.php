<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Server-side validation.
 *
 * Rules (pipe separated): required, email, phone, numeric, integer, min:n, max:n,
 * between:a,b, confirmed, in:a,b,c, unique:table,column[,ignoreId], slug, url,
 * date, password (8+ chars incl. letter & number), accepted, hex.
 */
final class Validator
{
    private array $errors = [];

    public function __construct(private array $data, private array $rules, private array $labels = [])
    {
    }

    public static function make(array $data, array $rules, array $labels = []): self
    {
        $v = new self($data, $rules, $labels);
        $v->run();
        return $v;
    }

    public function fails(): bool
    {
        return $this->errors !== [];
    }

    public function errors(): array
    {
        return $this->errors;
    }

    private function label(string $field): string
    {
        return $this->labels[$field] ?? ucfirst(str_replace('_', ' ', $field));
    }

    private function run(): void
    {
        foreach ($this->rules as $field => $ruleString) {
            $rules = is_array($ruleString) ? $ruleString : explode('|', $ruleString);
            $value = $this->data[$field] ?? null;
            if (is_string($value)) {
                $value = trim($value);
            }
            $isEmpty = $value === null || $value === '' || $value === [];

            foreach ($rules as $rule) {
                [$name, $param] = array_pad(explode(':', $rule, 2), 2, null);
                if ($name === 'nullable') {
                    continue;
                }
                if ($name === 'required') {
                    if ($isEmpty) {
                        $this->errors[$field] = $this->label($field) . ' is required.';
                        break;
                    }
                    continue;
                }
                if ($name === 'accepted') {
                    if (!in_array($value, ['1', 'on', 'yes', 1, true], true)) {
                        $this->errors[$field] = 'You must accept the ' . strtolower($this->label($field)) . '.';
                        break;
                    }
                    continue;
                }
                if ($isEmpty) {
                    // Remaining rules only apply when a value is present.
                    break;
                }
                $error = $this->check($name, $param, $value, $field);
                if ($error !== null) {
                    $this->errors[$field] = $error;
                    break;
                }
            }
        }
    }

    private function check(string $name, ?string $param, mixed $value, string $field): ?string
    {
        $label = $this->label($field);
        $str = is_scalar($value) ? (string) $value : '';
        switch ($name) {
            case 'email':
                return filter_var($str, FILTER_VALIDATE_EMAIL) ? null : 'Please enter a valid email address.';
            case 'phone':
                $digits = preg_replace('/\D+/', '', $str);
                return (strlen($digits) >= 10 && strlen($digits) <= 15) ? null : 'Please enter a valid phone number.';
            case 'numeric':
                return is_numeric($str) ? null : "{$label} must be a number.";
            case 'integer':
                return preg_match('/^-?\d+$/', $str) ? null : "{$label} must be a whole number.";
            case 'min':
                if (is_numeric($str) && $this->isNumericRule($field)) {
                    return (float) $str >= (float) $param ? null : "{$label} must be at least {$param}.";
                }
                return mb_strlen($str) >= (int) $param ? null : "{$label} must be at least {$param} characters.";
            case 'max':
                if (is_numeric($str) && $this->isNumericRule($field)) {
                    return (float) $str <= (float) $param ? null : "{$label} may not be greater than {$param}.";
                }
                return mb_strlen($str) <= (int) $param ? null : "{$label} may not exceed {$param} characters.";
            case 'between':
                [$a, $b] = explode(',', (string) $param);
                return ((float) $str >= (float) $a && (float) $str <= (float) $b) ? null : "{$label} must be between {$a} and {$b}.";
            case 'confirmed':
                return $str === (string) ($this->data[$field . '_confirmation'] ?? '') ? null : "{$label} confirmation does not match.";
            case 'in':
                return in_array($str, explode(',', (string) $param), true) ? null : "Please choose a valid {$label}.";
            case 'slug':
                return preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $str) ? null : "{$label} may only contain lowercase letters, numbers and dashes.";
            case 'url':
                return filter_var($str, FILTER_VALIDATE_URL) || str_starts_with($str, '/') || str_starts_with($str, '#') ? null : "{$label} must be a valid URL.";
            case 'date':
                return strtotime($str) !== false ? null : "{$label} must be a valid date.";
            case 'hex':
                return preg_match('/^#[0-9a-fA-F]{6}$/', $str) ? null : "{$label} must be a hex colour like #810100.";
            case 'password':
                return (mb_strlen($str) >= 8 && preg_match('/[A-Za-z]/', $str) && preg_match('/\d/', $str))
                    ? null : 'Password must be at least 8 characters and include a letter and a number.';
            case 'unique':
                $parts = explode(',', (string) $param);
                $table = $parts[0];
                $column = $parts[1] ?? $field;
                $ignore = isset($parts[2]) ? (int) $parts[2] : 0;
                if (!preg_match('/^\w+$/', $table) || !preg_match('/^\w+$/', $column)) {
                    return 'Invalid validation rule.';
                }
                $compare = $column === 'email' ? strtolower($str) : ($column === 'phone' ? preg_replace('/\D+/', '', $str) : $str);
                $exists = DB::value("SELECT COUNT(*) FROM `{$table}` WHERE `{$column}` = :v AND id <> :id", ['v' => $compare, 'id' => $ignore]);
                return (int) $exists === 0 ? null : "This {$label} is already registered.";
            case 'string':
                return null;
        }
        return null;
    }

    private function rulesFor(string $field): array
    {
        $r = $this->rules[$field] ?? [];
        return is_array($r) ? $r : explode('|', $r);
    }

    private function isNumericRule(string $field): bool
    {
        $r = $this->rulesFor($field);
        return in_array('numeric', $r, true) || in_array('integer', $r, true);
    }
}
