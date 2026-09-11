CREATE DATABASE IF NOT EXISTS `nextrastore_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `nextrastore_db`;

-- ตารางผู้ใช้งาน
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(100) NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('user', 'admin') DEFAULT 'user',
    `balance` DECIMAL(10,2) DEFAULT 0.00,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ตารางสินค้าหลัก
CREATE TABLE IF NOT EXISTS `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `image` VARCHAR(255) NULL,
    `price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `stock` INT DEFAULT -1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ตารางเก็บแพ็กเกจระยะเวลาและราคาของสินค้า (กำหนดชั่วโมง/วันได้อิสระ)
CREATE TABLE IF NOT EXISTS `product_duration_prices` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT NOT NULL,
    `duration_value` INT NOT NULL,              -- เช่น 12, 1, 3, 7, 30
    `time_unit` ENUM('hour', 'day') NOT NULL,  -- 'hour' = ชั่วโมง, 'day' = วัน
    `price` DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
);

-- ตารางการตั้งค่าหน้าบ้านแบบ Full Control
CREATE TABLE IF NOT EXISTS `site_settings` (
    `setting_key` VARCHAR(100) PRIMARY KEY,
    `setting_value` TEXT NULL,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ข้อมูลตัวอย่างเริ่มต้น
INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `balance`) 
VALUES (1, '@admin9098', 'admin@nextrastore.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.X8aM4d662', 'admin', 999999.00)
ON DUPLICATE KEY UPDATE `role` = 'admin';

INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('site_name', 'NEXTRASTORE'),
('meta_description', 'NEXTRASTORE ศูนย์รวมบริการสินค้าดิจิทัล เติมเกม และบริการออนไลน์ 24 ชม.'),
('color_bg', '#000000'),
('color_card_bg', '#080808'),
('color_primary', '#1877f2'),
('color_btn_buy_start', '#51aed9'),
('color_btn_buy_end', '#358bb5'),
('marquee_enabled', '1'),
('marquee_text', '📢 ยินดีต้อนรับสู่ NEXTRASTORE! สินค้าปลอดภัยมีแอดมินบริการ 24 ชม. 🚀'),
('marquee_speed', '22'),
('popular_title', 'Popular'),
('footer_title', 'NEXTRASTORE'),
('footer_subtitle', '🛡️ สินค้าปลอดภัยมีแอดมินบริการ 24 ชม.'),
('footer_btn1_text', 'เลือกดูสินค้า'),
('footer_btn1_url', '#products'),
('footer_btn2_text', 'ตรวจสอบการซื้อ'),
('footer_btn2_url', '#history'),
('copyright_text', '© 2026 NEXTRASTORE Platform. All rights reserved.'),
('custom_css', ''),
('custom_js', '')
ON DUPLICATE KEY UPDATE `setting_key` = `setting_key`;

-- ตัวอย่างสินค้าพร้อมแพ็กเกจเวลา
INSERT INTO `products` (`id`, `name`, `image`, `price`, `stock`) VALUES
(1, 'READY MANAGER VIP', 'https://via.placeholder.com/400x400/0f172a/ffffff?text=READY+MANAGER', 50.00, 36);

INSERT INTO `product_duration_prices` (`product_id`, `duration_value`, `time_unit`, `price`) VALUES
(1, 12, 'hour', 50.00),
(1, 1, 'day', 90.00),
(1, 7, 'day', 500.00);
