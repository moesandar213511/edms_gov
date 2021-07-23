-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:4306
-- Generation Time: Jul 23, 2021 at 06:36 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `government`
--

-- --------------------------------------------------------

--
-- Table structure for table `adjures`
--

CREATE TABLE `adjures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `adjures`
--

INSERT INTO `adjures` (`id`, `title`, `file`, `description`, `created_at`, `updated_at`) VALUES
(2, 'What is Lorem Ipsum?', '5d8b543ab66e6_Deep Dive Python By Win Htut.pdf', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2019-09-25 09:47:27', '2019-09-25 11:49:14'),
(6, 'Why do we use it?', '5d8b5449a4068_1.pdf', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2019-09-25 10:20:33', '2019-09-25 11:49:29'),
(7, 'Why didi we open Subdepartment1?', '5d8f3e9f036b1_Fire_Education_and_the_News.pdf', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.', '2019-09-28 11:06:07', '2019-09-28 11:06:07');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `letters`
--

CREATE TABLE `letters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `letter_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose_letter` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attach_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'false',
  `key_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'simple',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `letters`
--

INSERT INTO `letters` (`id`, `letter_no`, `date`, `title`, `purpose_letter`, `detail`, `attach_file`, `is_read`, `key_code`, `type`, `created_at`, `updated_at`) VALUES
(18, 'd34343', '2019-09-05', '2LhXczIxsy2CIlOhjrE0uWj/jlKGPdqDFqkPOjoGvKsWe08HgxeUZJXWh2B9NrjNml1bjCJDMp3zoiK2YpzRQsE+Y7DKD+yUQzcH0L42aZc=', 'Peter Schmeichel interested in Manchester United football director role', '2LhXczIxsy2CIlOhjrE0uWj/jlKGPdqDFqkPOjoGvKsWe08HgxeUZJXWh2B9NrjNml1bjCJDMp3zoiK2YpzRQsE+Y7DKD+yUQzcH0L42aZc=', NULL, 'false', '343434343434', 'important', '2019-09-25 12:30:17', '2019-09-25 12:30:17');

-- --------------------------------------------------------

--
-- Table structure for table `letter_sub_departments`
--

CREATE TABLE `letter_sub_departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `letter_id` int(11) NOT NULL,
  `in_sub_depart_id` int(11) NOT NULL,
  `out_sub_depart_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `letter_sub_departments`
--

INSERT INTO `letter_sub_departments` (`id`, `letter_id`, `in_sub_depart_id`, `out_sub_depart_id`, `type`, `created_at`, `updated_at`) VALUES
(24, 18, 11, 12, NULL, '2019-09-25 12:30:17', '2019-09-25 12:30:17');

-- --------------------------------------------------------

--
-- Table structure for table `main_departments`
--

CREATE TABLE `main_departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `depart_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `main_departments`
--

INSERT INTO `main_departments` (`id`, `depart_name`, `created_at`, `updated_at`) VALUES
(39, 'main department one', '2019-09-24 13:50:48', '2019-09-24 13:50:56');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_09_19_165703_create_main_departments_table', 2),
(7, '2019_09_21_084615_create_sub_departments_table', 3),
(8, '2019_09_21_171632_create_letters_table', 4),
(10, '2019_09_21_175210_create_letter_sub_departments_table', 5),
(11, '2019_09_25_153945_create_adjures_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_departments`
--

CREATE TABLE `sub_departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_depart_id` int(11) NOT NULL,
  `office_phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `human_phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_departments`
--

INSERT INTO `sub_departments` (`id`, `name`, `main_depart_id`, `office_phone`, `human_phone`, `address`, `latitude`, `longitude`, `logo`, `created_at`, `updated_at`) VALUES
(9, 'sub department one one', 39, '093434343434', '093434343434', 'Myitkyina', '4343434', '4343434', '5d8b5c94c1b7b_1551597326_49390114_2047775935309954_5272228649699901440_n.jpg', '2019-09-25 12:24:52', '2019-09-25 12:24:52'),
(10, 'sub department one one one', 39, '093434343434', '093434343434', 'Myitkyina', '4343434', '4343434', '5d8b5cae04fc3_1551597499_49625884_304434320206303_7668481115631386624_n.jpg', '2019-09-25 12:25:18', '2019-09-25 12:25:18'),
(11, 'no', 39, '093434343434', '3434343434', 'Myitkyina', '093434343434', '11111111', '5d8b5d8461fda_1551597583_50835152_232785204294692_5366485069970014208_n.jpg', '2019-09-25 12:28:52', '2019-09-25 12:28:52'),
(12, 'no1', 39, '093434343434', '093434343434', 'Myitkyina', '4343434', '4343434', '5d8b5d9aeafec_1551597529_49808111_2241682259431965_1816195816683995136_n.jpg', '2019-09-25 12:29:14', '2019-09-25 12:29:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_id` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `password`, `type`, `data_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$LS9I8ah9M6akzAvLNLJ3wusK2wZYFbqMZrQuUAQBQqKcRJ7xlA7yS', 'admin', 0, NULL, NULL, NULL),
(32, 'sub department one one', '$2y$10$zV497xoRkzLTkKVpDXnZZebc2xVF1plGjoHiShUEtPUM0LF/xfLQK', 'sub_depart_admin', 9, NULL, '2019-09-25 12:24:52', '2019-11-17 04:21:56'),
(33, 'sub department one one one', '$2y$10$f7szJoYu4cHw42tbLPxBBurJODq15byvQj66LTM9t1ogBJ9LdpWBe', 'sub_depart_admin', 10, NULL, '2019-09-25 12:25:18', '2019-09-25 12:25:18'),
(34, 'no', '$2y$10$Dfg9VnPlNAIkRqeeXOn6ruw/4FVQl/obJOnK5mWnpW4TU1oBXdmju', 'sub_depart_admin', 11, NULL, '2019-09-25 12:28:52', '2019-09-25 12:28:52'),
(35, 'no1', '$2y$10$4EXPFK4AI7qJ29kpG8kRR.2VCWKMKgCp75K41PuRLASF4CYkta4yi', 'sub_depart_admin', 12, NULL, '2019-09-25 12:29:15', '2019-11-17 04:22:15'),
(36, 'Subdepartment1', '$2y$10$FmMbqhfLFoci9JkdC1h2cuj/UD268yMUO1OaaturJbQngc8rW4s.C', 'sub_depart_admin', 13, NULL, '2019-09-28 10:58:19', '2019-09-28 11:01:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adjures`
--
ALTER TABLE `adjures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `letters`
--
ALTER TABLE `letters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `letter_sub_departments`
--
ALTER TABLE `letter_sub_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_departments`
--
ALTER TABLE `main_departments`
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
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `sub_departments`
--
ALTER TABLE `sub_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adjures`
--
ALTER TABLE `adjures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `letters`
--
ALTER TABLE `letters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `letter_sub_departments`
--
ALTER TABLE `letter_sub_departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `main_departments`
--
ALTER TABLE `main_departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sub_departments`
--
ALTER TABLE `sub_departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
