-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2023 at 09:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ssshg`
--

-- --------------------------------------------------------

--
-- Table structure for table `contribution_payments`
--

CREATE TABLE `contribution_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `society_member_id` int(11) NOT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `late_fine` decimal(8,2) DEFAULT NULL,
  `pay_date` datetime DEFAULT NULL,
  `pay_for_month_year` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `other_info` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contribution_payments`
--

INSERT INTO `contribution_payments` (`id`, `society_member_id`, `amount`, `late_fine`, `pay_date`, `pay_for_month_year`, `status`, `is_delete`, `other_info`, `created_at`, `updated_at`) VALUES
(2, 1, 500.00, 0.00, '2023-12-22 00:00:00', '12-2023', 0, 0, NULL, '2023-12-22 09:40:55', '2023-12-22 09:40:55'),
(3, 2, 500.00, 0.00, '2023-12-23 00:00:00', '12-2023', 1, 0, NULL, '2023-12-23 02:28:50', '2023-12-23 02:28:50'),
(4, 3, 500.00, 12.00, '2023-12-12 00:00:00', '12-2023', 1, 0, NULL, '2023-12-23 02:36:17', '2023-12-23 03:22:01'),
(5, 4, 500.00, 10.00, '2023-12-23 00:00:00', '11-2023', 1, 0, NULL, '2023-12-23 03:29:12', '2023-12-23 03:30:40'),
(6, 4, 500.00, 0.00, '2023-12-23 00:00:00', '12-2023', 1, 0, NULL, '2023-12-23 03:31:07', '2023-12-23 03:31:07');

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
-- Table structure for table `loan_accounts`
--

CREATE TABLE `loan_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `society_member_id` int(11) DEFAULT NULL,
  `society_member_reference_id` int(11) DEFAULT 0,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `full_amount` decimal(10,0) DEFAULT NULL,
  `intrest_rate` decimal(8,2) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `other_info` varchar(255) DEFAULT NULL,
  `remarks` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_accounts`
--

INSERT INTO `loan_accounts` (`id`, `parent_id`, `society_member_id`, `society_member_reference_id`, `start_date`, `end_date`, `amount`, `full_amount`, `intrest_rate`, `status`, `is_delete`, `other_info`, `remarks`, `created_at`, `updated_at`) VALUES
(7, 0, 4, 0, '2023-12-27 00:00:00', '2024-12-26 00:00:00', 7000.00, 17000, 1.00, 0, 0, NULL, NULL, '2023-12-26 05:10:35', '2023-12-27 03:15:38'),
(8, 0, 2, 0, '2023-12-28 00:00:00', '2024-12-28 00:00:00', 25000.00, 179000, 2.00, 1, 0, NULL, NULL, '2023-12-28 01:28:33', '2023-12-28 07:13:15'),
(9, 7, 4, 1, NULL, NULL, 5000.00, NULL, NULL, 1, 0, NULL, NULL, '2023-12-29 04:22:09', '2023-12-29 04:22:09'),
(10, 7, 4, 6, NULL, NULL, 5000.00, NULL, NULL, 1, 0, NULL, NULL, '2023-12-29 04:22:09', '2023-12-29 04:22:09');

-- --------------------------------------------------------

--
-- Table structure for table `loan_payments`
--

CREATE TABLE `loan_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_account_id` int(11) NOT NULL,
  `paid_amount` decimal(8,2) DEFAULT NULL,
  `intrest_amount` decimal(8,2) DEFAULT NULL,
  `balance` decimal(8,2) DEFAULT NULL,
  `pay_date` datetime DEFAULT NULL,
  `other_info` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_payments`
--

INSERT INTO `loan_payments` (`id`, `loan_account_id`, `paid_amount`, `intrest_amount`, `balance`, `pay_date`, `other_info`, `remarks`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 7, 500.00, 100.00, NULL, '2023-12-14 19:19:11', NULL, NULL, 1, 1, '2023-12-30 07:25:31', '2023-12-30 02:58:21'),
(2, 7, 1100.00, 80.00, NULL, '2023-11-11 00:00:00', NULL, NULL, 1, 0, '2023-12-30 02:36:21', '2023-12-30 02:57:22'),
(3, 7, 1000.00, 100.00, NULL, '2023-12-30 00:00:00', NULL, NULL, 1, 0, '2023-12-30 02:51:11', '2023-12-30 02:51:11');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `sub_reference_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `pin_code` varchar(255) DEFAULT NULL,
  `guardian` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `other_info` varchar(255) DEFAULT NULL,
  `other_info2` varchar(255) DEFAULT NULL,
  `adhar_card_url` varchar(255) DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `remarks` mediumtext DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `user_id`, `parent_id`, `reference_id`, `sub_reference_id`, `name`, `city`, `state`, `address1`, `address2`, `pin_code`, `guardian`, `gender`, `email`, `phone`, `password`, `other_info`, `other_info2`, `adhar_card_url`, `photo_url`, `remarks`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 0, 0, 'Baliram', 'Faridabad', 'Haryana', 'House No : 1261', 'Sector 62', '121004', 'Hari prasad', 'M', 'baliram.prasad@gmail.com', '09910652951', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2023-12-20 01:28:55', '2023-12-20 01:29:33'),
(2, 1, 1, 1, 1, 'Kanishk', 'Faridabad', 'Haryana', 'Faridabad', 'Sector 62', '121004', 'Baliram', 'M', 'baliram.prasad@gmail.com', '09910652951', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2023-12-21 03:50:10', '2023-12-23 10:10:48'),
(3, 1, 1, 1, 1, 'Tooktook', 'Faridabad', 'Haryana', 'Faridabad', 'Sector 62', '121004', 'Baliram', 'M', 'baliram.prasad@gmail.com', '09910652951', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2023-12-23 03:27:41', '2023-12-23 10:10:40'),
(4, 1, 0, 0, 0, 'Devendar Pal', 'Faridabad', 'Haryana', 'Faridabad', 'house no 1261', '121004', 'Shree Ved Prakash', 'M', 'baliram.prasad@gmail.com', '09910652951', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2023-12-27 03:28:52', '2023-12-27 03:28:52'),
(5, 1, 0, 0, 0, 'Manay Pande', 'Faridabad', 'Haryana', 'Faridabad', 'house no 1581', '121004', 'Dinesh Pandey', 'M', 'baliram.prasad@gmail.com', '09910652951', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2023-12-27 03:32:58', '2023-12-27 03:32:58');

-- --------------------------------------------------------

--
-- Table structure for table `member_types`
--

CREATE TABLE `member_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `member_types`
--

INSERT INTO `member_types` (`id`, `name`, `code`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'General (Member only)', 'GEN', 1, 0, '2023-12-20 01:01:24', '2023-12-20 01:03:26'),
(2, 'Cashier', 'cashier', 1, 0, '2023-12-20 01:02:24', '2023-12-20 01:02:24'),
(3, 'Core Member', 'core_member', 1, 0, '2023-12-20 01:03:02', '2023-12-20 01:03:02'),
(4, 'test', 'test', 1, 1, '2023-12-20 01:04:18', '2023-12-20 01:04:24');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_11_10_144234_create_member_types_table', 1),
(7, '2023_11_15_074052_create_society_rules_table', 1),
(9, '2023_11_09_171620_create_societies_table', 2),
(13, '2023_11_16_060749_create_members_table', 3),
(14, '2023_12_21_085757_create_society_members_table', 4),
(15, '2023_12_22_132524_create_contribution_payments_table', 5),
(16, '2023_12_23_111653_create_loan_accounts_table', 6),
(17, '2023_12_30_065324_create_loan_payments_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `societies`
--

CREATE TABLE `societies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `contribution_amount` decimal(10,0) NOT NULL,
  `maximum_loan_amount` decimal(10,0) NOT NULL,
  `intrest_rate` decimal(10,0) NOT NULL DEFAULT 1,
  `branch_code` int(11) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `pin_code` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `other_info1` varchar(255) DEFAULT NULL,
  `other_info2` varchar(255) DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `societies`
--

INSERT INTO `societies` (`id`, `name`, `code`, `contribution_amount`, `maximum_loan_amount`, `intrest_rate`, `branch_code`, `start_date`, `contact_person`, `contact_no`, `city`, `state`, `address1`, `address2`, `pin_code`, `status`, `remarks`, `other_info1`, `other_info2`, `logo_url`, `image_url`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Shiv Sakti Self Help Group', 'SSSHG', 500, 7000, 1, 1, '2023-11-28 00:00:00', NULL, NULL, 'Delhi NCR', 'Haryana', 'House No : 1261', 'Sector 62', '121004', 1, 'This is the first society', NULL, NULL, NULL, NULL, 0, '2023-11-28 00:39:07', '2023-12-27 10:20:21'),
(2, 'Mahila Society', 'MS', 500, 25000, 2, 0, '2023-11-28 00:00:00', NULL, NULL, 'Delhi NCR', 'Haryana', 'House No : 1260', 'Sector 62', '121004', 1, NULL, NULL, NULL, NULL, NULL, 0, '2023-11-28 00:41:19', '2023-12-23 07:37:01'),
(3, 'Test', 'test-code', 500, 5000, 1, 0, '2023-12-23 00:00:00', 'Baliram', '09910652951', 'Faridabad', 'Haryana', 'Faridabad', 'Sector 62', '121004', 1, NULL, NULL, NULL, NULL, NULL, 0, '2023-12-23 07:36:39', '2023-12-23 07:36:39');

-- --------------------------------------------------------

--
-- Table structure for table `society_members`
--

CREATE TABLE `society_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `society_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `member_type_id` int(11) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `other_info` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `society_members`
--

INSERT INTO `society_members` (`id`, `society_id`, `member_id`, `member_type_id`, `start_date`, `end_date`, `status`, `is_delete`, `other_info`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2023-12-21 00:00:00', '2028-12-21 00:00:00', 1, 0, NULL, 'This is for test2', '2023-12-21 06:40:26', '2023-12-23 08:12:12'),
(2, 2, 1, 0, '2023-12-12 00:00:00', '2028-12-21 00:00:00', 0, 0, NULL, '', '2023-12-21 06:59:28', '2023-12-21 07:59:25'),
(3, 2, 2, 0, '2023-12-21 00:00:00', '2028-12-21 00:00:00', 0, 0, NULL, '', '2023-12-21 08:11:48', '2023-12-22 07:43:39'),
(4, 1, 3, 0, '2023-12-23 00:00:00', '2028-12-23 00:00:00', 1, 0, NULL, '', '2023-12-23 03:28:31', '2023-12-23 03:28:31'),
(5, 1, 4, 2, '2023-12-27 00:00:00', '2028-12-27 00:00:00', 1, 0, NULL, NULL, '2023-12-27 03:31:34', '2023-12-27 03:31:34'),
(6, 1, 5, 1, '2023-12-27 00:00:00', '2028-12-27 00:00:00', 1, 0, NULL, NULL, '2023-12-27 03:33:12', '2023-12-27 03:33:12');

-- --------------------------------------------------------

--
-- Table structure for table `society_rules`
--

CREATE TABLE `society_rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `society_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `sort_desc` varchar(255) NOT NULL,
  `long_desc` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `society_rules`
--

INSERT INTO `society_rules` (`id`, `society_id`, `title`, `sort_desc`, `long_desc`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, '2', 'Contributions Amount', 'Contributions Amount is 500', 'Contributions Amount is 500', 1, 0, '2023-12-20 00:49:20', '2023-12-20 00:59:17'),
(2, '1', 'test', 'yyy', 'yy', 1, 1, '2023-12-20 01:04:56', '2023-12-20 01:05:05');

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
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'baliram', 'baliram@gmail.com', NULL, '$2y$10$VzTrvnx5Ky8C0XshsB8.pumkPucVCxKN9RF3E6ZNnwAMQcNZIWa8i', NULL, '2023-11-28 00:20:51', '2023-11-28 00:20:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contribution_payments`
--
ALTER TABLE `contribution_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `loan_accounts`
--
ALTER TABLE `loan_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_payments`
--
ALTER TABLE `loan_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_types`
--
ALTER TABLE `member_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `societies`
--
ALTER TABLE `societies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `society_members`
--
ALTER TABLE `society_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `society_rules`
--
ALTER TABLE `society_rules`
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
-- AUTO_INCREMENT for table `contribution_payments`
--
ALTER TABLE `contribution_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_accounts`
--
ALTER TABLE `loan_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `loan_payments`
--
ALTER TABLE `loan_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `member_types`
--
ALTER TABLE `member_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `societies`
--
ALTER TABLE `societies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `society_members`
--
ALTER TABLE `society_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `society_rules`
--
ALTER TABLE `society_rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
