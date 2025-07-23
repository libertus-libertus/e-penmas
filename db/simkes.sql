-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 05, 2025 at 04:28 PM
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
-- Database: `simkes`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE IF NOT EXISTS `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `registration_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointments_registration_id_foreign` (`registration_id`),
  KEY `appointments_user_id_foreign` (`user_id`),
  KEY `appointments_service_id_foreign` (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `registration_id`, `user_id`, `service_id`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, 4, 'Sakit demam', '2025-06-29 05:29:16', '2025-06-29 05:31:02', NULL),
(2, 11, 8, 4, 'Demam, Flu dll', '2025-06-29 07:33:54', '2025-06-29 07:33:54', NULL),
(3, 6, 1, 4, 'Batuk, Pilek, dll', '2025-06-29 07:35:12', '2025-06-29 07:35:12', NULL),
(4, 12, 9, 4, 'Mag, Muntaber, Demam', '2025-06-29 08:15:23', '2025-06-29 08:15:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE IF NOT EXISTS `job_batches` (
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

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_26_065915_add_position_to_users_table', 2),
(5, '2025_06_26_134718_create_services_table', 3),
(6, '2025_06_28_021743_create_service_schedules_table', 4),
(7, '2025_06_28_042632_add_role_and_make_position_nullable_to_users_table', 5),
(8, '2025_06_28_042837_create_patient_details_table', 6),
(9, '2025_06_28_133721_create_registrations_table', 7),
(10, '2025_06_28_133811_create_queues_table', 7),
(11, '2025_06_29_100245_add_deleted_at_to_registrations_table', 8),
(12, '2025_06_29_100730_add_cancelled_status_to_queues_table', 9),
(13, '2025_06_29_120434_create_appointments_table', 10),
(14, '2025_06_29_121326_add_deleted_at_to_appointments_table', 11),
(15, '2025_06_29_123630_create_patient_visits_table', 12),
(16, '2025_06_30_143648_add_deleted_at_to_users_table', 13),
(17, '2025_07_05_111001_make_patient_details_columns_nullable', 14);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_details`
--

CREATE TABLE IF NOT EXISTS `patient_details` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `bpjs_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_details_user_id_unique` (`user_id`),
  UNIQUE KEY `patient_details_nik_unique` (`nik`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_details`
--

INSERT INTO `patient_details` (`id`, `user_id`, `nik`, `address`, `birth_date`, `phone_number`, `gender`, `bpjs_status`, `created_at`, `updated_at`) VALUES
(1, 3, '1234567891011123', 'Jati, Padang Utara', '2000-02-02', '08128712891', 'Laki-laki', 1, '2025-06-28 00:32:52', '2025-06-28 01:28:47'),
(2, 10, '0987654321111213', 'Siteba', '2001-12-05', '08324767123', 'Laki-laki', 1, '2025-06-28 01:59:34', '2025-06-28 01:59:34'),
(3, 11, '1234567890098765', 'Dusun Kirip', '1992-10-01', '08123476834', 'Laki-laki', 1, '2025-06-28 06:55:41', '2025-06-28 06:55:41'),
(4, 12, '1234567890235467', 'Jl. Ar Hakim Dalam Gg Ar Hakim No. 34', '2000-12-09', '0812768348', 'Perempuan', 1, '2025-06-28 07:56:33', '2025-06-28 07:56:33'),
(5, 13, '0981928102128023', 'Sekadau', '1999-02-02', '0817268348', 'Perempuan', 1, '2025-06-28 08:40:21', '2025-06-28 08:40:21'),
(6, 16, '1352526353636567', 'Padang Barat', '2022-09-25', '082346275627', 'Laki-laki', 1, '2025-06-29 08:08:29', '2025-06-29 08:08:29'),
(7, 17, '1278102102011111', 'Jl. Siteba Gg Sitebu, Buluk Maija', '1999-12-01', '081927182791', 'Perempuan', 1, '2025-06-30 06:00:14', '2025-06-30 06:00:14'),
(8, 15, '9837493847999999', 'Padang', '2004-12-05', '08348734343', 'Laki-laki', 1, '2025-06-30 18:16:01', '2025-06-30 18:25:09'),
(9, 14, '1283743943789423', 'Padang Utara', '2004-10-07', '08236527831', 'Laki-laki', 1, '2025-06-30 18:18:30', '2025-06-30 18:18:30'),
(10, 18, '2312394893483904', 'Pontianak', '1999-07-23', '0812918291', 'Laki-laki', 1, '2025-06-30 18:36:54', '2025-06-30 18:36:54'),
(11, 22, '1289129128912222', 'Padang', '2002-02-02', '081218271929', 'Laki-laki', 1, '2025-07-05 03:50:51', '2025-07-05 03:50:51'),
(12, 24, '9128192810222224', 'Padang Utara', '2005-10-10', '08812917291', 'Perempuan', 1, '2025-07-05 04:13:16', '2025-07-05 04:14:23'),
(13, 25, '0129819299999999', 'UNP Padang', '2006-12-10', '0817612812791', 'Laki-laki', 1, '2025-07-05 07:16:11', '2025-07-05 07:21:41'),
(14, 23, '9172912911212222', 'Purus IV', '2003-02-04', '0812817291729', 'Laki-laki', 1, '2025-07-05 07:23:37', '2025-07-05 07:23:37');

-- --------------------------------------------------------

--
-- Table structure for table `patient_visits`
--

CREATE TABLE IF NOT EXISTS `patient_visits` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `patient_detail_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `visit_date` date NOT NULL,
  `status` enum('completed','canceled') NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patient_visits_patient_detail_id_foreign` (`patient_detail_id`),
  KEY `patient_visits_service_id_foreign` (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_visits`
--

INSERT INTO `patient_visits` (`id`, `patient_detail_id`, `service_id`, `visit_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 4, '2025-06-29', 'completed', '2025-06-29 05:42:00', '2025-06-29 05:42:00'),
(2, 1, 4, '2025-06-30', 'completed', '2025-06-29 07:33:02', '2025-06-29 07:33:02'),
(3, 6, 4, '2025-06-29', 'completed', '2025-06-29 08:25:52', '2025-06-29 08:25:52'),
(4, 12, 4, '2025-07-05', 'completed', '2025-07-05 04:59:14', '2025-07-05 04:59:14'),
(5, 13, 4, '2025-07-05', 'completed', '2025-07-05 07:21:08', '2025-07-05 07:21:08');

-- --------------------------------------------------------

--
-- Table structure for table `queues`
--

CREATE TABLE IF NOT EXISTS `queues` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `registration_id` bigint(20) UNSIGNED NOT NULL,
  `queue_number` int(11) NOT NULL,
  `status` enum('waiting','called','completed','skipped','cancelled') NOT NULL DEFAULT 'waiting',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `queues_registration_id_unique` (`registration_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `queues`
--

INSERT INTO `queues` (`id`, `registration_id`, `queue_number`, `status`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 'completed', '2025-06-29 02:26:56', '2025-06-29 02:49:05'),
(3, 3, 1, 'cancelled', '2025-06-29 02:50:01', '2025-06-29 03:10:43'),
(4, 6, 2, 'completed', '2025-06-29 03:26:13', '2025-06-29 03:26:58'),
(5, 7, 3, 'completed', '2025-06-29 03:32:50', '2025-06-29 03:32:50'),
(6, 8, 4, 'cancelled', '2025-06-29 03:39:05', '2025-06-29 03:39:40'),
(7, 9, 5, 'cancelled', '2025-06-29 03:52:16', '2025-06-29 03:54:29'),
(8, 10, 6, 'completed', '2025-06-29 03:55:59', '2025-06-29 05:42:00'),
(9, 11, 2, 'completed', '2025-06-29 07:31:47', '2025-06-29 07:33:02'),
(10, 12, 7, 'completed', '2025-06-29 08:08:58', '2025-06-29 08:25:52'),
(11, 13, 8, 'completed', '2025-06-29 08:18:34', '2025-07-05 02:55:29'),
(12, 14, 9, 'waiting', '2025-06-29 08:19:26', '2025-06-29 08:19:26'),
(13, 15, 1, 'completed', '2025-07-05 04:50:58', '2025-07-05 04:59:14'),
(14, 16, 2, 'completed', '2025-07-05 07:19:27', '2025-07-05 07:21:08');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE IF NOT EXISTS `registrations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `patient_detail_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `visit_date` date NOT NULL,
  `queue_number` int(11) NOT NULL,
  `status` enum('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `registrations_visit_date_queue_number_unique` (`visit_date`,`queue_number`),
  KEY `registrations_patient_detail_id_foreign` (`patient_detail_id`),
  KEY `registrations_service_id_foreign` (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `patient_detail_id`, `service_id`, `visit_date`, `queue_number`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 3, 4, '2025-06-30', 1, 'completed', '2025-06-29 02:26:56', '2025-06-29 02:28:13', NULL),
(3, 2, 4, '2025-06-29', 1, 'cancelled', '2025-06-29 02:50:01', '2025-06-29 03:10:43', '2025-06-29 03:10:43'),
(6, 5, 4, '2025-06-29', 2, 'completed', '2025-06-29 03:26:13', '2025-06-29 03:26:58', NULL),
(7, 2, 4, '2025-06-29', 3, 'completed', '2025-06-29 03:32:50', '2025-06-29 03:32:50', NULL),
(8, 4, 4, '2025-06-29', 4, 'cancelled', '2025-06-29 03:39:05', '2025-06-29 03:39:40', '2025-06-29 03:39:40'),
(9, 4, 4, '2025-06-29', 5, 'cancelled', '2025-06-29 03:52:16', '2025-06-29 03:54:29', '2025-06-29 03:54:29'),
(10, 4, 4, '2025-06-29', 6, 'completed', '2025-06-29 03:55:59', '2025-06-29 03:55:59', NULL),
(11, 1, 4, '2025-06-30', 2, 'completed', '2025-06-29 07:31:47', '2025-06-29 07:31:47', NULL),
(12, 6, 4, '2025-06-29', 7, 'completed', '2025-06-29 08:08:58', '2025-06-29 08:08:58', NULL),
(13, 6, 4, '2025-06-29', 8, 'completed', '2025-06-29 08:18:34', '2025-06-29 08:18:34', NULL),
(14, 6, 4, '2025-06-29', 9, 'completed', '2025-06-29 08:19:26', '2025-06-29 08:19:26', NULL),
(15, 12, 4, '2025-07-05', 1, 'completed', '2025-07-05 04:50:58', '2025-07-05 04:50:58', NULL),
(16, 13, 4, '2025-07-05', 2, 'completed', '2025-07-05 07:19:27', '2025-07-05 07:19:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(4, 'Poli Umum', 'Khusus Poli Umum', '2025-06-26 08:39:40', '2025-06-26 08:39:40');

-- --------------------------------------------------------

--
-- Table structure for table `service_schedules`
--

CREATE TABLE IF NOT EXISTS `service_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `day` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `service_schedules_service_id_day_unique` (`service_id`,`day`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_schedules`
--

INSERT INTO `service_schedules` (`id`, `service_id`, `day`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(1, 4, 'Senin', '07:30:00', '14:30:00', '2025-06-27 19:57:19', '2025-06-27 21:17:01'),
(2, 4, 'Selasa', '07:30:00', '14:30:00', '2025-06-27 20:18:01', '2025-06-27 21:17:32'),
(3, 4, 'Rabu', '07:30:00', '14:30:00', '2025-06-27 20:24:18', '2025-06-27 21:17:59'),
(4, 4, 'Kamis', '07:30:00', '14:30:00', '2025-06-27 20:27:59', '2025-06-27 21:18:22'),
(5, 4, 'Jumat', '07:30:00', '14:30:00', '2025-06-27 20:55:11', '2025-06-27 21:18:42');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1CSNnVhRjiEw9kSsGH7rI7yYUz51sO9bebzdHJh1', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid0h2Nk02ZDBsUjVsU2dwMW9LejVnUjR6YkltUGg2WTAwOGF5NnFzWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1751718677),
('8j1h5PR2D5Q1S63oj5mXnHUJNbnefRv2J4UYSfPL', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibkxGYmJiUTYyZ3BtanZsVUhMU3JaS0RycWRpVHg2eWk4VGFQeFBaMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1751725459),
('o6OcOAoM7Kze8Ny9qN2WDGzqr5SFONLvDwFfHV84', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiblpmOXh6ZnNuUGFoNmJ5VkZlaWlwdXk5SWtIcFE2NTZOcUl4VkI1QyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1751725603);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff','patient') NOT NULL DEFAULT 'patient',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `position`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Randi Kuniawan', 'randi@gmail.com', 'Dokter Umum', NULL, '$2y$12$0UkXkSDWMRLlZvlILiKbV.v7fRBp2riY2VWCziy3lTJhzuIcQvglq', 'admin', 'SO1j3YhqJbNpYxiKghzQjsAT2DLCG0Gwp65WWQdoxBTkKLNmJBVC0isUANPI', '2025-06-25 17:58:36', '2025-06-30 21:31:45', NULL),
(3, 'Hengky Salamao', 'hengky@gmail.com', NULL, NULL, '$2y$12$.c1hxptLNXMbwHKVXT0eOeHo.xjcj6uoFI0HYOeMrG8ePUxFVLmgi', 'patient', NULL, '2025-06-26 06:21:07', '2025-06-28 01:47:28', NULL),
(8, 'Libertus', 'libertus@gmail.com', 'Kapala Depatemen IT', NULL, '$2y$12$HIXg9GEX3U24DiIz/CtJ.ukUjUnvEGgqIuBsZjAHdCRgbCfcZu5ye', 'admin', NULL, '2025-06-28 00:06:39', '2025-06-30 21:29:35', NULL),
(9, 'Eldi', 'eldi@gmail.com', 'Staf Admin', NULL, '$2y$12$2s9p6PT8YLE8kq5rDL5D.Ov94a80tDtofVidGgdG83rLulD2lY55y', 'staff', NULL, '2025-06-28 01:40:13', '2025-06-30 21:30:55', '2025-06-30 21:30:55'),
(10, 'Rudi Hartono', 'rudi@gmail.com', NULL, NULL, '$2y$12$APwGZmAZkE3A4mazpsVeLeZyxJppxb4A8BLgdGnYBluznBDZRL1Zi', 'patient', NULL, '2025-06-28 01:59:34', '2025-06-28 01:59:34', NULL),
(11, 'Andi Sapotuk', 'andi@gmail.com', NULL, NULL, '$2y$12$Wpmvk7bk1lV8Vx1y7/9QfuvMo3AiuGXqDOe.mc5RYjin2LrhmHEUu', 'patient', NULL, '2025-06-28 06:55:41', '2025-06-28 06:55:41', NULL),
(12, 'Elsa Aryani', 'elsa@gmail.com', NULL, NULL, '$2y$12$PBYIAML7lXRGqjB2XQV6oOMf6m4ZIQjL.qQ3pW.6lp8LVhQRu1NxC', 'patient', NULL, '2025-06-28 07:56:33', '2025-06-28 07:56:33', NULL),
(13, 'Valentina Monalisa', 'monalisa@gmail.com', NULL, NULL, '$2y$12$DupuUYOtdwi/lMS3d.O1pu/uwEeKFtV7.fcV5QF2UCfUVz1FOhOhO', 'patient', NULL, '2025-06-28 08:40:21', '2025-06-28 08:40:21', NULL),
(14, 'Jono', 'jono@gmail.com', NULL, NULL, '$2y$12$2yGMcxMFAGycVrXoQkSBzOnhdeKyCr8HZS5ubtyQWlHe5fXg.WVlS', 'patient', NULL, '2025-06-29 07:28:56', '2025-06-30 19:26:28', '2025-06-30 19:26:28'),
(15, 'Narto', 'narto@gmail.com', NULL, NULL, '$2y$12$NIDd3.gNIQ4wDtZeRyH5fuetbvQi5skDwYMegNX5itR1UDJlPnBAS', 'patient', NULL, '2025-06-29 07:43:02', '2025-06-29 07:43:02', NULL),
(16, 'Hamba Allah', 'hambaallah@gmail.com', NULL, NULL, '$2y$12$QUfoq3H/dgHmyQ6n6/B2Teoa4IWwQnAI6BlhCDKMNY.ZC5FF/3SqK', 'patient', NULL, '2025-06-29 08:08:29', '2025-06-29 08:08:29', NULL),
(17, 'Rani', 'rani@gmail.com', NULL, NULL, '$2y$12$h5x2ATi93drWODfXbttIVOmwuPRRnDeUcdMcDR6XyIQodzkGPNT6O', 'patient', NULL, '2025-06-30 06:00:14', '2025-06-30 06:00:14', NULL),
(18, 'Wandi', 'wandi@gmail.com', NULL, NULL, '$2y$12$zpJzJojRZqx8/BTBj4ZmNuGN3uVplbUC6Dzfx3CZC/TSERNxTk5.y', 'patient', NULL, '2025-06-30 18:36:54', '2025-06-30 19:26:18', '2025-06-30 19:26:18'),
(19, 'Julianti', 'julianti@gmail.com', 'Staff Admin', NULL, '$2y$12$D6PSpkwPIX5ramx0vH55xuQxHcne5cpkgrLKkQfzQTJUakP31goYm', 'staff', NULL, '2025-06-30 21:30:49', '2025-06-30 21:31:08', NULL),
(20, 'Tren Ayu', 'trenayu@gmail.com', 'Staff Dokter', NULL, '$2y$12$7lLvQQSaCpewrzr3ePaZYeauEX4OIZ/r1xvQJr7i10D/JY4omDiTy', 'staff', NULL, '2025-06-30 21:32:48', '2025-06-30 21:32:48', NULL),
(21, 'Lustinus Wendi', 'lustinus.wendi12@gmail.com', 'Staff IT', NULL, '$2y$12$rXCufaZ/hCzEVyAsC3sEQus5tS6iUMdvPXo77GkFezNANVrr9e7.u', 'staff', NULL, '2025-06-30 21:46:08', '2025-06-30 21:46:08', NULL),
(22, 'Luis Diaz', 'luisdiaz@gmail.com', NULL, NULL, '$2y$12$xXTewgHPxs6Bh/ag8DDtN.ka1KUX4s3YkbYKZq9N3FT9WxWsJbgzC', 'patient', NULL, '2025-06-30 23:58:46', '2025-06-30 23:58:46', NULL),
(23, 'Kani', 'kani@gmail.com', NULL, NULL, '$2y$12$2dlhzkceWrZK51TNzOnb9uSBGWq/SmCKPnaLf4p6xccm9seJh7x9K', 'patient', NULL, '2025-07-05 04:03:57', '2025-07-05 04:03:57', NULL),
(24, 'Magda Lena', 'magdalena@gmail.com', NULL, NULL, '$2y$12$N48T4Ufr1ItmwO9yje7OI.wmgr1WyHMtf0u76AEcC8sMy8zKOsnzu', 'patient', NULL, '2025-07-05 04:13:16', '2025-07-05 04:13:16', NULL),
(25, 'Hasbas', 'hasbas@gmail.com', NULL, NULL, '$2y$12$VXuKFkkrdr4uv4OcGZDmTeWq/VzFJ78k3e6f1aj.YZPPR8zCJBI0a', 'patient', NULL, '2025-07-05 07:16:11', '2025-07-05 07:16:11', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_registration_id_foreign` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_details`
--
ALTER TABLE `patient_details`
  ADD CONSTRAINT `patient_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_visits`
--
ALTER TABLE `patient_visits`
  ADD CONSTRAINT `patient_visits_patient_detail_id_foreign` FOREIGN KEY (`patient_detail_id`) REFERENCES `patient_details` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_visits_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `queues`
--
ALTER TABLE `queues`
  ADD CONSTRAINT `queues_registration_id_foreign` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_patient_detail_id_foreign` FOREIGN KEY (`patient_detail_id`) REFERENCES `patient_details` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `registrations_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_schedules`
--
ALTER TABLE `service_schedules`
  ADD CONSTRAINT `service_schedules_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
