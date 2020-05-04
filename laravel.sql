-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2020 at 03:52 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` int(11) NOT NULL,
  `alert_type` tinyint(4) NOT NULL,
  `alert_priority` tinyint(4) NOT NULL DEFAULT 1,
  `calibration_info_id` int(11) NOT NULL,
  `exam_details_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `student_remarks` text DEFAULT NULL,
  `proctor_remarks` text DEFAULT NULL,
  `proctor_action` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1-ignore, 2- alert, 3- warning',
  `reviewer_remarks` text DEFAULT NULL,
  `viewed_by_student` tinyint(4) NOT NULL DEFAULT 0,
  `viewed_by_proctor` tinyint(4) NOT NULL DEFAULT 0,
  `viewed_by_reviewer` tinyint(4) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`id`, `alert_type`, `alert_priority`, `calibration_info_id`, `exam_details_id`, `schedule_id`, `student_id`, `subject_id`, `description`, `student_remarks`, `proctor_remarks`, `proctor_action`, `reviewer_remarks`, `viewed_by_student`, `viewed_by_proctor`, `viewed_by_reviewer`, `created`, `modified`, `status`) VALUES
(1, 1, 1, 1, 2, 2, 7, 2, 'Few objectional objects can be seen in room', NULL, 'Objectional content found', 2, NULL, 0, 1, 0, '2020-04-08 18:08:17', '2020-04-08 18:09:49', 1),
(2, 2, 1, 1, 1, 1, 5, 1, 'A person can be seen in background', NULL, NULL, 0, NULL, 0, 0, 0, '2020-04-09 07:59:21', '2020-04-09 08:01:14', 1),
(3, 5, 1, 0, 3, 3, 3, 3, 'Eye movement captured. Looking at left side', NULL, NULL, 0, NULL, 0, 1, 0, '2020-04-10 09:58:28', '2020-04-13 13:00:43', 1),
(4, 6, 1, 0, 3, 3, 3, 3, 'Head movement captured', NULL, NULL, 0, NULL, 1, 1, 0, '2020-04-10 09:18:28', '2020-04-13 13:01:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `alert_type`
--

CREATE TABLE `alert_type` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alert_type`
--

INSERT INTO `alert_type` (`id`, `type`, `created`, `modified`, `status`) VALUES
(1, 'Objectional object found', '2020-04-08 18:01:43', '2020-04-08 18:02:07', 1),
(2, 'Person Detected', '2020-04-08 18:01:43', '2020-04-08 18:03:23', 1),
(3, 'Electronic Gadget found', '2020-04-08 18:01:43', '2020-04-08 18:03:23', 1),
(4, 'Book found', '2020-04-08 18:01:43', '2020-04-08 18:03:23', 1),
(5, 'Eye Movement captured', '2020-04-08 18:01:43', '2020-04-08 18:03:23', 1),
(6, 'Head Movement captured', '2020-04-08 18:01:43', '2020-04-08 18:03:23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `calibration_info`
--

CREATE TABLE `calibration_info` (
  `id` int(11) NOT NULL,
  `exam_detail_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `looked_at_left` tinyint(4) NOT NULL,
  `looked_at_right` tinyint(4) NOT NULL,
  `looked_at_up` tinyint(4) NOT NULL,
  `looked_at_down` tinyint(4) NOT NULL,
  `left_hand_movement` tinyint(4) NOT NULL,
  `right_hand_movement` tinyint(4) NOT NULL,
  `head_movement` tinyint(4) NOT NULL,
  `object_detected` tinyint(4) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exam_details`
--

CREATE TABLE `exam_details` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `live_url` varchar(255) DEFAULT NULL,
  `content_url` varchar(255) DEFAULT NULL,
  `student_feedback` text DEFAULT NULL,
  `proctor_remarks` text DEFAULT 'Pending',
  `proctor_action` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0-nothing, 1- approve, 2- warning, 3-reject',
  `reviewer_remarks` text DEFAULT 'Pending',
  `reviewer_action` tinyint(4) NOT NULL DEFAULT 0,
  `sign_off_status` tinyint(4) NOT NULL DEFAULT 0,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exam_details`
--

INSERT INTO `exam_details` (`id`, `schedule_id`, `student_id`, `subject_id`, `live_url`, `content_url`, `student_feedback`, `proctor_remarks`, `proctor_action`, `reviewer_remarks`, `reviewer_action`, `sign_off_status`, `created`, `modified`, `status`) VALUES
(1, 1, 5, 1, NULL, NULL, 'Nice Experience', 'OK', 1, 'Pending', 0, 1, '2020-04-19 13:00:34', '2020-04-19 13:00:34', 1),
(2, 2, 7, 2, NULL, NULL, 'Good', 'Suspecious activity found', 2, 'Rejested as he was cheating', 3, 1, '2020-04-20 13:00:34', '2020-04-20 13:00:34', 1),
(3, 3, 3, 3, NULL, NULL, 'Good', 'No issues found', 1, 'OK', 1, 0, '2020-04-18 13:00:34', '2020-04-18 13:00:34', 1),
(4, 4, 8, 4, NULL, NULL, NULL, 'Pending', 0, 'Pending', 0, 0, '2020-04-14 13:00:34', '2020-04-14 13:00:34', 1),
(5, 5, 9, 5, NULL, NULL, 'Good', 'OK', 1, 'Pending', 0, 1, '2020-04-16 13:00:34', '2020-04-16 13:00:34', 1),
(8, 20, 3, 1, NULL, NULL, 'Provide your feedback here', 'Pending', 0, 'Pending', 0, 0, '2020-04-28 20:07:01', '2020-04-28 20:07:01', 1);

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
(3, '2017_07_12_145959_create_permission_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(2, 'App\\User', 2),
(2, 'App\\User', 4),
(3, 'App\\User', 3),
(3, 'App\\User', 5),
(3, 'App\\User', 6),
(3, 'App\\User', 7),
(3, 'App\\User', 8),
(3, 'App\\User', 9),
(4, 'App\\User', 4);

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'users_manage', 'web', '2020-04-02 10:49:30', '2020-04-02 10:54:03'),
(2, 'attend_exam', 'web', '2020-04-02 10:53:42', '2020-04-05 11:58:15'),
(3, 'invigilation_manage', 'web', '2020-04-02 11:00:52', '2020-04-05 11:58:49'),
(4, 'reviewer', 'web', '2020-04-07 11:28:37', '2020-04-07 11:28:37');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'administrator', 'web', '2020-04-02 10:49:30', '2020-04-02 10:49:30'),
(2, 'proctor', 'web', '2020-04-02 11:01:09', '2020-04-02 11:01:09'),
(3, 'student', 'web', '2020-04-02 11:01:19', '2020-04-02 11:01:19'),
(4, 'reviewer', 'web', '2020-04-07 11:29:13', '2020-04-07 11:29:13');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 3),
(3, 2),
(3, 4),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `subject_id`, `start_time`, `end_time`, `created`, `modified`, `status`) VALUES
(1, 1, '2020-04-08 09:00:00', '2020-04-08 11:00:00', '2020-04-07 12:26:25', '2020-04-07 12:27:42', 1),
(2, 2, '2020-04-10 12:00:00', '2020-04-10 13:00:00', '2020-04-07 12:26:25', '2020-04-07 12:29:44', 1),
(3, 3, '2020-04-10 09:00:00', '2020-04-10 10:00:00', '2020-04-07 12:26:25', '2020-04-07 12:29:44', 1),
(4, 4, '2020-04-20 10:00:00', '2020-04-20 21:00:00', '2020-04-07 12:26:25', '2020-04-07 12:29:44', 1),
(5, 5, '2020-04-09 09:00:00', '2020-04-09 10:00:00', '2020-04-07 12:26:25', '2020-04-07 12:29:44', 1),
(6, 6, '2020-04-21 12:00:00', '2020-04-21 11:59:45', '2020-04-07 12:26:25', '2020-04-07 12:29:44', 1),
(7, 1, '2020-04-22 11:00:00', '2020-04-22 12:00:00', '2020-04-05 17:22:54', '2020-04-08 17:23:35', 1),
(17, 3, '2020-05-01 09:00:00', '2020-05-01 11:00:00', '2020-04-27 18:10:57', '2020-04-27 18:10:57', 1),
(19, 6, '2020-05-07 08:00:00', '2020-05-07 10:00:00', '2020-04-27 19:14:54', '2020-04-27 19:14:54', 1),
(20, 1, '2020-05-19 09:00:00', '2020-05-19 11:00:00', '2020-04-27 19:16:13', '2020-04-27 19:16:13', 1),
(24, 5, '2020-04-28 18:00:00', '2020-04-28 23:00:00', '2020-04-28 18:32:01', '2020-04-28 18:32:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_exam_registration`
--

CREATE TABLE `student_exam_registration` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `exam_attended` tinyint(4) DEFAULT NULL COMMENT '0-not attended 1 -attended',
  `active_status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0- inactive 1- active',
  `created` datetime DEFAULT NULL,
  `modified` datetime NOT NULL DEFAULT current_timestamp(),
  `delete_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0- not delted 1- delted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_exam_registration`
--

INSERT INTO `student_exam_registration` (`id`, `student_id`, `subject_id`, `schedule_id`, `exam_attended`, `active_status`, `created`, `modified`, `delete_status`) VALUES
(1, 3, 1, 1, NULL, 1, '2020-04-08 17:10:39', '2020-04-08 17:13:03', 0),
(2, 3, 1, 7, NULL, 1, '2020-04-06 17:22:20', '2020-04-08 17:25:26', 0),
(3, 3, 5, 18, NULL, 1, '2020-04-27 18:43:03', '2020-04-27 18:43:03', 0),
(11, 3, 1, 9, NULL, 1, '2020-04-27 18:58:54', '2020-04-27 18:58:54', 0),
(14, 3, 1, 20, NULL, 1, '2020-04-27 20:09:41', '2020-04-27 20:09:41', 0),
(16, 3, 3, 17, NULL, 1, '2020-04-28 18:26:55', '2020-04-28 18:26:55', 0),
(17, 3, 5, 24, NULL, 1, '2020-04-28 18:32:24', '2020-04-28 18:32:24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `title`, `created`, `modified`, `status`) VALUES
(1, 'Mathematics', '2020-04-07 12:22:53', '2020-04-07 12:23:36', 1),
(2, 'English', '2020-04-07 12:22:53', '2020-04-07 12:23:36', 1),
(3, 'Chemistry', '2020-04-07 12:22:53', '2020-04-07 12:25:17', 1),
(4, 'Physics', '2020-04-07 12:22:53', '2020-04-07 12:25:17', 1),
(5, 'Biology', '2020-04-07 12:22:53', '2020-04-07 12:25:52', 1),
(6, 'Geography', '2020-04-07 12:22:53', '2020-04-07 12:25:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', '$2y$10$775Y7RK9wanXyT0bwPwdmOLMf90BkMMRIw1W5D96BP67916o2g.42', NULL, '2020-04-02 10:49:30', '2020-04-02 10:49:30'),
(2, 'Proctor', 'proctor@proctor.com', '$2y$10$n9/t1mHr7AI5LNU.v/lia.aPfnfwDKAg5phwEDpj/wQsgSNNHZ1ey', NULL, '2020-04-02 11:01:51', '2020-04-02 11:01:51'),
(3, 'andrew', 'student@student.com', '$2y$10$0XXdsUV/TsxA/z7LbfvUaOna6wEPeHicVCLvU8U.GAGN2Rg0KcEHK', 'JRoj9fD6lwqO8LzwzKEfSwsVq1zUAHZ5giSQUztK8muHyJGZFc0DLiCJQeji', '2020-04-02 11:02:13', '2020-04-08 23:23:02'),
(4, 'Reviewer', 'reviewer@reviewer.com', '$2y$10$5E058ZwnDkF2q0zRWEX6wOIpvZO0W9QydhCQIdi5/tWs9f1fGU/3u', NULL, '2020-04-07 11:29:53', '2020-04-07 11:29:53'),
(5, 'Simon', 'student1@student.com', '$2y$10$V/k7610qdFvJOmqgRIRmx.zuqrZ2Yn4EL8JGBCZjo4rxR./k385sO', NULL, '2020-04-08 06:25:08', '2020-04-08 06:25:08'),
(6, 'Zoya', 'student2@student.com', '$2y$10$pSt7YVM/4fwL2td2qPsCr.WIZhHXKzZVluBoIDxHKX4Tk9sKo3aEO', NULL, '2020-04-08 06:25:43', '2020-04-08 06:25:43'),
(7, 'Shane', 'student3@student.com', '$2y$10$IxGOKSE.oGVZE/KJDJAPH.eyjV/1PPgs6GAmpnfxqfQLPAex3YT7O', NULL, '2020-04-08 06:26:14', '2020-04-08 06:26:14'),
(8, 'Ricky', 'student4@student.com', '$2y$10$aA6ZmFiNo05Vgi7B7M/OyegJwgBMIqSQ/DjmPhrsHx8HQ60lrMh16', NULL, '2020-04-08 06:26:28', '2020-04-08 06:26:28'),
(9, 'Kevin', 'student5@student.com', '$2y$10$8C.Sk7mnv3EUUqX5kQe29uCTQdF.tWGUrpQOST0rCq6p5dggyv83a', NULL, '2020-04-08 06:27:42', '2020-04-08 06:27:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alert_type`
--
ALTER TABLE `alert_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calibration_info`
--
ALTER TABLE `calibration_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_details`
--
ALTER TABLE `exam_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_exam_registration`
--
ALTER TABLE `student_exam_registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
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
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `alert_type`
--
ALTER TABLE `alert_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `calibration_info`
--
ALTER TABLE `calibration_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_details`
--
ALTER TABLE `exam_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `student_exam_registration`
--
ALTER TABLE `student_exam_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

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
