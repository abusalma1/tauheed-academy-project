-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2025 at 04:31 PM
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
  `reset_expires` datetime DEFAULT NULL,
  `type` enum('admin','superAdmin') DEFAULT 'admin',
  `staff_no` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT 'male',
  `department` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `phone` varchar(20) DEFAULT NULL,
  `picture_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `reset_token`, `reset_expires`, `type`, `staff_no`, `address`, `qualification`, `experience`, `gender`, `department`, `status`, `phone`, `picture_path`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin@email.com', '$2y$10$bUZPk9sINCfqwty1GQttsOCV0XmbW5vsmsusziT5JtifMQ4br2XjW', NULL, NULL, 'superAdmin', 'STAFF/A/001', 'Address Address', 'Qualification', 'Experiance', 'male', 'Super Admin', 'active', '08012345678', NULL, '2025-11-28 04:02:17', NULL, '2025-11-28 04:42:51'),
(2, 'Abubakar Ahmad Adili', 'abubakarahmadadili@gmail.com', '$2y$10$Ha.KDetS1lPj8kO7.ue0X.kqnLIAI3ovepoxeydaZW1bbOusMcWfS', NULL, NULL, 'admin', 'STAFF/A/002', 'Address *\r\nAddress *', 'QualificationQualificationQualificationQualification', 'experienceexperience', 'male', 'Super Admin', 'active', '08012345678', NULL, '2025-12-01 03:07:17', NULL, '2025-12-01 03:14:25');

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(34) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `bank_name`, `account_name`, `account_number`, `purpose`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 'GT Bank', 'tauheed academywqe', '12345678', 'Secondary Section payment', '2025-12-01 01:30:40', '2025-12-01 02:38:59', '2025-12-01 01:38:59');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `level` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `section_id`, `name`, `level`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 1, 'Nursery 1', 1, '2025-11-28 04:46:22', NULL, '2025-11-28 04:46:22'),
(2, 1, 'Nursery 2', 2, '2025-11-28 06:14:52', NULL, '2025-11-28 06:14:52'),
(3, 1, 'Nursery 3', 3, '2025-11-29 02:37:31', NULL, '2025-11-29 02:37:31'),
(4, 2, 'Primary 1', 4, '2025-11-29 17:10:12', NULL, '2025-11-29 17:10:12'),
(5, 2, 'Primary 2', 5, '2025-11-29 17:23:28', NULL, '2025-11-29 17:23:28'),
(6, 2, 'Primary 3', 6, '2025-12-01 01:23:03', '2025-12-01 02:23:19', '2025-12-01 01:23:19');

-- --------------------------------------------------------

--
-- Table structure for table `class_arms`
--

CREATE TABLE `class_arms` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_arms`
--

INSERT INTO `class_arms` (`id`, `name`, `description`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 'A', 'First Section Of a class', '2025-11-28 04:37:13', NULL, '2025-11-28 04:37:13'),
(2, 'B', 'Second Section of a class', '2025-11-28 04:37:41', NULL, '2025-11-28 04:37:41'),
(3, 'C', '', '2025-12-01 01:20:29', '2025-12-01 02:20:50', '2025-12-01 01:20:50');

-- --------------------------------------------------------

--
-- Table structure for table `class_class_arms`
--

CREATE TABLE `class_class_arms` (
  `class_id` int(11) NOT NULL,
  `arm_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_class_arms`
--

INSERT INTO `class_class_arms` (`class_id`, `arm_id`, `teacher_id`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 1, NULL, '2025-11-28 04:46:22', NULL, '2025-11-28 04:46:22'),
(1, 2, NULL, '2025-11-28 04:46:22', NULL, '2025-11-28 04:46:22'),
(2, 1, 2, '2025-11-28 06:14:52', NULL, '2025-11-30 06:00:49'),
(2, 2, 2, '2025-11-28 06:14:52', NULL, '2025-11-29 19:00:01'),
(3, 1, 1, '2025-11-29 02:37:31', NULL, '2025-11-29 19:00:58'),
(3, 2, 2, '2025-11-29 02:37:31', NULL, '2025-11-29 19:45:46'),
(4, 1, NULL, '2025-11-29 17:10:12', NULL, '2025-11-29 17:10:12'),
(4, 2, NULL, '2025-11-29 17:10:12', NULL, '2025-11-29 17:10:12'),
(5, 1, NULL, '2025-11-29 17:23:28', NULL, '2025-11-29 17:23:28'),
(5, 2, NULL, '2025-11-29 17:23:28', NULL, '2025-11-29 17:23:28'),
(6, 1, NULL, '2025-12-01 01:23:14', NULL, '2025-12-01 01:23:14'),
(6, 2, NULL, '2025-12-01 01:23:14', NULL, '2025-12-01 01:23:14');

-- --------------------------------------------------------

--
-- Table structure for table `class_subjects`
--

CREATE TABLE `class_subjects` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_subjects`
--

INSERT INTO `class_subjects` (`id`, `class_id`, `subject_id`, `teacher_id`, `created_at`, `deleted_at`, `updated_at`) VALUES
(9, 1, 3, NULL, '2025-12-02 05:15:18', NULL, '2025-12-02 05:15:18'),
(10, 2, 3, NULL, '2025-12-02 05:15:18', NULL, '2025-12-02 05:15:18'),
(11, 3, 3, NULL, '2025-12-02 05:15:18', NULL, '2025-12-02 05:15:18'),
(12, 1, 1, NULL, '2025-12-02 05:15:27', NULL, '2025-12-02 05:15:27'),
(13, 2, 1, NULL, '2025-12-02 05:15:27', NULL, '2025-12-02 05:15:27'),
(14, 3, 1, NULL, '2025-12-02 05:15:27', NULL, '2025-12-02 05:15:27'),
(15, 4, 1, NULL, '2025-12-02 05:15:27', NULL, '2025-12-02 05:15:27'),
(16, 5, 1, NULL, '2025-12-02 05:15:27', NULL, '2025-12-02 05:15:27'),
(17, 1, 2, NULL, '2025-12-02 05:15:36', NULL, '2025-12-02 05:15:36'),
(18, 2, 2, NULL, '2025-12-02 05:15:36', NULL, '2025-12-02 05:15:36'),
(19, 3, 2, NULL, '2025-12-02 05:15:36', NULL, '2025-12-02 05:15:36'),
(20, 4, 2, NULL, '2025-12-02 05:15:36', NULL, '2025-12-02 05:15:36'),
(21, 5, 2, NULL, '2025-12-02 05:15:36', NULL, '2025-12-02 05:15:36');

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `first_term` decimal(10,2) DEFAULT NULL,
  `second_term` decimal(10,2) DEFAULT NULL,
  `third_term` decimal(10,2) DEFAULT NULL,
  `uniform` decimal(10,2) DEFAULT NULL,
  `transport` decimal(10,2) DEFAULT NULL,
  `materials` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `registration` decimal(10,2) DEFAULT NULL,
  `pta` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `class_id`, `first_term`, `second_term`, `third_term`, `uniform`, `transport`, `materials`, `created_at`, `deleted_at`, `updated_at`, `registration`, `pta`) VALUES
(1, 1, '30000.00', '25000.00', '22000.00', '20000.00', '10000.00', '13000.00', '2025-11-29 02:07:29', NULL, '2025-12-01 01:31:40', '12.00', '23.00'),
(2, 2, '30000.00', '25000.00', '22000.00', '20000.00', '121000.00', '13000.00', '2025-11-29 02:07:29', NULL, '2025-12-01 01:31:40', '23.00', '23.00'),
(3, 3, '1230.00', '1230.00', '1230.00', '1000.00', '1212.00', '1212.00', '2025-11-29 02:39:08', NULL, '2025-12-01 01:31:40', '23.00', '23.00'),
(4, 4, '123123.00', '32.00', '31212.00', '3123.00', '1200.00', '123.00', '2025-11-29 17:13:13', NULL, '2025-12-01 01:31:40', '23.00', '423.00'),
(5, 5, '12.00', '12.00', '-112.00', '12.00', '12.00', '12.00', '2025-11-29 17:24:28', NULL, '2025-12-01 01:31:40', '12.00', '12.00'),
(6, 6, '1421.00', '32453.00', '5467.00', '654.00', '3455.00', '56.00', '2025-12-01 01:31:40', NULL, '2025-12-01 01:31:40', '78.00', '45.00');

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
  `gender` enum('male','female') DEFAULT 'male',
  `occupation` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guardians`
--

INSERT INTO `guardians` (`id`, `name`, `email`, `phone`, `address`, `picture_path`, `relationship`, `gender`, `occupation`, `password`, `status`, `reset_token`, `reset_expires`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 'Guardian 1', 'guardian1@email.com', '07012345678', 'Address  Address  Address', NULL, 'father', 'male', 'Occupation', '$2y$10$Jgf5gtWVqYb41E5JC4WmGuj6DaPMtGFoyPXZCFjn88y4P6DGCyYC.', 'active', NULL, NULL, '2025-11-28 04:57:23', NULL, '2025-11-28 04:57:23'),
(2, 'Guardian 2', 'guardian2@email.com', '09087654321', 'Address Address Address', NULL, 'mother', 'female', 'Occupation', '$2y$10$aJkACwfluMuR78VgfcPi5OPDZD394x2gmsBrkSuy1LTflMGdOxizy', 'active', NULL, NULL, '2025-11-28 05:35:54', NULL, '2025-11-28 05:35:54'),
(3, 'Guardian 3', 'guardian3@email.com', '07012345678', 'AddressAddressAddress', NULL, 'father', 'male', 'Occupation', '$2y$10$RviQhzqBNnrXJL08xF0B6.pNWdLBtzjbYsPsBeak4TE8qZmnCKG9C', 'active', NULL, NULL, '2025-11-28 06:12:04', NULL, '2025-11-28 06:12:04');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `category` enum('announcement','event','achievement','update') DEFAULT 'announcement',
  `content` text DEFAULT NULL,
  `picture_path` varchar(255) DEFAULT NULL,
  `publication_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('draft','published') DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `category`, `content`, `picture_path`, `publication_date`, `status`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 'Something', 'announcement', 'somethinfgijqvnodfvnoads  oiuwbvpaev sfdinvoiaen sak  somethinfgijqvnodfvnoads  oiuwbvpaev sfdinvoiaen sak\r\n\r\nsomethinfgijqvnodfvnoads  oiuwbvpaev sfdinvoiaen sak  somethinfgijqvnodfvnoads  oiuwbvpaev sfdinvoiaen sak\r\n\r\nsomethinfgijqvnodfvnoads  oiuwbvpaev sfdinvoiaen sak  somethinfgijqvnodfvnoads  oiuwbvpaev sfdinvoiaen sak\r\n\r\nsomethinfgijqvnodfvnoads  oiuwbvpaev sfdinvoiaen sak  somethinfgijqvnodfvnoads  oiuwbvpaev sfdinvoiaen sak\r\n\r\nsomethinfgijqvnodfvnoads  oiuwbvpaev sfdinvoiaen sak  somethinfgijqvnodfvnoads  oiuwbvpaev sfdinvoiaen sak', NULL, '2025-12-01 01:51:36', 'published', '2025-12-01 01:50:06', '2025-12-01 02:51:36', '2025-12-01 01:51:36');

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
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `student_term_record_id`, `subject_id`, `ca`, `exam`, `grade`, `remark`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 1, 1, '21.00', '30.00', 'C', 'Good', '2025-11-28 06:20:09', NULL, '2025-11-28 06:20:09'),
(2, 3, 1, '30.00', '50.00', 'A', 'Excellent', '2025-11-28 06:20:09', NULL, '2025-11-28 06:20:09'),
(3, 4, 1, '16.00', '50.00', 'B', 'Very Good', '2025-11-28 06:20:09', NULL, '2025-11-28 06:20:09'),
(4, 1, 2, '13.00', '34.00', 'D', 'Pass', '2025-11-28 06:20:40', NULL, '2025-11-28 06:20:40'),
(5, 3, 2, '32.00', '43.00', 'A', 'Excellent', '2025-11-28 06:20:40', NULL, '2025-11-28 06:20:40'),
(6, 4, 2, '35.00', '35.00', 'B', 'Very Good', '2025-11-28 06:20:40', NULL, '2025-11-28 06:20:40'),
(7, 1, 3, '19.00', '60.00', 'A', 'Excellent', '2025-11-28 06:21:20', NULL, '2025-11-28 06:21:20'),
(8, 3, 3, '31.00', '37.00', 'B', 'Very Good', '2025-11-28 06:21:20', NULL, '2025-11-28 06:21:20'),
(9, 4, 3, '32.00', '52.00', 'A', 'Excellent', '2025-11-28 06:21:20', NULL, '2025-11-28 06:21:20'),
(10, 5, 1, '10.00', '32.00', 'D', 'Pass', '2025-11-28 06:31:55', NULL, '2025-11-28 06:31:55'),
(11, 6, 1, '12.00', '23.00', 'F', 'Fail', '2025-11-28 06:31:55', NULL, '2025-11-28 06:31:55'),
(12, 7, 1, '23.00', '23.00', 'D', 'Pass', '2025-11-28 06:31:56', NULL, '2025-11-28 06:31:56'),
(13, 5, 2, '31.00', '12.00', 'D', 'Pass', '2025-11-28 06:33:27', NULL, '2025-11-28 06:33:27'),
(14, 6, 2, '23.00', '53.00', 'A', 'Excellent', '2025-11-28 06:33:27', NULL, '2025-11-28 06:33:27'),
(15, 7, 2, '40.00', '23.00', 'B', 'Very Good', '2025-11-28 06:33:27', NULL, '2025-11-28 06:33:27'),
(16, 5, 3, '12.00', '43.00', 'C', 'Good', '2025-11-28 06:33:40', NULL, '2025-11-28 06:33:40'),
(17, 6, 3, '12.00', '21.00', 'E', 'Fail', '2025-11-28 06:33:40', NULL, '2025-11-28 06:33:40'),
(18, 7, 3, '34.00', '32.00', 'B', 'Very Good', '2025-11-28 06:33:40', NULL, '2025-11-28 06:33:40'),
(19, 8, 1, '21.00', '21.00', 'D', 'Pass', '2025-11-28 06:39:57', NULL, '2025-11-28 06:39:57'),
(20, 9, 1, '23.00', '23.00', 'D', 'Pass', '2025-11-28 06:39:57', NULL, '2025-11-28 06:39:57'),
(21, 10, 1, '22.00', '12.00', 'E', 'Fail', '2025-11-28 06:39:57', NULL, '2025-11-28 06:39:57'),
(22, 8, 2, '12.00', '32.00', 'D', 'Fair', '2025-11-28 06:47:33', NULL, '2025-11-28 06:47:33'),
(23, 9, 2, '23.00', '12.00', 'E', 'Poor', '2025-11-28 06:47:33', NULL, '2025-11-28 06:47:33'),
(24, 10, 2, '12.00', '23.00', 'E', 'Poor', '2025-11-28 06:47:33', NULL, '2025-11-28 06:47:33'),
(25, 8, 3, '21.00', '12.00', 'E', 'Poor', '2025-11-28 06:47:49', NULL, '2025-11-28 06:47:49'),
(26, 9, 3, '32.00', '12.00', 'D', 'Fair', '2025-11-28 06:47:49', NULL, '2025-11-28 06:47:49'),
(27, 10, 3, '32.00', '23.00', 'C', 'Good', '2025-11-28 06:47:49', NULL, '2025-11-28 06:47:49'),
(28, 11, 1, '19.00', '20.00', 'E', 'Poor', '2025-11-28 07:03:39', NULL, '2025-11-28 07:04:41'),
(29, 12, 1, '12.00', '12.00', 'E', 'Poor', '2025-11-28 07:03:39', NULL, '2025-11-28 07:03:39'),
(30, 13, 1, '12.00', '60.00', 'B', 'Very Good', '2025-11-28 07:03:39', NULL, '2025-11-28 10:18:31'),
(40, 11, 2, '21.00', '44.00', 'B', 'Very Good', '2025-12-01 03:57:57', NULL, '2025-12-01 03:57:57'),
(41, 12, 2, '32.00', '23.00', 'C', 'Good', '2025-12-01 03:57:57', NULL, '2025-12-01 03:57:57'),
(42, 13, 2, '23.00', '45.00', 'B', 'Very Good', '2025-12-01 03:57:57', NULL, '2025-12-01 03:57:57'),
(43, 16, 1, '28.00', '35.00', 'B', 'Very Good', '2025-12-02 04:23:09', NULL, '2025-12-02 04:23:09'),
(44, 14, 1, '33.00', '45.00', 'A', 'Excellent', '2025-12-02 04:23:09', NULL, '2025-12-02 04:23:09'),
(45, 15, 1, '32.00', '43.00', 'A', 'Excellent', '2025-12-02 04:23:09', NULL, '2025-12-02 04:23:09'),
(46, 16, 2, '12.00', '32.00', 'D', 'Fair', '2025-12-02 04:23:38', NULL, '2025-12-02 04:23:38'),
(47, 14, 2, '23.00', '34.00', 'C', 'Good', '2025-12-02 04:23:38', NULL, '2025-12-02 04:23:38'),
(48, 15, 2, '33.00', '43.00', 'A', 'Excellent', '2025-12-02 04:23:38', NULL, '2025-12-02 04:23:38'),
(49, 16, 3, '33.00', '43.00', 'A', 'Excellent', '2025-12-02 04:24:01', NULL, '2025-12-02 04:24:01'),
(50, 14, 3, '31.00', '35.00', 'B', 'Very Good', '2025-12-02 04:24:01', NULL, '2025-12-02 04:24:01'),
(51, 15, 3, '20.00', '44.00', 'B', 'Very Good', '2025-12-02 04:24:01', NULL, '2025-12-02 04:24:01'),
(52, 17, 1, '21.00', '24.00', 'D', 'Fair', '2025-12-02 04:24:38', NULL, '2025-12-02 04:24:38'),
(53, 18, 1, '31.00', '43.00', 'B', 'Very Good', '2025-12-02 04:24:38', NULL, '2025-12-02 04:24:38'),
(54, 19, 1, '23.00', '43.00', 'B', 'Very Good', '2025-12-02 04:24:38', NULL, '2025-12-02 04:24:38'),
(55, 17, 2, '12.00', '44.00', 'C', 'Good', '2025-12-02 04:25:08', NULL, '2025-12-02 04:25:08'),
(56, 18, 2, '32.00', '35.00', 'B', 'Very Good', '2025-12-02 04:25:08', NULL, '2025-12-02 04:25:08'),
(57, 19, 2, '31.00', '35.00', 'B', 'Very Good', '2025-12-02 04:25:08', NULL, '2025-12-02 04:25:08'),
(58, 17, 3, '21.00', '23.00', 'D', 'Fair', '2025-12-02 04:25:58', NULL, '2025-12-02 04:25:58'),
(59, 18, 3, '33.00', '23.00', 'C', 'Good', '2025-12-02 04:25:58', NULL, '2025-12-02 04:25:58'),
(60, 19, 3, '22.00', '22.00', 'D', 'Fair', '2025-12-02 04:25:58', NULL, '2025-12-02 04:25:58'),
(61, 25, 1, '23.00', '31.00', 'C', 'Good', '2025-12-02 04:39:58', NULL, '2025-12-02 04:39:58'),
(62, 23, 1, '33.00', '30.00', 'B', 'Very Good', '2025-12-02 04:39:58', NULL, '2025-12-02 04:39:58'),
(63, 24, 1, '19.00', '50.00', 'B', 'Very Good', '2025-12-02 04:39:58', NULL, '2025-12-02 04:39:58'),
(64, 25, 2, '23.00', '43.00', 'B', 'Very Good', '2025-12-02 04:40:16', NULL, '2025-12-02 04:40:16'),
(65, 23, 2, '35.00', '23.00', 'C', 'Good', '2025-12-02 04:40:16', NULL, '2025-12-02 04:40:16'),
(66, 24, 2, '33.00', '44.00', 'A', 'Excellent', '2025-12-02 04:40:16', NULL, '2025-12-02 04:40:16'),
(67, 25, 3, '19.00', '39.00', 'C', 'Good', '2025-12-02 04:40:40', NULL, '2025-12-02 04:40:40'),
(68, 23, 3, '34.00', '44.00', 'A', 'Excellent', '2025-12-02 04:40:40', NULL, '2025-12-02 04:40:40'),
(69, 24, 3, '40.00', '23.00', 'B', 'Very Good', '2025-12-02 04:40:40', NULL, '2025-12-02 04:40:40'),
(70, 26, 1, '19.00', '25.00', 'D', 'Fair', '2025-12-02 04:41:04', NULL, '2025-12-02 04:41:04'),
(71, 27, 1, '23.00', '43.00', 'B', 'Very Good', '2025-12-02 04:41:04', NULL, '2025-12-02 04:41:04'),
(72, 28, 1, '11.00', '31.00', 'D', 'Fair', '2025-12-02 04:41:04', NULL, '2025-12-02 04:41:04'),
(73, 26, 2, '33.00', '44.00', 'A', 'Excellent', '2025-12-02 04:41:24', NULL, '2025-12-02 04:41:24'),
(74, 27, 2, '25.00', '34.00', 'C', 'Good', '2025-12-02 04:41:24', NULL, '2025-12-02 04:41:24'),
(75, 28, 2, '34.00', '31.00', 'B', 'Very Good', '2025-12-02 04:41:24', NULL, '2025-12-02 04:41:24'),
(82, 26, 3, '40.00', '33.00', 'B', 'Very Good', '2025-12-02 04:42:28', NULL, '2025-12-02 04:42:28'),
(83, 27, 3, '35.00', '43.00', 'A', 'Excellent', '2025-12-02 04:42:28', NULL, '2025-12-02 04:42:28'),
(84, 28, 3, '31.00', '56.00', 'A', 'Excellent', '2025-12-02 04:42:28', NULL, '2025-12-02 04:42:28'),
(85, 20, 1, '23.00', '21.00', 'D', 'Fair', '2025-12-02 04:43:24', NULL, '2025-12-02 04:43:24'),
(86, 21, 1, '23.00', '23.00', 'D', 'Fair', '2025-12-02 04:43:24', NULL, '2025-12-02 04:43:24'),
(87, 22, 1, '34.00', '11.00', 'D', 'Fair', '2025-12-02 04:43:24', NULL, '2025-12-02 04:43:24'),
(88, 20, 2, '21.00', '23.00', 'D', 'Fair', '2025-12-02 04:43:46', NULL, '2025-12-02 04:43:46'),
(89, 21, 2, '34.00', '45.00', 'A', 'Excellent', '2025-12-02 04:43:46', NULL, '2025-12-02 04:43:46'),
(90, 22, 2, '12.00', '33.00', 'D', 'Fair', '2025-12-02 04:43:46', NULL, '2025-12-02 04:43:46'),
(91, 20, 3, '34.00', '55.00', 'A', 'Excellent', '2025-12-02 04:44:25', NULL, '2025-12-02 04:44:25'),
(92, 21, 3, '23.00', '43.00', 'B', 'Very Good', '2025-12-02 04:44:25', NULL, '2025-12-02 04:44:25'),
(93, 22, 3, '40.00', '11.00', 'C', 'Good', '2025-12-02 04:44:25', NULL, '2025-12-02 04:44:25'),
(94, 34, 1, '30.00', '40.00', 'B', 'Very Good', '2025-12-02 04:48:02', NULL, '2025-12-02 04:48:02'),
(95, 32, 1, '33.00', '38.00', 'B', 'Very Good', '2025-12-02 04:48:02', NULL, '2025-12-02 04:48:02'),
(96, 33, 1, '31.00', '56.00', 'A', 'Excellent', '2025-12-02 04:48:02', NULL, '2025-12-02 04:48:02'),
(97, 34, 2, '34.00', '43.00', 'A', 'Excellent', '2025-12-02 04:48:29', NULL, '2025-12-02 04:48:29'),
(98, 32, 2, '37.00', '40.00', 'A', 'Excellent', '2025-12-02 04:48:29', NULL, '2025-12-02 04:48:29'),
(99, 33, 2, '40.00', '39.00', 'A', 'Excellent', '2025-12-02 04:48:29', NULL, '2025-12-02 04:48:29'),
(100, 34, 3, '23.00', '55.00', 'A', 'Excellent', '2025-12-02 04:49:10', NULL, '2025-12-02 04:49:10'),
(101, 32, 3, '23.00', '50.00', 'B', 'Very Good', '2025-12-02 04:49:10', NULL, '2025-12-02 04:49:10'),
(102, 33, 3, '40.00', '45.00', 'A', 'Excellent', '2025-12-02 04:49:10', NULL, '2025-12-02 04:49:10'),
(103, 35, 1, '23.00', '44.00', 'B', 'Very Good', '2025-12-02 04:49:44', NULL, '2025-12-02 04:49:44'),
(104, 36, 1, '12.00', '44.00', 'C', 'Good', '2025-12-02 04:49:44', NULL, '2025-12-02 04:49:44'),
(105, 37, 1, '29.00', '38.00', 'B', 'Very Good', '2025-12-02 04:49:44', NULL, '2025-12-02 04:49:44'),
(106, 35, 2, '23.00', '33.00', 'C', 'Good', '2025-12-02 04:50:25', NULL, '2025-12-02 04:50:25'),
(107, 36, 2, '31.00', '34.00', 'B', 'Very Good', '2025-12-02 04:50:25', NULL, '2025-12-02 04:50:25'),
(108, 37, 2, '34.00', '44.00', 'A', 'Excellent', '2025-12-02 04:50:25', NULL, '2025-12-02 04:50:25'),
(109, 35, 3, '23.00', '43.00', 'B', 'Very Good', '2025-12-02 04:51:56', NULL, '2025-12-02 04:51:56'),
(110, 36, 3, '14.00', '43.00', 'C', 'Good', '2025-12-02 04:51:56', NULL, '2025-12-02 04:51:56'),
(111, 37, 3, '22.00', '43.00', 'B', 'Very Good', '2025-12-02 04:51:56', NULL, '2025-12-02 04:51:56'),
(112, 29, 2, '32.00', '44.00', 'A', 'Excellent', '2025-12-02 04:58:07', NULL, '2025-12-02 04:58:07'),
(113, 30, 2, '40.00', '22.00', 'B', 'Very Good', '2025-12-02 04:58:07', NULL, '2025-12-02 04:58:07'),
(114, 31, 2, '32.00', '43.00', 'A', 'Excellent', '2025-12-02 04:58:07', NULL, '2025-12-02 04:58:07'),
(115, 29, 1, '12.00', '33.00', 'D', 'Fair', '2025-12-02 05:13:08', NULL, '2025-12-02 05:13:08'),
(116, 30, 1, '4.00', '56.00', 'B', 'Very Good', '2025-12-02 05:13:08', NULL, '2025-12-02 05:13:08'),
(117, 31, 1, '16.00', '51.00', 'B', 'Very Good', '2025-12-02 05:13:08', NULL, '2025-12-02 05:13:08'),
(118, 29, 3, '34.00', '56.00', 'A', 'Excellent', '2025-12-02 05:13:43', NULL, '2025-12-02 05:13:43'),
(119, 30, 3, '23.00', '44.00', 'B', 'Very Good', '2025-12-02 05:13:43', NULL, '2025-12-02 05:13:43'),
(120, 31, 3, '29.00', '49.00', 'A', 'Excellent', '2025-12-02 05:13:43', NULL, '2025-12-02 05:13:43'),
(124, 43, 1, '33.00', '22.00', 'C', 'Good', '2025-12-02 05:31:18', NULL, '2025-12-02 05:31:18'),
(125, 41, 1, '23.00', '43.00', 'B', 'Very Good', '2025-12-02 05:31:18', NULL, '2025-12-02 05:31:18'),
(126, 42, 1, '34.00', '34.00', 'B', 'Very Good', '2025-12-02 05:31:18', NULL, '2025-12-02 05:31:18'),
(127, 43, 2, '19.00', '44.00', 'B', 'Very Good', '2025-12-02 05:31:46', NULL, '2025-12-02 05:31:46'),
(128, 41, 2, '34.00', '48.00', 'A', 'Excellent', '2025-12-02 05:31:46', NULL, '2025-12-02 05:31:46'),
(129, 42, 2, '22.00', '55.00', 'A', 'Excellent', '2025-12-02 05:31:46', NULL, '2025-12-02 05:31:46'),
(130, 43, 3, '14.00', '54.00', 'B', 'Very Good', '2025-12-02 05:32:13', NULL, '2025-12-02 05:32:13'),
(131, 41, 3, '29.00', '55.00', 'A', 'Excellent', '2025-12-02 05:32:13', NULL, '2025-12-02 05:32:13'),
(132, 42, 3, '40.00', '17.00', 'C', 'Good', '2025-12-02 05:32:13', NULL, '2025-12-02 05:32:13'),
(136, 44, 1, '22.00', '55.00', 'A', 'Excellent', '2025-12-02 05:52:22', NULL, '2025-12-02 05:52:22'),
(137, 45, 1, '17.00', '55.00', 'B', 'Very Good', '2025-12-02 05:52:22', NULL, '2025-12-02 05:52:22'),
(138, 46, 1, '32.00', '44.00', 'A', 'Excellent', '2025-12-02 05:52:22', NULL, '2025-12-02 05:52:22'),
(139, 44, 3, '12.00', '23.00', 'E', 'Poor', '2025-12-02 05:52:55', NULL, '2025-12-02 05:52:55'),
(140, 45, 3, '40.00', '43.00', 'A', 'Excellent', '2025-12-02 05:52:55', NULL, '2025-12-02 05:52:55'),
(141, 46, 3, '34.00', '34.00', 'B', 'Very Good', '2025-12-02 05:52:55', NULL, '2025-12-02 05:52:55'),
(142, 44, 2, '33.00', '44.00', 'A', 'Excellent', '2025-12-02 05:53:24', NULL, '2025-12-02 05:53:24'),
(143, 45, 2, '23.00', '43.00', 'B', 'Very Good', '2025-12-02 05:53:24', NULL, '2025-12-02 05:53:24'),
(144, 46, 2, '23.00', '56.00', 'A', 'Excellent', '2025-12-02 05:53:24', NULL, '2025-12-02 05:53:24'),
(145, 38, 1, '32.00', '44.00', 'A', 'Excellent', '2025-12-02 05:55:33', NULL, '2025-12-02 05:55:33'),
(146, 39, 1, '23.00', '23.00', 'D', 'Fair', '2025-12-02 05:55:33', NULL, '2025-12-02 05:55:33'),
(147, 40, 1, '40.00', '42.00', 'A', 'Excellent', '2025-12-02 05:55:33', NULL, '2025-12-02 05:55:33'),
(148, 38, 2, '34.00', '34.00', 'B', 'Very Good', '2025-12-02 05:56:00', NULL, '2025-12-02 05:56:00'),
(149, 39, 2, '34.00', '55.00', 'A', 'Excellent', '2025-12-02 05:56:00', NULL, '2025-12-02 05:56:00'),
(150, 40, 2, '28.00', '44.00', 'B', 'Very Good', '2025-12-02 05:56:00', NULL, '2025-12-02 05:56:00'),
(151, 38, 3, '23.00', '55.00', 'A', 'Excellent', '2025-12-02 05:56:32', NULL, '2025-12-02 05:56:32'),
(152, 39, 3, '23.00', '23.00', 'D', 'Fair', '2025-12-02 05:56:32', NULL, '2025-12-02 05:56:32'),
(153, 40, 3, '22.00', '56.00', 'A', 'Excellent', '2025-12-02 05:56:32', NULL, '2025-12-02 05:56:32'),
(157, 52, 1, '33.00', '60.00', 'A', 'Excellent', '2025-12-02 06:00:33', NULL, '2025-12-02 06:00:33'),
(158, 50, 1, '18.00', '56.00', 'B', 'Very Good', '2025-12-02 06:00:33', NULL, '2025-12-02 06:00:33'),
(159, 51, 1, '40.00', '33.00', 'B', 'Very Good', '2025-12-02 06:00:33', NULL, '2025-12-02 06:00:33'),
(160, 52, 2, '34.00', '55.00', 'A', 'Excellent', '2025-12-02 06:01:00', NULL, '2025-12-02 06:01:00'),
(161, 50, 2, '25.00', '14.00', 'E', 'Poor', '2025-12-02 06:01:00', NULL, '2025-12-02 06:01:00'),
(162, 51, 2, '18.00', '38.00', 'C', 'Good', '2025-12-02 06:01:00', NULL, '2025-12-02 06:01:00'),
(163, 52, 3, '19.00', '45.00', 'B', 'Very Good', '2025-12-02 06:01:34', NULL, '2025-12-02 06:01:34'),
(164, 50, 3, '25.00', '16.00', 'D', 'Fair', '2025-12-02 06:01:34', NULL, '2025-12-02 06:01:34'),
(165, 51, 3, '33.00', '57.00', 'A', 'Excellent', '2025-12-02 06:01:34', NULL, '2025-12-02 06:01:34'),
(166, 53, 1, '12.00', '44.00', 'C', 'Good', '2025-12-02 06:01:55', NULL, '2025-12-02 06:01:55'),
(167, 54, 1, '34.00', '53.00', 'A', 'Excellent', '2025-12-02 06:01:55', NULL, '2025-12-02 06:01:55'),
(168, 55, 1, '33.00', '56.00', 'A', 'Excellent', '2025-12-02 06:01:55', NULL, '2025-12-02 06:01:55'),
(169, 53, 2, '22.00', '56.00', 'A', 'Excellent', '2025-12-02 06:02:25', NULL, '2025-12-02 06:02:25'),
(170, 54, 2, '28.00', '33.00', 'B', 'Very Good', '2025-12-02 06:02:25', NULL, '2025-12-02 06:02:25'),
(171, 55, 2, '23.00', '40.00', 'B', 'Very Good', '2025-12-02 06:02:25', NULL, '2025-12-02 06:02:25'),
(172, 53, 3, '33.00', '55.00', 'A', 'Excellent', '2025-12-02 06:02:54', NULL, '2025-12-02 06:02:54'),
(173, 54, 3, '23.00', '45.00', 'B', 'Very Good', '2025-12-02 06:02:54', NULL, '2025-12-02 06:02:54'),
(174, 55, 3, '40.00', '35.00', 'A', 'Excellent', '2025-12-02 06:02:54', NULL, '2025-12-02 06:02:54'),
(175, 47, 1, '19.00', '44.00', 'B', 'Very Good', '2025-12-02 06:08:01', NULL, '2025-12-02 06:08:01'),
(176, 48, 1, '31.00', '31.00', 'B', 'Very Good', '2025-12-02 06:08:01', NULL, '2025-12-02 06:08:01'),
(177, 49, 1, '16.00', '33.00', 'D', 'Fair', '2025-12-02 06:08:01', NULL, '2025-12-02 06:08:01'),
(178, 47, 3, '33.00', '41.00', 'B', 'Very Good', '2025-12-02 06:09:47', NULL, '2025-12-02 06:09:47'),
(179, 48, 3, '32.00', '33.00', 'B', 'Very Good', '2025-12-02 06:09:47', NULL, '2025-12-02 06:09:47'),
(180, 49, 3, '40.00', '35.00', 'A', 'Excellent', '2025-12-02 06:09:47', NULL, '2025-12-02 06:09:47'),
(181, 47, 2, '32.00', '32.00', 'B', 'Very Good', '2025-12-02 06:10:19', NULL, '2025-12-02 06:10:19'),
(182, 48, 2, '22.00', '50.00', 'B', 'Very Good', '2025-12-02 06:10:19', NULL, '2025-12-02 06:10:19'),
(183, 49, 2, '39.00', '34.00', 'B', 'Very Good', '2025-12-02 06:10:19', NULL, '2025-12-02 06:10:19');

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
  `about_message` text DEFAULT NULL,
  `welcome_message` text DEFAULT NULL,
  `whatsapp_number` varchar(20) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `admission_number_format` varchar(255) DEFAULT NULL,
  `admission_number_format_description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`, `motto`, `address`, `phone`, `email`, `about_message`, `welcome_message`, `whatsapp_number`, `facebook`, `twitter`, `instagram`, `admission_number_format`, `admission_number_format_description`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 'Tauheed Academy', '', 'No 1. Tsafe Road, Gidan Madawaki Isah\r\nOpp. Stultan Abubakar III Jumu\'at Mosque, sokoto', '07012345678', 'tauheedacademy2015@gmail.com', '     Tauheed Academy is an Islamic-based educational institution dedicated to providing high-quality learning that balances both worldly knowledge and religious values. We believe that education should empower the mind while refining the character, and that a strong foundation in both academics and Islam produces confident, disciplined, and responsible individuals. Our school combines modern teaching methods with a nurturing atmosphere built on respect, sincerity, and the fear of Allah.\r\n\r\nOur Academic Programme\r\n\r\n     The academic section of Tauheed Academy offers a comprehensive curriculum that meets national educational standards while integrating Islamic ethics and values. Our teachers are trained, passionate, and committed to bringing out the best in every child. With a focus on critical thinking, literacy, numeracy, and personal development, we prepare students for success in further studies and future careers. Every classroom is designed to motivate learning, creativity, and excellence.\r\n\r\n     Our Tahfeez Section\r\n\r\nTauheed Academy is proud to operate a dedicated Tahfeez programme for students who wish to memorize the Qur’an. Our qualified Qur’an instructors use a structured and student-friendly approach that makes memorization easier, consistent, and spiritually rewarding. The Tahfeez section emphasizes proper tajweed, daily revision, discipline, and character building. We aim not only to help students complete memorization of the Qur’an, but also to embody its teachings in their daily lives.\r\n\r\nOur Commitment\r\n\r\n     At Tauheed Academy, we see education as a trust. Our goal is to guide every child to become a shining example in society — strong in knowledge, steadfast in faith, and grounded in good manners. With a peaceful learning environment, caring teachers, and a rich blend of academic and Islamic studies, we remain dedicated to producing well-rounded students who excel both in this world and in the next.', 'Assalamu Alaikum wa Rahmatullahi wa Barakatuhu,\r\n\r\n     It is my joy and privilege to welcome you to Tauheed Academy. At our institution, we strive to provide an environment where knowledge, discipline, and Islamic values come together to shape the leaders of tomorrow. Our mission is to nurture students academically while guiding them to develop strong character and a deep connection to their faith.\r\n\r\n     Thank you for choosing Tauheed Academy and trusting us with the education of your child. Together, we pray that Allah grants them success in both this world and the Hereafter.', '07012345678', 'https://facebook.com/tauheedacademy', 'https://x.com/tauheedacademy', 'https://instagram.com/tauheedacademy', 'ADM/2025/001', 'ADMISSION/YEAR?SERIAL NUMBER', '2025-11-28 03:55:32', NULL, '2025-12-01 01:19:33');

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
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `description`, `head_teacher_id`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 'Nursery', 'Pre Primary Education', 1, '2025-11-28 04:45:38', NULL, '2025-11-28 04:45:38'),
(2, 'Primary', 'Basic Western Education', 1, '2025-11-29 17:09:39', NULL, '2025-11-29 17:09:39'),
(3, 'Junoir Secondary', 'Section, for middles schloo educatiuonfwce', 1, '2025-12-01 01:22:06', '2025-12-01 02:22:18', '2025-12-01 01:22:18');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `name`, `start_date`, `end_date`, `status`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, '2020/2021', '2020-01-01', '2020-12-31', 'pending', '2025-11-28 04:53:08', NULL, '2025-11-28 04:53:08'),
(2, '2021/2022', '2021-01-01', '2021-12-31', 'pending', '2025-11-28 06:37:14', NULL, '2025-11-28 06:37:14'),
(3, '2022/2023', '2022-01-01', '2022-12-31', 'pending', '2025-12-02 04:45:43', NULL, '2025-12-02 04:45:43');

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
  `reset_expires` datetime DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `gender` enum('male','female') DEFAULT 'male',
  `class_id` int(11) DEFAULT NULL,
  `arm_id` int(11) DEFAULT NULL,
  `term_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `admission_number`, `email`, `phone`, `guardian_id`, `dob`, `picture`, `password`, `reset_token`, `reset_expires`, `status`, `gender`, `class_id`, `arm_id`, `term_id`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 'Sudent 1', 'ADM/2025/001', '', '', 1, '2010-01-01', NULL, '$2y$10$I0827bvuAUzAiVVsNEu79.MOsxJJzTMrK1Q.4PFN2ihcoqoXIxPaa', NULL, NULL, 'active', 'male', 3, 1, 7, '2025-11-28 04:58:20', NULL, '2025-12-02 05:14:41'),
(2, 'Student 2', 'ADM/2025/002', '', '', 2, '2010-12-12', NULL, '$2y$10$Ua3z/RF42cFJnVVMMDnEA.525aV1WPGOAZh5oIOZSFxyeMO9AALQS', NULL, NULL, 'active', 'female', 3, 1, 7, '2025-11-28 06:00:51', NULL, '2025-12-02 05:14:41'),
(3, 'Student 3', 'ADM/2025/003', '', '', 3, '2011-01-12', NULL, '$2y$10$iLBMhJRjRIHU24WYIZte2Oih1Na5emBd/swu6iQaUbXa1MTmb8I2G', NULL, NULL, 'active', 'male', 3, 1, 7, '2025-11-28 06:13:03', NULL, '2025-12-02 05:14:41'),
(4, 'student 4', 'ADM/2025/004', '', '', 3, '2011-12-21', NULL, '$2y$10$Wpz3CMkKn6imHNRDda3pCO.lRxzV0gGbW1FENhVz0fudU0UvB2TRS', NULL, NULL, 'active', 'female', 2, 1, 7, '2025-12-01 11:25:58', NULL, '2025-12-02 05:14:41'),
(5, 'student 5', 'ADM/2025/005', '', '', 1, '2011-12-23', NULL, '$2y$10$xujXEVHiVdBPF73snPL5z.RXNGg3QGkMeDZRzEnu2uCwVNzrn8Mc6', NULL, NULL, 'active', 'male', 2, 1, 7, '2025-12-01 11:26:43', NULL, '2025-12-02 05:14:41'),
(6, 'Student 6', 'ADM/2025//006', '', '', 2, '2012-01-02', NULL, '$2y$10$YvvD8gmgOLe50zRfkdA4c.JQteJifBFYhsaWY8SxDmtQLJ2dw113u', NULL, NULL, 'active', 'male', 2, 1, 7, '2025-12-01 11:27:55', NULL, '2025-12-02 05:14:41'),
(7, 'student 7', 'ADM/2025/007', '', '', 1, '2011-01-01', NULL, '$2y$10$RN.08kU3QmyGfe/ktOEFX.I2zdAGpqTq2rfRzZ4zD39TfWsQKYfS2', NULL, NULL, 'active', 'male', 2, 2, 7, '2025-12-01 12:24:49', NULL, '2025-12-02 05:14:41'),
(8, 'student 8', 'ADM/2025/008', '', '', 1, '2010-01-31', NULL, '$2y$10$BhVZaUhv7eveETTR3SUmd.el/dzIwW.i9Zb/543IWXGjINhJhoXpa', NULL, NULL, 'active', 'female', 2, 2, 7, '2025-12-01 12:25:34', NULL, '2025-12-02 05:14:41'),
(9, 'Student 9', 'ADM/2025/009', '', '', 3, '2010-12-31', NULL, '$2y$10$F8THskZebiBxT5AtdslSpuSXlJc8l.eI/sTnfnPGzHMpSQ1MojTrK', NULL, NULL, 'active', 'female', 2, 2, 7, '2025-12-01 12:28:40', NULL, '2025-12-02 05:14:41');

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
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_class_records`
--

INSERT INTO `student_class_records` (`id`, `student_id`, `session_id`, `class_id`, `arm_id`, `overall_total`, `overall_average`, `overall_position`, `promotion_status`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '436.00', '48.45', 3, 'pending', '2025-11-28 04:58:20', NULL, '2025-12-02 15:08:50'),
(2, 2, 1, 1, 1, '492.00', '54.67', 2, 'pending', '2025-11-28 06:00:51', NULL, '2025-12-02 15:08:50'),
(3, 3, 1, 1, 1, '519.00', '57.66', 1, 'pending', '2025-11-28 06:13:03', NULL, '2025-12-02 15:08:50'),
(4, 1, 2, 2, 1, '492.00', '60.44', 2, 'promoted', '2025-11-28 06:49:55', NULL, '2025-12-02 05:13:43'),
(5, 2, 2, 2, 1, '459.00', '55.39', 3, 'promoted', '2025-11-28 06:49:55', NULL, '2025-12-02 05:13:43'),
(6, 3, 2, 2, 1, '501.00', '63.44', 1, 'promoted', '2025-11-28 06:49:55', NULL, '2025-12-02 05:13:43'),
(7, 4, 2, 1, 1, '621.00', '69.00', 2, 'promoted', '2025-12-01 11:25:58', NULL, '2025-12-02 04:49:10'),
(8, 5, 2, 1, 1, '675.00', '75.00', 1, 'promoted', '2025-12-01 11:26:43', NULL, '2025-12-02 04:49:10'),
(9, 6, 2, 1, 1, '586.00', '65.11', 3, 'promoted', '2025-12-01 11:27:55', NULL, '2025-12-02 04:49:10'),
(10, 7, 2, 1, 2, '528.00', '58.67', 3, 'promoted', '2025-12-01 12:24:49', NULL, '2025-12-02 04:51:56'),
(11, 8, 2, 1, 2, '578.00', '64.22', 2, 'promoted', '2025-12-01 12:25:34', NULL, '2025-12-02 04:51:56'),
(12, 9, 2, 1, 2, '580.00', '64.45', 1, 'promoted', '2025-12-01 12:28:40', NULL, '2025-12-02 04:51:56'),
(13, 1, 3, 3, 1, '423.00', '70.50', 2, 'promoted', '2025-12-02 05:14:41', NULL, '2025-12-02 06:10:19'),
(14, 2, 3, 3, 1, '380.00', '63.33', 3, 'promoted', '2025-12-02 05:14:41', NULL, '2025-12-02 06:10:19'),
(15, 3, 3, 3, 1, '429.00', '71.50', 1, 'promoted', '2025-12-02 05:14:41', NULL, '2025-12-02 06:10:19'),
(16, 4, 3, 2, 1, '386.00', '64.33', 3, 'pending', '2025-12-02 05:14:41', NULL, '2025-12-02 06:12:16'),
(17, 5, 3, 2, 1, '421.00', '70.17', 2, 'pending', '2025-12-02 05:14:41', NULL, '2025-12-02 06:12:16'),
(18, 6, 3, 2, 1, '432.00', '72.00', 1, 'pending', '2025-12-02 05:14:41', NULL, '2025-12-02 06:12:16'),
(19, 7, 3, 2, 2, '411.00', '68.50', 3, 'promoted', '2025-12-02 05:14:41', NULL, '2025-12-02 06:02:54'),
(20, 8, 3, 2, 2, '437.00', '72.84', 2, 'promoted', '2025-12-02 05:14:41', NULL, '2025-12-02 06:02:54'),
(21, 9, 3, 2, 2, '450.00', '75.00', 1, 'promoted', '2025-12-02 05:14:41', NULL, '2025-12-02 06:02:54');

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
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_term_records`
--

INSERT INTO `student_term_records` (`id`, `student_class_record_id`, `term_id`, `total_marks`, `average_marks`, `position_in_class`, `class_size`, `overall_grade`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 1, 1, '177.00', '59.00', 3, 3, 'C', '2025-11-28 05:34:07', NULL, '2025-12-02 15:27:57'),
(3, 2, 1, '223.00', '74.33', 1, 3, 'B', '2025-11-28 06:00:51', NULL, '2025-12-02 15:27:57'),
(4, 3, 1, '220.00', '73.33', 2, 3, 'B', '2025-11-28 06:13:03', NULL, '2025-12-02 15:27:57'),
(5, 1, 2, '140.00', '46.67', 3, 3, NULL, '2025-11-28 06:26:47', NULL, '2025-11-28 06:33:40'),
(6, 2, 2, '144.00', '48.00', 2, 3, NULL, '2025-11-28 06:26:47', NULL, '2025-11-28 06:33:40'),
(7, 3, 2, '175.00', '58.33', 1, 3, NULL, '2025-11-28 06:26:47', NULL, '2025-11-28 06:33:40'),
(8, 1, 3, '119.00', '39.67', 3, 3, NULL, '2025-11-28 06:34:57', NULL, '2025-11-28 06:47:49'),
(9, 2, 3, '125.00', '41.67', 1, 3, NULL, '2025-11-28 06:34:57', NULL, '2025-11-28 06:47:49'),
(10, 3, 3, '124.00', '41.33', 2, 3, NULL, '2025-11-28 06:34:57', NULL, '2025-11-28 06:47:49'),
(11, 4, 4, '104.00', '52.00', 2, 3, NULL, '2025-11-28 06:49:55', NULL, '2025-12-01 03:57:57'),
(12, 5, 4, '79.00', '39.50', 3, 3, NULL, '2025-11-28 06:49:55', NULL, '2025-12-01 03:57:57'),
(13, 6, 4, '140.00', '70.00', 1, 3, NULL, '2025-11-28 06:49:55', NULL, '2025-12-01 03:57:57'),
(14, 7, 4, '201.00', '67.00', 2, 3, 'B', '2025-12-01 11:25:58', NULL, '2025-12-02 04:24:01'),
(15, 8, 4, '215.00', '71.67', 1, 3, 'B', '2025-12-01 11:26:43', NULL, '2025-12-02 04:24:01'),
(16, 9, 4, '183.00', '61.00', 3, 3, 'B', '2025-12-01 11:27:55', NULL, '2025-12-02 04:24:01'),
(17, 10, 4, '145.00', '48.33', 3, 3, 'D', '2025-12-01 12:24:49', NULL, '2025-12-02 04:25:58'),
(18, 11, 4, '197.00', '65.67', 1, 3, 'B', '2025-12-01 12:25:34', NULL, '2025-12-02 04:25:58'),
(19, 12, 4, '176.00', '58.67', 2, 3, 'C', '2025-12-01 12:28:40', NULL, '2025-12-02 04:25:58'),
(20, 4, 5, '177.00', '59.00', 2, 3, 'C', '2025-12-02 04:38:27', NULL, '2025-12-02 04:44:25'),
(21, 5, 5, '191.00', '63.67', 1, 3, 'B', '2025-12-02 04:38:27', NULL, '2025-12-02 04:44:25'),
(22, 6, 5, '141.00', '47.00', 3, 3, 'D', '2025-12-02 04:38:27', NULL, '2025-12-02 04:44:25'),
(23, 7, 5, '199.00', '66.33', 2, 3, 'B', '2025-12-02 04:38:27', NULL, '2025-12-02 04:40:40'),
(24, 8, 5, '209.00', '69.67', 1, 3, 'B', '2025-12-02 04:38:27', NULL, '2025-12-02 04:40:40'),
(25, 9, 5, '178.00', '59.33', 3, 3, 'C', '2025-12-02 04:38:27', NULL, '2025-12-02 04:40:40'),
(26, 10, 5, '194.00', '64.67', 2, 3, 'B', '2025-12-02 04:38:27', NULL, '2025-12-02 04:42:28'),
(27, 11, 5, '203.00', '67.67', 1, 3, 'B', '2025-12-02 04:38:27', NULL, '2025-12-02 04:42:28'),
(28, 12, 5, '194.00', '64.67', 2, 3, 'B', '2025-12-02 04:38:27', NULL, '2025-12-02 04:42:28'),
(29, 4, 6, '211.00', '70.33', 2, 3, 'B', '2025-12-02 04:44:51', NULL, '2025-12-02 05:13:43'),
(30, 5, 6, '189.00', '63.00', 3, 3, 'B', '2025-12-02 04:44:51', NULL, '2025-12-02 05:13:43'),
(31, 6, 6, '220.00', '73.33', 1, 3, 'B', '2025-12-02 04:44:51', NULL, '2025-12-02 05:13:43'),
(32, 7, 6, '221.00', '73.67', 3, 3, 'B', '2025-12-02 04:44:51', NULL, '2025-12-02 04:49:10'),
(33, 8, 6, '251.00', '83.67', 1, 3, 'A', '2025-12-02 04:44:51', NULL, '2025-12-02 04:49:10'),
(34, 9, 6, '225.00', '75.00', 2, 3, 'A', '2025-12-02 04:44:51', NULL, '2025-12-02 04:49:10'),
(35, 10, 6, '189.00', '63.00', 2, 3, 'B', '2025-12-02 04:44:51', NULL, '2025-12-02 04:51:56'),
(36, 11, 6, '178.00', '59.33', 3, 3, 'C', '2025-12-02 04:44:51', NULL, '2025-12-02 04:51:56'),
(37, 12, 6, '210.00', '70.00', 1, 3, 'B', '2025-12-02 04:44:51', NULL, '2025-12-02 04:51:56'),
(38, 13, 7, '222.00', '74.00', 2, 3, 'B', '2025-12-02 05:14:41', NULL, '2025-12-02 05:56:32'),
(39, 14, 7, '181.00', '60.33', 3, 3, 'B', '2025-12-02 05:14:41', NULL, '2025-12-02 05:56:32'),
(40, 15, 7, '232.00', '77.33', 1, 3, 'A', '2025-12-02 05:14:41', NULL, '2025-12-02 05:56:32'),
(41, 16, 7, '232.00', '77.33', 1, 3, 'A', '2025-12-02 05:14:41', NULL, '2025-12-02 05:32:13'),
(42, 17, 7, '202.00', '67.33', 2, 3, 'B', '2025-12-02 05:14:41', NULL, '2025-12-02 05:32:13'),
(43, 18, 7, '186.00', '62.00', 3, 3, 'B', '2025-12-02 05:14:41', NULL, '2025-12-02 05:32:13'),
(44, 19, 7, '189.00', '63.00', 3, 3, 'B', '2025-12-02 05:14:41', NULL, '2025-12-02 05:53:24'),
(45, 20, 7, '221.00', '73.67', 2, 3, 'B', '2025-12-02 05:14:41', NULL, '2025-12-02 05:53:24'),
(46, 21, 7, '223.00', '74.33', 1, 3, 'B', '2025-12-02 05:14:41', NULL, '2025-12-02 05:53:24'),
(47, 13, 8, '201.00', '67.00', 1, 3, 'B', '2025-12-02 05:59:46', NULL, '2025-12-02 06:10:19'),
(48, 14, 8, '199.00', '66.33', 2, 3, 'B', '2025-12-02 05:59:46', NULL, '2025-12-02 06:10:19'),
(49, 15, 8, '197.00', '65.67', 3, 3, 'B', '2025-12-02 05:59:46', NULL, '2025-12-02 06:10:19'),
(50, 16, 8, '154.00', '51.33', 3, 3, 'C', '2025-12-02 05:59:46', NULL, '2025-12-02 06:01:34'),
(51, 17, 8, '219.00', '73.00', 2, 3, 'B', '2025-12-02 05:59:46', NULL, '2025-12-02 06:01:34'),
(52, 18, 8, '246.00', '82.00', 1, 3, 'A', '2025-12-02 05:59:46', NULL, '2025-12-02 06:01:34'),
(53, 19, 8, '222.00', '74.00', 2, 3, 'B', '2025-12-02 05:59:46', NULL, '2025-12-02 06:02:54'),
(54, 20, 8, '216.00', '72.00', 3, 3, 'B', '2025-12-02 05:59:46', NULL, '2025-12-02 06:02:54'),
(55, 21, 8, '227.00', '75.67', 1, 3, 'A', '2025-12-02 05:59:46', NULL, '2025-12-02 06:02:54');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 'English', '2025-11-28 06:13:26', NULL, '2025-11-28 06:13:26'),
(2, 'Maths', '2025-11-28 06:13:35', NULL, '2025-11-28 06:13:35'),
(3, 'Quantitave Reasoning', '2025-11-28 06:16:13', NULL, '2025-11-28 06:16:13');

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
  `qualification` varchar(255) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT 'male',
  `staff_no` varchar(50) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `picture_path` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `email`, `phone`, `address`, `qualification`, `experience`, `gender`, `staff_no`, `status`, `picture_path`, `password`, `reset_token`, `reset_expires`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 'Teacher 1', 'teacher1@email.com', '09012346578', 'Teacher 1 Address', 'Qualification', 'experiaence', 'male', 'STAFF/T/001', 'active', NULL, '$2y$10$MEvKbvKpm2rSa94LtHtGAegNxBUEyFxiRV5KBymYUgDjREwIKqNcu', NULL, NULL, '2025-11-28 04:45:04', NULL, '2025-11-28 04:45:04'),
(2, 'Teacher 2', 'teacher2@email.com', '07012345678', 'Address Adress', 'B.Sc Mathematics', 'abubcocn boiasb asofnoief', 'female', 'STAFF/T/002', 'active', NULL, '$2y$10$GjkGQHiYABXxWOGe07LCMuA8TBLRQskS841Efm3ILi79.2nQitxHW', NULL, NULL, '2025-11-29 18:59:29', NULL, '2025-11-29 18:59:29');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_section`
--

CREATE TABLE `teacher_section` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `name`, `session_id`, `start_date`, `end_date`, `status`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, 'First Term', 1, '2020-01-01', '2020-04-30', 'finished', '2025-11-28 04:53:43', NULL, '2025-11-28 06:26:47'),
(2, 'Second Term', 1, '2020-05-01', '2020-08-30', 'finished', '2025-11-28 04:54:50', NULL, '2025-11-28 06:34:57'),
(3, 'Third Term', 1, '2020-09-01', '2020-12-31', 'finished', '2025-11-28 04:55:48', NULL, '2025-11-28 06:49:55'),
(4, 'First Term', 2, '2021-01-01', '2021-04-30', 'finished', '2025-11-28 06:37:59', NULL, '2025-12-02 04:38:27'),
(5, 'Second Term', 2, '2021-05-01', '2021-08-31', 'finished', '2025-11-28 06:38:34', NULL, '2025-12-02 04:44:51'),
(6, 'Third Term', 2, '2021-09-01', '2021-12-31', 'finished', '2025-11-28 06:39:02', NULL, '2025-12-02 05:18:53'),
(7, 'First Term', 3, '2022-01-01', '2022-04-30', 'finished', '2025-12-02 04:46:09', NULL, '2025-12-02 05:59:46'),
(8, 'Second Term', 3, '2022-05-01', '2022-08-31', 'ongoing', '2025-12-02 05:34:06', NULL, '2025-12-02 05:59:46');

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
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fees_class` (`class_id`);

--
-- Indexes for table `guardians`
--
ALTER TABLE `guardians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `class_arms`
--
ALTER TABLE `class_arms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `class_subjects`
--
ALTER TABLE `class_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `student_class_records`
--
ALTER TABLE `student_class_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `student_term_records`
--
ALTER TABLE `student_term_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teacher_section`
--
ALTER TABLE `teacher_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- Constraints for table `fees`
--
ALTER TABLE `fees`
  ADD CONSTRAINT `fk_fees_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
