-- Savié Amour — complete database (schema + demo content) for phpMyAdmin / hosting import.
-- Default admin: admin@savieamour.com / ChangeMe@2026  (CHANGE IT right after first login).
-- Generated 2026-11-24


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('super_admin','manager','support') NOT NULL DEFAULT 'manager',
  `phone` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_admins_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES
(1,'Store Owner','admin@savieamour.com','$2y$10$D2cCGpCzvgCKdOdGv0hateKPO5LLMm9eKJumcHZOpOcrE5Ooly0yW','super_admin',NULL,1,NULL,'2026-11-24 13:01:27',NULL);
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `banners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('hero','promo') NOT NULL DEFAULT 'hero',
  `eyebrow` varchar(80) DEFAULT NULL,
  `title` varchar(190) NOT NULL,
  `title_italic` varchar(120) DEFAULT NULL COMMENT 'Highlighted italic part of the title',
  `subtitle` varchar(300) DEFAULT NULL,
  `button_text` varchar(60) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `button2_text` varchar(60) DEFAULT NULL,
  `button2_link` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `theme` enum('noir','cotton','cherry') NOT NULL DEFAULT 'noir',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `starts_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_banners` (`type`,`is_active`,`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES
(1,'hero','the art of beauty','Where sacred vermilion meets','velvety noir','Ritual-inspired sindoor, tints and kohl — crafted for rituals that linger.','Shop the collection','/shop','Discover sindoor','/category/sindoor','banners/demo-hero-ritual.webp','noir',1,1,NULL,NULL,'2026-11-24 13:01:27',NULL),
(2,'hero','New · Velvet Lip & Cheek Tint','Four shades of','amour','A weightless tint that melts into lips and cheeks for a velvet flush that lasts all day.','Shop tints','/category/tints','View shades','/product/velvet-lip-cheek-tint','banners/demo-hero-tints.webp','cotton',2,1,NULL,NULL,'2026-11-24 13:01:27',NULL),
(3,'hero','Kohl & Eyeliner','Lines as deep as','noir','Smudge-proof kohl and precision liners with up to 24-hour staying power.','Shop kohl','/category/kohl-pencils','Shop eyeliner','/category/eyeliner','banners/demo-hero-noir.webp','cherry',3,1,NULL,NULL,'2026-11-24 13:01:27',NULL),
(4,'promo','Limited edition','The Bridal','Edit','Use code AMOUR15 for 15% off sindoor, tints and kohl for the big day.','Shop the edit','/collection/the-bridal-edit',NULL,NULL,'banners/demo-promo-bridal.webp','cotton',4,1,NULL,NULL,'2026-11-24 13:01:27',NULL),
(5,'promo','Smudge-proof for 24 hours','Kohl in','three moods','Noir, emerald and plum — find the kohl that matches your mood.','Shop kohl','/category/kohl-pencils',NULL,NULL,'banners/demo-promo-kohl.webp','noir',5,1,NULL,NULL,'2026-11-24 13:01:27',NULL);
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `variant_id` int(10) unsigned DEFAULT NULL,
  `quantity` int(10) unsigned NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_cart_items_cart` (`cart_id`),
  KEY `idx_cart_items_product` (`product_id`),
  KEY `fk_cart_items_variant` (`variant_id`),
  CONSTRAINT `fk_cart_items_cart` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cart_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cart_items_variant` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `cart_items` WRITE;
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `token` char(48) DEFAULT NULL,
  `coupon_code` varchar(40) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_carts_customer` (`customer_id`),
  UNIQUE KEY `uq_carts_token` (`token`),
  CONSTRAINT `fk_carts_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `slug` varchar(140) NOT NULL,
  `tagline` varchar(190) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(190) DEFAULT NULL,
  `meta_description` varchar(300) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_categories_slug` (`slug`),
  KEY `idx_categories_active` (`is_active`,`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES
(1,'Sindoor','sindoor','Sacred vermilion for every ritual','Liquid and powder sindoor in rich, long-lasting vermilion — crafted for daily wear and once-in-a-lifetime moments.','categories/demo-sindoor.webp',1,1,1,'Sindoor | Savié Amour','Liquid and powder sindoor in rich, long-lasting vermilion — crafted for daily wear and once-in-a-lifetime moments.','2026-11-24 13:01:27',NULL),
(2,'Tints','tints','Lip & cheek colour that melts in','Weightless lip and cheek tints that build from a sheer flush to velvet-rich colour.','categories/demo-tints.webp',2,1,1,'Tints | Savié Amour','Weightless lip and cheek tints that build from a sheer flush to velvet-rich colour.','2026-11-24 13:01:27',NULL),
(3,'Kohl Pencils','kohl-pencils','Smudge-proof depth, from noir to emerald','Creamy, highly pigmented kohl that glides on and stays put — in classic noir and jewel tones.','categories/demo-kohl.webp',3,1,1,'Kohl Pencils | Savié Amour','Creamy, highly pigmented kohl that glides on and stays put — in classic noir and jewel tones.','2026-11-24 13:01:27',NULL),
(4,'Eyeliner','eyeliner','Precision lines, velvet finish','Liquid and felt-tip liners for the finest flick to the boldest wing.','categories/demo-eyeliner.webp',4,1,1,'Eyeliner | Savié Amour','Liquid and felt-tip liners for the finest flick to the boldest wing.','2026-11-24 13:01:27',NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `collection_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `collection_products` (
  `collection_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`collection_id`,`product_id`),
  KEY `idx_collection_products_product` (`product_id`),
  CONSTRAINT `fk_cp_collection` FOREIGN KEY (`collection_id`) REFERENCES `collections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cp_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `collection_products` WRITE;
/*!40000 ALTER TABLE `collection_products` DISABLE KEYS */;
INSERT INTO `collection_products` VALUES
(1,1,1),
(1,2,0),
(1,4,2),
(1,6,5),
(1,8,3),
(1,13,4),
(2,8,0),
(2,10,3),
(2,12,4),
(2,13,1),
(2,14,2);
/*!40000 ALTER TABLE `collection_products` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `collections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `collections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `slug` varchar(140) NOT NULL,
  `eyebrow` varchar(80) DEFAULT NULL,
  `tagline` varchar(190) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `show_on_home` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_collections_slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `collections` WRITE;
/*!40000 ALTER TABLE `collections` DISABLE KEYS */;
INSERT INTO `collections` VALUES
(1,'The Bridal Edit','the-bridal-edit','Special collection','Vermilion, velvet and noir for the most cherished rituals.','Everything for the bride and her circle — heirloom sindoor, a tint that lasts through every ceremony and kohl that never smudges.','collections/demo-bridal-edit.webp',1,1,1,'2026-11-24 13:01:27',NULL),
(2,'Noir Essentials','noir-essentials','Collection','The deepest blacks for the boldest eyes.','Kohl and liners in our richest noir.','banners/demo-promo-kohl.webp',0,2,1,'2026-11-24 13:01:27',NULL);
/*!40000 ALTER TABLE `collections` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(190) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_messages_read` (`is_read`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `coupon_usages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupon_usages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `email` varchar(190) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_coupon_usages_coupon` (`coupon_id`,`email`),
  KEY `fk_cu_order` (`order_id`),
  CONSTRAINT `fk_cu_coupon` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cu_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `coupon_usages` WRITE;
/*!40000 ALTER TABLE `coupon_usages` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupon_usages` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(40) NOT NULL,
  `description` varchar(190) DEFAULT NULL,
  `type` enum('percent','fixed') NOT NULL DEFAULT 'percent',
  `value` decimal(10,2) NOT NULL,
  `min_order_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `max_discount` decimal(10,2) DEFAULT NULL,
  `usage_limit` int(10) unsigned DEFAULT NULL,
  `usage_per_customer` int(10) unsigned DEFAULT NULL,
  `used_count` int(10) unsigned NOT NULL DEFAULT 0,
  `starts_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_coupons_code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` VALUES
(1,'AMOUR15','15% off orders above ₹999 (max ₹300)','percent',15.00,999.00,300.00,NULL,NULL,0,NULL,NULL,1,'2026-11-24 13:01:27',NULL),
(2,'WELCOME100','₹100 off your first order above ₹699','fixed',100.00,699.00,NULL,NULL,1,0,NULL,NULL,1,'2026-11-24 13:01:27',NULL),
(3,'FESTIVE10','10% festive offer','percent',10.00,0.00,NULL,500,NULL,0,NULL,'2027-01-23 23:59:59',1,'2026-11-24 13:01:27',NULL);
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `customer_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_addresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `label` varchar(40) NOT NULL DEFAULT 'Home',
  `full_name` varchar(120) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address_line1` varchar(190) NOT NULL,
  `address_line2` varchar(190) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL DEFAULT 'India',
  `postal_code` varchar(12) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_addresses_customer` (`customer_id`),
  CONSTRAINT `fk_addresses_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `customer_addresses` WRITE;
/*!40000 ALTER TABLE `customer_addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_addresses` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `customer_remember_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_remember_tokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `selector` char(24) NOT NULL,
  `validator_hash` char(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_remember_selector` (`selector`),
  KEY `idx_remember_customer` (`customer_id`),
  CONSTRAINT `fk_remember_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `customer_remember_tokens` WRITE;
/*!40000 ALTER TABLE `customer_remember_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_remember_tokens` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `newsletter` tinyint(1) NOT NULL DEFAULT 0,
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_customers_email` (`email`),
  UNIQUE KEY `uq_customers_phone` (`phone`),
  KEY `idx_customers_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `home_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `section_key` varchar(40) NOT NULL,
  `name` varchar(80) NOT NULL,
  `eyebrow` varchar(80) DEFAULT NULL,
  `title` varchar(190) DEFAULT NULL,
  `title_italic` varchar(120) DEFAULT NULL,
  `subtitle` varchar(300) DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `settings` text DEFAULT NULL COMMENT 'JSON',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_home_sections_key` (`section_key`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `home_sections` WRITE;
/*!40000 ALTER TABLE `home_sections` DISABLE KEYS */;
INSERT INTO `home_sections` VALUES
(1,'hero','Hero slider',NULL,NULL,NULL,NULL,1,1,'[]'),
(2,'marquee','Scrolling ticker',NULL,NULL,NULL,NULL,1,2,'{\"items\":[\"Sacred Vermilion\",\"Velvet Tints\",\"Kohl as deep as noir\",\"Cruelty-free\",\"Crafted in India\",\"Rituals that linger\"]}'),
(3,'categories','Featured categories','Shop by ritual','Find your','ritual','Four rituals, one philosophy — colour that honours tradition and lives beautifully today.',1,3,'[]'),
(4,'bestsellers','Best sellers','Curated collection','Our','favorites',NULL,1,4,'{\"limit\":8}'),
(5,'quote','Brand quote',NULL,'Where sacred vermilion meets the velvety depth of noir —','crafted for rituals that linger.',NULL,1,5,'[]'),
(6,'new_arrivals','New arrivals','Just landed','New','arrivals','The latest shades and formulas from the Savié Amour atelier.',1,6,'{\"limit\":8}'),
(7,'promos','Promotional banners',NULL,NULL,NULL,NULL,1,7,'[]'),
(8,'collection','Special collection',NULL,NULL,NULL,NULL,1,8,'[]'),
(9,'trending','Trending / featured','Trending now','Loved by','many',NULL,1,9,'{\"limit\":4}'),
(10,'benefits','Brand benefits',NULL,NULL,NULL,NULL,1,10,'[]'),
(11,'testimonials','Testimonials','Kind words','Notes of','amour',NULL,1,11,'[]'),
(12,'instagram','Instagram gallery','@savieamour','Rituals on','Instagram','Tag us to be featured in our gallery.',1,12,'[]'),
(13,'newsletter','Newsletter','The Amour letter','Join the','inner circle','New shades, rituals and private offers — straight to your inbox.',1,13,'[]');
/*!40000 ALTER TABLE `home_sections` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `login_attempts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` char(64) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `attempted_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_attempts` (`identifier`,`attempted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `newsletter_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `newsletter_subscribers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(190) NOT NULL,
  `status` enum('subscribed','unsubscribed') NOT NULL DEFAULT 'subscribed',
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_newsletter_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `newsletter_subscribers` WRITE;
/*!40000 ALTER TABLE `newsletter_subscribers` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_subscribers` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned DEFAULT NULL,
  `variant_id` int(10) unsigned DEFAULT NULL,
  `product_name` varchar(190) NOT NULL,
  `variant_name` varchar(100) DEFAULT NULL,
  `sku` varchar(64) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `regular_price` decimal(10,2) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `line_total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_order_items_order` (`order_id`),
  KEY `idx_order_items_product` (`product_id`),
  KEY `fk_order_items_variant` (`variant_id`),
  CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_order_items_variant` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `order_status_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_status_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `status` varchar(30) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `actor` varchar(60) NOT NULL DEFAULT 'system',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_history_order` (`order_id`,`created_at`),
  CONSTRAINT `fk_history_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `order_status_history` WRITE;
/*!40000 ALTER TABLE `order_status_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_status_history` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(30) NOT NULL,
  `access_token` char(40) NOT NULL,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `customer_name` varchar(120) NOT NULL,
  `customer_email` varchar(190) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `shipping_name` varchar(120) NOT NULL,
  `shipping_phone` varchar(20) NOT NULL,
  `shipping_address1` varchar(190) NOT NULL,
  `shipping_address2` varchar(190) DEFAULT NULL,
  `shipping_city` varchar(100) NOT NULL,
  `shipping_state` varchar(100) NOT NULL,
  `shipping_country` varchar(100) NOT NULL,
  `shipping_postal_code` varchar(12) NOT NULL,
  `billing_name` varchar(120) NOT NULL,
  `billing_phone` varchar(20) NOT NULL,
  `billing_address1` varchar(190) NOT NULL,
  `billing_address2` varchar(190) DEFAULT NULL,
  `billing_city` varchar(100) NOT NULL,
  `billing_state` varchar(100) NOT NULL,
  `billing_country` varchar(100) NOT NULL,
  `billing_postal_code` varchar(12) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `coupon_code` varchar(40) DEFAULT NULL,
  `shipping_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cod_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax_label` varchar(30) DEFAULT NULL,
  `tax_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tax_inclusive` tinyint(1) NOT NULL DEFAULT 1,
  `total` decimal(10,2) NOT NULL,
  `currency` char(3) NOT NULL DEFAULT 'INR',
  `payment_method` enum('cod','razorpay') NOT NULL DEFAULT 'cod',
  `payment_status` enum('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  `status` enum('pending','processing','confirmed','shipped','delivered','cancelled','refunded') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `courier_name` varchar(100) DEFAULT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `cancel_reason` varchar(255) DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_orders_number` (`order_number`),
  KEY `idx_orders_customer` (`customer_id`,`created_at`),
  KEY `idx_orders_status` (`status`,`created_at`),
  KEY `idx_orders_payment_status` (`payment_status`),
  KEY `idx_orders_created` (`created_at`),
  CONSTRAINT `fk_orders_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(190) NOT NULL,
  `slug` varchar(190) NOT NULL,
  `content` mediumtext DEFAULT NULL,
  `meta_title` varchar(190) DEFAULT NULL,
  `meta_description` varchar(300) DEFAULT NULL,
  `show_in_footer` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_pages_slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES
(1,'About Us','about-us','<h2>The art of beauty, rooted in ritual</h2>\n<p>Savié Amour was born from a simple belief: the most beautiful rituals are the ones that linger. From the sacred stroke of vermilion to the depth of a kohl-lined eye, we craft colour that honours Indian beauty traditions and lives effortlessly in modern life.</p>\n<p>Every formula is developed in India with skin-safe pigments, tested for long wear and comfort, and finished in packaging made to be kept — maroon, gold and noir, like the petals that inspired us.</p>\n<h3>What we stand for</h3>\n<ul>\n<li><strong>Ritual first</strong> — products designed around the moments that matter.</li>\n<li><strong>Clean, kind formulas</strong> — cruelty-free, free of lead and mercury.</li>\n<li><strong>Colour that lasts</strong> — smudge-proof, transfer-resistant wear.</li>\n<li><strong>Made to be treasured</strong> — keepsake packaging and thoughtful details.</li>\n</ul>','About Us | Savié Amour','The art of beauty, rooted in ritual\nSavié Amour was born from a simple belief: the most beautiful rituals are the ones that linger. From the sacred stroke…',1,1,'2026-11-24 13:01:27',NULL),
(2,'Privacy Policy','privacy-policy','<p>This policy explains how Savié Amour collects, uses and protects your personal information when you use our website.</p>\n<h3>Information we collect</h3>\n<p>When you create an account or place an order we collect your name, e-mail address, phone number and delivery address. Payments made online are processed securely by our payment partner; we never store your card or UPI details.</p>\n<h3>How we use your information</h3>\n<ul><li>To process and deliver your orders and keep you updated about them.</li><li>To provide customer support.</li><li>To send newsletters if you have subscribed (you can unsubscribe at any time).</li></ul>\n<h3>Cookies</h3>\n<p>We use essential cookies to keep you signed in, remember your shopping bag and recently viewed products.</p>\n<h3>Your rights</h3>\n<p>You can view and update your details from your account at any time, or write to us to request deletion of your data.</p>','Privacy Policy | Savié Amour','This policy explains how Savié Amour collects, uses and protects your personal information when you use our website.\nInformation we collect\nWhen you create…',1,1,'2026-11-24 13:01:27',NULL),
(3,'Terms & Conditions','terms-and-conditions','<p>By using this website and placing an order you agree to the following terms.</p>\n<h3>Orders</h3>\n<p>All orders are subject to availability and confirmation. We reserve the right to cancel an order in case of pricing errors or suspected fraud; any amount paid will be refunded in full.</p>\n<h3>Pricing</h3>\n<p>Prices are listed in Indian Rupees and are inclusive of GST unless stated otherwise. Shipping charges, if any, are shown at checkout.</p>\n<h3>Product use</h3>\n<p>Our products are for external use only. Please read the ingredient list and patch test before first use.</p>\n<h3>Intellectual property</h3>\n<p>All content on this website, including the Savié Amour name and logo, is our property and may not be used without permission.</p>','Terms & Conditions | Savié Amour','By using this website and placing an order you agree to the following terms.\nOrders\nAll orders are subject to availability and confirmation. We reserve the…',1,1,'2026-11-24 13:01:27',NULL),
(4,'Shipping Policy','shipping-policy','<p>We ship across India through trusted courier partners.</p>\n<ul><li>Orders are dispatched within 1–2 business days.</li><li>Delivery usually takes 3–7 business days depending on your location.</li><li>Shipping is free on orders above ₹999; a flat fee applies below that.</li><li>Cash on Delivery is available on most PIN codes.</li></ul>\n<p>Once your order ships you will receive the courier name and tracking number by e-mail and in your account.</p>','Shipping Policy | Savié Amour','We ship across India through trusted courier partners.\nOrders are dispatched within 1–2 business days.Delivery usually takes 3–7 business days depending on…',1,1,'2026-11-24 13:01:27',NULL),
(5,'Returns & Refunds','return-refund-policy','<p>For hygiene reasons cosmetic products can only be returned if they arrive damaged, defective or incorrect.</p>\n<ul><li>Please contact us within 48 hours of delivery with your order number and photos of the product and packaging.</li><li>Once approved, we will arrange a replacement or a refund to your original payment method.</li><li>Refunds are processed within 5–7 business days of approval.</li></ul>\n<p>You can cancel an order from your account any time before it is shipped.</p>','Returns & Refunds | Savié Amour','For hygiene reasons cosmetic products can only be returned if they arrive damaged, defective or incorrect.\nPlease contact us within 48 hours of delivery wi…',1,1,'2026-11-24 13:01:27',NULL);
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_type` enum('customer','admin') NOT NULL DEFAULT 'customer',
  `email` varchar(190) NOT NULL,
  `token_hash` char(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_resets_email` (`user_type`,`email`),
  KEY `idx_resets_token` (`token_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `method` enum('cod','razorpay') NOT NULL,
  `gateway_order_id` varchar(100) DEFAULT NULL,
  `gateway_payment_id` varchar(100) DEFAULT NULL,
  `gateway_signature` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` char(3) NOT NULL DEFAULT 'INR',
  `status` enum('created','pending','paid','failed','refunded') NOT NULL DEFAULT 'created',
  `refund_id` varchar(100) DEFAULT NULL,
  `refunded_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `error_message` varchar(255) DEFAULT NULL,
  `payload` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_payments_order` (`order_id`),
  KEY `idx_payments_gateway_order` (`gateway_order_id`),
  CONSTRAINT `fk_payments_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `image` varchar(255) NOT NULL,
  `alt` varchar(190) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_product_images` (`product_id`,`sort_order`),
  CONSTRAINT `fk_product_images_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES
(1,1,'products/demo-liquid-sindoor-swatch.webp','Sacred Vermilion Liquid Sindoor',1,'2026-11-24 13:01:27'),
(2,1,'products/demo-liquid-sindoor-moody.webp','Sacred Vermilion Liquid Sindoor',2,'2026-11-24 13:01:27'),
(3,1,'products/demo-liquid-sindoor-hover.webp','Sacred Vermilion Liquid Sindoor',3,'2026-11-24 13:01:27'),
(4,2,'products/demo-powder-sindoor-swatch.webp','Heritage Kumkum Powder Sindoor',1,'2026-11-24 13:01:27'),
(5,2,'products/demo-powder-sindoor-moody.webp','Heritage Kumkum Powder Sindoor',2,'2026-11-24 13:01:27'),
(6,2,'products/demo-powder-sindoor-hover.webp','Heritage Kumkum Powder Sindoor',3,'2026-11-24 13:01:27'),
(7,3,'products/demo-maroon-sindoor-swatch.webp','Noor Maroon Liquid Sindoor',1,'2026-11-24 13:01:27'),
(8,3,'products/demo-maroon-sindoor-moody.webp','Noor Maroon Liquid Sindoor',2,'2026-11-24 13:01:27'),
(9,3,'products/demo-maroon-sindoor-hover.webp','Noor Maroon Liquid Sindoor',3,'2026-11-24 13:01:27'),
(10,4,'products/demo-velvet-tint-swatch.webp','Velvet Lip & Cheek Tint',1,'2026-11-24 13:01:27'),
(11,4,'products/demo-velvet-tint-moody.webp','Velvet Lip & Cheek Tint',2,'2026-11-24 13:01:27'),
(12,4,'products/demo-velvet-tint-hover.webp','Velvet Lip & Cheek Tint',3,'2026-11-24 13:01:27'),
(13,5,'products/demo-glass-tint-swatch.webp','Glass Kiss Water Tint',1,'2026-11-24 13:01:27'),
(14,5,'products/demo-glass-tint-moody.webp','Glass Kiss Water Tint',2,'2026-11-24 13:01:27'),
(15,5,'products/demo-glass-tint-hover.webp','Glass Kiss Water Tint',3,'2026-11-24 13:01:27'),
(16,6,'products/demo-matte-tint-swatch.webp','Matte Desire Liquid Tint',1,'2026-11-24 13:01:27'),
(17,6,'products/demo-matte-tint-moody.webp','Matte Desire Liquid Tint',2,'2026-11-24 13:01:27'),
(18,6,'products/demo-matte-tint-hover.webp','Matte Desire Liquid Tint',3,'2026-11-24 13:01:27'),
(19,7,'products/demo-bloom-tint-swatch.webp','Bloom Cheek Tint',1,'2026-11-24 13:01:27'),
(20,7,'products/demo-bloom-tint-moody.webp','Bloom Cheek Tint',2,'2026-11-24 13:01:27'),
(21,7,'products/demo-bloom-tint-hover.webp','Bloom Cheek Tint',3,'2026-11-24 13:01:27'),
(22,8,'products/demo-kohl-noir-swatch.webp','Noir Absolu Kohl Pencil',1,'2026-11-24 13:01:27'),
(23,8,'products/demo-kohl-noir-moody.webp','Noir Absolu Kohl Pencil',2,'2026-11-24 13:01:27'),
(24,8,'products/demo-kohl-noir-hover.webp','Noir Absolu Kohl Pencil',3,'2026-11-24 13:01:27'),
(25,9,'products/demo-kohl-brown-swatch.webp','Smoky Brown Kohl',1,'2026-11-24 13:01:27'),
(26,9,'products/demo-kohl-brown-moody.webp','Smoky Brown Kohl',2,'2026-11-24 13:01:27'),
(27,9,'products/demo-kohl-brown-hover.webp','Smoky Brown Kohl',3,'2026-11-24 13:01:27'),
(28,10,'products/demo-kohl-plum-swatch.webp','Midnight Plum Kohl',1,'2026-11-24 13:01:27'),
(29,10,'products/demo-kohl-plum-moody.webp','Midnight Plum Kohl',2,'2026-11-24 13:01:27'),
(30,10,'products/demo-kohl-plum-hover.webp','Midnight Plum Kohl',3,'2026-11-24 13:01:27'),
(31,11,'products/demo-kohl-emerald-swatch.webp','Royal Emerald Kohl',1,'2026-11-24 13:01:27'),
(32,11,'products/demo-kohl-emerald-moody.webp','Royal Emerald Kohl',2,'2026-11-24 13:01:27'),
(33,11,'products/demo-kohl-emerald-hover.webp','Royal Emerald Kohl',3,'2026-11-24 13:01:27'),
(34,12,'products/demo-kohl-duo-swatch.webp','Kajal Duo Set',1,'2026-11-24 13:01:27'),
(35,12,'products/demo-kohl-duo-moody.webp','Kajal Duo Set',2,'2026-11-24 13:01:27'),
(36,12,'products/demo-kohl-duo-hover.webp','Kajal Duo Set',3,'2026-11-24 13:01:27'),
(37,13,'products/demo-liner-noir-swatch.webp','Ink Noir Liquid Eyeliner',1,'2026-11-24 13:01:27'),
(38,13,'products/demo-liner-noir-moody.webp','Ink Noir Liquid Eyeliner',2,'2026-11-24 13:01:27'),
(39,13,'products/demo-liner-noir-hover.webp','Ink Noir Liquid Eyeliner',3,'2026-11-24 13:01:27'),
(40,14,'products/demo-liner-pen-swatch.webp','Precision Felt-Tip Liner',1,'2026-11-24 13:01:27'),
(41,14,'products/demo-liner-pen-moody.webp','Precision Felt-Tip Liner',2,'2026-11-24 13:01:27'),
(42,14,'products/demo-liner-pen-hover.webp','Precision Felt-Tip Liner',3,'2026-11-24 13:01:27');
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `product_variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_variants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `swatch` varchar(7) DEFAULT NULL COMMENT 'hex colour for shade swatches',
  `sku` varchar(64) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL COMMENT 'NULL = use product price',
  `sale_price` decimal(10,2) DEFAULT NULL,
  `stock_qty` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_variants_product` (`product_id`,`sort_order`),
  CONSTRAINT `fk_variants_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `product_variants` WRITE;
/*!40000 ALTER TABLE `product_variants` DISABLE KEYS */;
INSERT INTO `product_variants` VALUES
(1,4,'Cherry Amour','#8E0B14','SA-TNT-001-1',NULL,NULL,40,'variants/demo-velvet-tint-v1.webp',1,1,'2026-11-24 13:01:27',NULL),
(2,4,'Rosewood','#9E4A4F','SA-TNT-001-2',NULL,NULL,32,'variants/demo-velvet-tint-v2.webp',2,1,'2026-11-24 13:01:27',NULL),
(3,4,'Noir Berry','#4A0D1C','SA-TNT-001-3',NULL,NULL,18,'variants/demo-velvet-tint-v3.webp',3,1,'2026-11-24 13:01:27',NULL),
(4,4,'Nude Petal','#C17F73','SA-TNT-001-4',NULL,NULL,4,'variants/demo-velvet-tint-v4.webp',4,1,'2026-11-24 13:01:27',NULL),
(5,5,'Crimson Dew','#B01224','SA-TNT-002-1',NULL,NULL,30,'variants/demo-glass-tint-v1.webp',1,1,'2026-11-24 13:01:27',NULL),
(6,5,'Petal Pink','#D46A78','SA-TNT-002-2',NULL,NULL,26,'variants/demo-glass-tint-v2.webp',2,1,'2026-11-24 13:01:27',NULL),
(7,5,'Plum Wine','#6B1630','SA-TNT-002-3',NULL,NULL,22,'variants/demo-glass-tint-v3.webp',3,1,'2026-11-24 13:01:27',NULL),
(8,6,'Sindoor Red','#A3120E','SA-TNT-003-1',NULL,NULL,28,'variants/demo-matte-tint-v1.webp',1,1,'2026-11-24 13:01:27',NULL),
(9,6,'Maroon Muse','#630000','SA-TNT-003-2',799.00,699.00,25,'variants/demo-matte-tint-v2.webp',2,1,'2026-11-24 13:01:27',NULL),
(10,6,'Brick Rose','#9A3B32','SA-TNT-003-3',NULL,NULL,0,'variants/demo-matte-tint-v3.webp',3,1,'2026-11-24 13:01:27',NULL),
(11,7,'Blush Bloom','#C9636A','SA-TNT-004-1',NULL,NULL,20,'variants/demo-bloom-tint-v1.webp',1,1,'2026-11-24 13:01:27',NULL),
(12,7,'Coral Silk','#D2735E','SA-TNT-004-2',NULL,NULL,16,'variants/demo-bloom-tint-v2.webp',2,1,'2026-11-24 13:01:27',NULL),
(13,14,'Noir','#141111','SA-EYE-002-1',NULL,NULL,45,'variants/demo-liner-pen-v1.webp',1,1,'2026-11-24 13:01:27',NULL),
(14,14,'Bordeaux','#5B0A14','SA-EYE-002-2',NULL,NULL,22,'variants/demo-liner-pen-v2.webp',2,1,'2026-11-24 13:01:27',NULL);
/*!40000 ALTER TABLE `product_variants` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned DEFAULT NULL,
  `subcategory_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(190) NOT NULL,
  `slug` varchar(210) NOT NULL,
  `sku` varchar(64) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `specifications` text DEFAULT NULL COMMENT 'JSON [{label,value}]',
  `additional_info` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `stock_qty` int(11) NOT NULL DEFAULT 0,
  `stock_status` enum('in_stock','out_of_stock') NOT NULL DEFAULT 'in_stock',
  `variant_label` varchar(40) DEFAULT NULL COMMENT 'e.g. Shade, Size',
  `image` varchar(255) DEFAULT NULL,
  `hover_image` varchar(255) DEFAULT NULL,
  `badge` varchar(40) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_bestseller` tinyint(1) NOT NULL DEFAULT 0,
  `is_new` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(190) DEFAULT NULL,
  `meta_description` varchar(300) DEFAULT NULL,
  `sold_count` int(10) unsigned NOT NULL DEFAULT 0,
  `view_count` int(10) unsigned NOT NULL DEFAULT 0,
  `rating_avg` decimal(3,2) NOT NULL DEFAULT 0.00,
  `rating_count` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_products_slug` (`slug`),
  UNIQUE KEY `uq_products_sku` (`sku`),
  KEY `idx_products_category` (`category_id`,`is_active`),
  KEY `idx_products_subcategory` (`subcategory_id`),
  KEY `idx_products_active_created` (`is_active`,`created_at`),
  KEY `idx_products_flags` (`is_active`,`is_featured`,`is_bestseller`,`is_new`),
  KEY `idx_products_sold` (`sold_count`),
  CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_products_subcategory` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES
(1,1,1,'Sacred Vermilion Liquid Sindoor','sacred-vermilion-liquid-sindoor','SA-SIN-001','A long-lasting liquid sindoor in a true, sacred vermilion — one precise stroke that stays vivid all day.','<p>Our signature <strong>Sacred Vermilion</strong> is a quick-drying liquid sindoor that sets to a soft, transfer-resistant finish. The slim applicator draws a clean line along the parting in a single stroke.</p><ul><li>Rich, true-red vermilion pigment</li><li>Quick-drying and water-resistant</li><li>Gentle on the scalp; free of lead and mercury</li></ul><p>Worn daily or for once-in-a-lifetime ceremonies, it is colour crafted for rituals that linger.</p>','[{\"label\":\"Net quantity\",\"value\":\"5 ml\"},{\"label\":\"Finish\",\"value\":\"Soft matte\"},{\"label\":\"Wear time\",\"value\":\"Up to 16 hours\"},{\"label\":\"Skin type\",\"value\":\"All skin types\"},{\"label\":\"Shelf life\",\"value\":\"24 months\"}]','<p><strong>How to use:</strong> Shake gently. Draw the applicator along the hair parting in one stroke and let it set for 30 seconds.</p><p><strong>Manufactured &amp; marketed by:</strong> Savié Amour, Mumbai, India.</p><p><strong>Country of origin:</strong> India</p><p>For external use only. Patch test before first use. Store in a cool, dry place away from direct sunlight.</p>',449.00,399.00,64,'in_stock',NULL,'products/demo-liquid-sindoor.webp','products/demo-liquid-sindoor-hover.webp','Best Seller',1,1,0,1,'Sacred Vermilion Liquid Sindoor | Savié Amour','A long-lasting liquid sindoor in a true, sacred vermilion — one precise stroke that stays vivid all day.',412,0,0.00,0,'2026-07-27 13:01:27',NULL),
(2,1,2,'Heritage Kumkum Powder Sindoor','heritage-kumkum-powder-sindoor','SA-SIN-002','Finely milled kumkum in an heirloom maroon-and-gold keepsake box.','<p>Velvety, finely milled powder sindoor in a deep vermilion, presented in a keepsake box with gold filigree — made to be treasured and gifted.</p><ul><li>Silky, non-gritty texture</li><li>Buildable colour from soft to intense</li><li>Free of lead, mercury and synthetic fragrance</li></ul>','[{\"label\":\"Net weight\",\"value\":\"6 g\"},{\"label\":\"Finish\",\"value\":\"Powder matte\"},{\"label\":\"Packaging\",\"value\":\"Keepsake box with mirror lid\"},{\"label\":\"Shelf life\",\"value\":\"36 months\"}]','<p><strong>How to use:</strong> Dip the tip of the ring finger or a fine brush and press gently along the parting.</p><p><strong>Manufactured &amp; marketed by:</strong> Savié Amour, Mumbai, India.</p><p><strong>Country of origin:</strong> India</p><p>For external use only. Patch test before first use. Store in a cool, dry place away from direct sunlight.</p>',549.00,NULL,38,'in_stock',NULL,'products/demo-powder-sindoor.webp','products/demo-powder-sindoor-hover.webp','Ritual Essential',1,0,0,1,'Heritage Kumkum Powder Sindoor | Savié Amour','Finely milled kumkum in an heirloom maroon-and-gold keepsake box.',186,0,0.00,0,'2026-08-26 13:01:27',NULL),
(3,1,1,'Noor Maroon Liquid Sindoor','noor-maroon-liquid-sindoor','SA-SIN-003','A deep maroon liquid sindoor with a satin sheen — modern, rich and long-wearing.','<p><strong>Noor Maroon</strong> brings the depth of our brand colour to a liquid sindoor. Its satin finish catches the light softly, and the quick-dry formula resists smudging.</p>','[{\"label\":\"Net quantity\",\"value\":\"5 ml\"},{\"label\":\"Finish\",\"value\":\"Satin\"},{\"label\":\"Wear time\",\"value\":\"Up to 16 hours\"},{\"label\":\"Shelf life\",\"value\":\"24 months\"}]','<p><strong>Manufactured &amp; marketed by:</strong> Savié Amour, Mumbai, India.</p><p><strong>Country of origin:</strong> India</p><p>For external use only. Patch test before first use. Store in a cool, dry place away from direct sunlight.</p>',449.00,NULL,42,'in_stock',NULL,'products/demo-maroon-sindoor.webp','products/demo-maroon-sindoor-hover.webp',NULL,0,0,1,1,'Noor Maroon Liquid Sindoor | Savié Amour','A deep maroon liquid sindoor with a satin sheen — modern, rich and long-wearing.',24,0,0.00,0,'2026-11-18 13:01:27',NULL),
(4,2,3,'Velvet Lip & Cheek Tint','velvet-lip-cheek-tint','SA-TNT-001','A weightless, blendable tint that gives lips and cheeks a velvety flush of colour.','<p>The tint that started it all. A whipped, weightless formula that melts into lips and cheeks, blurring into a natural, velvet-soft finish that lasts all day.</p><ul><li>Two-in-one for lips and cheeks</li><li>Buildable from sheer to vivid</li><li>Enriched with rosehip oil and vitamin E</li></ul>','[{\"label\":\"Net quantity\",\"value\":\"4 ml\"},{\"label\":\"Finish\",\"value\":\"Velvet matte\"},{\"label\":\"Wear time\",\"value\":\"Up to 8 hours\"},{\"label\":\"Key ingredients\",\"value\":\"Rosehip oil, Vitamin E\"},{\"label\":\"Vegan\",\"value\":\"Yes\"}]','<p><strong>How to use:</strong> Dab onto the centre of the lips and the apples of the cheeks, then blend with fingertips.</p><p><strong>Manufactured &amp; marketed by:</strong> Savié Amour, Mumbai, India.</p><p><strong>Country of origin:</strong> India</p><p>For external use only. Patch test before first use. Store in a cool, dry place away from direct sunlight.</p>',699.00,599.00,0,'in_stock','Shade','products/demo-velvet-tint.webp','products/demo-velvet-tint-hover.webp','Iconic Shade',1,1,0,1,'Velvet Lip & Cheek Tint | Savié Amour','A weightless, blendable tint that gives lips and cheeks a velvety flush of colour.',538,0,0.00,0,'2026-09-10 13:01:27',NULL),
(5,2,4,'Glass Kiss Water Tint','glass-kiss-water-tint','SA-TNT-002','A juicy water tint that stains lips with sheer, glassy colour.','<p>A water-light stain that sinks in for a just-bitten look, with a glassy sheen. Layer for more intensity or top with balm for shine.</p>','[{\"label\":\"Net quantity\",\"value\":\"4.5 ml\"},{\"label\":\"Finish\",\"value\":\"Glassy stain\"},{\"label\":\"Wear time\",\"value\":\"Up to 6 hours\"},{\"label\":\"Vegan\",\"value\":\"Yes\"}]','<p><strong>Manufactured &amp; marketed by:</strong> Savié Amour, Mumbai, India.</p><p><strong>Country of origin:</strong> India</p><p>For external use only. Patch test before first use. Store in a cool, dry place away from direct sunlight.</p>',599.00,NULL,0,'in_stock','Shade','products/demo-glass-tint.webp','products/demo-glass-tint-hover.webp',NULL,1,0,1,1,'Glass Kiss Water Tint | Savié Amour','A juicy water tint that stains lips with sheer, glassy colour.',64,0,0.00,0,'2026-11-20 13:01:27',NULL),
(6,2,3,'Matte Desire Liquid Tint','matte-desire-liquid-tint','SA-TNT-003','High-impact liquid colour that dries to a comfortable, transfer-proof matte.','<p>Saturated colour in a single swipe. Matte Desire dries down to a feather-light matte that will not crack or transfer.</p>','[{\"label\":\"Net quantity\",\"value\":\"4 ml\"},{\"label\":\"Finish\",\"value\":\"Transfer-proof matte\"},{\"label\":\"Wear time\",\"value\":\"Up to 12 hours\"}]','<p><strong>Manufactured &amp; marketed by:</strong> Savié Amour, Mumbai, India.</p><p><strong>Country of origin:</strong> India</p><p>For external use only. Patch test before first use. Store in a cool, dry place away from direct sunlight.</p>',749.00,649.00,0,'in_stock','Shade','products/demo-matte-tint.webp','products/demo-matte-tint-hover.webp',NULL,0,1,0,1,'Matte Desire Liquid Tint | Savié Amour','High-impact liquid colour that dries to a comfortable, transfer-proof matte.',301,0,0.00,0,'2026-09-25 13:01:27',NULL),
(7,2,3,'Bloom Cheek Tint','bloom-cheek-tint','SA-TNT-004','A sheer gel tint for a fresh, from-within flush on cheeks.','<p>A cooling gel tint that blends invisibly for a natural flush that lasts.</p>','[{\"label\":\"Net quantity\",\"value\":\"6 ml\"},{\"label\":\"Finish\",\"value\":\"Natural\"},{\"label\":\"Wear time\",\"value\":\"Up to 8 hours\"}]','<p><strong>Manufactured &amp; marketed by:</strong> Savié Amour, Mumbai, India.</p><p><strong>Country of origin:</strong> India</p><p>For external use only. Patch test before first use. Store in a cool, dry place away from direct sunlight.</p>',549.00,NULL,0,'in_stock','Shade','products/demo-bloom-tint.webp','products/demo-bloom-tint-hover.webp',NULL,0,0,0,1,'Bloom Cheek Tint | Savié Amour','A sheer gel tint for a fresh, from-within flush on cheeks.',77,0,0.00,0,'2026-10-15 13:01:27',NULL),
(8,3,5,'Noir Absolu Kohl Pencil','noir-absolu-kohl-pencil','SA-KHL-001','Our deepest black kohl — creamy, smudge-proof and safe for the waterline.','<p>An intensely black, creamy kohl that glides across the waterline without tugging and sets to a smudge-proof, water-resistant finish.</p><ul><li>Ophthalmologist tested</li><li>24-hour smudge-proof wear</li><li>Enriched with castor oil and camphor</li></ul>','[{\"label\":\"Net weight\",\"value\":\"1.2 g\"},{\"label\":\"Finish\",\"value\":\"Intense matte black\"},{\"label\":\"Wear time\",\"value\":\"Up to 24 hours\"},{\"label\":\"Ophthalmologist tested\",\"value\":\"Yes\"}]','<p><strong>How to use:</strong> Glide along the upper and lower waterline. Smudge within 30 seconds for a smoky look.</p><p><strong>Manufactured &amp; marketed by:</strong> Savié Amour, Mumbai, India.</p><p><strong>Country of origin:</strong> India</p><p>For external use only. Patch test before first use. Store in a cool, dry place away from direct sunlight.</p>',399.00,NULL,120,'in_stock',NULL,'products/demo-kohl-noir.webp','products/demo-kohl-noir-hover.webp','Best Seller',1,1,0,1,'Noir Absolu Kohl Pencil | Savié Amour','Our deepest black kohl — creamy, smudge-proof and safe for the waterline.',690,0,0.00,0,'2026-06-27 13:01:27',NULL),
(9,3,6,'Smoky Brown Kohl','smoky-brown-kohl','SA-KHL-002','A soft, smoky espresso kohl for subtle everyday definition.','<p>A warm espresso brown that defines without harshness — perfect for daytime and softer smoky eyes.</p>','[{\"label\":\"Net weight\",\"value\":\"1.2 g\"},{\"label\":\"Finish\",\"value\":\"Soft matte\"},{\"label\":\"Wear time\",\"value\":\"Up to 20 hours\"}]','<p><strong>Manufactured &amp; marketed by:</strong> Savié Amour, Mumbai, India.</p><p><strong>Country of origin:</strong> India</p><p>For external use only. Patch test before first use. Store in a cool, dry place away from direct sunlight.</p>',399.00,NULL,54,'in_stock',NULL,'products/demo-kohl-brown.webp','products/demo-kohl-brown-hover.webp',NULL,0,0,0,1,'Smoky Brown Kohl | Savié Amour','A soft, smoky espresso kohl for subtle everyday definition.',142,0,0.00,0,'2026-09-05 13:01:27',NULL),
(10,3,6,'Midnight Plum Kohl','midnight-plum-kohl','SA-KHL-003','A deep aubergine kohl that makes every eye colour glow.','<p>A rich plum with a hint of shimmer, designed to brighten brown and hazel eyes.</p>','[{\"label\":\"Net weight\",\"value\":\"1.2 g\"},{\"label\":\"Finish\",\"value\":\"Satin shimmer\"},{\"label\":\"Wear time\",\"value\":\"Up to 20 hours\"}]','<p><strong>Manufactured &amp; marketed by:</strong> Savié Amour, Mumbai, India.</p><p><strong>Country of origin:</strong> India</p><p>For external use only. Patch test before first use. Store in a cool, dry place away from direct sunlight.</p>',449.00,NULL,3,'in_stock',NULL,'products/demo-kohl-plum.webp','products/demo-kohl-plum-hover.webp',NULL,0,0,1,1,'Midnight Plum Kohl | Savié Amour','A deep aubergine kohl that makes every eye colour glow.',33,0,0.00,0,'2026-11-15 13:01:27',NULL),
(11,3,6,'Royal Emerald Kohl','royal-emerald-kohl','SA-KHL-004','A jewel-toned emerald kohl for festive, statement eyes.','<p>Deep, regal emerald with a satin finish — our favourite for celebrations.</p>','[{\"label\":\"Net weight\",\"value\":\"1.2 g\"},{\"label\":\"Finish\",\"value\":\"Satin\"},{\"label\":\"Wear time\",\"value\":\"Up to 20 hours\"}]','<p><strong>Manufactured &amp; marketed by:</strong> Savié Amour, Mumbai, India.</p><p><strong>Country of origin:</strong> India</p><p>For external use only. Patch test before first use. Store in a cool, dry place away from direct sunlight.</p>',449.00,379.00,26,'in_stock',NULL,'products/demo-kohl-emerald.webp','products/demo-kohl-emerald-hover.webp',NULL,0,0,0,1,'Royal Emerald Kohl | Savié Amour','A jewel-toned emerald kohl for festive, statement eyes.',58,0,0.00,0,'2026-10-10 13:01:27',NULL),
(12,3,7,'Kajal Duo Set','kajal-duo-set','SA-KHL-005','Noir Absolu and Smoky Brown kohl together — day to night in one set.','<p>The essential pairing: our cult Noir Absolu for intensity and Smoky Brown for softer days, presented in a gift sleeve.</p>','[{\"label\":\"Contents\",\"value\":\"2 × 1.2 g kohl pencils\"},{\"label\":\"Shades\",\"value\":\"Noir Absolu, Smoky Brown\"}]','<p><strong>Manufactured &amp; marketed by:</strong> Savié Amour, Mumbai, India.</p><p><strong>Country of origin:</strong> India</p><p>For external use only. Patch test before first use. Store in a cool, dry place away from direct sunlight.</p>',749.00,649.00,30,'in_stock',NULL,'products/demo-kohl-duo.webp','products/demo-kohl-duo-hover.webp','Gift Set',1,0,0,1,'Kajal Duo Set | Savié Amour','Noir Absolu and Smoky Brown kohl together — day to night in one set.',97,0,0.00,0,'2026-10-25 13:01:27',NULL),
(13,4,8,'Ink Noir Liquid Eyeliner','ink-noir-liquid-eyeliner','SA-EYE-001','A jet-black liquid liner with an ultra-fine brush for a razor-sharp wing.','<p>Glossy, jet-black ink and a fine, flexible brush for anything from a whisper-thin line to a dramatic wing. Waterproof and flake-free.</p>','[{\"label\":\"Net quantity\",\"value\":\"3.5 ml\"},{\"label\":\"Finish\",\"value\":\"Glossy black\"},{\"label\":\"Wear time\",\"value\":\"Up to 24 hours\"},{\"label\":\"Waterproof\",\"value\":\"Yes\"}]','<p><strong>Manufactured &amp; marketed by:</strong> Savié Amour, Mumbai, India.</p><p><strong>Country of origin:</strong> India</p><p>For external use only. Patch test before first use. Store in a cool, dry place away from direct sunlight.</p>',599.00,NULL,70,'in_stock',NULL,'products/demo-liner-noir.webp','products/demo-liner-noir-hover.webp',NULL,1,1,0,1,'Ink Noir Liquid Eyeliner | Savié Amour','A jet-black liquid liner with an ultra-fine brush for a razor-sharp wing.',355,0,0.00,0,'2026-08-16 13:01:27',NULL),
(14,4,9,'Precision Felt-Tip Liner','precision-felt-tip-liner','SA-EYE-002','A felt-tip liner pen with a firm, fine point for effortless control.','<p>The easiest way to a perfect line. A firm felt tip delivers even, saturated colour from the first stroke to the last.</p>','[{\"label\":\"Net quantity\",\"value\":\"1 ml\"},{\"label\":\"Tip\",\"value\":\"0.1 mm felt tip\"},{\"label\":\"Wear time\",\"value\":\"Up to 20 hours\"}]','<p><strong>Manufactured &amp; marketed by:</strong> Savié Amour, Mumbai, India.</p><p><strong>Country of origin:</strong> India</p><p>For external use only. Patch test before first use. Store in a cool, dry place away from direct sunlight.</p>',549.00,479.00,0,'in_stock','Shade','products/demo-liner-pen.webp','products/demo-liner-pen-hover.webp',NULL,0,0,1,1,'Precision Felt-Tip Liner | Savié Amour','A felt-tip liner pen with a firm, fine point for effortless control.',48,0,0.00,0,'2026-11-12 13:01:27',NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(120) NOT NULL,
  `rating` tinyint(3) unsigned NOT NULL,
  `title` varchar(190) DEFAULT NULL,
  `comment` text NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_reviews_product` (`product_id`,`status`),
  KEY `idx_reviews_customer` (`customer_id`),
  CONSTRAINT `fk_reviews_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_reviews_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `key` varchar(100) NOT NULL,
  `value` mediumtext DEFAULT NULL,
  `group` varchar(50) NOT NULL DEFAULT 'general',
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES
('admin_notification_email','orders@savieamour.com','email','2026-11-24 07:31:27'),
('announcement_messages','Complimentary shipping on orders above ₹999\nNew — Velvet Lip & Cheek Tint in four shades\nUse code AMOUR15 for 15% off the Bridal Edit','general','2026-11-24 07:31:27'),
('benefits','[{\"icon\":\"leaf\",\"title\":\"Cruelty-free & vegan\",\"text\":\"Never tested on animals, free of animal-derived ingredients.\"},{\"icon\":\"shield\",\"title\":\"Dermatologically tested\",\"text\":\"Gentle, skin-safe pigments made for everyday rituals.\"},{\"icon\":\"sparkle\",\"title\":\"Long-wear colour\",\"text\":\"Smudge-proof formulas that stay true from dawn to dusk.\"},{\"icon\":\"truck\",\"title\":\"Free shipping over ₹999\",\"text\":\"Fast, insured delivery with Cash on Delivery across India.\"}]','home','2026-11-24 07:31:27'),
('business_hours','Mon – Sat, 10:00 am – 7:00 pm IST','general','2026-11-24 07:31:27'),
('cod_enabled','1','shipping','2026-11-24 07:31:27'),
('cod_fee','0','shipping','2026-11-24 07:31:27'),
('copyright_text','© {year} Savié Amour. All rights reserved.','general','2026-11-24 07:31:27'),
('currency_code','INR','general','2026-11-24 07:31:27'),
('currency_symbol','₹','general','2026-11-24 07:31:27'),
('default_country','India','general','2026-11-24 07:31:27'),
('delivery_estimate','Delivered in 3–7 business days across India','shipping','2026-11-24 07:31:27'),
('facebook_url','https://www.facebook.com/savieamour','social','2026-11-24 07:31:27'),
('favicon','','general','2026-11-24 07:31:27'),
('footer_about','Savié Amour crafts ritual-inspired colour — sacred vermilion, velvet tints and kohl as deep as noir — for beauty that lingers.','general','2026-11-24 07:31:27'),
('free_shipping_threshold','999','shipping','2026-11-24 07:31:27'),
('google_analytics_id','','seo','2026-11-24 07:31:27'),
('gstin','','tax','2026-11-24 07:31:27'),
('guest_checkout','1','general','2026-11-24 07:31:27'),
('instagram_handle','@savieamour','social','2026-11-24 07:31:27'),
('instagram_url','https://www.instagram.com/savieamour','social','2026-11-24 07:31:27'),
('logo','','general','2026-11-24 07:31:27'),
('logo_light','','general','2026-11-24 07:31:27'),
('low_stock_threshold','5','general','2026-11-24 07:31:27'),
('mail_driver','log','email','2026-11-24 07:31:27'),
('mail_from_address','hello@savieamour.com','email','2026-11-24 07:31:27'),
('mail_from_name','Savié Amour','email','2026-11-24 07:31:27'),
('meta_description','Shop ritual-inspired beauty from Savié Amour: liquid & powder sindoor, velvet lip and cheek tints, smudge-proof kohl pencils and precision eyeliners. Free shipping over ₹999.','seo','2026-11-24 07:31:27'),
('meta_keywords','sindoor, liquid sindoor, lip tint, cheek tint, kohl pencil, kajal, eyeliner, Indian beauty','seo','2026-11-24 07:31:27'),
('meta_title','Savié Amour — The Art of Beauty | Sindoor, Lip Tints, Kohl & Eyeliner','seo','2026-11-24 07:31:27'),
('notify_admin_new_order','1','email','2026-11-24 07:31:27'),
('notify_customer_order_status','1','email','2026-11-24 07:31:27'),
('order_prefix','SA','general','2026-11-24 07:31:27'),
('pinterest_url','https://www.pinterest.com/savieamour','social','2026-11-24 07:31:27'),
('prices_include_tax','1','tax','2026-11-24 07:31:27'),
('products_per_page','12','general','2026-11-24 07:31:27'),
('razorpay_enabled','0','payment','2026-11-24 07:31:27'),
('razorpay_key_id','','payment','2026-11-24 07:31:27'),
('razorpay_key_secret','','payment','2026-11-24 07:31:27'),
('razorpay_webhook_secret','','payment','2026-11-24 07:31:27'),
('review_auto_approve','0','general','2026-11-24 07:31:27'),
('shipping_enabled','1','shipping','2026-11-24 07:31:27'),
('shipping_flat_rate','79','shipping','2026-11-24 07:31:27'),
('site_address','Savié Amour Studio\nBandra West, Mumbai 400050\nMaharashtra, India','general','2026-11-24 07:31:27'),
('site_email','hello@savieamour.com','general','2026-11-24 07:31:27'),
('site_name','Savié Amour','general','2026-11-24 07:31:27'),
('site_phone','+91 98200 00000','general','2026-11-24 07:31:27'),
('site_tagline','the art of beauty','general','2026-11-24 07:31:27'),
('smtp_encryption','tls','email','2026-11-24 07:31:27'),
('smtp_host','','email','2026-11-24 07:31:27'),
('smtp_password','','email','2026-11-24 07:31:27'),
('smtp_port','587','email','2026-11-24 07:31:27'),
('smtp_username','','email','2026-11-24 07:31:27'),
('tax_enabled','1','tax','2026-11-24 07:31:27'),
('tax_label','GST','tax','2026-11-24 07:31:27'),
('tax_rate','18','tax','2026-11-24 07:31:27'),
('whatsapp_number','919820000000','general','2026-11-24 07:31:27'),
('x_url','','social','2026-11-24 07:31:27'),
('youtube_url','','social','2026-11-24 07:31:27');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `social_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `social_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `caption` varchar(190) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `social_posts` WRITE;
/*!40000 ALTER TABLE `social_posts` DISABLE KEYS */;
INSERT INTO `social_posts` VALUES
(1,'social/demo-1.webp','https://www.instagram.com/savieamour','Sacred vermilion, one stroke.',1,1,'2026-11-24 13:01:27'),
(2,'social/demo-2.webp','https://www.instagram.com/savieamour','Velvet tints in every mood.',2,1,'2026-11-24 13:01:27'),
(3,'social/demo-3.webp','https://www.instagram.com/savieamour','Kohl as deep as noir.',3,1,'2026-11-24 13:01:27'),
(4,'social/demo-4.webp','https://www.instagram.com/savieamour','Swatch the shades.',4,1,'2026-11-24 13:01:27'),
(5,'social/demo-5.webp','https://www.instagram.com/savieamour','An heirloom for every ritual.',5,1,'2026-11-24 13:01:27'),
(6,'social/demo-6.webp','https://www.instagram.com/savieamour','The precision liner.',6,1,'2026-11-24 13:01:27');
/*!40000 ALTER TABLE `social_posts` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `subcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `subcategories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `name` varchar(120) NOT NULL,
  `slug` varchar(140) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_subcategories_slug` (`category_id`,`slug`),
  CONSTRAINT `fk_subcategories_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `subcategories` WRITE;
/*!40000 ALTER TABLE `subcategories` DISABLE KEYS */;
INSERT INTO `subcategories` VALUES
(1,1,'Liquid Sindoor','liquid-sindoor',NULL,NULL,1,1,'2026-11-24 13:01:27',NULL),
(2,1,'Powder Sindoor','powder-sindoor',NULL,NULL,2,1,'2026-11-24 13:01:27',NULL),
(3,2,'Lip & Cheek Tints','lip-cheek-tints',NULL,NULL,1,1,'2026-11-24 13:01:27',NULL),
(4,2,'Water Tints','water-tints',NULL,NULL,2,1,'2026-11-24 13:01:27',NULL),
(5,3,'Classic Kohl','classic-kohl',NULL,NULL,1,1,'2026-11-24 13:01:27',NULL),
(6,3,'Coloured Kohl','coloured-kohl',NULL,NULL,2,1,'2026-11-24 13:01:27',NULL),
(7,3,'Gift Sets','gift-sets',NULL,NULL,3,1,'2026-11-24 13:01:27',NULL),
(8,4,'Liquid Liner','liquid-liner',NULL,NULL,1,1,'2026-11-24 13:01:27',NULL),
(9,4,'Pen Liner','pen-liner',NULL,NULL,2,1,'2026-11-24 13:01:27',NULL);
/*!40000 ALTER TABLE `subcategories` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `testimonials` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `location` varchar(120) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `rating` tinyint(3) unsigned NOT NULL DEFAULT 5,
  `content` text NOT NULL,
  `product_name` varchar(190) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` VALUES
(1,'Ananya R.','Mumbai',NULL,5,'The liquid sindoor stayed perfect through my entire wedding day — not a single smudge. The colour is exactly the red I wanted.','Sacred Vermilion Liquid Sindoor',1,1,'2026-11-24 13:01:27'),
(2,'Meher K.','New Delhi',NULL,5,'Velvet Tint in Cherry Amour is my everyday shade now. It looks like my lips, only better, and it lasts through lunch.','Velvet Lip & Cheek Tint',2,1,'2026-11-24 13:01:27'),
(3,'Sanya P.','Bengaluru',NULL,5,'I have watery eyes and Noir Absolu is the first kohl that does not travel. Deep black, super creamy.','Noir Absolu Kohl Pencil',3,1,'2026-11-24 13:01:27'),
(4,'Ishita M.','Kolkata',NULL,5,'The kumkum box is so beautiful I keep it on my dressing table. Fine powder and a lovely deep colour.','Heritage Kumkum Powder Sindoor',4,1,'2026-11-24 13:01:27'),
(5,'Rhea D.','Pune',NULL,5,'Gorgeous packaging, quick delivery and the liner brush gives the sharpest wing I have ever managed.','Ink Noir Liquid Eyeliner',5,1,'2026-11-24 13:01:27');
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `wishlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_wishlist` (`customer_id`,`product_id`),
  KEY `idx_wishlist_product` (`product_id`),
  CONSTRAINT `fk_wishlist_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_wishlist_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `wishlist` WRITE;
/*!40000 ALTER TABLE `wishlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlist` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

