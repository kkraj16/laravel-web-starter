-- ============================================================
-- Ratannam Gold — Database Setup
-- Created: 2026-02-22
-- Description: Creates the full database schema and inserts
--              default seed data for a fresh installation.
-- Usage: Import via phpMyAdmin or CLI:
--   mysql -u root < database/ratannam_db_setup.sql
-- ============================================================

-- Create and select the database
CREATE DATABASE IF NOT EXISTS `ratannam_db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `ratannam_db`;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- 1. USERS & AUTH
-- ============================================================

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 2. RBAC (Roles & Permissions)
-- ============================================================

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL DEFAULT 'web',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL DEFAULT 'web',
  `group_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 3. CMS (Categories, Products, Reviews)
-- ============================================================

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `product_type` enum('simple','variable','digital') NOT NULL DEFAULT 'simple',
  `brand_id` bigint(20) unsigned DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `sale_start` datetime DEFAULT NULL,
  `sale_end` datetime DEFAULT NULL,
  `tax_class` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `manage_stock` tinyint(1) NOT NULL DEFAULT 1,
  `stock_status` enum('instock','outofstock','onbackorder') NOT NULL DEFAULT 'instock',
  `material` varchar(255) DEFAULT NULL,
  `purity` varchar(255) DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_trending` tinyint(1) NOT NULL DEFAULT 0,
  `show_on_homepage` tinyint(1) NOT NULL DEFAULT 0,
  `thumbnail` varchar(255) DEFAULT NULL,
  `gallery` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery`)),
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  UNIQUE KEY `products_sku_unique` (`sku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `product_images`;
CREATE TABLE `product_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE `product_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_categories_product_id_foreign` (`product_id`),
  KEY `product_categories_category_id_foreign` (`category_id`),
  CONSTRAINT `product_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_categories_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `product_variants`;
CREATE TABLE `product_variants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `attributes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attributes`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_variants_product_id_foreign` (`product_id`),
  CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 4. ORDERS
-- ============================================================

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `is_vip` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_email_unique` (`email`),
  UNIQUE KEY `customers_user_id_unique` (`user_id`),
  CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) NOT NULL,
  `customer_id` bigint(20) unsigned NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_customer_id_foreign` (`customer_id`),
  CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 5. SYSTEM (Settings, Themes, Audit Logs)
-- ============================================================

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `type` varchar(255) NOT NULL DEFAULT 'string',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `themes`;
CREATE TABLE `themes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `directory_name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `audit_logs`;
CREATE TABLE `audit_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `record_id` bigint(20) unsigned DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 6. TESTIMONIALS
-- ============================================================

DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `rating` tinyint(3) unsigned NOT NULL DEFAULT 5,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `review_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 7. BANNERS
-- ============================================================

DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `text_alignment` varchar(255) NOT NULL DEFAULT 'center',
  `content_position` varchar(255) NOT NULL DEFAULT 'center',
  `image_path` varchar(255) NOT NULL,
  `mobile_image_path` varchar(255) DEFAULT NULL,
  `content_image_path` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `show_content` tinyint(1) NOT NULL DEFAULT 1,
  `show_content_image` tinyint(1) NOT NULL DEFAULT 1,
  `overlay_opacity` decimal(3,1) NOT NULL DEFAULT 0.6,
  `animate_image` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 8. CACHE & QUEUE (Laravel Framework)
-- ============================================================

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 9. MIGRATIONS TRACKING
-- ============================================================

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- ============================================================
--  DEFAULT DATA INSERTS
-- ============================================================
-- ============================================================

-- -----------------------------------------------------------
-- Admin User (password: password)
-- -----------------------------------------------------------
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `avatar`, `is_active`, `remember_token`, `created_at`, `updated_at`)
VALUES (1, 'Admin', 'admin@ratannam.com', NOW(), '$2y$12$/egxex5Rix3kFjilUtXUUOw3DWrrJM0VJTI.s2vqPJbbMmFo2YpTS', NULL, NULL, 1, NULL, NOW(), NOW());

-- -----------------------------------------------------------
-- Roles
-- -----------------------------------------------------------
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', NOW(), NOW()),
(2, 'Admin', 'web', NOW(), NOW()),
(3, 'Manager', 'web', NOW(), NOW()),
(4, 'Customer', 'web', NOW(), NOW());

-- -----------------------------------------------------------
-- Permissions (42 total)
-- -----------------------------------------------------------
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(1,  'product.view',       'web', NULL, NOW(), NOW()),
(2,  'product.create',     'web', NULL, NOW(), NOW()),
(3,  'product.edit',       'web', NULL, NOW(), NOW()),
(4,  'product.delete',     'web', NULL, NOW(), NOW()),
(5,  'category.view',      'web', NULL, NOW(), NOW()),
(6,  'category.create',    'web', NULL, NOW(), NOW()),
(7,  'category.edit',      'web', NULL, NOW(), NOW()),
(8,  'category.delete',    'web', NULL, NOW(), NOW()),
(9,  'order.view',         'web', NULL, NOW(), NOW()),
(10, 'order.create',       'web', NULL, NOW(), NOW()),
(11, 'order.edit',         'web', NULL, NOW(), NOW()),
(12, 'order.delete',       'web', NULL, NOW(), NOW()),
(13, 'customer.view',      'web', NULL, NOW(), NOW()),
(14, 'customer.create',    'web', NULL, NOW(), NOW()),
(15, 'customer.edit',      'web', NULL, NOW(), NOW()),
(16, 'customer.delete',    'web', NULL, NOW(), NOW()),
(17, 'review.view',        'web', NULL, NOW(), NOW()),
(18, 'review.create',      'web', NULL, NOW(), NOW()),
(19, 'review.edit',        'web', NULL, NOW(), NOW()),
(20, 'review.delete',      'web', NULL, NOW(), NOW()),
(21, 'banner.view',        'web', NULL, NOW(), NOW()),
(22, 'banner.create',      'web', NULL, NOW(), NOW()),
(23, 'banner.edit',        'web', NULL, NOW(), NOW()),
(24, 'banner.delete',      'web', NULL, NOW(), NOW()),
(25, 'testimonial.view',   'web', NULL, NOW(), NOW()),
(26, 'testimonial.create', 'web', NULL, NOW(), NOW()),
(27, 'testimonial.edit',   'web', NULL, NOW(), NOW()),
(28, 'testimonial.delete', 'web', NULL, NOW(), NOW()),
(29, 'user.view',          'web', NULL, NOW(), NOW()),
(30, 'user.create',        'web', NULL, NOW(), NOW()),
(31, 'user.edit',          'web', NULL, NOW(), NOW()),
(32, 'user.delete',        'web', NULL, NOW(), NOW()),
(33, 'role.view',          'web', NULL, NOW(), NOW()),
(34, 'role.create',        'web', NULL, NOW(), NOW()),
(35, 'role.edit',          'web', NULL, NOW(), NOW()),
(36, 'role.delete',        'web', NULL, NOW(), NOW()),
(37, 'settings.view',      'web', NULL, NOW(), NOW()),
(38, 'settings.create',    'web', NULL, NOW(), NOW()),
(39, 'settings.edit',      'web', NULL, NOW(), NOW()),
(40, 'settings.delete',    'web', NULL, NOW(), NOW()),
(41, 'dashboard.view',     'web', NULL, NOW(), NOW()),
(42, 'media.upload',       'web', NULL, NOW(), NOW());

-- -----------------------------------------------------------
-- Assign Admin user → Super Admin role
-- -----------------------------------------------------------
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`)
VALUES (1, 'App\\Models\\User', 1);

-- -----------------------------------------------------------
-- Role-Permission Mapping
-- Super Admin (1): ALL permissions
-- Admin (2): Most permissions (no role mgmt, no settings.delete)
-- Manager (3): Product, Category, Order, Review, Banner, Testimonial, Dashboard, Media
-- -----------------------------------------------------------
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
-- Super Admin gets everything
(1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),
(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),
(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),
(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),
-- Admin
(1,2),(2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2),(10,2),(11,2),(12,2),
(13,2),(14,2),(15,2),(16,2),(17,2),(18,2),(19,2),(20,2),(21,2),(22,2),(23,2),(24,2),
(25,2),(26,2),(27,2),(28,2),(29,2),(30,2),(31,2),(32,2),
(37,2),(38,2),(39,2),(41,2),(42,2),
-- Manager
(1,3),(2,3),(3,3),(4,3),(5,3),(6,3),(7,3),(8,3),(9,3),(10,3),(11,3),(12,3),
(17,3),(18,3),(19,3),(20,3),(21,3),(22,3),(23,3),(24,3),
(25,3),(26,3),(27,3),(28,3),(41,3),(42,3);

-- -----------------------------------------------------------
-- Settings
-- -----------------------------------------------------------
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES
(1,  'site_name',         'Ratannam Gold',                                               'general', 'string',  NOW(), NOW()),
(2,  'site_tagline',      'Crafting timeless elegance since generations.',                'general', 'string',  NOW(), NOW()),
(3,  'site_logo',         '/images/logo.png',                                            'general', 'string',  NOW(), NOW()),
(4,  'active_theme',      'default',                                                     'general', 'string',  NOW(), NOW()),
(5,  'contact_email',     'info@ratannamgold.com',                                       'contact', 'string',  NOW(), NOW()),
(6,  'contact_phone',     '+91 9928154903',                                              'contact', 'string',  NOW(), NOW()),
(7,  'store_phone',       '+91 9928154903',                                              'contact', 'string',  NOW(), NOW()),
(8,  'contact_whatsapp',  '919928154903',                                                'contact', 'string',  NOW(), NOW()),
(9,  'contact_address',   'Opposite Bangur College, Pali, Rajasthan – 306401',           'contact', 'string',  NOW(), NOW()),
(10, 'map_coordinates',   '25.7711,73.3234',                                             'contact', 'string',  NOW(), NOW()),
(11, 'google_map_embed',  '',                                                            'contact', 'string',  NOW(), NOW()),
(12, 'social_facebook',   '#',                                                           'social',  'string',  NOW(), NOW()),
(13, 'social_instagram',  '#',                                                           'social',  'string',  NOW(), NOW()),
(14, 'social_twitter',    '#',                                                           'social',  'string',  NOW(), NOW()),
(15, 'currency_symbol',   '₹',                                                          'finance', 'string',  NOW(), NOW()),
(16, 'hide_prices',       '0',                                                           'finance', 'boolean', NOW(), NOW()),
(17, 'show_gold_prices',  '1',                                                           'finance', 'boolean', NOW(), NOW()),
(18, 'show_silver_prices','1',                                                           'finance', 'boolean', NOW(), NOW());

-- -----------------------------------------------------------
-- Categories
-- -----------------------------------------------------------
INSERT INTO `categories` (`id`, `name`, `description`, `slug`, `icon`, `parent_id`, `image`, `position`, `is_active`, `meta_title`, `meta_description`, `meta_keywords`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Gold Jewellery',       'Exquisite 22k and 18k gold jewellery collections.',              'gold-jewellery',       'bi bi-gem',        NULL, NULL, 0, 1, 'Gold Jewellery — Ratannam Gold',       'Exquisite 22k and 18k gold jewellery collections.',              NULL, NULL, NOW(), NOW()),
(2, 'Silver Jewellery',     'Premium sterling silver accessories.',                           'silver-jewellery',     'bi bi-stars',      NULL, NULL, 1, 1, 'Silver Jewellery — Ratannam Gold',     'Premium sterling silver accessories.',                           NULL, NULL, NOW(), NOW()),
(3, 'Bridal Jewellery',     'Complete bridal sets for your special day.',                     'bridal-jewellery',     'bi bi-heart-fill', NULL, NULL, 2, 1, 'Bridal Jewellery — Ratannam Gold',     'Complete bridal sets for your special day.',                     NULL, NULL, NOW(), NOW()),
(4, 'Daily Wear Jewellery', 'Lightweight and stylish jewellery for everyday elegance.',       'daily-wear-jewellery', 'bi bi-sun',        NULL, NULL, 3, 1, 'Daily Wear Jewellery — Ratannam Gold', 'Lightweight and stylish jewellery for everyday elegance.',       NULL, NULL, NOW(), NOW()),
(5, 'Men & Kids',           'Exclusive collections for men and children.',                    'men-kids',             'bi bi-people',     NULL, NULL, 4, 1, 'Men & Kids — Ratannam Gold',           'Exclusive collections for men and children.',                    NULL, NULL, NOW(), NOW()),
(6, 'Coins & Gifts',        'Gold/Silver coins and gifting articles.',                        'coins-gifts',          'bi bi-coin',       NULL, NULL, 5, 1, 'Coins & Gifts — Ratannam Gold',        'Gold/Silver coins and gifting articles.',                        NULL, NULL, NOW(), NOW()),
(7, 'Gold Rings',            NULL,                                                            'gold-rings',           NULL,               NULL, NULL, 0, 1, NULL,                                   NULL,                                                            NULL, NULL, NOW(), NOW());

-- -----------------------------------------------------------
-- Testimonials
-- -----------------------------------------------------------
INSERT INTO `testimonials` (`id`, `name`, `content`, `rating`, `is_active`, `review_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Anjali Gupta',     'Beautiful designs and very transparent pricing. I loved the transparency with the live rates. Will visit again.',                     5, 1, '2026-02-19', NOW(), NOW(), NULL),
(2, 'Rahul Verma',      'Excellent service and genuine quality. The staff was very helpful in helping me choose the perfect ring for my wife.',               5, 1, '2026-02-16', NOW(), NOW(), NULL),
(3, 'Priya Sharma',     'Absolutely stunning craftsmanship! The gold necklace I purchased was the highlight of my jewelry collection. Highly recommended.',   5, 1, '2026-02-11', NOW(), NOW(), NULL),
(4, 'Amit Singhania',   'Ratannam Gold is my go-to for investment gold. Their purity is guaranteed and the buy-back policies are very fair.',                 4, 1, '2026-02-06', NOW(), NOW(), NULL),
(5, 'Suman Rathore',    'I ordered a custom bangle set and it turned out exactly how I imagined. The detailing is exquisite. Thank you!',                     5, 1, '2026-02-01', NOW(), NOW(), NULL),
(6, 'Vikram Singh',     'Best jewellery showroom in Pali. The variety of designs in both gold and silver is amazing. Very polite staff.',                     5, 1, '2026-01-27', NOW(), NOW(), NULL);

-- -----------------------------------------------------------
-- Migrations Tracking (so Laravel knows schema is up-to-date)
-- -----------------------------------------------------------
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_17_045924_create_rbac_tables', 1),
(5, '2026_01_17_045937_create_cms_tables', 1),
(6, '2026_01_17_045937_create_order_tables', 1),
(7, '2026_01_17_045937_create_system_tables', 1),
(8, '2026_01_17_133000_create_testimonials_table', 1),
(9, '2026_01_18_084301_create_banners_table', 1);

-- ============================================================
-- DONE — Re-enable checks
-- ============================================================
SET FOREIGN_KEY_CHECKS = 1;
