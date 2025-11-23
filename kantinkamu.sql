-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2025 at 06:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kantinkamu`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Makanan', 'makanan'),
(2, 'Minuman', 'minuman');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(160) NOT NULL,
  `description` text DEFAULT NULL,
  `price` int(10) UNSIGNED NOT NULL,
  `stock` int(10) UNSIGNED DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_popular` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `stock`, `image`, `is_active`, `is_popular`, `created_at`, `updated_at`) VALUES
(1, 1, 'karee raitsu', 'karee-raitsu', 'Rich and aromatic Japanese curry.', 24000, 10, '5.png', 1, 1, '2025-11-10 00:49:27', '2025-11-16 10:46:07'),
(2, 1, 'bulgogi bowl', 'bulgogi-bowl', 'Grilled marinated beef with rice.', 26000, 5, '4.png', 1, 1, '2025-11-10 00:49:27', '2025-11-16 10:45:56'),
(3, 1, 'kimchi fried rice', 'kimchi-fried-rice', 'Stir-fried rice with kimchi and vegetables.', 60000, 10, '2.png', 1, 1, '2025-11-10 00:49:27', '2025-11-16 10:45:45'),
(4, 1, 'Crispy sambal matah', 'crispy-sambal-matah', 'Crispy chicken with healthy vegetables.', 30000, 10, '4-1762742721.png', 1, 0, '2025-11-10 00:49:27', '2025-11-16 10:45:34'),
(6, 1, 'ayam goreng', 'ayam-goreng', 'enak', 10000, 9, '6-1762757767.jpeg', 1, 0, NULL, NULL),
(12, 2, 'es teh', 'es-teh', 'manis', 3000, 10, '12-1762767646.webp', 1, 0, NULL, '2025-11-16 10:45:23'),
(13, 1, 'Mie Ayam', 'mie-ayam', 'Mie ayam yang lezat', 6000, 10, '13-1762921588.jpeg', 1, 1, NULL, '2025-11-16 10:45:13');

-- --------------------------------------------------------

--
-- Table structure for table `menu_categories`
--

CREATE TABLE `menu_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_categories`
--

INSERT INTO `menu_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Signature', '2025-11-10 00:49:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-11-10-000001', 'App\\Database\\Migrations\\CreateRoles', 'default', 'App', 1762735745, 1),
(2, '2025-11-10-000002', 'App\\Database\\Migrations\\CreateUsers', 'default', 'App', 1762735746, 1),
(3, '2025-11-10-000003', 'App\\Database\\Migrations\\CreateMenuCategories', 'default', 'App', 1762735746, 1),
(4, '2025-11-10-000004', 'App\\Database\\Migrations\\CreateMenus', 'default', 'App', 1762735746, 1),
(5, '2025-11-10-000005', 'App\\Database\\Migrations\\CreateOrders', 'default', 'App', 1762735746, 1),
(6, '2025-11-10-000006', 'App\\Database\\Migrations\\CreateOrderItems', 'default', 'App', 1762735746, 1),
(7, '2025-11-10-000007', 'App\\Database\\Migrations\\CreatePayments', 'default', 'App', 1762735746, 1),
(8, '2025-11-10-000008', 'App\\Database\\Migrations\\AddStockToMenus', 'default', 'App', 1762745029, 2),
(9, '2025-11-10-000009', 'App\\Database\\Migrations\\AddIsPopularToMenus', 'default', 'App', 1762758213, 3),
(10, '2025-11-10-000010', 'App\\Database\\Migrations\\AddCategories', 'default', 'App', 1762760868, 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(30) NOT NULL,
  `status` enum('pending','paid','processing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `total_amount` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `code`, `status`, `total_amount`, `created_at`) VALUES
(30, 1, 'ORD251116104620', '', 26000, '2025-11-16 10:46:20'),
(31, 1, 'ORD251116104842', '', 26000, '2025-11-16 10:48:42'),
(32, 1, 'ORD251116105004', '', 26000, '2025-11-16 10:50:04'),
(33, 1, 'ORD251116105049', '', 26000, '2025-11-16 10:50:49'),
(44, 11, 'ORD251119103734', '', 10000, '2025-11-19 10:37:34'),
(45, 11, 'ORD251119225326', '', 26000, '2025-11-19 22:53:26');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `qty` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `price` int(10) UNSIGNED NOT NULL,
  `subtotal` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `menu_id`, `name`, `qty`, `price`, `subtotal`) VALUES
(30, 30, 2, 'bulgogi bowl', 1, 26000, 26000),
(31, 31, 2, 'bulgogi bowl', 1, 26000, 26000),
(32, 32, 2, 'bulgogi bowl', 1, 26000, 26000),
(33, 33, 2, 'bulgogi bowl', 1, 26000, 26000),
(44, 44, 6, 'ayam goreng', 1, 10000, 10000),
(45, 45, 2, 'bulgogi bowl', 1, 26000, 26000);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `method` varchar(50) NOT NULL,
  `amount` int(10) UNSIGNED NOT NULL,
  `paid_at` datetime DEFAULT NULL,
  `status` enum('unpaid','paid','failed') NOT NULL DEFAULT 'unpaid',
  `notes` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2025-11-10 00:49:27', NULL),
(2, 'pembeli', '2025-11-10 00:49:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `npm` varchar(10) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `building` varchar(100) DEFAULT NULL,
  `room` varchar(100) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `npm`, `email`, `password_hash`, `is_active`, `created_at`, `updated_at`, `building`, `room`, `note`) VALUES
(1, 1, 'Admin Kantin', '1234567890', 'admin@kantin.local', '$2y$10$yuv5HuyfeRt0602YU9cQhurgu7Qnx/9TsUPbYWtQQaaVnqphigEkW', 1, '2025-11-10 00:49:27', NULL, NULL, NULL, NULL),
(2, 2, 'Budi Pembeli', NULL, 'budi@kantin.local', '$2y$10$VwEjAkdsVmPIj2kiSgxX9.mJzvEeIqHSWXtrLcQdgFiRym8m8rF7.', 1, '2025-11-10 00:49:27', NULL, NULL, NULL, NULL),
(4, 2, 'bintang', NULL, 'bintang123@gmail.com', '$2y$10$rPQ0RiuIFNSk8NKovbxqN.8oSUw3GjipQUdNtIdt.AiPVwSm8cvzi', 1, NULL, NULL, NULL, NULL, NULL),
(5, 2, 'fernanda', NULL, 'fernanda54321@gmail.com', '$2y$10$EFlTttQXgDefv7mu2dbNV.8KmHSuB5HswaH/AHZ/.tyV4OhNEEzFK', 1, NULL, NULL, NULL, NULL, NULL),
(9, 2, 'arya', NULL, 'arya123@gmail.com', '$2y$10$pt7bkYi3OrvHuy9BD4RVkOqbg3VCn8hEegCpLw0QINsAIQrg6BxP2', 1, NULL, NULL, NULL, NULL, NULL),
(10, 2, 'putra bintang', NULL, 'bintang321@gmail.com', '$2y$10$ZBHPQQBDfnrIYzuMh5SgQukwGomSlVVeIdj/m6PvcNmjJxc7Q7yJ2', 1, NULL, NULL, NULL, NULL, NULL),
(11, 2, 'Muhammad Ramadhan Putra Bintang', '2313030012', '', '$2y$10$de0.siyMbJCnmqFoC7nNDOo3WPCe7sN76Nf1Hf8zoWuBfx8XiZ1Ya', 1, '2025-11-12 02:45:37', NULL, NULL, NULL, NULL),
(14, 2, 'Rico Aditio', '2313030067', '', '$2y$10$cZYdQHL6bij599VI56DoO.fXZfUkQzPbRK76zNqTUgGuBzQcCImpq', 1, '2025-11-12 04:07:33', NULL, NULL, NULL, NULL),
(15, 2, 'arya', '2313030021', '', '$2y$10$hEQHuyrkxWCqKtq1uGdDc.n52oiI6LDNtGgcLgG44I/ld3eHkU3v6', 1, '2025-11-12 07:26:53', NULL, NULL, NULL, NULL),
(16, 2, 'ridho banda gilardino', '2313030136', '', '$2y$10$N3RIVs3t8i57FHWTpcu8SeGdVJ9Ir884xQlRwV/BBPM/sYbWidIz2', 1, '2025-11-16 09:38:17', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `building` varchar(100) NOT NULL,
  `room` varchar(100) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `menus_category_id_foreign` (`category_id`);

--
-- Indexes for table `menu_categories`
--
ALTER TABLE `menu_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_address_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `menu_categories`
--
ALTER TABLE `menu_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `fk_user_address_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
