-- phpMyAdmin SQL Dump - UPGRADED VERSION
-- Production-Ready E-commerce Database
-- Version: 2.0
-- Generated: Dec 13, 2025

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- EXISTING TABLES (UPDATED)
-- --------------------------------------------------------

--
-- Table structure for table `products`
--
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) NOT NULL,
  `stock` int(11) DEFAULT 100,
  `sku` varchar(50) DEFAULT NULL,
  `weight` int(11) DEFAULT 500 COMMENT 'Weight in grams',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `category` (`category`),
  KEY `price` (`price`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--
INSERT INTO `products` (`id`, `name`, `price`, `image`, `description`, `category`, `stock`, `sku`, `weight`) VALUES
(1, 'Espresso', 20000.00, 'assets/img/Espresso.jpeg', 'Kopi Espresso murni dengan biji kopi pilihan terbaik.', 'Kopi', 50, 'KOP-001', 200),
(2, 'Americano', 22000.00, 'assets/img/americano.jpeg', 'Classic Americano untuk pecinta kopi hitam.', 'Kopi', 50, 'KOP-002', 200),
(3, 'Kopi Susu Ulu', 25000.00, 'assets/img/kopsuulu.jpeg', 'Signature Kopi Susu Ulu dengan gula aren asli.', 'Kopi', 100, 'KOP-003', 250),
(4, 'Kopi Susu Caramel', 28000.00, 'assets/img/kopsucaramel.jpeg', 'Kopi Susu dengan tambahan sirup karamel manis.', 'Kopi', 50, 'KOP-004', 250),
(5, 'Matcha Latte', 30000.00, 'assets/img/Matcha.jpeg', 'Minuman Matcha premium dengan susu.', 'Non Kopi', 50, 'NON-001', 250),
(6, 'Es Teh', 10000.00, 'assets/img/esteh.jpeg', 'Es Teh manis segar penyejuk dahaga.', 'Non Kopi', 100, 'NON-002', 250),
(7, 'Mie Goreng Spesial', 20000.00, 'assets/img/MieGoreng.jpeg', 'Mie Goreng nikmat dengan telur dan sayuran.', 'Makanan', 40, 'MAK-001', 300),
(8, 'Mie Rebus Spesial', 20000.00, 'assets/img/mierebus.jpeg', 'Mie Rebus hangat dengan kuah kaldu mantap.', 'Makanan', 40, 'MAK-002', 300),
(9, 'Nasi Ayam', 28000.00, 'assets/img/nasiay.jpeg', 'Nasi dengan olahan ayam spesial dan sambal.', 'Makanan', 30, 'MAK-003', 350),
(10, 'Nasi Sosis', 25000.00, 'assets/img/nasisos.jpeg', 'Nasi sosis praktis untuk teman nongkrong.', 'Makanan', 30, 'MAK-004', 350),
(11, 'Risol', 15000.00, 'assets/img/Risol.jpeg', 'Risol isi mayo yang renyah di luar, lembut di dalam.', 'Snack', 50, 'SNK-001', 150),
(12, 'Kentang Goreng', 18000.00, 'assets/img/kentang.jpeg', 'Kentang goreng renyah (French Fries).', 'Snack', 50, 'SNK-002', 200),
(13, 'Cireng Bumbu Rujak', 15000.00, 'assets/img/cireng.jpeg', 'Cireng hangat dengan bumbu rujak pedas manis.', 'Snack', 50, 'SNK-003', 200),
(14, 'Red Velvet', 30000.00, 'assets/img/Redvelvet.jpeg', 'Minuman manis rasa Red Velvet yang unik.', 'Non Kopi', 40, 'NON-003', 250),
(15, 'Lemon Tea', 18000.00, 'assets/img/lemon.jpeg', 'Teh Lemon segar cocok untuk siang hari.', 'Non Kopi', 50, 'NON-004', 250),
(16, 'Strawberry Mojito', 28000.00, 'assets/img/strawberimajito.jpeg', 'Mojito dengan sirup stroberi, mint dan soda.', 'Non Kopi', 40, 'NON-005', 250);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `role` varchar(20) DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--
INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `role`) VALUES
('ADM-001', 'Administrator', 'admin@toko.com', '$2y$10$8ZBO4a/l4M2.qPeCWM6OUeWz4BXkW7zUH6uQ1AtbtPglEofERKdoC', '2023-01-01 00:00:00', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--
CREATE TABLE `orders` (
  `id` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_address` text NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) DEFAULT 0.00,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `payment_status` varchar(20) DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_token` varchar(255) DEFAULT NULL,
  `courier` varchar(50) DEFAULT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `paid_at` datetime DEFAULT NULL,
  `shipped_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

CREATE TABLE `messages` (
  `id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

CREATE TABLE `newsletter_subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `subscribed_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('site_name', 'Ulu Coffe'),
('site_email', 'admin@toko.com'),
('site_phone', '0812-3456-7890'),
('site_address', 'Bandar Lampung, Indonesia'),
('tax_percentage', '0'),
('currency', 'IDR');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;