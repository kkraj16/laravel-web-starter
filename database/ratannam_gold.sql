-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 25, 2026 at 08:36 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ratannam_gold`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `record_id` bigint(20) UNSIGNED DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `subtitle`, `text_alignment`, `content_position`, `image_path`, `mobile_image_path`, `content_image_path`, `button_text`, `button_link`, `sort_order`, `is_active`, `show_content`, `show_content_image`, `overlay_opacity`, `animate_image`, `created_at`, `updated_at`) VALUES
(1, 'New Collection', NULL, 'center', 'center', '/images/banner1.jpg', NULL, NULL, NULL, NULL, 0, 0, 1, 1, 0.6, 1, '2026-01-25 00:10:25', '2026-01-25 00:24:27');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `slug`, `icon`, `parent_id`, `image`, `position`, `is_active`, `meta_title`, `meta_description`, `meta_keywords`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Gold Jewellery', 'Exquisite 22k and 18k gold jewellery collections.', 'gold-jewellery', 'bi bi-gem', NULL, NULL, 0, 1, 'Gold Jewellery - Ratannam Gold', 'Exquisite 22k and 18k gold jewellery collections.', NULL, NULL, '2026-01-25 00:10:25', '2026-01-25 00:10:25'),
(2, 'Silver Jewellery', 'Premium sterling silver accessories.', 'silver-jewellery', 'bi bi-stars', NULL, NULL, 1, 1, 'Silver Jewellery - Ratannam Gold', 'Premium sterling silver accessories.', NULL, NULL, '2026-01-25 00:10:25', '2026-01-25 00:10:25'),
(3, 'Bridal Jewellery', 'Complete bridal sets for your special day.', 'bridal-jewellery', 'bi bi-heart-fill', NULL, NULL, 2, 1, 'Bridal Jewellery - Ratannam Gold', 'Complete bridal sets for your special day.', NULL, NULL, '2026-01-25 00:10:25', '2026-01-25 00:10:25'),
(4, 'Daily Wear Jewellery', 'Lightweight and stylish jewellery for everyday elegance.', 'daily-wear-jewellery', 'bi bi-sun', NULL, NULL, 3, 1, 'Daily Wear Jewellery - Ratannam Gold', 'Lightweight and stylish jewellery for everyday elegance.', NULL, NULL, '2026-01-25 00:10:25', '2026-01-25 00:10:25'),
(5, 'Men & Kids', 'Exclusive collections for men and children.', 'men-kids', 'bi bi-people', NULL, NULL, 4, 1, 'Men & Kids - Ratannam Gold', 'Exclusive collections for men and children.', NULL, NULL, '2026-01-25 00:10:25', '2026-01-25 00:10:25'),
(6, 'Coins & Gifts', 'Gold/Silver coins and gifting articles.', 'coins-gifts', 'bi bi-coin', NULL, NULL, 5, 1, 'Coins & Gifts - Ratannam Gold', 'Gold/Silver coins and gifting articles.', NULL, NULL, '2026-01-25 00:10:25', '2026-01-25 00:10:25'),
(7, 'Gold Rings', NULL, 'gold-rings', NULL, NULL, NULL, 0, 1, NULL, NULL, NULL, NULL, '2026-01-25 00:10:25', '2026-01-25 00:10:25');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `is_vip` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

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
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL DEFAULT 'web',
  `group_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'product.view', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(2, 'product.create', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(3, 'product.edit', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(4, 'product.delete', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(5, 'category.view', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(6, 'category.create', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(7, 'category.edit', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(8, 'category.delete', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(9, 'order.view', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(10, 'order.create', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(11, 'order.edit', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(12, 'order.delete', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(13, 'customer.view', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(14, 'customer.create', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(15, 'customer.edit', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(16, 'customer.delete', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(17, 'review.view', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(18, 'review.create', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(19, 'review.edit', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(20, 'review.delete', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(21, 'banner.view', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(22, 'banner.create', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(23, 'banner.edit', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(24, 'banner.delete', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(25, 'user.view', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(26, 'user.create', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(27, 'user.edit', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(28, 'user.delete', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(29, 'role.view', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(30, 'role.create', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(31, 'role.edit', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(32, 'role.delete', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(33, 'settings.view', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(34, 'settings.create', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(35, 'settings.edit', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(36, 'settings.delete', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(37, 'dashboard.view', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(38, 'media.upload', 'web', NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `product_type` enum('simple','variable','digital') NOT NULL DEFAULT 'simple',
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `short_description`, `description`, `product_type`, `brand_id`, `price`, `sale_price`, `sale_start`, `sale_end`, `tax_class`, `sku`, `stock_quantity`, `manage_stock`, `stock_status`, `material`, `purity`, `weight`, `is_active`, `is_trending`, `show_on_homepage`, `thumbnail`, `gallery`, `meta_title`, `meta_description`, `meta_keywords`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Classic Gold Band', 'classic-gold-band', NULL, 'A timeless classic gold band.', 'simple', NULL, 25000.00, 23750.00, NULL, NULL, NULL, 'YXYTMJ24', 10, 1, 'instock', 'Gold', NULL, NULL, 1, 1, 0, 'products/VYtLNGYIJY3TdOzwswIRPL7zDdsSrcmlyav901rO.png', NULL, NULL, NULL, NULL, NULL, '2026-01-25 00:10:25', '2026-01-25 00:14:26');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `product_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 7, '2026-01-25 00:10:25', '2026-01-25 00:10:25');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `is_primary`, `created_at`, `updated_at`) VALUES
(1, 1, 'products/VYtLNGYIJY3TdOzwswIRPL7zDdsSrcmlyav901rO.png', 1, '2026-01-25 00:13:58', '2026-01-25 00:13:58');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `attributes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attributes`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL DEFAULT 'web',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(2, 'Manager', 'web', '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(3, 'Admin', 'web', '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(4, 'Customer', 'web', '2026-01-25 00:10:24', '2026-01-25 00:10:24');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(2, 3),
(3, 1),
(3, 2),
(3, 3),
(4, 1),
(4, 2),
(4, 3),
(5, 1),
(5, 2),
(5, 3),
(6, 1),
(6, 2),
(6, 3),
(7, 1),
(7, 2),
(7, 3),
(8, 1),
(8, 2),
(8, 3),
(9, 1),
(9, 2),
(9, 3),
(10, 1),
(10, 2),
(10, 3),
(11, 1),
(11, 2),
(11, 3),
(12, 1),
(12, 2),
(12, 3),
(13, 1),
(13, 3),
(14, 1),
(14, 3),
(15, 1),
(15, 3),
(16, 1),
(16, 3),
(17, 1),
(17, 2),
(17, 3),
(18, 1),
(18, 2),
(18, 3),
(19, 1),
(19, 2),
(19, 3),
(20, 1),
(20, 2),
(20, 3),
(21, 1),
(21, 2),
(21, 3),
(22, 1),
(22, 2),
(22, 3),
(23, 1),
(23, 2),
(23, 3),
(24, 1),
(24, 2),
(24, 3),
(25, 1),
(25, 3),
(26, 1),
(26, 3),
(27, 1),
(27, 3),
(28, 1),
(28, 3),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(33, 3),
(34, 1),
(34, 3),
(35, 1),
(35, 3),
(36, 1),
(37, 1),
(37, 2),
(37, 3),
(38, 1),
(38, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `type` varchar(255) NOT NULL DEFAULT 'string',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Ratannam Gold', 'general', 'string', NULL, NULL),
(2, 'site_logo', '/images/logo.png', 'general', 'string', NULL, NULL),
(3, 'contact_email', 'info@ratannam.com', 'general', 'string', NULL, NULL),
(4, 'currency_symbol', '₹', 'finance', 'string', NULL, NULL),
(5, 'active_theme', 'default', 'theme', 'string', NULL, NULL),
(6, 'rate_gold_24k', '156000', 'rates', 'number', '2026-01-25 00:19:58', '2026-01-25 00:19:58'),
(7, 'rate_gold_22k', '135000', 'rates', 'number', '2026-01-25 00:19:58', '2026-01-25 00:19:58'),
(8, 'rate_silver', '295000', 'rates', 'number', '2026-01-25 00:19:58', '2026-01-25 00:19:58'),
(9, 'show_gold_prices', '0', 'rates', 'boolean', '2026-01-25 00:19:58', '2026-01-25 00:20:16'),
(10, 'show_silver_prices', '0', 'rates', 'boolean', '2026-01-25 00:19:58', '2026-01-25 00:20:16'),
(11, 'app_name', 'Ratannam Gold', 'global', 'string', '2026-01-25 00:26:30', '2026-01-25 00:26:30'),
(12, 'hide_prices', '0', 'general', 'boolean', '2026-01-25 00:26:30', '2026-01-25 02:03:54'),
(13, 'store_phone', NULL, 'general', 'string', '2026-01-25 02:03:54', '2026-01-25 02:03:54'),
(14, 'contact_whatsapp', NULL, 'general', 'string', '2026-01-25 02:03:54', '2026-01-25 02:03:54'),
(15, 'map_coordinates', '25.773949, 73.339001', 'general', 'string', '2026-01-25 02:03:54', '2026-01-25 02:03:54'),
(16, 'contact_address', NULL, 'general', 'string', '2026-01-25 02:03:54', '2026-01-25 02:03:54'),
(17, 'google_map_embed', NULL, 'general', 'string', '2026-01-25 02:03:54', '2026-01-25 02:03:54');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL DEFAULT 5,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `review_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `directory_name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `avatar`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@ratannam.com', '2026-01-25 00:10:24', '$2y$12$FqwDh5jQxsBrb.MynBdkPOVcvhae8r0We5FgWgqBfyehNkl0tYwGy', NULL, NULL, 1, NULL, '2026-01-25 00:10:24', '2026-01-25 00:10:24'),
(2, 'Store Manager', 'manager@ratannam.com', '2026-01-25 00:10:25', '$2y$12$L58ywmFNkAhQajCGg3Xg4uui2z5Pf64qAmYX6.gx7IHqonuKNA.kW', NULL, NULL, 1, NULL, '2026-01-25 00:10:25', '2026-01-25 00:10:25'),
(3, 'John Doe', 'customer@ratannam.com', '2026-01-25 00:10:25', '$2y$12$ulPAREj9wT2gRIY.f1GEZefrRyeUqAZsDZXlPofhXqmSXFZac3j3O', NULL, NULL, 1, NULL, '2026-01-25 00:10:25', '2026-01-25 00:10:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD UNIQUE KEY `customers_user_id_unique` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_categories_product_id_foreign` (`product_id`),
  ADD KEY `product_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variants_product_id_foreign` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD CONSTRAINT `product_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_categories_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
