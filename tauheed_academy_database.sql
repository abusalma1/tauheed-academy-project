-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2025 at 04:59 AM
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
(3, 1, 1, NULL, '2025-11-28 06:14:58', NULL, '2025-11-28 06:14:58'),
(4, 2, 1, NULL, '2025-11-28 06:14:58', NULL, '2025-11-28 06:14:58'),
(5, 1, 2, NULL, '2025-11-28 06:15:04', NULL, '2025-11-28 06:15:04'),
(6, 2, 2, NULL, '2025-11-28 06:15:04', NULL, '2025-11-28 06:15:04'),
(7, 1, 3, NULL, '2025-11-28 06:16:13', NULL, '2025-11-28 06:16:13'),
(8, 2, 3, NULL, '2025-11-28 06:16:13', NULL, '2025-11-28 06:16:13');

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
(42, 13, 2, '23.00', '45.00', 'B', 'Very Good', '2025-12-01 03:57:57', NULL, '2025-12-01 03:57:57');

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
(2, '2021/2022', '2021-01-01', '2021-12-31', 'pending', '2025-11-28 06:37:14', NULL, '2025-11-28 06:37:14');

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
(1, 'Sudent 1', 'ADM/2025/001', '', '', 1, '2010-01-01', NULL, '$2y$10$I0827bvuAUzAiVVsNEu79.MOsxJJzTMrK1Q.4PFN2ihcoqoXIxPaa', NULL, NULL, 'active', 'male', 2, 1, 4, '2025-11-28 04:58:20', NULL, '2025-11-28 06:49:55'),
(2, 'Student 2', 'ADM/2025/002', '', '', 2, '2010-12-12', NULL, '$2y$10$Ua3z/RF42cFJnVVMMDnEA.525aV1WPGOAZh5oIOZSFxyeMO9AALQS', NULL, NULL, 'active', 'female', 2, 1, 4, '2025-11-28 06:00:51', NULL, '2025-11-30 07:00:53'),
(3, 'Student 3', 'ADM/2025/003', '', '', 3, '2011-01-12', NULL, '$2y$10$iLBMhJRjRIHU24WYIZte2Oih1Na5emBd/swu6iQaUbXa1MTmb8I2G', NULL, NULL, 'active', 'male', 2, 1, 4, '2025-11-28 06:13:03', NULL, '2025-11-28 06:49:55');

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
(1, 1, 1, 1, 1, '0.00', '0.00', NULL, 'promoted', '2025-11-28 04:58:20', NULL, '2025-11-28 06:49:55'),
(2, 2, 1, 1, 1, '0.00', '0.00', NULL, 'promoted', '2025-11-28 06:00:51', NULL, '2025-11-28 06:49:55'),
(3, 3, 1, 1, 1, '0.00', '0.00', NULL, 'promoted', '2025-11-28 06:13:03', NULL, '2025-11-28 06:49:55'),
(4, 1, 2, 2, 1, '0.00', '0.00', NULL, 'pending', '2025-11-28 06:49:55', NULL, '2025-11-28 06:49:55'),
(5, 2, 2, 2, 1, '0.00', '0.00', NULL, 'pending', '2025-11-28 06:49:55', NULL, '2025-11-28 06:49:55'),
(6, 3, 2, 2, 1, '0.00', '0.00', NULL, 'pending', '2025-11-28 06:49:55', NULL, '2025-11-28 06:49:55');

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
(1, 1, 1, '177.00', '59.00', 3, 3, NULL, '2025-11-28 05:34:07', NULL, '2025-11-28 06:21:20'),
(3, 2, 1, '223.00', '74.33', 1, 3, NULL, '2025-11-28 06:00:51', NULL, '2025-11-28 06:21:20'),
(4, 3, 1, '220.00', '73.33', 2, 3, NULL, '2025-11-28 06:13:03', NULL, '2025-11-28 06:21:20'),
(5, 1, 2, '140.00', '46.67', 3, 3, NULL, '2025-11-28 06:26:47', NULL, '2025-11-28 06:33:40'),
(6, 2, 2, '144.00', '48.00', 2, 3, NULL, '2025-11-28 06:26:47', NULL, '2025-11-28 06:33:40'),
(7, 3, 2, '175.00', '58.33', 1, 3, NULL, '2025-11-28 06:26:47', NULL, '2025-11-28 06:33:40'),
(8, 1, 3, '119.00', '39.67', 3, 3, NULL, '2025-11-28 06:34:57', NULL, '2025-11-28 06:47:49'),
(9, 2, 3, '125.00', '41.67', 1, 3, NULL, '2025-11-28 06:34:57', NULL, '2025-11-28 06:47:49'),
(10, 3, 3, '124.00', '41.33', 2, 3, NULL, '2025-11-28 06:34:57', NULL, '2025-11-28 06:47:49'),
(11, 4, 4, '104.00', '52.00', 2, 3, NULL, '2025-11-28 06:49:55', NULL, '2025-12-01 03:57:57'),
(12, 5, 4, '79.00', '39.50', 3, 3, NULL, '2025-11-28 06:49:55', NULL, '2025-12-01 03:57:57'),
(13, 6, 4, '140.00', '70.00', 1, 3, NULL, '2025-11-28 06:49:55', NULL, '2025-12-01 03:57:57');

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
(4, 'First Term', 2, '2021-01-01', '2021-04-30', 'ongoing', '2025-11-28 06:37:59', NULL, '2025-11-28 06:49:55'),
(5, 'Second Term', 2, '2021-05-01', '2021-08-31', 'pending', '2025-11-28 06:38:34', NULL, '2025-11-28 06:38:34'),
(6, 'Third Term', 2, '2021-09-01', '2021-12-31', 'pending', '2025-11-28 06:39:02', NULL, '2025-11-28 06:39:02');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_class_records`
--
ALTER TABLE `student_class_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student_term_records`
--
ALTER TABLE `student_term_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
