-- 1. Create the seo_metas table
CREATE TABLE IF NOT EXISTS `seo_metas` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `seoable_id` bigint(20) unsigned DEFAULT NULL,
    `seoable_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `page_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `route_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `meta_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `meta_keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `canonical_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `og_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `og_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `og_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `robots` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'index, follow',
    `structured_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `seo_metas_seoable_id_seoable_type_index` (`seoable_id`,`seoable_type`),
    KEY `seo_metas_page_path_index` (`page_path`),
    KEY `seo_metas_route_name_index` (`route_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Populate Static Page SEO (Home, About, Contact)
REPLACE INTO `seo_metas` (`route_name`, `page_path`, `meta_title`, `meta_description`, `meta_keywords`, `canonical_url`, `og_title`, `og_description`, `og_image`, `robots`, `created_at`, `updated_at`)
VALUES 
('home', '/', 'Ratannam Gold | Luxury BIS Hallmarked Gold & Diamond Jewellery in Pali', 'Discover the finest 22K BIS Hallmarked gold jewellery at Ratannam Gold, Pali. Exclusive bridal collections, designer necklaces, and Rajputana heritage jewellery. Purity guaranteed since 1994.', 'Ratannam Gold Pali, 22K Hallmarked Gold, Bridal Jewellery Rajasthan, Diamond Jewellery Pali, KK Rajpurohit Jewellers, Traditional Rajasthani Jewellery, Gold Shop near me', 'http://localhost/ratannam-prod/public/', 'Ratannam Gold | Premium Jewellery & Heritage Collections', 'Experience the artistry of traditional and modern gold jewellery. 100% BIS Hallmarked pieces handcrafted for the modern bride.', 'uploads/seo/home-og.jpg', 'index, follow', NOW(), NOW()),

('about', '/about', 'Our Heritage | Ratannam Gold - Legacy of Purity & Trust Since 1994', 'Founded by KK Rajpurohit, Ratannam Gold is a name synonymous with 916 purity and artistic excellence in Pali, Rajasthan. Experience three decades of handcrafted luxury.', 'Ratannam Gold Story, KK Rajpurohit, History of Ratannam Gold, Trusted Jewellers Pali, Traditional Rajasthani Craftsmanship, Gold Purity 916', 'http://localhost/ratannam-prod/public/about', 'The Legacy of Ratannam Gold', 'A tradition of trust and artistic brilliance. Learn about our journey in crafting perfection for over 30 years.', NULL, 'index, follow', NOW(), NOW()),

('contact', '/contact', 'Visit Us | Ratannam Gold Showroom in Pali - Expert Consultations', 'Visit our luxury boutique in Pali, Rajasthan for exclusive designs. Contact our experts for custom bridal sets and live gold market rates.', 'Ratannam Gold Location, Jewellery Shop Pali Rajasthan, Custom Jewellery Orders, Gold Rate Pali, Visit Ratannam Gold Showroom, KK Rajpurohit Contact', 'http://localhost/ratannam-prod/public/contact', 'Reach Out to Ratannam Gold Pali', 'Book a private consultation or visit our boutique. We are here to help you find your next heirloom.', NULL, 'index, follow', NOW(), NOW());

-- 3. Update Category SEO
INSERT INTO `seo_metas` (`seoable_id`, `seoable_type`, `meta_title`, `meta_description`, `meta_keywords`, `og_title`, `og_description`, `robots`, `canonical_url`, `created_at`, `updated_at`)
SELECT id, 'App\\Models\\Category', 'Gold Jewellery Collection | 22K BIS Hallmarked | Ratannam Gold', 'Explore our stunning range of 22K gold jewellery. From traditional kundan to modern lightweight designs, find the perfect piece for every celebration.', '22k gold jewellery, hallmarked gold, gold ornaments, traditional gold designs, modern gold jewellery', 'Gold Jewellery Collection | 22K BIS Hallmarked | Ratannam Gold', 'Explore our stunning range of 22K gold jewellery. From traditional kundan to modern lightweight designs, find the perfect piece for every celebration.', 'index, follow', 'http://localhost/ratannam-prod/public/category/gold-jewellery', NOW(), NOW()
FROM `categories` WHERE `slug` = 'gold-jewellery' AND id NOT IN (SELECT seoable_id FROM seo_metas WHERE seoable_type = 'App\\Models\\Category');

INSERT INTO `seo_metas` (`seoable_id`, `seoable_type`, `meta_title`, `meta_description`, `meta_keywords`, `og_title`, `og_description`, `robots`, `canonical_url`, `created_at`, `updated_at`)
SELECT id, 'App\\Models\\Category', 'Fine Silver Jewellery & Articles | Pure Silver | Ratannam Gold', 'Discover elegant silver jewellery and ceremonial articles. High-purity silver ornaments handcrafted with precision and care.', 'silver jewellery, pure silver articles, silver ornaments, silver gifts, handcrafted silver', 'Fine Silver Jewellery & Articles | Pure Silver | Ratannam Gold', 'Discover elegant silver jewellery and ceremonial articles. High-purity silver ornaments handcrafted with precision and care.', 'index, follow', 'http://localhost/ratannam-prod/public/category/silver-jewellery', NOW(), NOW()
FROM `categories` WHERE `slug` = 'silver-jewellery' AND id NOT IN (SELECT seoable_id FROM seo_metas WHERE seoable_type = 'App\\Models\\Category');

INSERT INTO `seo_metas` (`seoable_id`, `seoable_type`, `meta_title`, `meta_description`, `meta_keywords`, `og_title`, `og_description`, `robots`, `canonical_url`, `created_at`, `updated_at`)
SELECT id, 'App\\Models\\Category', 'Exquisite Bridal Jewellery | Wedding Collection | Ratannam Gold', 'Make your big day unforgettable with our royal bridal collection. Heavy kundan sets, temple jewellery, and designer bridal ornaments in 22K gold.', 'bridal gold jewellery, wedding jewellery set, kundan bridal set, temple jewellery, wedding gold ornaments', 'Exquisite Bridal Jewellery | Wedding Collection | Ratannam Gold', 'Make your big day unforgettable with our royal bridal collection. Heavy kundan sets, temple jewellery, and designer bridal ornaments in 22K gold.', 'index, follow', 'http://localhost/ratannam-prod/public/category/bridal-jewellery', NOW(), NOW()
FROM `categories` WHERE `slug` = 'bridal-jewellery' AND id NOT IN (SELECT seoable_id FROM seo_metas WHERE seoable_type = 'App\\Models\\Category');

INSERT INTO `seo_metas` (`seoable_id`, `seoable_type`, `meta_title`, `meta_description`, `meta_keywords`, `og_title`, `og_description`, `robots`, `canonical_url`, `created_at`, `updated_at`)
SELECT id, 'App\\Models\\Category', 'Designer Gold Rings | Wedding, Engagement & Daily Wear | Ratannam Gold', 'Find the perfect ring for every finger. Browse our collection of engagement rings, wedding bands, and daily wear gold rings in unique designs.', 'gold rings, engagement rings, gold wedding bands, ladies gold rings, mens gold rings', 'Designer Gold Rings | Wedding, Engagement & Daily Wear | Ratannam Gold', 'Find the perfect ring for every finger. Browse our collection of engagement rings, wedding bands, and daily wear gold rings in unique designs.', 'index, follow', 'http://localhost/ratannam-prod/public/category/gold-rings', NOW(), NOW()
FROM `categories` WHERE `slug` = 'gold-rings' AND id NOT IN (SELECT seoable_id FROM seo_metas WHERE seoable_type = 'App\\Models\\Category');

-- 4. Update Dynamic Footer Contact Settings
UPDATE `settings` SET `value` = '+91 9950199935' WHERE `key` = 'store_phone';
UPDATE `settings` SET `value` = 'ratannamgold@zohomail.in' WHERE `key` = 'contact_email';
