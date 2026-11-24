# Savié Amour — Premium E-commerce Store (Core PHP + MySQL)

A complete, production-ready e-commerce website for **Savié Amour — the art of beauty**, built in Core PHP 8, MySQL/MariaDB, Bootstrap 5, vanilla JavaScript and AJAX. No WordPress, no framework.

Brand system: Noir `#1B1717` · Maroon `#630000` · Cherry `#810100` · Cotton `#EDEBDD`, with Cormorant Garamond (display) and Plus Jakarta Sans (text) self-hosted. The logo, petal texture and favicon are taken from the supplied brand board.

---

## Requirements

- PHP **8.1+** with `pdo_mysql`, `gd` (WebP support), `mbstring`, `fileinfo`, `curl`, `openssl`
- MySQL 5.7+/8 or MariaDB 10.4+
- Apache with `mod_rewrite` (on Nginx, route all non-file requests to `public/index.php`)

## Installation

### Option A — with SSH (recommended)

```bash
php bin/install.php
```

The installer asks for the site URL and database details, writes `config/config.php`, creates the tables, optionally loads the demo catalogue, and creates your super-admin account.

### Option B — XAMPP / shared hosting / cPanel (no SSH)

1. Extract the zip into `htdocs` (XAMPP) or `public_html` — any folder name works, e.g. `htdocs/savie_amour_new`.
2. In phpMyAdmin create a database (e.g. `savie_amour`, collation `utf8mb4_unicode_ci`), select it, and **Import** `database/savie_amour_full.sql`.
3. Open `config/config.php` and check the `db` section: `database` must match the name from step 2. XAMPP defaults are `root` with an empty password. Leave `app_url` empty locally — the folder is detected automatically.
4. Open `http://localhost/savie_amour_new` (your folder name). Admin: `/admin` with **admin@savieamour.com / ChangeMe@2026** — **change the password immediately** (the dashboard warns until you do).

If something is wrong (database name, MySQL password, MySQL not running, tables not imported) the site shows a page explaining exactly what to fix.

On the live server set `app_url` to your real domain (e.g. `https://www.savieamour.com`) and `app_env` to `production`.

Make `public/uploads/` and `storage/` writable by the web server.

### Document root

Point the domain's document root to **`/public`** if your host allows it. Otherwise the root `.htaccess` forwards requests into `/public` and blocks access to `config/`, `src/`, `views/`, `storage/`, `database/` and `bin/`.

### Local development

```bash
php -S localhost:8000 -t public public/index.php
```

### Cron (every 15 minutes)

```bash
*/15 * * * * php /path/to/site/bin/cron.php >/dev/null 2>&1
```

This cancels online orders left unpaid for 2+ hours (returning their stock) and cleans expired tokens and old guest carts.

---

## After installing — go-live checklist (Admin → Settings)

1. **E-mail**: switch the driver from *Log* to **SMTP** and send a test e-mail.
2. **Payments**: add your Razorpay Key ID, Key Secret and Webhook Secret, then enable it. In the Razorpay dashboard, add the webhook URL shown on that screen with the events `payment.captured`, `payment.failed` and `order.paid`.
3. **General / Social**: replace the placeholder phone, address, e-mail and social links.
4. **Catalogue**: the demo products use illustrated placeholder images in the brand palette. Replace them with real product photography (Admin → Products) or delete them.
5. **Testimonials & policies**: the starter testimonials are samples and the policy pages are templates. Replace them with real customer quotes and have the policies reviewed.
6. Set `'app_env' => 'production'` in `config/config.php` and enable the HTTPS redirect in `public/.htaccess`.

---

## Admin roles

| Role | Access |
|---|---|
| **Website Developer** | Everything, including the homepage sections, hero banners, testimonials, Instagram gallery, CMS pages, logo/website texts and SEO. |
| **Store Owner** | Products, categories, collections, orders, customers, coupons, reviews, messages, newsletter, business settings (contact details, shipping, GST, payments, e-mail) and team accounts. Cannot change the website design/content or developer accounts. |
| **Store Manager** | Catalogue, orders, customers, coupons, reviews, messages. |
| **Customer Support** | Orders, customers, reviews, messages. |

The first account (created by the installer or the SQL import) is the developer account. Create the client's login from **Admin → Admin users** with the role *Store Owner*.

## Shipping & order tracking

1. A new order arrives (e-mail alert + **Orders** badge) with status *Pending*.
2. Confirm it (status *Confirmed* — the customer is e-mailed), pack it and book the shipment with your courier or a shipping aggregator (Shiprocket, Delhivery, etc.).
3. On the order page, fill **Courier**, **Tracking/AWB number** and the **Tracking link**, tick *Mark as shipped & notify customer* and save.
4. The customer receives a shipping e-mail with a **Track shipment** button, and sees the courier details under *My account → Orders* and on the public **Track order** page (`/track-order`, order number + e-mail or phone — works for guest orders too).
5. When the courier delivers, set the status to *Delivered* (COD orders are marked paid automatically). Cancelling or refunding returns stock.

Automatic status updates from a courier API (e.g. Shiprocket webhooks) can be added later; the current flow is manual and works with any courier.

## Database updates

New features that need database changes upgrade an existing database automatically on the next page load (tracked by the `schema_version` setting) — no re-import needed.

---

## Features

**Storefront**
- Homepage with 13 sections, all manageable from the admin: rotating announcement bar, 3-panel hero slider (image · text · image) with a logo preloader, scrolling ticker, featured categories, best sellers with AJAX category tabs, brand quote, new-arrivals carousel, promotional banners, special collection, trending products, brand benefits, testimonials, Instagram gallery, newsletter.
- Mega menu, mobile off-canvas navigation, live AJAX search suggestions.
- Shop, category, subcategory, collection and search pages with AJAX filters (category, type, price range, stock, sale, new, best seller, featured), sorting, pagination and *Load more*.
- Product cards with hover image, badges, discount %, shade swatches, wishlist, add to bag and quick view.
- Product page: gallery with hover zoom, shade/size variants with their own price, stock and image, quantity, Add to bag, Buy now, specifications, additional info, reviews and ratings, customer reviews with up to 3 photos, related and recently viewed products, Product/Breadcrumb JSON-LD.
- Slide-in cart drawer (no page reload), cart page with quantity updates, coupons, free-shipping progress, stock validation.
- Checkout: contact, shipping and billing addresses (saved addresses for members), order notes, coupons, GST, shipping and COD fee, **Cash on Delivery** and **Razorpay**. Stock is locked and decremented in a transaction, so the last unit can't be sold twice.
- Order confirmation page and e-mails.
- Wishlist: guests get a sign-in prompt, and the product is saved automatically after they log in or register.
- Customer accounts: register, log in with e-mail or phone, remember me, forgot/reset password, profile, password, addresses, order history, tracking timeline, cancelling eligible orders.
- About, Contact (with spam honeypot), policy pages, XML sitemap, robots.txt, canonical/OG tags.

**Admin panel (`/admin`)**
- Dashboard: sales, orders, customers, products, pending/completed orders, 30-day sales chart, recent orders, best sellers, low-stock alerts and a setup checklist.
- Products: full CRUD, images (main, hover, gallery), variants, specifications, rich-text descriptions, badges, featured/best-seller/new flags, SEO fields, collections, duplicate, bulk actions, filters.
- Categories and subcategories (images, ordering, visibility, homepage flag), collections, review moderation.
- Orders: search and filters, CSV export, status updates with customer e-mails, payment status, courier/tracking, refunds (through the Razorpay API or recorded manually), printable invoice.
- Customers (view, edit, deactivate, export), coupons (percent or fixed, minimum order, maximum discount, usage limits, dates).
- Content: banners, testimonials, Instagram gallery, homepage section order/visibility/titles, brand benefits, CMS pages, contact messages, newsletter list with export.
- Settings: general, logo and favicon, social links, store, shipping and COD, tax/GST, payments, e-mail/SMTP, SEO. Admin users with roles (Super Admin, Store Manager, Customer Support) and profile/password management.

**Security**
PDO prepared statements everywhere · `password_hash` · CSRF tokens on every form and AJAX call · output escaping and a whitelist HTML sanitiser for rich text · hardened sessions (HttpOnly, SameSite, strict mode, ID regeneration, idle timeout) · login/registration/contact rate limiting · hashed single-use reset tokens · rotating hashed remember-me tokens · role-based admin access · image uploads checked by MIME type and dimensions, re-encoded with GD, randomly renamed, and stored in a folder where scripts can't run · open-redirect protection · CSV-injection-safe exports · security headers.

**Performance & SEO**
Uploads are converted to WebP in 300/600/full sizes with `srcset` and lazy loading. Minified CSS/JS, self-hosted fonts with `font-display: swap`, long-term browser caching and gzip (`.htaccess`), cache-busting asset versions, indexed queries, clean URLs.

## Project structure

```
public/          web root: index.php, assets (css, js, fonts, img, vendor), uploads
src/             Core (DB, Router, Auth, Validator, Uploader, Mailer…), Services, Controllers
views/           storefront, admin and e-mail templates
database/        schema.sql, seed.php (demo content), savie_amour_full.sql (import file)
bin/             install.php, cron.php
config/          config.sample.php → config.php
storage/         logs (incl. e-mails in “log” mode)
```

Edit `public/assets/css/app.css` and `js/app.js` (or the `admin.*` files), then regenerate the `.min` versions (for example with `npx esbuild file --minify --outfile=…`). If you delete a `.min` file, the site falls back to the readable source file automatically.
