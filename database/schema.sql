-- ---------------------------------------------------------------------------
-- Savié Amour — database schema (MySQL 5.7+/8, MariaDB 10.4+)
-- Engine: InnoDB, charset utf8mb4. Run via `php bin/install.php`.
-- ---------------------------------------------------------------------------
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Admin users ----------------------------------------------------------------
CREATE TABLE IF NOT EXISTS admins (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name            VARCHAR(120) NOT NULL,
  email           VARCHAR(190) NOT NULL,
  password_hash   VARCHAR(255) NOT NULL,
  role            ENUM('developer','super_admin','manager','support') NOT NULL DEFAULT 'manager',
  phone           VARCHAR(20) NULL,
  is_active       TINYINT(1) NOT NULL DEFAULT 1,
  last_login_at   DATETIME NULL,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at      DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_admins_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Customers ------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS customers (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name            VARCHAR(120) NOT NULL,
  email           VARCHAR(190) NOT NULL,
  phone           VARCHAR(20) NULL,
  password_hash   VARCHAR(255) NOT NULL,
  is_active       TINYINT(1) NOT NULL DEFAULT 1,
  newsletter      TINYINT(1) NOT NULL DEFAULT 0,
  last_login_at   DATETIME NULL,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at      DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_customers_email (email),
  UNIQUE KEY uq_customers_phone (phone),
  KEY idx_customers_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS customer_remember_tokens (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  customer_id     INT UNSIGNED NOT NULL,
  selector        CHAR(24) NOT NULL,
  validator_hash  CHAR(64) NOT NULL,
  expires_at      DATETIME NOT NULL,
  created_at      DATETIME NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_remember_selector (selector),
  KEY idx_remember_customer (customer_id),
  CONSTRAINT fk_remember_customer FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS password_resets (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  user_type       ENUM('customer','admin') NOT NULL DEFAULT 'customer',
  email           VARCHAR(190) NOT NULL,
  token_hash      CHAR(64) NOT NULL,
  expires_at      DATETIME NOT NULL,
  created_at      DATETIME NOT NULL,
  PRIMARY KEY (id),
  KEY idx_resets_email (user_type, email),
  KEY idx_resets_token (token_hash)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS login_attempts (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  identifier      CHAR(64) NOT NULL,
  ip_address      VARCHAR(45) NOT NULL,
  attempted_at    DATETIME NOT NULL,
  PRIMARY KEY (id),
  KEY idx_attempts (identifier, attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS customer_addresses (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  customer_id     INT UNSIGNED NOT NULL,
  label           VARCHAR(40) NOT NULL DEFAULT 'Home',
  full_name       VARCHAR(120) NOT NULL,
  phone           VARCHAR(20) NOT NULL,
  address_line1   VARCHAR(190) NOT NULL,
  address_line2   VARCHAR(190) NULL,
  city            VARCHAR(100) NOT NULL,
  state           VARCHAR(100) NOT NULL,
  country         VARCHAR(100) NOT NULL DEFAULT 'India',
  postal_code     VARCHAR(12) NOT NULL,
  is_default      TINYINT(1) NOT NULL DEFAULT 0,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at      DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_addresses_customer (customer_id),
  CONSTRAINT fk_addresses_customer FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Catalogue ------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS categories (
  id               INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name             VARCHAR(120) NOT NULL,
  slug             VARCHAR(140) NOT NULL,
  tagline          VARCHAR(190) NULL,
  description      TEXT NULL,
  image            VARCHAR(255) NULL,
  sort_order       INT NOT NULL DEFAULT 0,
  is_active        TINYINT(1) NOT NULL DEFAULT 1,
  is_featured      TINYINT(1) NOT NULL DEFAULT 1,
  meta_title       VARCHAR(190) NULL,
  meta_description VARCHAR(300) NULL,
  created_at       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at       DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_categories_slug (slug),
  KEY idx_categories_active (is_active, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS subcategories (
  id               INT UNSIGNED NOT NULL AUTO_INCREMENT,
  category_id      INT UNSIGNED NOT NULL,
  name             VARCHAR(120) NOT NULL,
  slug             VARCHAR(140) NOT NULL,
  description      TEXT NULL,
  image            VARCHAR(255) NULL,
  sort_order       INT NOT NULL DEFAULT 0,
  is_active        TINYINT(1) NOT NULL DEFAULT 1,
  created_at       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at       DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_subcategories_slug (category_id, slug),
  CONSTRAINT fk_subcategories_category FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS products (
  id                INT UNSIGNED NOT NULL AUTO_INCREMENT,
  category_id       INT UNSIGNED NULL,
  subcategory_id    INT UNSIGNED NULL,
  name              VARCHAR(190) NOT NULL,
  slug              VARCHAR(210) NOT NULL,
  sku               VARCHAR(64) NOT NULL,
  short_description TEXT NULL,
  description       MEDIUMTEXT NULL,
  specifications    TEXT NULL COMMENT 'JSON [{label,value}]',
  additional_info   TEXT NULL,
  price             DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  sale_price        DECIMAL(10,2) NULL,
  stock_qty         INT NOT NULL DEFAULT 0,
  stock_status      ENUM('in_stock','out_of_stock') NOT NULL DEFAULT 'in_stock',
  variant_label     VARCHAR(40) NULL COMMENT 'e.g. Shade, Size',
  image             VARCHAR(255) NULL,
  hover_image       VARCHAR(255) NULL,
  badge             VARCHAR(40) NULL,
  is_featured       TINYINT(1) NOT NULL DEFAULT 0,
  is_bestseller     TINYINT(1) NOT NULL DEFAULT 0,
  is_new            TINYINT(1) NOT NULL DEFAULT 0,
  is_active         TINYINT(1) NOT NULL DEFAULT 1,
  meta_title        VARCHAR(190) NULL,
  meta_description  VARCHAR(300) NULL,
  sold_count        INT UNSIGNED NOT NULL DEFAULT 0,
  view_count        INT UNSIGNED NOT NULL DEFAULT 0,
  rating_avg        DECIMAL(3,2) NOT NULL DEFAULT 0.00,
  rating_count      INT UNSIGNED NOT NULL DEFAULT 0,
  created_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at        DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_products_slug (slug),
  UNIQUE KEY uq_products_sku (sku),
  KEY idx_products_category (category_id, is_active),
  KEY idx_products_subcategory (subcategory_id),
  KEY idx_products_active_created (is_active, created_at),
  KEY idx_products_flags (is_active, is_featured, is_bestseller, is_new),
  KEY idx_products_sold (sold_count),
  CONSTRAINT fk_products_category FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE SET NULL,
  CONSTRAINT fk_products_subcategory FOREIGN KEY (subcategory_id) REFERENCES subcategories (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS product_images (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  product_id      INT UNSIGNED NOT NULL,
  image           VARCHAR(255) NOT NULL,
  alt             VARCHAR(190) NULL,
  sort_order      INT NOT NULL DEFAULT 0,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_product_images (product_id, sort_order),
  CONSTRAINT fk_product_images_product FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS product_variants (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  product_id      INT UNSIGNED NOT NULL,
  name            VARCHAR(100) NOT NULL,
  swatch          VARCHAR(7) NULL COMMENT 'hex colour for shade swatches',
  sku             VARCHAR(64) NULL,
  price           DECIMAL(10,2) NULL COMMENT 'NULL = use product price',
  sale_price      DECIMAL(10,2) NULL,
  stock_qty       INT NOT NULL DEFAULT 0,
  image           VARCHAR(255) NULL,
  sort_order      INT NOT NULL DEFAULT 0,
  is_active       TINYINT(1) NOT NULL DEFAULT 1,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at      DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_variants_product (product_id, sort_order),
  CONSTRAINT fk_variants_product FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS collections (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name            VARCHAR(120) NOT NULL,
  slug            VARCHAR(140) NOT NULL,
  eyebrow         VARCHAR(80) NULL,
  tagline         VARCHAR(190) NULL,
  description     TEXT NULL,
  image           VARCHAR(255) NULL,
  show_on_home    TINYINT(1) NOT NULL DEFAULT 0,
  sort_order      INT NOT NULL DEFAULT 0,
  is_active       TINYINT(1) NOT NULL DEFAULT 1,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at      DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_collections_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS collection_products (
  collection_id   INT UNSIGNED NOT NULL,
  product_id      INT UNSIGNED NOT NULL,
  sort_order      INT NOT NULL DEFAULT 0,
  PRIMARY KEY (collection_id, product_id),
  KEY idx_collection_products_product (product_id),
  CONSTRAINT fk_cp_collection FOREIGN KEY (collection_id) REFERENCES collections (id) ON DELETE CASCADE,
  CONSTRAINT fk_cp_product FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS reviews (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  product_id      INT UNSIGNED NOT NULL,
  customer_id     INT UNSIGNED NULL,
  name            VARCHAR(120) NOT NULL,
  rating          TINYINT UNSIGNED NOT NULL,
  title           VARCHAR(190) NULL,
  comment         TEXT NOT NULL,
  is_verified     TINYINT(1) NOT NULL DEFAULT 0,
  status          ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_reviews_product (product_id, status),
  KEY idx_reviews_customer (customer_id),
  CONSTRAINT fk_reviews_product FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE,
  CONSTRAINT fk_reviews_customer FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS review_images (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  review_id       INT UNSIGNED NOT NULL,
  image           VARCHAR(255) NOT NULL,
  sort_order      INT NOT NULL DEFAULT 0,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_review_images_review (review_id),
  CONSTRAINT fk_review_images_review FOREIGN KEY (review_id) REFERENCES reviews (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Wishlist & cart ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS wishlist (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  customer_id     INT UNSIGNED NOT NULL,
  product_id      INT UNSIGNED NOT NULL,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_wishlist (customer_id, product_id),
  KEY idx_wishlist_product (product_id),
  CONSTRAINT fk_wishlist_customer FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE CASCADE,
  CONSTRAINT fk_wishlist_product FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS carts (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  customer_id     INT UNSIGNED NULL,
  token           CHAR(48) NULL,
  coupon_code     VARCHAR(40) NULL,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at      DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_carts_customer (customer_id),
  UNIQUE KEY uq_carts_token (token),
  CONSTRAINT fk_carts_customer FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS cart_items (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  cart_id         INT UNSIGNED NOT NULL,
  product_id      INT UNSIGNED NOT NULL,
  variant_id      INT UNSIGNED NULL,
  quantity        INT UNSIGNED NOT NULL DEFAULT 1,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at      DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_cart_items_cart (cart_id),
  KEY idx_cart_items_product (product_id),
  CONSTRAINT fk_cart_items_cart FOREIGN KEY (cart_id) REFERENCES carts (id) ON DELETE CASCADE,
  CONSTRAINT fk_cart_items_product FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE,
  CONSTRAINT fk_cart_items_variant FOREIGN KEY (variant_id) REFERENCES product_variants (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Coupons --------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS coupons (
  id                   INT UNSIGNED NOT NULL AUTO_INCREMENT,
  code                 VARCHAR(40) NOT NULL,
  description          VARCHAR(190) NULL,
  type                 ENUM('percent','fixed') NOT NULL DEFAULT 'percent',
  value                DECIMAL(10,2) NOT NULL,
  min_order_amount     DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  max_discount         DECIMAL(10,2) NULL,
  usage_limit          INT UNSIGNED NULL,
  usage_per_customer   INT UNSIGNED NULL,
  used_count           INT UNSIGNED NOT NULL DEFAULT 0,
  starts_at            DATETIME NULL,
  expires_at           DATETIME NULL,
  is_active            TINYINT(1) NOT NULL DEFAULT 1,
  created_at           DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at           DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_coupons_code (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Orders & payments ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS orders (
  id                    INT UNSIGNED NOT NULL AUTO_INCREMENT,
  order_number          VARCHAR(30) NOT NULL,
  access_token          CHAR(40) NOT NULL,
  customer_id           INT UNSIGNED NULL,
  customer_name         VARCHAR(120) NOT NULL,
  customer_email        VARCHAR(190) NOT NULL,
  customer_phone        VARCHAR(20) NOT NULL,
  shipping_name         VARCHAR(120) NOT NULL,
  shipping_phone        VARCHAR(20) NOT NULL,
  shipping_address1     VARCHAR(190) NOT NULL,
  shipping_address2     VARCHAR(190) NULL,
  shipping_city         VARCHAR(100) NOT NULL,
  shipping_state        VARCHAR(100) NOT NULL,
  shipping_country      VARCHAR(100) NOT NULL,
  shipping_postal_code  VARCHAR(12) NOT NULL,
  billing_name          VARCHAR(120) NOT NULL,
  billing_phone         VARCHAR(20) NOT NULL,
  billing_address1      VARCHAR(190) NOT NULL,
  billing_address2      VARCHAR(190) NULL,
  billing_city          VARCHAR(100) NOT NULL,
  billing_state         VARCHAR(100) NOT NULL,
  billing_country       VARCHAR(100) NOT NULL,
  billing_postal_code   VARCHAR(12) NOT NULL,
  subtotal              DECIMAL(10,2) NOT NULL,
  discount_amount       DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  coupon_code           VARCHAR(40) NULL,
  shipping_amount       DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  cod_fee               DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  tax_amount            DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  tax_label             VARCHAR(30) NULL,
  tax_rate              DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  tax_inclusive         TINYINT(1) NOT NULL DEFAULT 1,
  total                 DECIMAL(10,2) NOT NULL,
  currency              CHAR(3) NOT NULL DEFAULT 'INR',
  payment_method        ENUM('cod','razorpay') NOT NULL DEFAULT 'cod',
  payment_status        ENUM('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  status                ENUM('pending','processing','confirmed','shipped','delivered','cancelled','refunded') NOT NULL DEFAULT 'pending',
  notes                 TEXT NULL,
  admin_notes           TEXT NULL,
  courier_name          VARCHAR(100) NULL,
  tracking_number       VARCHAR(100) NULL,
  tracking_url          VARCHAR(500) NULL,
  cancel_reason         VARCHAR(255) NULL,
  cancelled_at          DATETIME NULL,
  ip_address            VARCHAR(45) NULL,
  created_at            DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at            DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_orders_number (order_number),
  KEY idx_orders_customer (customer_id, created_at),
  KEY idx_orders_status (status, created_at),
  KEY idx_orders_payment_status (payment_status),
  KEY idx_orders_created (created_at),
  CONSTRAINT fk_orders_customer FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS order_items (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  order_id        INT UNSIGNED NOT NULL,
  product_id      INT UNSIGNED NULL,
  variant_id      INT UNSIGNED NULL,
  product_name    VARCHAR(190) NOT NULL,
  variant_name    VARCHAR(100) NULL,
  sku             VARCHAR(64) NULL,
  image           VARCHAR(255) NULL,
  unit_price      DECIMAL(10,2) NOT NULL,
  regular_price   DECIMAL(10,2) NOT NULL,
  quantity        INT UNSIGNED NOT NULL,
  line_total      DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (id),
  KEY idx_order_items_order (order_id),
  KEY idx_order_items_product (product_id),
  CONSTRAINT fk_order_items_order FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE,
  CONSTRAINT fk_order_items_product FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE SET NULL,
  CONSTRAINT fk_order_items_variant FOREIGN KEY (variant_id) REFERENCES product_variants (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS order_status_history (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  order_id        INT UNSIGNED NOT NULL,
  status          VARCHAR(30) NOT NULL,
  note            VARCHAR(255) NULL,
  actor           VARCHAR(60) NOT NULL DEFAULT 'system',
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_history_order (order_id, created_at),
  CONSTRAINT fk_history_order FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS payments (
  id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
  order_id            INT UNSIGNED NOT NULL,
  method              ENUM('cod','razorpay') NOT NULL,
  gateway_order_id    VARCHAR(100) NULL,
  gateway_payment_id  VARCHAR(100) NULL,
  gateway_signature   VARCHAR(255) NULL,
  amount              DECIMAL(10,2) NOT NULL,
  currency            CHAR(3) NOT NULL DEFAULT 'INR',
  status              ENUM('created','pending','paid','failed','refunded') NOT NULL DEFAULT 'created',
  refund_id           VARCHAR(100) NULL,
  refunded_amount     DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  error_message       VARCHAR(255) NULL,
  payload             TEXT NULL,
  created_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at          DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_payments_order (order_id),
  KEY idx_payments_gateway_order (gateway_order_id),
  CONSTRAINT fk_payments_order FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS coupon_usages (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  coupon_id       INT UNSIGNED NOT NULL,
  order_id        INT UNSIGNED NOT NULL,
  customer_id     INT UNSIGNED NULL,
  email           VARCHAR(190) NOT NULL,
  discount_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_coupon_usages_coupon (coupon_id, email),
  CONSTRAINT fk_cu_coupon FOREIGN KEY (coupon_id) REFERENCES coupons (id) ON DELETE CASCADE,
  CONSTRAINT fk_cu_order FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Content --------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS banners (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  type            ENUM('hero','promo') NOT NULL DEFAULT 'hero',
  eyebrow         VARCHAR(80) NULL,
  title           VARCHAR(190) NOT NULL,
  title_italic    VARCHAR(120) NULL COMMENT 'Highlighted italic part of the title',
  subtitle        VARCHAR(300) NULL,
  button_text     VARCHAR(60) NULL,
  button_link     VARCHAR(255) NULL,
  button2_text    VARCHAR(60) NULL,
  button2_link    VARCHAR(255) NULL,
  image           VARCHAR(255) NULL COMMENT 'Hero: left image / promo: background',
  image2          VARCHAR(255) NULL COMMENT 'Hero: right image',
  theme           ENUM('noir','cotton','cherry') NOT NULL DEFAULT 'noir',
  sort_order      INT NOT NULL DEFAULT 0,
  is_active       TINYINT(1) NOT NULL DEFAULT 1,
  starts_at       DATETIME NULL,
  ends_at         DATETIME NULL,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at      DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_banners (type, is_active, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS testimonials (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name            VARCHAR(120) NOT NULL,
  location        VARCHAR(120) NULL,
  avatar          VARCHAR(255) NULL,
  rating          TINYINT UNSIGNED NOT NULL DEFAULT 5,
  content         TEXT NOT NULL,
  product_name    VARCHAR(190) NULL,
  sort_order      INT NOT NULL DEFAULT 0,
  is_active       TINYINT(1) NOT NULL DEFAULT 1,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS home_sections (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  section_key     VARCHAR(40) NOT NULL,
  name            VARCHAR(80) NOT NULL,
  eyebrow         VARCHAR(80) NULL,
  title           VARCHAR(190) NULL,
  title_italic    VARCHAR(120) NULL,
  subtitle        VARCHAR(300) NULL,
  is_visible      TINYINT(1) NOT NULL DEFAULT 1,
  sort_order      INT NOT NULL DEFAULT 0,
  settings        TEXT NULL COMMENT 'JSON',
  PRIMARY KEY (id),
  UNIQUE KEY uq_home_sections_key (section_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS pages (
  id               INT UNSIGNED NOT NULL AUTO_INCREMENT,
  title            VARCHAR(190) NOT NULL,
  slug             VARCHAR(190) NOT NULL,
  content          MEDIUMTEXT NULL,
  meta_title       VARCHAR(190) NULL,
  meta_description VARCHAR(300) NULL,
  show_in_footer   TINYINT(1) NOT NULL DEFAULT 1,
  is_active        TINYINT(1) NOT NULL DEFAULT 1,
  created_at       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at       DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_pages_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS social_posts (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  image           VARCHAR(255) NOT NULL,
  link            VARCHAR(255) NULL,
  caption         VARCHAR(190) NULL,
  sort_order      INT NOT NULL DEFAULT 0,
  is_active       TINYINT(1) NOT NULL DEFAULT 1,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS newsletter_subscribers (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  email           VARCHAR(190) NOT NULL,
  status          ENUM('subscribed','unsubscribed') NOT NULL DEFAULT 'subscribed',
  ip_address      VARCHAR(45) NULL,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_newsletter_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contact_messages (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name            VARCHAR(120) NOT NULL,
  email           VARCHAR(190) NOT NULL,
  phone           VARCHAR(20) NULL,
  subject         VARCHAR(190) NULL,
  message         TEXT NOT NULL,
  is_read         TINYINT(1) NOT NULL DEFAULT 0,
  ip_address      VARCHAR(45) NULL,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_messages_read (is_read, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS settings (
  `key`           VARCHAR(100) NOT NULL,
  `value`         MEDIUMTEXT NULL,
  `group`         VARCHAR(50) NOT NULL DEFAULT 'general',
  updated_at      DATETIME NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
