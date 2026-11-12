# AF Prestige Roofing: afproofing.com.au

The website for AF Prestige Roofing, a locally owned and operated roof restoration company servicing Adelaide and regional South Australia within 100km of the city. It's built with plain HTML, CSS and PHP, with no frameworks, database or build step, so it runs on any standard cPanel / shared hosting plan.

## Pages

| URL | File | Purpose |
| --- | --- | --- |
| `/` | `index.php` | Homepage: hero with quote form, services, before/after, process, why us, reviews, areas, FAQs |
| `/services` | `services.php` | Overview of all services |
| `/services/{name}` | `service.php` | One SEO page per service (7 pages, generated from `includes/data/services.php`) |
| `/gallery` | `gallery.php` | Before & after gallery with drag sliders and filters |
| `/why-choose-us` | `why-choose-us.php` | Workmanship, attention to detail, reliability, satisfaction |
| `/reviews` | `reviews.php` | Customer testimonials |
| `/service-areas` | `service-areas.php` | Regions & suburbs for local SEO |
| `/contact` | `contact.php` | Phone, email, hours, service area, enquiry form, map |
| `/free-quote` | `free-quote.php` | Dedicated free-quote landing page |
| `/thank-you` | `thank-you.php` | Shown after an enquiry is sent (not indexed by Google) |
| `/privacy-policy` | `privacy-policy.php` | Privacy policy |
| `/sitemap.xml` | `sitemap.php` | Automatic XML sitemap for Google |

## Before going live: checklist

Everything below is in **`includes/config.php`** unless noted.

- [ ] **Phone number.** It's currently a placeholder (`0400 000 000`).
- [ ] **Email addresses.** Set `email`, `enquiry_to` (where enquiries go) and `mail_from`. Create the `mail_from` mailbox (e.g. `website@afproofing.com.au`) in your hosting so emails aren't marked as spam.
- [ ] **Opening hours.** Confirm `hours` and `hours_note`.
- [ ] **ABN and licence number** (optional, but they build trust).
- [ ] **Social links and Google Business Profile URL** (`social`), plus your Google **"write a review" link** (`google_review_url`).
- [ ] **Real photos.** Replace the illustrated placeholder images (see below).
- [ ] **Real reviews.** Edit `includes/data/reviews.php`. The current reviews are samples and show a "Sample review" label. Only publish genuine reviews from real customers: fake reviews breach Australian Consumer Law.
- [ ] **Gallery projects.** Edit `includes/data/gallery.php`: add your photos and the suburb for each job, then set `'sample' => false`.
- [ ] **Google Analytics** (optional): add your GA4 ID to `ga4_id`.
- [ ] **Google Search Console**: add `google_site_verification`, then submit `https://afproofing.com.au/sitemap.xml`.
- [ ] Once HTTPS works, uncomment the `Strict-Transport-Security` line in `.htaccess`.

## Hosting requirements

- PHP **8.0 or newer** with the `mbstring` extension and `mail()` enabled (both standard on cPanel hosting)
- Apache with `mod_rewrite` (for the clean URLs in `.htaccess`)
- The `storage/` folder must be writable by PHP (it holds a backup log of enquiries and the anti-spam key)

### Uploading

1. Upload **everything in this folder** (including the hidden `.htaccess` files) to your web root, usually `public_html/`.
2. Make sure `storage/` is writable (permissions `755`, or `775` on some hosts).
3. Visit the site and submit a test enquiry from the Contact page to confirm the email arrives.

`router.php` is only for previewing on your own computer. It's blocked on the live server.

### Nginx (if your host doesn't use Apache)

```nginx
location ~ ^/(includes|storage)/ { deny all; }
location = /sitemap.xml { rewrite ^ /sitemap.php last; }
location ~ ^/services/([a-z0-9-]+)$ { rewrite ^/services/([a-z0-9-]+)$ /service.php?slug=$1 last; }
location / { try_files $uri $uri.php $uri/ =404; }
error_page 404 /404.php;
```

## Preview on your computer

With PHP installed:

```bash
php -S localhost:8000 router.php
```

Then open http://localhost:8000. When run this way, enquiries are saved to `storage/enquiries.log` instead of being emailed.

## Replacing the images

The images in `assets/img/` are illustrations so the site looks finished from day one. To use your own photos, **overwrite the file with your photo using the same file name**. The site picks up the change automatically.

| File | Used for | Recommended size |
| --- | --- | --- |
| `assets/img/hero.jpg` | Homepage banner (kept dark behind the text) | 1920 × 1080 |
| `assets/img/about.jpg` | Homepage "About" section | 1200 × 900 |
| `assets/img/services/*.jpg` | One per service page | 1200 × 800 |
| `assets/img/gallery/project-N-before.jpg` / `-after.jpg` | Before & after sliders: take both from the **same angle** | 1200 × 900 (4:3) |
| `assets/img/og-image.jpg` | Preview image when the site is shared on Facebook, SMS etc. | 1200 × 630 |
| `assets/img/services/Concrete Tile Restoration.jpg` | Background photo behind the homepage "Why choose us" section (set in `index.php`, shown under a teal overlay) | 1920 × 1080 |

### Logo files

The logo is stored as sharp vector (SVG) files traced from the master artwork, `assets/img/logo-original.png`.

| File | Used for |
| --- | --- |
| `assets/img/logo-horizontal.svg` | Website header (dark teal on white) |
| `assets/img/logo-horizontal-light.svg` | Website footer (yellow house mark, white lettering for dark backgrounds) |
| `assets/img/logo.svg` / `logo-light.svg` | Stacked logo, as designed, on a transparent background (for print, signage, documents) |
| `assets/img/logo.png` | Stacked logo on brand yellow. Used as the logo in Google's business details |
| `favicon.svg`, `favicon.ico`, `apple-touch-icon.png`, `assets/img/icon-192.png`, `assets/img/icon-512.png` | Browser tab and home-screen icons |

Tips: export as JPG at about 80% quality and keep each photo under ~250 KB so pages load fast on mobile. To add more gallery projects, copy a block in `includes/data/gallery.php`.

## Editing content

| What | Where |
| --- | --- |
| Business details, hours, social links | `includes/config.php` |
| Service pages (text, lists, FAQs) | `includes/data/services.php` |
| Gallery projects | `includes/data/gallery.php` |
| Reviews | `includes/data/reviews.php` |
| Suburbs, towns & regions (metro and regional) | `includes/data/areas.php` |
| Service radius (currently 100km) | `service_radius_km` in `includes/config.php` |
| Homepage FAQs | `includes/data/faqs.php` |
| Colours & fonts | Top of `assets/css/style.css` (`:root`). Theme: brand teal `#12393e` (`--teal`) and yellow `#ffc20e` (`--yellow`) |

## What's built in

- **Fully responsive** for phones, tablets and desktops, with a sticky "Call Now / Free Quote" bar on mobile.
- **Fast.** No frameworks or jQuery, self-hosted fonts, lazy-loaded images, compression and long-term browser caching via `.htaccess`.
- **Local SEO.**
  - Unique title and description on every page.
  - Keyword-focused service pages: "roof restoration Adelaide", "roof painting Adelaide", "roof cleaning Adelaide", "ridge capping Adelaide" and more.
  - A service-areas page listing metropolitan suburbs and regional towns within the 100km service radius.
  - Clean URLs, canonical tags and an automatic sitemap.
  - Google structured data: `RoofingContractor` business details with areas served and hours, `Service`, `BreadcrumbList` and `FAQPage`.
- **Enquiry form.**
  - Works with or without JavaScript.
  - Validates input on the page and again on the server.
  - Spam protection: hidden honeypot field, signed timestamp and a per-IP rate limit.
  - Emails each enquiry and keeps a backup copy in `storage/enquiries.log`.
- **Accessible.** Keyboard-friendly menus and sliders, skip link, labelled form fields, good colour contrast, and reduced motion for visitors who ask for it.

## Local SEO: next steps after launch

The website is one part of ranking in Google Maps and local results. These have the biggest impact:

1. **Google Business Profile.** Create or claim it, choose "Roofing contractor" as the primary category, add your services and service areas, upload real job photos regularly and link it to this website.
2. **Reviews.** Ask every happy customer for a Google review (put your review link in `google_review_url`). Review quantity, recency and replies all matter.
3. **Consistent business details.** Use exactly the same business name, phone and website everywhere online.
4. **Directory listings.** List the business on True Local, Yellow Pages, Localsearch, hipages, Oneflare, ServiceSeeking and Word of Mouth.
5. **Real project photos.** Use descriptive file names and add the suburb to each gallery project (e.g. "Terracotta roof restoration in Burnside").
6. **Keep adding content.** Add new gallery projects regularly. Consider short articles answering common questions, such as "How much does roof restoration cost in Adelaide?".
