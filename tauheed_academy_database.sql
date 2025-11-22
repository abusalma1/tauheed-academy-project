-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2025 at 07:40 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tauheed_academy_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `type` enum('admin','superAdmin') DEFAULT 'admin',
  `staff_no` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `phone` varchar(20) DEFAULT NULL,
  `picture_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `qualification` varchar(255) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT 'male',
  `experience` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `reset_token`, `type`, `staff_no`, `address`, `department`, `status`, `phone`, `picture_path`, `created_at`, `updated_at`, `qualification`, `gender`, `experience`, `reset_expires`) VALUES
(1, 'Abubakar Ahmad Adili', 'superadmin@email.com', '$2y$10$CWSA8wZpIm.29G7UUqjabeQQ2e5sDSGgg7wmS/reLHUlPWjykolAa', NULL, 'superAdmin', 'ST/2025/001', 'Maniru Road', 'Director/CEO', 'active', '09061893504', NULL, '2025-11-05 14:33:05', '2025-11-20 12:03:54', NULL, 'male', NULL, NULL),
(2, 'Aminu Ahmad Adili', 'admin@email.com', '$2y$10$TDnqjeR0wzvlaI3TLIYBiewsjVljhGrlcXTEwQbn4Pwf7JBt/sU4q', NULL, 'admin', 'ST/2025/002', 'Kofar Marke Area', 'Development', 'active', '09061893504', NULL, '2025-11-10 12:28:17', '2025-11-17 13:50:15', NULL, 'male', NULL, NULL),
(3, 'Abusalma', 'abusalma@email.com', '$2y$12$cwHfSjrOQke1NebbuPwSLOjUE1A0G7QZ6nA2Mqa/2AfwOFvYQqBbS', NULL, 'admin', 'ST/2025/003', 'Mabera', 'FInance', 'active', '09071465325', NULL, '2025-11-20 14:46:54', '2025-11-20 14:46:54', 'B.sc Public Admin', 'male', 'iconic Open University (10 years fince officer)', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `section_id`, `name`, `created_at`, `updated_at`, `level`) VALUES
(1, 3, 'JSS 1', '2025-11-06 13:45:16', '2025-11-21 14:00:43', 6),
(2, 1, 'Nursery 1', '2025-11-06 13:54:09', '2025-11-21 13:59:26', 1),
(3, 1, 'Nursery 2', '2025-11-06 13:54:38', '2025-11-21 13:59:40', 2),
(4, 2, 'SS 1', '2025-11-06 13:54:54', '2025-11-21 14:01:28', 7),
(5, 2, 'SS 2', '2025-11-06 13:55:14', '2025-11-21 14:01:59', 8),
(6, 2, 'SS 3', '2025-11-07 08:53:57', '2025-11-21 14:02:08', 9),
(7, 1, 'Nursery 3', '2025-11-07 10:10:37', '2025-11-21 13:59:40', 3),
(8, 4, 'Primary 1', '2025-11-07 10:42:32', '2025-11-21 14:00:17', 4),
(9, 4, 'Primary 2', '2025-11-10 12:48:20', '2025-11-21 14:00:43', 5),
(15, 5, 'Raudatu Aisha', '2025-11-21 13:52:12', '2025-11-21 14:02:42', 10);

-- --------------------------------------------------------

--
-- Table structure for table `class_arms`
--

CREATE TABLE `class_arms` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_arms`
--

INSERT INTO `class_arms` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'A', '', '2025-11-05 14:48:58', '2025-11-05 14:48:58'),
(2, 'B', '', '2025-11-05 14:49:03', '2025-11-10 12:54:17'),
(3, 'C', '', '2025-11-05 14:49:08', '2025-11-05 14:49:08'),
(4, 'D', '', '2025-11-05 14:49:14', '2025-11-05 14:49:14'),
(5, 'E', '', '2025-11-10 12:59:41', '2025-11-10 12:59:41');

-- --------------------------------------------------------

--
-- Table structure for table `class_class_arms`
--

CREATE TABLE `class_class_arms` (
  `class_id` int(11) NOT NULL,
  `arm_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_class_arms`
--

INSERT INTO `class_class_arms` (`class_id`, `arm_id`, `teacher_id`) VALUES
(1, 1, NULL),
(1, 2, NULL),
(1, 3, NULL),
(2, 1, NULL),
(2, 2, NULL),
(3, 1, NULL),
(3, 2, NULL),
(4, 1, NULL),
(4, 2, NULL),
(4, 3, NULL),
(5, 1, NULL),
(5, 2, NULL),
(6, 1, NULL),
(6, 2, NULL),
(7, 1, NULL),
(7, 2, NULL),
(8, 1, NULL),
(8, 2, NULL),
(8, 3, NULL),
(9, 1, NULL),
(9, 2, NULL),
(9, 3, NULL),
(15, 1, NULL),
(15, 2, NULL),
(15, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `class_subjects`
--

CREATE TABLE `class_subjects` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_subjects`
--

INSERT INTO `class_subjects` (`id`, `class_id`, `subject_id`, `teacher_id`, `created_at`) VALUES
(11, 2, 1, NULL, '2025-11-07 09:39:14'),
(12, 3, 1, NULL, '2025-11-07 09:39:15'),
(13, 4, 1, 1, '2025-11-07 09:39:15'),
(14, 5, 1, 2, '2025-11-07 09:39:15'),
(15, 1, 1, NULL, '2025-11-07 09:39:15'),
(16, 6, 1, NULL, '2025-11-07 09:39:15'),
(23, 4, 3, NULL, '2025-11-07 09:40:21'),
(24, 5, 3, NULL, '2025-11-07 09:40:21'),
(25, 6, 3, NULL, '2025-11-07 09:40:21'),
(26, 1, 2, 1, '2025-11-09 14:26:31'),
(27, 2, 2, 1, '2025-11-09 14:26:32'),
(28, 3, 2, NULL, '2025-11-09 14:26:32'),
(29, 4, 2, NULL, '2025-11-09 14:26:32'),
(30, 5, 2, NULL, '2025-11-09 14:26:32'),
(31, 6, 2, NULL, '2025-11-09 14:26:32'),
(32, 7, 2, 3, '2025-11-09 14:26:32'),
(33, 8, 2, NULL, '2025-11-09 14:26:33'),
(34, 4, 6, NULL, '2025-11-10 10:45:51'),
(35, 5, 6, NULL, '2025-11-10 10:45:52'),
(36, 6, 6, NULL, '2025-11-10 10:45:52'),
(37, 4, 7, NULL, '2025-11-10 10:49:18'),
(38, 5, 7, NULL, '2025-11-10 10:49:18'),
(39, 6, 7, NULL, '2025-11-10 10:49:18'),
(40, 1, 4, 1, '2025-11-10 11:41:24'),
(41, 1, 8, NULL, '2025-11-10 11:41:53'),
(42, 2, 5, NULL, '2025-11-10 12:00:21'),
(43, 3, 5, NULL, '2025-11-10 12:00:21');

-- --------------------------------------------------------

--
-- Table structure for table `guardians`
--

CREATE TABLE `guardians` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `picture_path` varchar(255) DEFAULT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `reset_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `gender` enum('male','female') DEFAULT 'male',
  `reset_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guardians`
--

INSERT INTO `guardians` (`id`, `name`, `email`, `phone`, `address`, `picture_path`, `relationship`, `occupation`, `password`, `status`, `reset_token`, `created_at`, `updated_at`, `gender`, `reset_expires`) VALUES
(1, 'Yusuf Kaoje', 'guardian@email.com', '09061893504', 'Arkilla Fire Service', NULL, 'father', 'Physician', '$2y$10$oF/M3BFvfwc3jPCL.b5JY.2JNHwbzdBprVYCtYeXZGwSVXTEWIbMC', 'active', NULL, '2025-11-06 09:46:29', '2025-11-20 05:40:26', 'male', NULL),
(2, 'Yahya Kamar', 'yahya@email.com', '08012345678', 'Emir Yahya', NULL, 'father', 'Lecture', '$2y$10$daEH3qJkX30oe/jS3/0g5uk51ylsINpdn0I3qR8WktBe8rutOErly', 'active', NULL, '2025-11-06 09:47:39', '2025-11-18 11:10:26', 'male', NULL),
(3, 'Tijjani kware', 'tijjani@email.com', '090 1934 4018', 'kware LG', NULL, 'father', 'Business Man', '$2y$10$daEH3qJkX30oe/jS3/0g5uk51ylsINpdn0I3qR8WktBe8rutOErly', 'active', NULL, '2025-11-10 12:33:37', '2025-11-18 11:10:26', 'male', NULL),
(4, 'Faruk Kalgo', 'kalgo@email.com', '09061893504', 'Runjin Sambo', NULL, 'father', 'Lecuture', '$2y$10$daEH3qJkX30oe/jS3/0g5uk51ylsINpdn0I3qR8WktBe8rutOErly', 'active', NULL, '2025-11-11 10:35:02', '2025-11-18 11:10:26', 'male', NULL),
(5, 'Sanusi Gandu', 'sanusi@email.com', '09061893504', 'Gandu Area', NULL, 'father', 'Business', '$2y$10$daEH3qJkX30oe/jS3/0g5uk51ylsINpdn0I3qR8WktBe8rutOErly', 'active', NULL, '2025-11-11 10:36:16', '2025-11-18 11:10:26', 'male', NULL),
(6, 'Hassan Musa Kebbeh', 'kebbeh@email.com', '09061893504', 'Gidan Igwai', NULL, 'father', 'Civil Servant', '$2y$10$daEH3qJkX30oe/jS3/0g5uk51ylsINpdn0I3qR8WktBe8rutOErly', 'active', NULL, '2025-11-11 10:37:30', '2025-11-18 11:10:26', 'male', NULL),
(7, 'Bello Inga', 'bello@email.com', '09012345652', 'Binanchi Area', NULL, 'father', 'Business', '$2y$10$daEH3qJkX30oe/jS3/0g5uk51ylsINpdn0I3qR8WktBe8rutOErly', 'active', NULL, '2025-11-11 10:38:32', '2025-11-18 11:10:26', 'male', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `student_term_record_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `ca` decimal(5,2) DEFAULT 0.00,
  `exam` decimal(5,2) DEFAULT 0.00,
  `total` decimal(6,2) GENERATED ALWAYS AS (`ca` + `exam`) STORED,
  `grade` varchar(2) DEFAULT NULL,
  `remark` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `student_term_record_id`, `subject_id`, `ca`, `exam`, `grade`, `remark`, `created_at`, `updated_at`) VALUES
(1, 1, 8, '5.00', '50.00', 'C', 'Good', '2025-11-17 07:49:27', '2025-11-17 11:34:39'),
(2, 2, 8, '19.00', '18.00', 'F', 'Fail', '2025-11-17 07:49:28', '2025-11-17 11:34:39'),
(3, 3, 8, '35.00', '34.00', 'B', 'Very Good', '2025-11-17 07:52:45', '2025-11-17 07:52:45'),
(4, 4, 8, '30.00', '50.00', 'A', 'Excellent', '2025-11-17 07:52:46', '2025-11-17 07:52:46'),
(9, 3, 4, '20.00', '50.00', 'A', 'Excellent', '2025-11-17 12:32:13', '2025-11-17 12:32:13'),
(10, 4, 4, '35.00', '60.00', 'A', 'Excellent', '2025-11-17 12:32:14', '2025-11-17 12:32:14');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `motto` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `whatsapp_number` varchar(20) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`, `motto`, `address`, `phone`, `email`, `whatsapp_number`, `facebook`, `twitter`, `instagram`, `logo_path`, `created_at`, `updated_at`) VALUES
(1, 'Tauheed Academy', 'Nuturing Future Leaders', 'Maniru Road\r\n', '', '', '', '', '', '', NULL, '2025-11-05 14:32:05', '2025-11-10 12:00:04');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `head_teacher_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `description`, `head_teacher_id`, `created_at`, `updated_at`) VALUES
(1, 'Nursery', 'pre primary Education', 1, '2025-11-06 09:29:24', '2025-11-06 09:29:24'),
(2, 'Senoir Secondary', 'senior secondary section', 3, '2025-11-06 09:30:15', '2025-11-06 09:30:15'),
(3, 'Junior Secondary', 'Junior Secondary', 3, '2025-11-06 09:30:46', '2025-11-06 09:30:46'),
(4, 'Primary', 'Basic Education', 3, '2025-11-07 10:43:02', '2025-11-07 10:43:02'),
(5, 'Tahfeez', 'Islamiyya', 2, '2025-11-10 12:49:47', '2025-11-10 12:49:47');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('pending','ongoing','finished') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `name`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(1, '2023/2024', '2024-01-01', '2024-12-31', 'pending', '2025-11-07 14:15:27'),
(2, '2024/2025', '2025-01-01', '2025-12-31', 'pending', '2025-11-07 15:14:02'),
(3, '2025/2026', '2026-01-01', '2026-12-31', 'pending', '2025-11-10 09:21:50'),
(4, '2022/2023', '2023-01-01', '2023-12-31', 'pending', '2025-11-10 11:55:38'),
(5, '2026/2027', '2027-01-01', '2028-12-31', 'pending', '2025-11-10 11:56:25');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `admission_number` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `guardian_id` int(11) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `gender` enum('male','female') DEFAULT 'male',
  `class_id` int(11) DEFAULT NULL,
  `arm_id` int(11) DEFAULT NULL,
  `term_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reset_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `admission_number`, `email`, `phone`, `guardian_id`, `dob`, `picture`, `password`, `reset_token`, `status`, `gender`, `class_id`, `arm_id`, `term_id`, `created_at`, `updated_at`, `reset_expires`) VALUES
(1, 'Abdulrahman Faruk Kalgo', '25/04/001', 'student@email.com', '09061893504', 4, '2005-01-01', NULL, '$2y$10$ocPaYzJd91p9wDzMYHrJ5uQ0aZmNTzFhcfTzFUmoWX01wd18e/Nb2', NULL, 'active', 'male', 1, 1, 1, '2025-11-13 09:49:29', '2025-11-20 05:39:31', NULL),
(2, 'Sagir yusuf Kaoje', '25/04/002', '', '', 1, '2022-12-12', NULL, '$2y$10$irkhT8/EmOsB8/9CzoajRe6T.HxMV3E2ncG/XMrZ6Qw0NGGb5ADye', NULL, 'active', 'male', 1, 2, 1, '2025-11-13 11:54:58', '2025-11-19 15:25:39', NULL),
(3, 'Samir Yusuf', '25/04/003', '', '', 1, '2018-01-01', NULL, '$2y$10$irkhT8/EmOsB8/9CzoajRe6T.HxMV3E2ncG/XMrZ6Qw0NGGb5ADye', NULL, 'active', 'male', 2, 1, 1, '2025-11-15 00:26:26', '2025-11-19 15:25:39', NULL),
(4, 'Kabir Ysusf kaoje', '25/04/004', 'student2@email.com', '', 1, '2018-01-01', NULL, '$2y$10$irkhT8/EmOsB8/9CzoajRe6T.HxMV3E2ncG/XMrZ6Qw0NGGb5ADye', NULL, 'active', 'female', 4, 1, 2, '2025-11-17 14:08:23', '2025-11-19 15:25:39', NULL),
(5, 'Sadiaya F K', '25/04/005', '', '', 4, '2002-12-12', NULL, '$2y$10$irkhT8/EmOsB8/9CzoajRe6T.HxMV3E2ncG/XMrZ6Qw0NGGb5ADye', NULL, 'active', 'female', 4, 1, 1, '2025-11-17 13:07:23', '2025-11-19 15:25:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_class_records`
--

CREATE TABLE `student_class_records` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `arm_id` int(11) NOT NULL,
  `overall_total` decimal(8,2) DEFAULT 0.00,
  `overall_average` decimal(5,2) DEFAULT 0.00,
  `overall_position` int(11) DEFAULT NULL,
  `promotion_status` enum('promoted','repeat','pending') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_class_records`
--

INSERT INTO `student_class_records` (`id`, `student_id`, `session_id`, `class_id`, `arm_id`, `overall_total`, `overall_average`, `overall_position`, `promotion_status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '0.00', '0.00', NULL, 'pending', '2025-11-17 07:47:32', '2025-11-17 07:47:32'),
(2, 2, 1, 1, 2, '0.00', '0.00', NULL, 'pending', '2025-11-17 07:49:27', '2025-11-17 07:49:27'),
(3, 4, 1, 4, 1, '0.00', '0.00', NULL, 'pending', '2025-11-17 14:08:25', '2025-11-17 14:08:25'),
(4, 5, 1, 4, 1, '0.00', '0.00', NULL, 'pending', '2025-11-17 13:07:23', '2025-11-17 13:07:23');

-- --------------------------------------------------------

--
-- Table structure for table `student_term_records`
--

CREATE TABLE `student_term_records` (
  `id` int(11) NOT NULL,
  `student_class_record_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `total_marks` decimal(8,2) DEFAULT 0.00,
  `average_marks` decimal(5,2) DEFAULT 0.00,
  `position_in_class` int(11) DEFAULT NULL,
  `class_size` int(11) DEFAULT NULL,
  `overall_grade` varchar(5) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_term_records`
--

INSERT INTO `student_term_records` (`id`, `student_class_record_id`, `term_id`, `total_marks`, `average_marks`, `position_in_class`, `class_size`, `overall_grade`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '55.00', '55.00', 1, 2, NULL, '2025-11-17 07:49:25', '2025-11-17 11:34:40'),
(2, 2, 1, '37.00', '37.00', 2, 2, NULL, '2025-11-17 07:49:28', '2025-11-17 11:34:40'),
(3, 1, 2, '139.00', '69.50', 2, 2, NULL, '2025-11-17 07:52:44', '2025-11-17 12:32:18'),
(4, 2, 2, '175.00', '87.50', 1, 2, NULL, '2025-11-17 07:52:45', '2025-11-17 12:32:18');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Mathematics', '2025-11-06 12:22:34', '2025-11-06 12:22:34'),
(2, 'English', '2025-11-06 13:47:06', '2025-11-06 13:47:06'),
(3, 'bology', '2025-11-06 13:50:44', '2025-11-06 13:50:44'),
(4, 'Basic Technology', '2025-11-06 14:04:36', '2025-11-10 11:41:24'),
(5, 'Quantitave Reasoning', '2025-11-07 08:47:33', '2025-11-07 08:47:33'),
(6, 'Geography', '2025-11-10 10:45:51', '2025-11-10 10:45:51'),
(7, 'Economics', '2025-11-10 10:49:18', '2025-11-10 10:49:18'),
(8, 'Basic Science', '2025-11-10 11:41:53', '2025-11-10 11:41:53');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `qualification` varchar(150) DEFAULT NULL,
  `staff_no` varchar(50) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `picture_path` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `gender` enum('male','female') DEFAULT 'male',
  `experience` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `email`, `phone`, `address`, `qualification`, `staff_no`, `status`, `picture_path`, `password`, `reset_token`, `created_at`, `updated_at`, `gender`, `experience`, `reset_expires`) VALUES
(1, 'Mudassir Ahmad Adili', 'teacher@email.com', '09061893504', 'Maniru Road sokoto', 'B.Sc Mathematics', 'ST/2025/002', 'active', NULL, '$2y$10$70rAPv9uUi9pKQrFeZpUwexTtTc.sBq3RJ8U8MpibMYefRjKU/CDK', NULL, '2025-11-06 07:43:31', '2025-11-20 05:40:57', 'male', NULL, NULL),
(2, 'Nasir Ahmad Adili', 'nasir@email.com', '09061893504', 'Maniru Road', 'B.Sc Computer Science', 'ST/2025/001', 'active', NULL, '$2y$10$SRxpNUZjWZ2YOemv54dv1O1iqPAKblCMsSvEbbgvZlv6nqC2J24HS', NULL, '2025-11-06 09:26:51', '2025-11-17 13:43:48', 'male', NULL, NULL),
(3, 'Abdullahi Ahmad Adili', 'abdullahi@email.com', '08012345678', 'Maniru Road', 'B.Sc Mathematics', 'ST/2025/003', 'active', NULL, '$2y$10$SRxpNUZjWZ2YOemv54dv1O1iqPAKblCMsSvEbbgvZlv6nqC2J24HS', NULL, '2025-11-06 09:28:47', '2025-11-17 13:43:48', 'male', NULL, NULL),
(4, 'Mubarak Ahmad Adili', 'mk@email.com', '09061893504', 'Arkilla', 'B.Sc Accouting', 'ST/2025/005', 'active', NULL, '$2y$10$SRxpNUZjWZ2YOemv54dv1O1iqPAKblCMsSvEbbgvZlv6nqC2J24HS', NULL, '2025-11-10 12:29:49', '2025-11-17 13:43:48', 'male', NULL, NULL),
(5, 'Abba Ahmad Adili', 'abba@email.com', '090 1934 4018', 'Kofar Marke', 'B.sc Animal Science', 'ST/2025/006', 'active', NULL, '$2y$10$SRxpNUZjWZ2YOemv54dv1O1iqPAKblCMsSvEbbgvZlv6nqC2J24HS', NULL, '2025-11-10 12:32:14', '2025-11-17 13:43:48', 'male', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_section`
--

CREATE TABLE `teacher_section` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `session_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('pending','ongoing','finished') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `name`, `session_id`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(1, 'First Term', 1, '2024-01-01', '2024-04-30', 'finished', '2025-11-09 14:33:02'),
(2, 'Second Term', 1, '2024-05-01', '2025-08-30', 'finished', '2025-11-09 14:43:45'),
(3, 'First Term', 2, '2025-01-01', '2025-04-30', 'finished', '2025-11-10 07:37:42'),
(4, 'Second Term', 2, '2025-04-01', '2025-08-31', 'finished', '2025-11-10 07:43:42'),
(5, 'First Term', 3, '2026-01-01', '2026-04-30', 'ongoing', '2025-11-10 09:22:36'),
(6, 'Second Term', 3, '2026-05-01', '2026-08-31', 'pending', '2025-11-10 11:57:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `staff_no` (`staff_no`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `level` (`level`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `class_arms`
--
ALTER TABLE `class_arms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_class_arms`
--
ALTER TABLE `class_class_arms`
  ADD PRIMARY KEY (`class_id`,`arm_id`),
  ADD KEY `arm_id` (`arm_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `class_subjects`
--
ALTER TABLE `class_subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `class_id` (`class_id`,`subject_id`,`teacher_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `guardians`
--
ALTER TABLE `guardians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_term_record_id` (`student_term_record_id`,`subject_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `head_teacher_id` (`head_teacher_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admission_number` (`admission_number`),
  ADD KEY `guardian_id` (`guardian_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `arm_id` (`arm_id`),
  ADD KEY `term_id` (`term_id`);

--
-- Indexes for table `student_class_records`
--
ALTER TABLE `student_class_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`session_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `arm_id` (`arm_id`);

--
-- Indexes for table `student_term_records`
--
ALTER TABLE `student_term_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_class_record_id` (`student_class_record_id`,`term_id`),
  ADD KEY `term_id` (`term_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `staff_no` (`staff_no`);

--
-- Indexes for table `teacher_section`
--
ALTER TABLE `teacher_section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `class_arms`
--
ALTER TABLE `class_arms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `class_subjects`
--
ALTER TABLE `class_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_class_records`
--
ALTER TABLE `student_class_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student_term_records`
--
ALTER TABLE `student_term_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teacher_section`
--
ALTER TABLE `teacher_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `class_class_arms`
--
ALTER TABLE `class_class_arms`
  ADD CONSTRAINT `class_class_arms_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_class_arms_ibfk_2` FOREIGN KEY (`arm_id`) REFERENCES `class_arms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_class_arms_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `class_subjects`
--
ALTER TABLE `class_subjects`
  ADD CONSTRAINT `class_subjects_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_subjects_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`student_term_record_id`) REFERENCES `student_term_records` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`head_teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`guardian_id`) REFERENCES `guardians` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_ibfk_3` FOREIGN KEY (`arm_id`) REFERENCES `class_arms` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_ibfk_4` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `student_class_records`
--
ALTER TABLE `student_class_records`
  ADD CONSTRAINT `student_class_records_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_class_records_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_class_records_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_class_records_ibfk_4` FOREIGN KEY (`arm_id`) REFERENCES `class_arms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_term_records`
--
ALTER TABLE `student_term_records`
  ADD CONSTRAINT `student_term_records_ibfk_1` FOREIGN KEY (`student_class_record_id`) REFERENCES `student_class_records` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_term_records_ibfk_2` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_section`
--
ALTER TABLE `teacher_section`
  ADD CONSTRAINT `teacher_section_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_section_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `terms`
--
ALTER TABLE `terms`
  ADD CONSTRAINT `terms_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
