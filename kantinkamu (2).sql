-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2025 at 11:36 PM
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
(4, 1, 'Nasi Lodeh', 'nasi-lodeh', 'enak', 6000, 20, '4-1764032410.webp', 1, 1, '2025-11-10 00:49:27', '2025-12-09 20:09:04'),
(6, 1, 'Nasi Pecel', 'nasi-pecel', 'enak', 7000, 20, '6-1765122537.jpg', 1, 0, NULL, '2025-12-08 11:11:50'),
(12, 2, 'Es Teh', 'es-teh', 'manis', 3000, 19, '12-1762767646.webp', 1, 0, NULL, '2025-11-29 09:37:39'),
(13, 1, 'Soto', 'soto', 'Soto\r\n yang lezat', 6000, 20, '13-1765157815.png', 1, 0, NULL, '2025-12-10 13:42:17'),
(14, 1, 'Nasi Lele', 'nasi-lele', 'enak', 7000, 22, '14-1764033199.webp', 1, 1, '2025-11-25 01:13:19', '2025-12-03 15:02:00'),
(15, 1, 'Nasi Ayam Kremes', 'nasi-ayam-kremes', 'enak', 8000, 19, '15-1764033306.webp', 1, 1, '2025-11-25 01:15:06', '2025-12-09 20:08:41'),
(16, 2, 'Kopi Susu Gelas', 'kopi-susu-gelas', 'manis', 3000, 19, '16-1764033530.webp', 1, 0, '2025-11-25 01:18:50', '2025-11-29 09:37:02'),
(17, 2, 'Es Jeruk', 'es-jeruk', 'manis', 4000, 12, '17-1764033638.webp', 1, 0, '2025-11-25 01:20:38', '2025-12-03 15:01:35'),
(18, 2, 'Es Susu', 'es-susu', 'manis', 4000, 19, '18-1764033791.webp', 1, 0, '2025-11-25 01:23:11', '2025-12-03 15:01:28'),
(19, 2, 'Es Joshua', 'es-joshua', 'manis', 5000, 13, '19-1764033870.webp', 1, 0, '2025-11-25 01:24:30', '2025-12-09 20:08:15'),
(21, 1, 'Nasi Ayam Bali', 'nasi-ayam-bali', 'lezat dan menggiurkan', 8000, 19, '21-1765167873.jpg', 1, 0, '2025-12-08 11:24:33', '2025-12-08 11:24:33'),
(22, 1, 'Nasi Telur Bali', 'nasi-telur-bali', 'lezatt', 7000, 20, '22-1765168462.jpg', 1, 0, '2025-12-08 11:34:21', '2025-12-08 11:34:22'),
(23, 1, 'Nasi Rames', 'nasi-rames', 'enak', 8000, 20, '23-1765168667.jpg', 1, 0, '2025-12-08 11:37:47', '2025-12-08 11:37:47'),
(24, 1, 'Mie Instan Goreng', 'mie-instan-goreng', 'enak dan lezat', 5000, 19, '24-1765168884.jpg', 1, 0, '2025-12-08 11:41:24', '2025-12-08 11:41:24'),
(25, 1, 'Mie Instan Kuah', 'mie-instan-kuah', 'enak', 5000, 19, '25-1765169000.jpg', 1, 0, '2025-12-08 11:43:20', '2025-12-08 11:43:20'),
(26, 1, 'Mie Instan Goreng + Telur', 'mie-instan-goreng-telur', 'enak', 8000, 19, '26-1765169132.jpg', 1, 0, '2025-12-08 11:45:32', '2025-12-08 11:45:32'),
(27, 1, 'Mie Instan Kuah + Telur', 'mie-instan-kuah-telur', 'lezat', 8000, 19, '27-1765169292.jpg', 1, 0, '2025-12-08 11:48:12', '2025-12-08 11:48:12'),
(28, 1, 'Intermie', 'intermie', 'enak', 3000, 18, '28-1765169729.jpg', 1, 0, '2025-12-08 11:55:29', '2025-12-08 11:55:42'),
(29, 1, 'Intermie + Telur', 'intermie-telur', 'lezat', 6000, 18, '29-1765169898.jpg', 1, 0, '2025-12-08 11:58:18', '2025-12-08 11:58:18'),
(30, 1, 'Mie Goreng', 'mie-goreng', 'enak', 10000, 19, '30-1765170088.jpg', 1, 0, '2025-12-08 12:01:28', '2025-12-08 12:01:28'),
(31, 1, 'Mie Godog', 'mie-godog', 'lezat', 10000, 19, '31-1765170199.webp', 1, 0, '2025-12-08 12:03:19', '2025-12-08 12:03:19'),
(32, 1, 'Nasi Goreng', 'nasi-goreng', 'enak', 10000, 20, '32-1765170331.jpg', 1, 0, '2025-12-08 12:05:31', '2025-12-08 12:05:31'),
(33, 1, 'Nasi Goreng Mawot', 'nasi-goreng-mawot', 'lezat', 10000, 20, '33-1765170497.jpg', 1, 0, '2025-12-08 12:08:17', '2025-12-08 12:08:17'),
(34, 1, 'Mi Seblak', 'mi-seblak', 'enak', 10000, 15, '34-1765170620.jpg', 1, 1, '2025-12-08 12:10:20', '2025-12-10 13:43:33'),
(35, 2, 'Kopi Hitam Gelas', 'kopi-hitam-gelas', 'manis', 3000, 19, '35-1765170821.jpg', 1, 0, '2025-12-08 12:13:41', '2025-12-08 12:13:41'),
(36, 2, 'Kopi Hitam Cangkir', 'kopi-hitam-cangkir', '...', 2000, 19, '36-1765285385.jpg', 1, 0, '2025-12-09 20:03:05', '2025-12-09 20:03:05'),
(37, 2, 'Kopi Susu Cangkir', 'kopi-susu-cangkir', '...', 2500, 19, '37-1765285505.jpg', 1, 0, '2025-12-09 20:05:05', '2025-12-09 20:05:05'),
(38, 2, 'Teh Panas', 'teh-panas', '...', 3000, 20, '38-1765285629.jpg', 1, 0, '2025-12-09 20:07:09', '2025-12-09 20:07:09'),
(39, 2, 'Jeruk Panas', 'jeruk-panas', '...\r\n', 4000, 19, '39-1765285882.jpg', 1, 0, '2025-12-09 20:11:22', '2025-12-09 20:12:04'),
(40, 2, 'Wedang Jahe', 'wedang-jahe', '...', 3000, 20, '40-1765286719.jpg', 1, 0, '2025-12-09 20:14:23', '2025-12-09 20:25:19'),
(41, 2, 'Susu Jahe', 'susu-jahe', '...', 4000, 20, '41-1765286174.jpg', 1, 0, '2025-12-09 20:16:14', '2025-12-09 20:16:14'),
(42, 2, 'Susu Hangat', 'susu-hangat', '...', 4000, 20, '42-1765286306.jpg', 1, 0, '2025-12-09 20:18:26', '2025-12-09 20:18:26'),
(43, 2, 'Es Kuku Bima', 'es-kuku-bima', '...', 3000, 13, '43-1765286441.jpg', 1, 0, '2025-12-09 20:20:41', '2025-12-09 20:20:41'),
(44, 2, 'Es Sisri', 'es-sisri', '...', 1000, 19, '44-1765286540.jpg', 1, 0, '2025-12-09 20:22:20', '2025-12-09 20:22:20');

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
(10, '2025-11-10-000010', 'App\\Database\\Migrations\\AddCategories', 'default', 'App', 1762760868, 4),
(11, '2025-11-10-000011', 'App\\Database\\Migrations\\AddPaymentColumnsToOrders', 'default', 'App', 1764643058, 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(30) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `payment_status` varchar(20) DEFAULT 'unpaid',
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `delivery_method` enum('pickup','delivery') NOT NULL DEFAULT 'pickup',
  `delivery_address_id` int(10) UNSIGNED DEFAULT NULL,
  `delivery_fee` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `total_amount` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `code`, `status`, `payment_status`, `payment_method`, `payment_type`, `delivery_method`, `delivery_address_id`, `delivery_fee`, `total_amount`, `created_at`) VALUES
(87, 29, 'ORD251209213413', 'completed', 'paid', NULL, NULL, 'delivery', 1, 0, 23000, '2025-12-09 21:34:13'),
(97, 29, 'ORD251209223152', 'processing', 'unpaid', NULL, NULL, 'pickup', NULL, 0, 13000, '2025-12-09 22:31:52'),
(99, 29, 'ORD251209223311', 'processing', 'unpaid', NULL, NULL, 'pickup', NULL, 0, 9000, '2025-12-09 22:33:11'),
(101, 29, 'ORD251209223354', 'processing', 'unpaid', NULL, NULL, 'pickup', NULL, 0, 10000, '2025-12-09 22:33:54'),
(103, 29, 'ORD251209223707', 'processing', 'unpaid', NULL, NULL, 'pickup', NULL, 0, 8000, '2025-12-09 22:37:07'),
(105, 29, 'ORD251209224810', 'processing', 'unpaid', NULL, NULL, 'pickup', NULL, 0, 10500, '2025-12-09 22:48:10'),
(107, 29, 'ORD251209224935', 'completed', 'unpaid', NULL, NULL, 'pickup', NULL, 0, 11000, '2025-12-09 22:49:35'),
(123, 30, 'ORD251211142022', 'completed', 'paid', NULL, NULL, 'pickup', NULL, 0, 17000, '2025-12-11 14:20:22'),
(127, 32, 'ORD251212074716', 'completed', 'paid', NULL, NULL, 'delivery', 7, 0, 4000, '2025-12-12 07:47:16'),
(155, 67, 'ORD251214154142', 'completed', 'paid', NULL, NULL, 'delivery', 3, 0, 5000, '2025-12-14 15:41:42'),
(157, 68, 'ORD251214160415', 'completed', 'paid', NULL, NULL, 'delivery', 3, 0, 3000, '2025-12-14 16:04:15');

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
(160, 87, 19, 'Es Joshua', 1, 5000, 5000),
(161, 87, 17, 'Es Jeruk', 1, 4000, 4000),
(162, 87, 29, 'Intermie + Telur', 1, 6000, 6000),
(163, 87, 21, 'Nasi Ayam Bali', 1, 8000, 8000),
(173, 97, 30, 'Mie Goreng', 1, 10000, 10000),
(174, 97, 12, 'Es Teh', 1, 3000, 3000),
(175, 99, 24, 'Mie Instan Goreng', 1, 5000, 5000),
(176, 99, 39, 'Jeruk Panas', 1, 4000, 4000),
(177, 101, 26, 'Mie Instan Goreng + Telur', 1, 8000, 8000),
(178, 101, 36, 'Kopi Hitam Cangkir', 1, 2000, 2000),
(179, 103, 25, 'Mie Instan Kuah', 1, 5000, 5000),
(180, 103, 35, 'Kopi Hitam Gelas', 1, 3000, 3000),
(181, 105, 27, 'Mie Instan Kuah + Telur', 1, 8000, 8000),
(182, 105, 37, 'Kopi Susu Cangkir', 1, 2500, 2500),
(183, 107, 15, 'Nasi Ayam Kremes', 1, 8000, 8000),
(184, 107, 16, 'Kopi Susu Gelas', 1, 3000, 3000),
(199, 123, 17, 'Es Jeruk', 1, 4000, 4000),
(200, 123, 17, 'Es Jeruk', 1, 4000, 4000),
(201, 123, 28, 'Intermie', 1, 3000, 3000),
(202, 123, 29, 'Intermie + Telur', 1, 6000, 6000),
(205, 127, 17, 'Es Jeruk', 1, 4000, 4000),
(220, 155, 19, 'Es Joshua', 1, 5000, 5000),
(221, 157, 43, 'Es Kuku Bima', 1, 3000, 3000);

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
  `no_hp` varchar(13) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `building` varchar(100) DEFAULT NULL,
  `room` varchar(100) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `wa_verified` tinyint(1) DEFAULT 0,
  `wa_verified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `no_hp`, `email`, `password_hash`, `is_active`, `created_at`, `updated_at`, `building`, `room`, `note`, `wa_verified`, `wa_verified_at`) VALUES
(1, 1, 'Admin Kantin', '083456789010', 'admin@kantin.local', '$2y$10$yuv5HuyfeRt0602YU9cQhurgu7Qnx/9TsUPbYWtQQaaVnqphigEkW', 1, '2025-11-10 00:49:27', NULL, NULL, NULL, NULL, 1, NULL),
(19, 2, 'arya', '081234567892', NULL, '$2y$10$DYbBZk.9QFnfEgKNVIe1iezeLi80SgeCwvNy5wianKBUvwUrP9/Qa', 1, '2025-11-30 10:58:29', NULL, NULL, NULL, NULL, 0, NULL),
(21, 2, 'heru', '082345678967', NULL, '$2y$10$X1aj26V7JVxqecE7czdNIO8goG4oNzracOLEklvoRRyol7x6HijyS', 1, '2025-12-01 11:59:22', NULL, NULL, NULL, NULL, 0, NULL),
(29, 2, 'yoga prasetya', '085123456789', NULL, '$2y$10$EB7HwvhBlYA6lmYYAbm6yuuWhQJeMLkgVQ2wmRA.09Fhn09ahWyxe', 1, '2025-12-08 06:01:01', NULL, NULL, NULL, NULL, 0, NULL),
(30, 2, 'Rico Aditio', '081554829151', NULL, '$2y$10$Cxr5wyeent9fNZkpfBOMzeivyE78Zd1W1OMEAeeDPqIjp2IZMPUBu', 1, '2025-12-11 13:21:28', NULL, NULL, NULL, NULL, 0, NULL),
(32, 2, 'FAIZIN NOVAL', '0895367362068', NULL, '$2y$10$Nfx70YCzQVvZb4i9tB3/sOqMjQKgJoLUYislSdUb2muMypM.dLK1y', 1, '2025-12-12 07:34:22', NULL, NULL, NULL, NULL, 0, NULL),
(66, 2, 'panjul', '0857833544372', NULL, '$2y$10$p9XOV9kXhwcmKusGbp/PGurRZ0/Q7H8ifVNp50yiVH8rgfUK.EjZe', 1, '2025-12-14 14:45:04', NULL, NULL, NULL, NULL, 0, NULL),
(67, 2, 'bintang', '085748543921', NULL, '$2y$10$4uWCt8DsIZuSiady1r6yRuH9IIddGP1hYcbw.tvhV.xP2GYoW4k4m', 1, '2025-12-14 15:40:09', NULL, NULL, NULL, NULL, 1, '2025-12-14 15:40:36'),
(68, 2, 'Fernanda Septian', '085707559188', NULL, '$2y$10$sJqY2qLEM0./y.8v5OfK7u2mMz/ahZKBJncop56pNOFPkUEt3fneq', 1, '2025-12-14 16:03:07', NULL, NULL, NULL, NULL, 1, '2025-12-14 16:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `building` varchar(100) NOT NULL,
  `room` varchar(100) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `user_id`, `building`, `room`, `note`, `is_default`, `created_at`) VALUES
(1, NULL, 'KANTOR', 'KAPRODI SI', 'Lantai 1', 1, '2025-12-01 08:13:06'),
(2, NULL, 'KANTOR', 'KAPRODI TI', NULL, 1, '2025-12-01 08:56:13'),
(3, NULL, 'KANTOR', 'KAPRODI ELEKTRO', NULL, 1, '2025-12-01 08:56:37'),
(4, NULL, 'KANTOR', 'KAPRODI INDUSTRI', NULL, 1, '2025-12-01 09:15:01'),
(7, NULL, 'AREA', 'HOTSPOT AREA', NULL, 1, '2025-12-08 03:44:07'),
(8, NULL, 'KANTOR', 'RUANG GURU', NULL, 1, '2025-12-12 00:25:32'),
(9, NULL, 'HALAMAN KAMPUS', 'GAZEBO', NULL, 1, '2025-12-12 00:25:32');

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
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `fk_orders_delivery_address` (`delivery_address_id`);

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
  ADD UNIQUE KEY `users_no_hp_unique` (`no_hp`),
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `menu_categories`
--
ALTER TABLE `menu_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  ADD CONSTRAINT `fk_orders_delivery_address` FOREIGN KEY (`delivery_address_id`) REFERENCES `user_addresses` (`id`) ON DELETE SET NULL,
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
