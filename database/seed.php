<?php
/**
 * Demo/starter content for Savié Amour.
 *
 * Product images under public/uploads/<dir>/demo-*.webp are illustrated
 * placeholders in the brand palette — replace them from Admin → Products with
 * real photography. Contact details, testimonials and policy texts are
 * placeholders too and must be reviewed before launch.
 */
declare(strict_types=1);

use App\Core\DB;
use App\Core\Settings;

return static function (): void {
    $now = date('Y-m-d H:i:s');
    $ago = static fn(int $days) => date('Y-m-d H:i:s', strtotime("-{$days} days"));

    // ------------------------------------------------------------ settings
    $settings = [
        'general' => [
            'site_name' => 'Savié Amour',
            'site_tagline' => 'the art of beauty',
            'site_email' => 'hello@savieamour.com',
            'site_phone' => '+91 98200 00000',
            'whatsapp_number' => '919820000000',
            'site_address' => "Savié Amour Studio\nBandra West, Mumbai 400050\nMaharashtra, India",
            'business_hours' => 'Mon – Sat, 10:00 am – 7:00 pm IST',
            'announcement_messages' => "Complimentary shipping on orders above ₹999\nNew — Velvet Lip & Cheek Tint in four shades\nUse code AMOUR15 for 15% off the Bridal Edit",
            'footer_about' => 'Savié Amour crafts ritual-inspired colour — sacred vermilion, velvet tints and kohl as deep as noir — for beauty that lingers.',
            'copyright_text' => '© {year} Savié Amour. All rights reserved.',
            'logo' => '', 'logo_light' => '', 'favicon' => '',
            'currency_code' => 'INR', 'currency_symbol' => '₹',
            'products_per_page' => '12', 'low_stock_threshold' => '5', 'guest_checkout' => '1',
            'review_auto_approve' => '0', 'order_prefix' => 'SA', 'default_country' => 'India',
        ],
        'social' => [
            'instagram_url' => 'https://www.instagram.com/savieamour',
            'instagram_handle' => '@savieamour',
            'facebook_url' => 'https://www.facebook.com/savieamour',
            'youtube_url' => '',
            'pinterest_url' => 'https://www.pinterest.com/savieamour',
            'x_url' => '',
        ],
        'shipping' => [
            'shipping_enabled' => '1', 'shipping_flat_rate' => '79', 'free_shipping_threshold' => '999',
            'cod_enabled' => '1', 'cod_fee' => '0', 'delivery_estimate' => 'Delivered in 3–7 business days across India',
        ],
        'tax' => ['tax_enabled' => '1', 'tax_label' => 'GST', 'tax_rate' => '18', 'prices_include_tax' => '1', 'gstin' => ''],
        'payment' => [
            'razorpay_enabled' => '0', 'razorpay_key_id' => '', 'razorpay_key_secret' => '', 'razorpay_webhook_secret' => '',
        ],
        'email' => [
            'mail_driver' => 'log', 'mail_from_address' => 'hello@savieamour.com', 'mail_from_name' => 'Savié Amour',
            'admin_notification_email' => 'orders@savieamour.com', 'notify_admin_new_order' => '1', 'notify_customer_order_status' => '1',
            'smtp_host' => '', 'smtp_port' => '587', 'smtp_encryption' => 'tls', 'smtp_username' => '', 'smtp_password' => '',
        ],
        'seo' => [
            'meta_title' => 'Savié Amour — The Art of Beauty | Sindoor, Lip Tints, Kohl & Eyeliner',
            'meta_description' => 'Shop ritual-inspired beauty from Savié Amour: liquid & powder sindoor, velvet lip and cheek tints, smudge-proof kohl pencils and precision eyeliners. Free shipping over ₹999.',
            'meta_keywords' => 'sindoor, liquid sindoor, lip tint, cheek tint, kohl pencil, kajal, eyeliner, Indian beauty',
            'google_analytics_id' => '',
        ],
        'home' => [
            'benefits' => json_encode([
                ['icon' => 'leaf', 'title' => 'Cruelty-free & vegan', 'text' => 'Never tested on animals, free of animal-derived ingredients.'],
                ['icon' => 'shield', 'title' => 'Dermatologically tested', 'text' => 'Gentle, skin-safe pigments made for everyday rituals.'],
                ['icon' => 'sparkle', 'title' => 'Long-wear colour', 'text' => 'Smudge-proof formulas that stay true from dawn to dusk.'],
                ['icon' => 'truck', 'title' => 'Free shipping over ₹999', 'text' => 'Fast, insured delivery with Cash on Delivery across India.'],
            ], JSON_UNESCAPED_UNICODE),
        ],
    ];
    foreach ($settings as $group => $items) {
        foreach ($items as $k => $v) {
            Settings::set($k, $v, $group);
        }
    }

    // ------------------------------------------------------------ categories
    $cats = [
        ['Sindoor', 'sindoor', 'Sacred vermilion for every ritual', 'Liquid and powder sindoor in rich, long-lasting vermilion — crafted for daily wear and once-in-a-lifetime moments.', 'categories/demo-sindoor.webp',
            [['Liquid Sindoor', 'liquid-sindoor'], ['Powder Sindoor', 'powder-sindoor']]],
        ['Tints', 'tints', 'Lip & cheek colour that melts in', 'Weightless lip and cheek tints that build from a sheer flush to velvet-rich colour.', 'categories/demo-tints.webp',
            [['Lip & Cheek Tints', 'lip-cheek-tints'], ['Water Tints', 'water-tints']]],
        ['Kohl Pencils', 'kohl-pencils', 'Smudge-proof depth, from noir to emerald', 'Creamy, highly pigmented kohl that glides on and stays put — in classic noir and jewel tones.', 'categories/demo-kohl.webp',
            [['Classic Kohl', 'classic-kohl'], ['Coloured Kohl', 'coloured-kohl'], ['Gift Sets', 'gift-sets']]],
        ['Eyeliner', 'eyeliner', 'Precision lines, velvet finish', 'Liquid and felt-tip liners for the finest flick to the boldest wing.', 'categories/demo-eyeliner.webp',
            [['Liquid Liner', 'liquid-liner'], ['Pen Liner', 'pen-liner']]],
    ];
    $catIds = [];
    $subIds = [];
    foreach ($cats as $i => [$name, $slug, $tagline, $desc, $img, $subs]) {
        $catIds[$slug] = DB::insert('categories', [
            'name' => $name, 'slug' => $slug, 'tagline' => $tagline, 'description' => $desc, 'image' => $img,
            'sort_order' => $i + 1, 'is_active' => 1, 'is_featured' => 1,
            'meta_title' => $name . ' | Savié Amour', 'meta_description' => $desc, 'created_at' => $now,
        ]);
        foreach ($subs as $j => [$sname, $sslug]) {
            $subIds[$sslug] = DB::insert('subcategories', [
                'category_id' => $catIds[$slug], 'name' => $sname, 'slug' => $sslug, 'sort_order' => $j + 1, 'is_active' => 1, 'created_at' => $now,
            ]);
        }
    }

    // ------------------------------------------------------------ products
    $p = static function (array $d) use ($catIds, $subIds, $now): int {
        $key = $d['key'];
        $id = DB::insert('products', [
            'category_id' => $catIds[$d['cat']],
            'subcategory_id' => $subIds[$d['sub']] ?? null,
            'name' => $d['name'],
            'slug' => slugify($d['name']),
            'sku' => $d['sku'],
            'short_description' => $d['short'],
            'description' => $d['desc'],
            'specifications' => json_encode($d['specs'], JSON_UNESCAPED_UNICODE),
            'additional_info' => $d['info'] ?? null,
            'price' => $d['price'],
            'sale_price' => $d['sale'] ?? null,
            'stock_qty' => $d['stock'] ?? 0,
            'stock_status' => 'in_stock',
            'variant_label' => isset($d['variants']) ? ($d['variant_label'] ?? 'Shade') : null,
            'image' => "products/demo-{$key}.webp",
            'hover_image' => "products/demo-{$key}-hover.webp",
            'badge' => $d['badge'] ?? null,
            'is_featured' => (int) ($d['featured'] ?? 0),
            'is_bestseller' => (int) ($d['bestseller'] ?? 0),
            'is_new' => (int) ($d['new'] ?? 0),
            'is_active' => 1,
            'meta_title' => $d['name'] . ' | Savié Amour',
            'meta_description' => $d['short'],
            'sold_count' => $d['sold'] ?? 0,
            'created_at' => date('Y-m-d H:i:s', strtotime('-' . ($d['age'] ?? 30) . ' days')),
        ]);
        $gallery = ["products/demo-{$key}-swatch.webp", "products/demo-{$key}-moody.webp", "products/demo-{$key}-hover.webp"];
        foreach ($gallery as $i => $img) {
            DB::insert('product_images', ['product_id' => $id, 'image' => $img, 'alt' => $d['name'], 'sort_order' => $i + 1, 'created_at' => $now]);
        }
        foreach ($d['variants'] ?? [] as $i => $v) {
            DB::insert('product_variants', [
                'product_id' => $id, 'name' => $v[0], 'swatch' => $v[1], 'sku' => $d['sku'] . '-' . ($i + 1),
                'price' => $v[3] ?? null, 'sale_price' => $v[4] ?? null, 'stock_qty' => $v[2],
                'image' => "variants/demo-{$key}-v" . ($i + 1) . '.webp', 'sort_order' => $i + 1, 'is_active' => 1, 'created_at' => $now,
            ]);
        }
        return $id;
    };

    $commonInfo = '<p><strong>Manufactured &amp; marketed by:</strong> Savié Amour, Mumbai, India.</p><p><strong>Country of origin:</strong> India</p><p>For external use only. Patch test before first use. Store in a cool, dry place away from direct sunlight.</p>';
    $ids = [];
    $ids['liquid-sindoor'] = $p([
        'key' => 'liquid-sindoor', 'cat' => 'sindoor', 'sub' => 'liquid-sindoor', 'sku' => 'SA-SIN-001',
        'name' => 'Sacred Vermilion Liquid Sindoor', 'price' => 449, 'sale' => 399, 'stock' => 64,
        'badge' => 'Best Seller', 'bestseller' => 1, 'featured' => 1, 'sold' => 412, 'age' => 120,
        'short' => 'A long-lasting liquid sindoor in a true, sacred vermilion — one precise stroke that stays vivid all day.',
        'desc' => '<p>Our signature <strong>Sacred Vermilion</strong> is a quick-drying liquid sindoor that sets to a soft, transfer-resistant finish. The slim applicator draws a clean line along the parting in a single stroke.</p><ul><li>Rich, true-red vermilion pigment</li><li>Quick-drying and water-resistant</li><li>Gentle on the scalp; free of lead and mercury</li></ul><p>Worn daily or for once-in-a-lifetime ceremonies, it is colour crafted for rituals that linger.</p>',
        'specs' => [['label' => 'Net quantity', 'value' => '5 ml'], ['label' => 'Finish', 'value' => 'Soft matte'], ['label' => 'Wear time', 'value' => 'Up to 16 hours'], ['label' => 'Skin type', 'value' => 'All skin types'], ['label' => 'Shelf life', 'value' => '24 months']],
        'info' => '<p><strong>How to use:</strong> Shake gently. Draw the applicator along the hair parting in one stroke and let it set for 30 seconds.</p>' . $commonInfo,
    ]);
    $ids['powder-sindoor'] = $p([
        'key' => 'powder-sindoor', 'cat' => 'sindoor', 'sub' => 'powder-sindoor', 'sku' => 'SA-SIN-002',
        'name' => 'Heritage Kumkum Powder Sindoor', 'price' => 549, 'stock' => 38, 'badge' => 'Ritual Essential',
        'featured' => 1, 'sold' => 186, 'age' => 90,
        'short' => 'Finely milled kumkum in an heirloom maroon-and-gold keepsake box.',
        'desc' => '<p>Velvety, finely milled powder sindoor in a deep vermilion, presented in a keepsake box with gold filigree — made to be treasured and gifted.</p><ul><li>Silky, non-gritty texture</li><li>Buildable colour from soft to intense</li><li>Free of lead, mercury and synthetic fragrance</li></ul>',
        'specs' => [['label' => 'Net weight', 'value' => '6 g'], ['label' => 'Finish', 'value' => 'Powder matte'], ['label' => 'Packaging', 'value' => 'Keepsake box with mirror lid'], ['label' => 'Shelf life', 'value' => '36 months']],
        'info' => '<p><strong>How to use:</strong> Dip the tip of the ring finger or a fine brush and press gently along the parting.</p>' . $commonInfo,
    ]);
    $ids['maroon-sindoor'] = $p([
        'key' => 'maroon-sindoor', 'cat' => 'sindoor', 'sub' => 'liquid-sindoor', 'sku' => 'SA-SIN-003',
        'name' => 'Noor Maroon Liquid Sindoor', 'price' => 449, 'stock' => 42, 'new' => 1, 'age' => 6, 'sold' => 24,
        'short' => 'A deep maroon liquid sindoor with a satin sheen — modern, rich and long-wearing.',
        'desc' => '<p><strong>Noor Maroon</strong> brings the depth of our brand colour to a liquid sindoor. Its satin finish catches the light softly, and the quick-dry formula resists smudging.</p>',
        'specs' => [['label' => 'Net quantity', 'value' => '5 ml'], ['label' => 'Finish', 'value' => 'Satin'], ['label' => 'Wear time', 'value' => 'Up to 16 hours'], ['label' => 'Shelf life', 'value' => '24 months']],
        'info' => $commonInfo,
    ]);
    $ids['velvet-tint'] = $p([
        'key' => 'velvet-tint', 'cat' => 'tints', 'sub' => 'lip-cheek-tints', 'sku' => 'SA-TNT-001',
        'name' => 'Velvet Lip & Cheek Tint', 'price' => 699, 'sale' => 599, 'badge' => 'Iconic Shade',
        'bestseller' => 1, 'featured' => 1, 'sold' => 538, 'age' => 75,
        'short' => 'A weightless, blendable tint that gives lips and cheeks a velvety flush of colour.',
        'desc' => '<p>The tint that started it all. A whipped, weightless formula that melts into lips and cheeks, blurring into a natural, velvet-soft finish that lasts all day.</p><ul><li>Two-in-one for lips and cheeks</li><li>Buildable from sheer to vivid</li><li>Enriched with rosehip oil and vitamin E</li></ul>',
        'specs' => [['label' => 'Net quantity', 'value' => '4 ml'], ['label' => 'Finish', 'value' => 'Velvet matte'], ['label' => 'Wear time', 'value' => 'Up to 8 hours'], ['label' => 'Key ingredients', 'value' => 'Rosehip oil, Vitamin E'], ['label' => 'Vegan', 'value' => 'Yes']],
        'info' => '<p><strong>How to use:</strong> Dab onto the centre of the lips and the apples of the cheeks, then blend with fingertips.</p>' . $commonInfo,
        'variants' => [['Cherry Amour', '#8E0B14', 40], ['Rosewood', '#9E4A4F', 32], ['Noir Berry', '#4A0D1C', 18], ['Nude Petal', '#C17F73', 4]],
    ]);
    $ids['glass-tint'] = $p([
        'key' => 'glass-tint', 'cat' => 'tints', 'sub' => 'water-tints', 'sku' => 'SA-TNT-002',
        'name' => 'Glass Kiss Water Tint', 'price' => 599, 'new' => 1, 'featured' => 1, 'sold' => 64, 'age' => 4,
        'short' => 'A juicy water tint that stains lips with sheer, glassy colour.',
        'desc' => '<p>A water-light stain that sinks in for a just-bitten look, with a glassy sheen. Layer for more intensity or top with balm for shine.</p>',
        'specs' => [['label' => 'Net quantity', 'value' => '4.5 ml'], ['label' => 'Finish', 'value' => 'Glassy stain'], ['label' => 'Wear time', 'value' => 'Up to 6 hours'], ['label' => 'Vegan', 'value' => 'Yes']],
        'info' => $commonInfo,
        'variants' => [['Crimson Dew', '#B01224', 30], ['Petal Pink', '#D46A78', 26], ['Plum Wine', '#6B1630', 22]],
    ]);
    $ids['matte-tint'] = $p([
        'key' => 'matte-tint', 'cat' => 'tints', 'sub' => 'lip-cheek-tints', 'sku' => 'SA-TNT-003',
        'name' => 'Matte Desire Liquid Tint', 'price' => 749, 'sale' => 649, 'bestseller' => 1, 'sold' => 301, 'age' => 60,
        'short' => 'High-impact liquid colour that dries to a comfortable, transfer-proof matte.',
        'desc' => '<p>Saturated colour in a single swipe. Matte Desire dries down to a feather-light matte that will not crack or transfer.</p>',
        'specs' => [['label' => 'Net quantity', 'value' => '4 ml'], ['label' => 'Finish', 'value' => 'Transfer-proof matte'], ['label' => 'Wear time', 'value' => 'Up to 12 hours']],
        'info' => $commonInfo,
        'variants' => [['Sindoor Red', '#A3120E', 28], ['Maroon Muse', '#630000', 25, 799, 699], ['Brick Rose', '#9A3B32', 0]],
    ]);
    $ids['bloom-tint'] = $p([
        'key' => 'bloom-tint', 'cat' => 'tints', 'sub' => 'lip-cheek-tints', 'sku' => 'SA-TNT-004',
        'name' => 'Bloom Cheek Tint', 'price' => 549, 'sold' => 77, 'age' => 40,
        'short' => 'A sheer gel tint for a fresh, from-within flush on cheeks.',
        'desc' => '<p>A cooling gel tint that blends invisibly for a natural flush that lasts.</p>',
        'specs' => [['label' => 'Net quantity', 'value' => '6 ml'], ['label' => 'Finish', 'value' => 'Natural'], ['label' => 'Wear time', 'value' => 'Up to 8 hours']],
        'info' => $commonInfo,
        'variants' => [['Blush Bloom', '#C9636A', 20], ['Coral Silk', '#D2735E', 16]],
    ]);
    $ids['kohl-noir'] = $p([
        'key' => 'kohl-noir', 'cat' => 'kohl-pencils', 'sub' => 'classic-kohl', 'sku' => 'SA-KHL-001',
        'name' => 'Noir Absolu Kohl Pencil', 'price' => 399, 'stock' => 120, 'badge' => 'Best Seller',
        'bestseller' => 1, 'featured' => 1, 'sold' => 690, 'age' => 150,
        'short' => 'Our deepest black kohl — creamy, smudge-proof and safe for the waterline.',
        'desc' => '<p>An intensely black, creamy kohl that glides across the waterline without tugging and sets to a smudge-proof, water-resistant finish.</p><ul><li>Ophthalmologist tested</li><li>24-hour smudge-proof wear</li><li>Enriched with castor oil and camphor</li></ul>',
        'specs' => [['label' => 'Net weight', 'value' => '1.2 g'], ['label' => 'Finish', 'value' => 'Intense matte black'], ['label' => 'Wear time', 'value' => 'Up to 24 hours'], ['label' => 'Ophthalmologist tested', 'value' => 'Yes']],
        'info' => '<p><strong>How to use:</strong> Glide along the upper and lower waterline. Smudge within 30 seconds for a smoky look.</p>' . $commonInfo,
    ]);
    $ids['kohl-brown'] = $p([
        'key' => 'kohl-brown', 'cat' => 'kohl-pencils', 'sub' => 'coloured-kohl', 'sku' => 'SA-KHL-002',
        'name' => 'Smoky Brown Kohl', 'price' => 399, 'stock' => 54, 'sold' => 142, 'age' => 80,
        'short' => 'A soft, smoky espresso kohl for subtle everyday definition.',
        'desc' => '<p>A warm espresso brown that defines without harshness — perfect for daytime and softer smoky eyes.</p>',
        'specs' => [['label' => 'Net weight', 'value' => '1.2 g'], ['label' => 'Finish', 'value' => 'Soft matte'], ['label' => 'Wear time', 'value' => 'Up to 20 hours']],
        'info' => $commonInfo,
    ]);
    $ids['kohl-plum'] = $p([
        'key' => 'kohl-plum', 'cat' => 'kohl-pencils', 'sub' => 'coloured-kohl', 'sku' => 'SA-KHL-003',
        'name' => 'Midnight Plum Kohl', 'price' => 449, 'stock' => 3, 'new' => 1, 'sold' => 33, 'age' => 9,
        'short' => 'A deep aubergine kohl that makes every eye colour glow.',
        'desc' => '<p>A rich plum with a hint of shimmer, designed to brighten brown and hazel eyes.</p>',
        'specs' => [['label' => 'Net weight', 'value' => '1.2 g'], ['label' => 'Finish', 'value' => 'Satin shimmer'], ['label' => 'Wear time', 'value' => 'Up to 20 hours']],
        'info' => $commonInfo,
    ]);
    $ids['kohl-emerald'] = $p([
        'key' => 'kohl-emerald', 'cat' => 'kohl-pencils', 'sub' => 'coloured-kohl', 'sku' => 'SA-KHL-004',
        'name' => 'Royal Emerald Kohl', 'price' => 449, 'sale' => 379, 'stock' => 26, 'sold' => 58, 'age' => 45,
        'short' => 'A jewel-toned emerald kohl for festive, statement eyes.',
        'desc' => '<p>Deep, regal emerald with a satin finish — our favourite for celebrations.</p>',
        'specs' => [['label' => 'Net weight', 'value' => '1.2 g'], ['label' => 'Finish', 'value' => 'Satin'], ['label' => 'Wear time', 'value' => 'Up to 20 hours']],
        'info' => $commonInfo,
    ]);
    $ids['kohl-duo'] = $p([
        'key' => 'kohl-duo', 'cat' => 'kohl-pencils', 'sub' => 'gift-sets', 'sku' => 'SA-KHL-005',
        'name' => 'Kajal Duo Set', 'price' => 749, 'sale' => 649, 'stock' => 30, 'badge' => 'Gift Set', 'featured' => 1, 'sold' => 97, 'age' => 30,
        'short' => 'Noir Absolu and Smoky Brown kohl together — day to night in one set.',
        'desc' => '<p>The essential pairing: our cult Noir Absolu for intensity and Smoky Brown for softer days, presented in a gift sleeve.</p>',
        'specs' => [['label' => 'Contents', 'value' => '2 × 1.2 g kohl pencils'], ['label' => 'Shades', 'value' => 'Noir Absolu, Smoky Brown']],
        'info' => $commonInfo,
    ]);
    $ids['liner-noir'] = $p([
        'key' => 'liner-noir', 'cat' => 'eyeliner', 'sub' => 'liquid-liner', 'sku' => 'SA-EYE-001',
        'name' => 'Ink Noir Liquid Eyeliner', 'price' => 599, 'stock' => 70, 'bestseller' => 1, 'featured' => 1, 'sold' => 355, 'age' => 100,
        'short' => 'A jet-black liquid liner with an ultra-fine brush for a razor-sharp wing.',
        'desc' => '<p>Glossy, jet-black ink and a fine, flexible brush for anything from a whisper-thin line to a dramatic wing. Waterproof and flake-free.</p>',
        'specs' => [['label' => 'Net quantity', 'value' => '3.5 ml'], ['label' => 'Finish', 'value' => 'Glossy black'], ['label' => 'Wear time', 'value' => 'Up to 24 hours'], ['label' => 'Waterproof', 'value' => 'Yes']],
        'info' => $commonInfo,
    ]);
    $ids['liner-pen'] = $p([
        'key' => 'liner-pen', 'cat' => 'eyeliner', 'sub' => 'pen-liner', 'sku' => 'SA-EYE-002',
        'name' => 'Precision Felt-Tip Liner', 'price' => 549, 'sale' => 479, 'new' => 1, 'sold' => 48, 'age' => 12,
        'short' => 'A felt-tip liner pen with a firm, fine point for effortless control.',
        'desc' => '<p>The easiest way to a perfect line. A firm felt tip delivers even, saturated colour from the first stroke to the last.</p>',
        'specs' => [['label' => 'Net quantity', 'value' => '1 ml'], ['label' => 'Tip', 'value' => '0.1 mm felt tip'], ['label' => 'Wear time', 'value' => 'Up to 20 hours']],
        'info' => $commonInfo,
        'variants' => [['Noir', '#141111', 45], ['Bordeaux', '#5B0A14', 22]],
    ]);

    // ------------------------------------------------------------ collections
    $bridal = DB::insert('collections', [
        'name' => 'The Bridal Edit', 'slug' => 'the-bridal-edit', 'eyebrow' => 'Special collection',
        'tagline' => 'Vermilion, velvet and noir for the most cherished rituals.',
        'description' => 'Everything for the bride and her circle — heirloom sindoor, a tint that lasts through every ceremony and kohl that never smudges.',
        'image' => 'collections/demo-bridal-edit.webp', 'show_on_home' => 1, 'sort_order' => 1, 'is_active' => 1, 'created_at' => $now,
    ]);
    foreach (['powder-sindoor', 'liquid-sindoor', 'velvet-tint', 'kohl-noir', 'liner-noir', 'matte-tint'] as $i => $k) {
        DB::insert('collection_products', ['collection_id' => $bridal, 'product_id' => $ids[$k], 'sort_order' => $i]);
    }
    $noir = DB::insert('collections', [
        'name' => 'Noir Essentials', 'slug' => 'noir-essentials', 'eyebrow' => 'Collection',
        'tagline' => 'The deepest blacks for the boldest eyes.', 'description' => 'Kohl and liners in our richest noir.',
        'image' => 'banners/demo-promo-kohl.webp', 'show_on_home' => 0, 'sort_order' => 2, 'is_active' => 1, 'created_at' => $now,
    ]);
    foreach (['kohl-noir', 'liner-noir', 'liner-pen', 'kohl-plum', 'kohl-duo'] as $i => $k) {
        DB::insert('collection_products', ['collection_id' => $noir, 'product_id' => $ids[$k], 'sort_order' => $i]);
    }

    // ------------------------------------------------------------ banners
    $banners = [
        ['hero', 'the art of beauty', 'Where sacred vermilion meets', 'velvety noir', 'Ritual-inspired sindoor, tints and kohl — crafted for rituals that linger.', 'Shop the collection', '/shop', 'Discover sindoor', '/category/sindoor', 'banners/demo-hero-ritual.webp', 'noir'],
        ['hero', 'New · Velvet Lip & Cheek Tint', 'Four shades of', 'amour', 'A weightless tint that melts into lips and cheeks for a velvet flush that lasts all day.', 'Shop tints', '/category/tints', 'View shades', '/product/velvet-lip-cheek-tint', 'banners/demo-hero-tints.webp', 'cotton'],
        ['hero', 'Kohl & Eyeliner', 'Lines as deep as', 'noir', 'Smudge-proof kohl and precision liners with up to 24-hour staying power.', 'Shop kohl', '/category/kohl-pencils', 'Shop eyeliner', '/category/eyeliner', 'banners/demo-hero-noir.webp', 'cherry'],
        ['promo', 'Limited edition', 'The Bridal', 'Edit', 'Use code AMOUR15 for 15% off sindoor, tints and kohl for the big day.', 'Shop the edit', '/collection/the-bridal-edit', null, null, 'banners/demo-promo-bridal.webp', 'cotton'],
        ['promo', 'Smudge-proof for 24 hours', 'Kohl in', 'three moods', 'Noir, emerald and plum — find the kohl that matches your mood.', 'Shop kohl', '/category/kohl-pencils', null, null, 'banners/demo-promo-kohl.webp', 'noir'],
    ];
    foreach ($banners as $i => $b) {
        DB::insert('banners', [
            'type' => $b[0], 'eyebrow' => $b[1], 'title' => $b[2], 'title_italic' => $b[3], 'subtitle' => $b[4],
            'button_text' => $b[5], 'button_link' => $b[6], 'button2_text' => $b[7], 'button2_link' => $b[8],
            'image' => $b[9], 'theme' => $b[10], 'sort_order' => $i + 1, 'is_active' => 1, 'created_at' => $now,
        ]);
    }

    // ------------------------------------------------------------ testimonials (sample — replace with real customer quotes)
    $testimonials = [
        ['Ananya R.', 'Mumbai', 'The liquid sindoor stayed perfect through my entire wedding day — not a single smudge. The colour is exactly the red I wanted.', 'Sacred Vermilion Liquid Sindoor'],
        ['Meher K.', 'New Delhi', 'Velvet Tint in Cherry Amour is my everyday shade now. It looks like my lips, only better, and it lasts through lunch.', 'Velvet Lip & Cheek Tint'],
        ['Sanya P.', 'Bengaluru', 'I have watery eyes and Noir Absolu is the first kohl that does not travel. Deep black, super creamy.', 'Noir Absolu Kohl Pencil'],
        ['Ishita M.', 'Kolkata', 'The kumkum box is so beautiful I keep it on my dressing table. Fine powder and a lovely deep colour.', 'Heritage Kumkum Powder Sindoor'],
        ['Rhea D.', 'Pune', 'Gorgeous packaging, quick delivery and the liner brush gives the sharpest wing I have ever managed.', 'Ink Noir Liquid Eyeliner'],
    ];
    foreach ($testimonials as $i => $t) {
        DB::insert('testimonials', ['name' => $t[0], 'location' => $t[1], 'rating' => 5, 'content' => $t[2], 'product_name' => $t[3], 'sort_order' => $i + 1, 'is_active' => 1, 'created_at' => $now]);
    }

    // ------------------------------------------------------------ social posts
    $captions = ['Sacred vermilion, one stroke.', 'Velvet tints in every mood.', 'Kohl as deep as noir.', 'Swatch the shades.', 'An heirloom for every ritual.', 'The precision liner.'];
    foreach ($captions as $i => $cap) {
        DB::insert('social_posts', ['image' => 'social/demo-' . ($i + 1) . '.webp', 'link' => 'https://www.instagram.com/savieamour', 'caption' => $cap, 'sort_order' => $i + 1, 'is_active' => 1, 'created_at' => $now]);
    }

    // ------------------------------------------------------------ coupons
    DB::insert('coupons', ['code' => 'AMOUR15', 'description' => '15% off orders above ₹999 (max ₹300)', 'type' => 'percent', 'value' => 15, 'min_order_amount' => 999, 'max_discount' => 300, 'is_active' => 1, 'created_at' => $now]);
    DB::insert('coupons', ['code' => 'WELCOME100', 'description' => '₹100 off your first order above ₹699', 'type' => 'fixed', 'value' => 100, 'min_order_amount' => 699, 'usage_per_customer' => 1, 'is_active' => 1, 'created_at' => $now]);
    DB::insert('coupons', ['code' => 'FESTIVE10', 'description' => '10% festive offer', 'type' => 'percent', 'value' => 10, 'min_order_amount' => 0, 'usage_limit' => 500, 'expires_at' => date('Y-m-d 23:59:59', strtotime('+60 days')), 'is_active' => 1, 'created_at' => $now]);

    // ------------------------------------------------------------ homepage sections
    $sections = [
        ['hero', 'Hero slider', null, null, null, null, []],
        ['marquee', 'Scrolling ticker', null, null, null, null, ['items' => ['Sacred Vermilion', 'Velvet Tints', 'Kohl as deep as noir', 'Cruelty-free', 'Crafted in India', 'Rituals that linger']]],
        ['categories', 'Featured categories', 'Shop by ritual', 'Find your', 'ritual', 'Four rituals, one philosophy — colour that honours tradition and lives beautifully today.', []],
        ['bestsellers', 'Best sellers', 'Curated collection', 'Our', 'favorites', null, ['limit' => 8]],
        ['quote', 'Brand quote', null, 'Where sacred vermilion meets the velvety depth of noir —', 'crafted for rituals that linger.', null, []],
        ['new_arrivals', 'New arrivals', 'Just landed', 'New', 'arrivals', 'The latest shades and formulas from the Savié Amour atelier.', ['limit' => 8]],
        ['promos', 'Promotional banners', null, null, null, null, []],
        ['collection', 'Special collection', null, null, null, null, []],
        ['trending', 'Trending / featured', 'Trending now', 'Loved by', 'many', null, ['limit' => 4]],
        ['benefits', 'Brand benefits', null, null, null, null, []],
        ['testimonials', 'Testimonials', 'Kind words', 'Notes of', 'amour', null, []],
        ['instagram', 'Instagram gallery', '@savieamour', 'Rituals on', 'Instagram', 'Tag us to be featured in our gallery.', []],
        ['newsletter', 'Newsletter', 'The Amour letter', 'Join the', 'inner circle', 'New shades, rituals and private offers — straight to your inbox.', []],
    ];
    foreach ($sections as $i => $s) {
        DB::insert('home_sections', [
            'section_key' => $s[0], 'name' => $s[1], 'eyebrow' => $s[2], 'title' => $s[3], 'title_italic' => $s[4], 'subtitle' => $s[5],
            'is_visible' => 1, 'sort_order' => $i + 1, 'settings' => json_encode($s[6], JSON_UNESCAPED_UNICODE),
        ]);
    }

    // ------------------------------------------------------------ CMS pages
    $pages = require __DIR__ . '/pages.php';
    foreach ($pages as $slug => [$title, $content, $footer]) {
        DB::insert('pages', ['title' => $title, 'slug' => $slug, 'content' => $content, 'meta_title' => $title . ' | Savié Amour', 'meta_description' => str_limit(strip_tags($content), 155), 'show_in_footer' => $footer, 'is_active' => 1, 'created_at' => $now]);
    }
};
