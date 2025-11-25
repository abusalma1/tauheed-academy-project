-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2025 at 04:04 PM
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
-- Database: `tauheed_academy_database`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_timestamp_columns` ()   BEGIN
    DECLARE done INT DEFAULT 0;
    DECLARE tbl VARCHAR(255);
    DECLARE cur CURSOR FOR
        SELECT table_name FROM information_schema.tables WHERE table_schema = DATABASE();
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    OPEN cur;
    read_loop: LOOP
        FETCH cur INTO tbl;
        IF done THEN
            LEAVE read_loop;
        END IF;

        SET @s = CONCAT('ALTER TABLE `', tbl, '` ',
            'ADD COLUMN IF NOT EXISTS `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, ',
            'ADD COLUMN IF NOT EXISTS `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, ',
            'ADD COLUMN IF NOT EXISTS `deleted_at` DATETIME NULL;');

        PREPARE stmt FROM @s;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;
    END LOOP;

    CLOSE cur;
END$$

DELIMITER ;

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
  `reset_expires` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `reset_token`, `type`, `staff_no`, `address`, `department`, `status`, `phone`, `picture_path`, `created_at`, `updated_at`, `qualification`, `gender`, `experience`, `reset_expires`, `deleted_at`) VALUES
(1, 'Abubakar Ahmad Adili', 'abubakarahmadadili@gmail.com', '$2y$10$VmpoPAOKYaVB4pEfE0h/qepU80Egi/8T4mxIPCGirpA2//ionrL0y', NULL, 'superAdmin', 'ST/2025/001', 'Maniru Road', 'Director/CEO', 'active', '09061893504', NULL, '2025-11-05 14:33:05', '2025-11-23 12:50:50', NULL, 'male', NULL, NULL, NULL),
(2, 'Aminu Ahmad Adili', 'admin@email.com', '$2y$10$n8ei/IxLhOlEcIE8aFHDpemDAnithSjtGFgBeOTXIYM1e4WvThR1C', NULL, 'admin', 'ST/2025/002', 'Kofar Marke Area', 'Development', 'active', '09061893504', NULL, '2025-11-10 12:28:17', '2025-11-22 16:12:52', NULL, 'male', NULL, NULL, NULL),
(3, 'Abusalma', 'adahiru.iuol@gmail.com', '$2y$10$N6uZt2KgNrfwAls0hM.YTO5oE8hOystwNjMr2/9c6qSOgZCIe3Gqq', NULL, 'admin', 'ST/2025/003', 'Mabera', 'FInance', 'active', '08160050448', NULL, '2025-11-20 14:46:54', '2025-11-24 10:57:27', 'B.sc Public Admin', 'male', 'iconic Open University (10 years fince officer)', NULL, NULL);

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `bank_name`, `account_name`, `account_number`, `purpose`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'UBA Bank', 'Tauheed Academy', '9078563412', 'Tansport Fee', '2025-11-25 13:31:30', '2025-11-25 13:48:11', NULL),
(2, 'GT bank', 'Tauheed Academy', '2143658709', 'PTA Fee', '2025-11-25 13:48:44', '2025-11-25 13:48:44', NULL);

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
  `level` int(11) NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `section_id`, `name`, `created_at`, `updated_at`, `level`, `deleted_at`) VALUES
(1, 3, 'JSS 1', '2025-11-06 13:45:16', '2025-11-21 14:00:43', 6, NULL),
(2, 1, 'Nursery 1', '2025-11-06 13:54:09', '2025-11-21 13:59:26', 1, NULL),
(3, 1, 'Nursery 2', '2025-11-06 13:54:38', '2025-11-21 13:59:40', 2, NULL),
(4, 2, 'SS 1', '2025-11-06 13:54:54', '2025-11-21 14:01:28', 7, NULL),
(5, 2, 'SS 2', '2025-11-06 13:55:14', '2025-11-21 14:01:59', 8, NULL),
(6, 2, 'SS 3', '2025-11-07 08:53:57', '2025-11-21 14:02:08', 9, NULL),
(7, 1, 'Nursery 3', '2025-11-07 10:10:37', '2025-11-21 13:59:40', 3, NULL),
(8, 4, 'Primary 1', '2025-11-07 10:42:32', '2025-11-21 14:00:17', 4, NULL),
(9, 4, 'Primary 2', '2025-11-10 12:48:20', '2025-11-21 14:00:43', 5, NULL),
(15, 5, 'Raudatu Aisha', '2025-11-21 13:52:12', '2025-11-21 14:02:42', 10, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `class_arms`
--

CREATE TABLE `class_arms` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_arms`
--

INSERT INTO `class_arms` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'A', '', '2025-11-05 14:48:58', '2025-11-05 14:48:58', NULL),
(2, 'B', '', '2025-11-05 14:49:03', '2025-11-10 12:54:17', NULL),
(3, 'C', '', '2025-11-05 14:49:08', '2025-11-05 14:49:08', NULL),
(4, 'D', '', '2025-11-05 14:49:14', '2025-11-05 14:49:14', NULL),
(5, 'E', '', '2025-11-10 12:59:41', '2025-11-10 12:59:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `class_class_arms`
--

CREATE TABLE `class_class_arms` (
  `class_id` int(11) NOT NULL,
  `arm_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_class_arms`
--

INSERT INTO `class_class_arms` (`class_id`, `arm_id`, `teacher_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(1, 2, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(1, 3, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(2, 1, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(2, 2, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(3, 1, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(3, 2, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(4, 1, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(4, 2, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(4, 3, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(5, 1, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(5, 2, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(6, 1, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(6, 2, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(7, 1, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(7, 2, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(8, 1, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(8, 2, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(8, 3, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(9, 1, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(9, 2, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(9, 3, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(15, 1, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(15, 2, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL),
(15, 3, NULL, '2025-11-25 14:51:12', '2025-11-25 14:51:12', NULL);

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_subjects`
--

INSERT INTO `class_subjects` (`id`, `class_id`, `subject_id`, `teacher_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(11, 2, 1, NULL, '2025-11-07 09:39:14', '2025-11-25 14:51:12', NULL),
(12, 3, 1, NULL, '2025-11-07 09:39:15', '2025-11-25 14:51:12', NULL),
(13, 4, 1, 1, '2025-11-07 09:39:15', '2025-11-25 14:51:12', NULL),
(14, 5, 1, 2, '2025-11-07 09:39:15', '2025-11-25 14:51:12', NULL),
(15, 1, 1, NULL, '2025-11-07 09:39:15', '2025-11-25 14:51:12', NULL),
(16, 6, 1, NULL, '2025-11-07 09:39:15', '2025-11-25 14:51:12', NULL),
(23, 4, 3, NULL, '2025-11-07 09:40:21', '2025-11-25 14:51:12', NULL),
(24, 5, 3, NULL, '2025-11-07 09:40:21', '2025-11-25 14:51:12', NULL),
(25, 6, 3, NULL, '2025-11-07 09:40:21', '2025-11-25 14:51:12', NULL),
(26, 1, 2, 1, '2025-11-09 14:26:31', '2025-11-25 14:51:12', NULL),
(27, 2, 2, 1, '2025-11-09 14:26:32', '2025-11-25 14:51:12', NULL),
(28, 3, 2, NULL, '2025-11-09 14:26:32', '2025-11-25 14:51:12', NULL),
(29, 4, 2, NULL, '2025-11-09 14:26:32', '2025-11-25 14:51:12', NULL),
(30, 5, 2, NULL, '2025-11-09 14:26:32', '2025-11-25 14:51:12', NULL),
(31, 6, 2, NULL, '2025-11-09 14:26:32', '2025-11-25 14:51:12', NULL),
(32, 7, 2, 3, '2025-11-09 14:26:32', '2025-11-25 14:51:12', NULL),
(33, 8, 2, NULL, '2025-11-09 14:26:33', '2025-11-25 14:51:12', NULL),
(34, 4, 6, NULL, '2025-11-10 10:45:51', '2025-11-25 14:51:12', NULL),
(35, 5, 6, NULL, '2025-11-10 10:45:52', '2025-11-25 14:51:12', NULL),
(36, 6, 6, NULL, '2025-11-10 10:45:52', '2025-11-25 14:51:12', NULL),
(37, 4, 7, NULL, '2025-11-10 10:49:18', '2025-11-25 14:51:12', NULL),
(38, 5, 7, NULL, '2025-11-10 10:49:18', '2025-11-25 14:51:12', NULL),
(39, 6, 7, NULL, '2025-11-10 10:49:18', '2025-11-25 14:51:12', NULL),
(40, 1, 4, 1, '2025-11-10 11:41:24', '2025-11-25 14:51:12', NULL),
(41, 1, 8, NULL, '2025-11-10 11:41:53', '2025-11-25 14:51:12', NULL),
(42, 2, 5, NULL, '2025-11-10 12:00:21', '2025-11-25 14:51:12', NULL),
(43, 3, 5, NULL, '2025-11-10 12:00:21', '2025-11-25 14:51:12', NULL);

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `class_id`, `first_term`, `second_term`, `third_term`, `uniform`, `transport`, `materials`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-11-25 10:19:39', '2025-11-25 10:19:39', NULL),
(2, 2, 12.00, 12.00, 12.00, 12.00, 12.00, 12.00, '2025-11-25 10:19:39', '2025-11-25 10:19:39', NULL),
(3, 3, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-11-25 10:19:39', '2025-11-25 10:19:39', NULL),
(4, 4, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-11-25 10:19:39', '2025-11-25 10:19:39', NULL),
(5, 5, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-11-25 10:19:39', '2025-11-25 10:19:39', NULL),
(6, 6, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-11-25 10:19:39', '2025-11-25 10:19:39', NULL),
(7, 7, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-11-25 10:19:40', '2025-11-25 10:19:40', NULL),
(8, 8, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-11-25 10:19:40', '2025-11-25 10:19:40', NULL),
(9, 9, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-11-25 10:19:40', '2025-11-25 10:19:40', NULL),
(10, 15, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-11-25 10:19:40', '2025-11-25 10:19:40', NULL);

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
  `reset_expires` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guardians`
--

INSERT INTO `guardians` (`id`, `name`, `email`, `phone`, `address`, `picture_path`, `relationship`, `occupation`, `password`, `status`, `reset_token`, `created_at`, `updated_at`, `gender`, `reset_expires`, `deleted_at`) VALUES
(1, 'Yusuf Kaoje', 'guardian@email.com', '09061893504', 'Arkilla Fire Service', NULL, 'father', 'Physician', '$2y$10$oF/M3BFvfwc3jPCL.b5JY.2JNHwbzdBprVYCtYeXZGwSVXTEWIbMC', 'active', NULL, '2025-11-06 09:46:29', '2025-11-20 05:40:26', 'male', NULL, NULL),
(2, 'Yahya Kamar', 'yahya@email.com', '08012345678', 'Emir Yahya', NULL, 'father', 'Lecture', '$2y$10$daEH3qJkX30oe/jS3/0g5uk51ylsINpdn0I3qR8WktBe8rutOErly', 'active', NULL, '2025-11-06 09:47:39', '2025-11-18 11:10:26', 'male', NULL, NULL),
(3, 'Tijjani kware', 'tijjani@email.com', '090 1934 4018', 'kware LG', NULL, 'father', 'Business Man', '$2y$10$daEH3qJkX30oe/jS3/0g5uk51ylsINpdn0I3qR8WktBe8rutOErly', 'active', NULL, '2025-11-10 12:33:37', '2025-11-18 11:10:26', 'male', NULL, NULL),
(4, 'Faruk Kalgo', 'kalgo@email.com', '09061893504', 'Runjin Sambo', NULL, 'father', 'Lecuture', '$2y$10$daEH3qJkX30oe/jS3/0g5uk51ylsINpdn0I3qR8WktBe8rutOErly', 'active', NULL, '2025-11-11 10:35:02', '2025-11-18 11:10:26', 'male', NULL, NULL),
(5, 'Sanusi Gandu', 'sanusi@email.com', '09061893504', 'Gandu Area', NULL, 'father', 'Business', '$2y$10$daEH3qJkX30oe/jS3/0g5uk51ylsINpdn0I3qR8WktBe8rutOErly', 'active', NULL, '2025-11-11 10:36:16', '2025-11-18 11:10:26', 'male', NULL, NULL),
(6, 'Hassan Musa Kebbeh', 'kebbeh@email.com', '09061893504', 'Gidan Igwai', NULL, 'father', 'Civil Servant', '$2y$10$daEH3qJkX30oe/jS3/0g5uk51ylsINpdn0I3qR8WktBe8rutOErly', 'active', NULL, '2025-11-11 10:37:30', '2025-11-18 11:10:26', 'male', NULL, NULL),
(7, 'Bello Inga', 'bello@email.com', '09012345652', 'Binanchi Area', NULL, 'father', 'Business', '$2y$10$daEH3qJkX30oe/jS3/0g5uk51ylsINpdn0I3qR8WktBe8rutOErly', 'active', NULL, '2025-11-11 10:38:32', '2025-11-18 11:10:26', 'male', NULL, NULL);

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `category`, `content`, `picture_path`, `publication_date`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'School Opning', 'announcement', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet ullam reprehenderit sapiente cum velit exercitationem nemo facilis voluptas quos nihil? Vitae qui accusamus ipsum illum consequatur reiciendis quos nesciunt nihil.\r\n\r\nLorem ipsum dolor, sit amet consectetur adipisicing elit. Amet ullam reprehenderit sapiente cum velit exercitationem nemo facilis voluptas quos nihil? Vitae qui accusamus ipsum illum consequatur reiciendis quos nesciunt nihil.\r\n\r\nLorem ipsum dolor, sit amet consectetur adipisicing elit. Amet ullam reprehenderit sapiente cum velit exercitationem nemo facilis voluptas quos nihil? Vitae qui accusamus ipsum illum consequatur reiciendis quos nesciunt nihil.\r\n\r\n\r\nLorem ipsum dolor, sit amet consectetur adipisicing elit. Amet ullam reprehenderit sapiente cum velit exercitationem nemo facilis voluptas quos nihil? Vitae qui accusamus ipsum illum consequatur reiciendis quos nesciunt nihil.', NULL, '2025-11-23 23:00:00', '', '2025-11-24 04:30:55', '2025-11-24 04:30:55', NULL),
(2, 'Third Term Holiday', 'announcement', 'Holday will last 3 weeks', NULL, '2025-11-23 23:00:00', '', '2025-11-24 04:32:30', '2025-11-24 04:32:30', NULL),
(3, 'Secondary Section Opening', 'achievement', 'Secondary Sectino Is about to be opend ,', NULL, '2025-11-23 23:00:00', 'published', '2025-11-24 04:44:10', '2025-11-24 04:44:10', NULL),
(4, 'lorem lorem', 'achievement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore eveniet, consectetur veniam commodi soluta accusantium aliquid iusto debitis sapiente cupiditate ratione minus minima sit nostrum! Voluptates quae natus iusto quibusdam.\r\n\r\n\r\n    Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore eveniet, consectetur veniam commodi soluta accusantium aliquid iusto debitis sapiente cupiditate ratione minus minima sit nostrum! Voluptates quae natus iusto quibusdam.\r\n\r\n\r\n    Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore eveniet, consectetur veniam commodi soluta accusantium aliquid iusto debitis sapiente cupiditate ratione minus minima sit nostrum! Voluptates quae natus iusto quibusdam.\r\n\r\n\r\n\r\n    Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore eveniet, consectetur veniam commodi soluta accusantium aliquid iusto debitis sapiente cupiditate ratione minus minima sit nostrum! Voluptates quae natus iusto quibusdam.\r\n\r\n\r\n\r\n    Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore eveniet, consectetur veniam commodi soluta accusantium aliquid iusto debitis sapiente cupiditate ratione minus minima sit nostrum! Voluptates quae natus iusto quibusdam.', NULL, '2025-11-23 23:00:00', 'published', '2025-11-24 05:45:56', '2025-11-24 05:45:56', NULL),
(6, 'testing', 'event', '<?php\r\n$title = \"News Detail\";\r\ninclude(__DIR__ . \'/../../includes/header.php\');\r\n\r\nif (isset($_GET[\'id\'])) {\r\n    $id = $_GET[\'id\'];\r\n    $stmt = $conn->prepare(\'SELECT * FROM news WHERE id=?\');\r\n    $stmt->bind_param(\'i\', $id);\r\n    $stmt->execute();\r\n    $result = $stmt->get_result();\r\n\r\n    if ($result->num_rows > 0) {\r\n        $story = $result->fetch_assoc();\r\n\r\n        // Get Previous Article (earlier created_at)\r\n        $stmtPrev = $conn->prepare(\'SELECT id, picture_path, created_at, title FROM news WHERE created_at < ? ORDER BY created_at DESC LIMIT 1\');\r\n        $stmtPrev->bind_param(\'s\', $story[\'created_at\']);\r\n        $stmtPrev->execute();\r\n        $prevResult = $stmtPrev->get_result();\r\n        $previous = $prevResult->fetch_assoc();\r\n\r\n        // Get Next Article (later created_at)\r\n        $stmtNext = $conn->prepare(\'SELECT id, picture_path, created_at, title FROM news WHERE created_at > ? ORDER BY created_at ASC LIMIT 1\');\r\n        $stmtNext->bind_param(\'s\', $story[\'created_at\']);\r\n        $stmtNext->execute();\r\n        $nextResult = $stmtNext->get_result();\r\n        $next = $nextResult->fetch_assoc();\r\n    } else {\r\n        header(\'Location: \' . route(\'back\'));\r\n    }\r\n} else {\r\n    header(\'Location: \' . route(\'back\'));\r\n}\r\n\r\n?>\r\n\r\n<body class=\"bg-gray-50\">\r\n    <!-- Navigation -->\r\n    <?php include(__DIR__ . \"/../../includes/nav.php\") ?>\r\n\r\n\r\n    <!-- Page Header -->\r\n    <section class=\"bg-gradient-to-r from-blue-900 to-blue-800 text-white py-12\">\r\n        <div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8\">\r\n            <h1 class=\"text-4xl md:text-5xl font-bold mb-4\">News Detail</h1>\r\n            <p class=\"text-xl text-blue-200\">See the content of the story</p>\r\n        </div>\r\n    </section>\r\n\r\n\r\n    <!-- News Detail Content -->\r\n    <section class=\"py-16 bg-gray-100\">\r\n        <div class=\"max-w-4xl mx-auto px-4 sm:px-6 lg:px-8\">\r\n            <article class=\"bg-white rounded-lg shadow-lg overflow-hidden\">\r\n                <!-- Featured Image -->\r\n                <div class=\"relative overflow-hidden h-96 md:h-96\">\r\n                    <img src=\"/placeholder.svg?height=500&width=800\" alt=\"News\" class=\"w-full h-full object-cover\">\r\n                    <!-- Category badge in top-right corner -->\r\n                    <?php if ($story[\'category\'] === \'event\'): ?>\r\n                        <div class=\"absolute top-4 right-4 bg-green-600  text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg\">\r\n                            <i class=\"fas fa-calendar-check mr-2\"></i>Event\r\n                        </div>\r\n                    <?php elseif ($story[\'category\'] === \'achievement\'): ?>\r\n                        <div class=\"absolute top-4 right-4 bg-yellow-600  text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg\">\r\n                            <i class=\"fas fa-star mr-2\"></i>Achievement\r\n                        </div>\r\n                    <?php elseif ($story[\'category\'] === \'announcement\'): ?>\r\n                        <div class=\"absolute top-4 right-4 bg-blue-600  text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg\">\r\n                            <i class=\"fas fa-bullhorn mr-2\"></i>Announcement\r\n                        </div>\r\n                    <?php elseif ($story[\'category\'] === \'update\'): ?>\r\n                        <div class=\"absolute top-4 right-4 bg-purple-600  text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg\">\r\n                            <i class=\"fas fa-info-circle mr-2\"></i>Update\r\n                        </div>\r\n                    <?php endif ?>\r\n                </div>\r\n\r\n                <!-- Article Header -->\r\n                <div class=\"p-8 border-b\">\r\n                    <div class=\"flex flex-wrap items-center gap-4 mb-4 text-sm text-gray-600\">\r\n                        <div class=\"flex items-center gap-2\">\r\n                            <i class=\"fas fa-calendar text-blue-900\"></i>\r\n                            <span><?= date(\'D d M, Y\', strtotime($story[\'created_at\'])); ?></span>\r\n                        </div>\r\n                        <div class=\"flex items-center gap-2\">\r\n                            <i class=\"fas fa-user text-blue-900\"></i>\r\n                            <span>By Admin</span>\r\n                        </div>\r\n                    </div>\r\n                    <h1 class=\"text-4xl font-bold text-gray-900 mb-4\"><?= htmlspecialchars(ucwords($story[\'title\'])) ?></h1>\r\n\r\n                </div>\r\n\r\n                <!-- Article Body -->\r\n                <div class=\"p-8 prose prose-lg max-w-none\">\r\n                    <h2 class=\"text-2xl font-bold text-gray-900 mt-8 mb-4\">Article Content</h2>\r\n                    <p class=\"text-gray-700 mb-6 leading-relaxed\"><?= nl2br(htmlspecialchars($story[\'content\'])); ?> </p>\r\n\r\n\r\n\r\n                </div>\r\n\r\n                <!-- Article Footer with Social Sharing -->\r\n                <div class=\"p-8 bg-gray-50 border-t\">\r\n                    <div class=\"flex flex-col md:flex-row md:items-center md:justify-between\">\r\n                        <div class=\"mb-4 md:mb-0\">\r\n                            <p class=\"text-gray-600 text-sm mb-3\">Share this article:</p>\r\n                            <div class=\"flex gap-3\">\r\n                                <a href=\"#\" class=\"inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-sm\">\r\n                                    <i class=\"fab fa-facebook-f\"></i>Facebook\r\n                                </a>\r\n                                <a href=\"#\" class=\"inline-flex items-center gap-2 bg-blue-400 text-white px-4 py-2 rounded hover:bg-blue-500 transition text-sm\">\r\n                                    <i class=\"fab fa-twitter\"></i>Twitter\r\n                                </a>\r\n                                <a href=\"#\" class=\"inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition text-sm\">\r\n                                    <i class=\"fab fa-whatsapp\"></i>WhatsApp\r\n                                </a>\r\n                            </div>\r\n                        </div>\r\n                        <a href=\"school-news.html\" class=\"inline-flex items-center gap-2 bg-blue-900 text-white px-6 py-2 rounded hover:bg-blue-800 transition font-semibold\">\r\n                            <i class=\"fas fa-arrow-left\"></i>Back to News\r\n                        </a>\r\n                    </div>\r\n                </div>\r\n            </article>\r\n\r\n            <!-- Next & Previous Articles -->\r\n            <section class=\"mt-12\">\r\n                <h2 class=\"text-3xl font-bold text-gray-900 mb-8\">More Articles</h2>\r\n                <div class=\"grid grid-cols-1 md:grid-cols-2 gap-6\">\r\n\r\n                    <!-- Previous Article -->\r\n                    <?php if ($previous): ?>\r\n                        <div class=\"bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition\">\r\n                            <div class=\"relative overflow-hidden h-40\">\r\n                                <img src=\"/placeholder.svg?height=200&width=400\" alt=\"Previous Article\" class=\"w-full h-full object-cover\">\r\n                                <div class=\"absolute top-2 left-2 bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold\">\r\n                                    <i class=\"fas fa-arrow-left mr-1\"></i>Previous\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"p-4\">\r\n                                <p class=\"text-xs text-gray-500 mb-2\"><i class=\"fas fa-calendar mr-1\"></i><?= date(\'D d M, Y\', strtotime($previous[\'created_at\'])); ?></p>\r\n                                <h3 class=\"text-lg font-bold text-gray-900 mb-2\"><?= ucwords($previous[\'title\']) ?></h3>\r\n                                <a href=\"<?= route(\'news-detial\') . \'?id=\' . $previous[\'id\'] ?>\" class=\"text-blue-900 font-semibold text-sm hover:text-blue-700\">\r\n                                    Read Previous <i class=\"fas fa-arrow-left\"></i>\r\n                                </a>\r\n                            </div>\r\n                        </div>\r\n                    <?php endif ?>\r\n                    <?php if ($next): ?>\r\n                        <!-- Next Article -->\r\n                        <div class=\"bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition\">\r\n                            <div class=\"relative overflow-hidden h-40\">\r\n                                <img src=\"/placeholder.svg?height=200&width=400\" alt=\"Next Article\" class=\"w-full h-full object-cover\">\r\n                                <div class=\"absolute top-2 right-2 bg-purple-600 text-white px-3 py-1 rounded text-xs font-semibold\">\r\n                                    <i class=\"fas fa-arrow-right mr-1\"></i>Next\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"p-4\">\r\n                                <p class=\"text-xs text-gray-500 mb-2\"><i class=\"fas fa-calendar mr-1\"></i><?= date(\'D d M, Y\', strtotime($next[\'created_at\'])); ?></p>\r\n                                <h3 class=\"text-lg font-bold text-gray-900 mb-2\"><?= htmlspecialchars(ucwords($next[\'title\'])) ?></h3>\r\n                                <a href=\"<?= route(\'news-detial\') . \'?id=\' . $next[\'id\'] ?>\" class=\"text-blue-900 font-semibold text-sm hover:text-blue-700\">\r\n                                    Read Next <i class=\"fas fa-arrow-right\"></i>\r\n                                </a>\r\n                            </div>\r\n                        </div>\r\n                    <?php endif ?>\r\n\r\n                </div>\r\n            </section>\r\n\r\n        </div>\r\n    </section>\r\n\r\n    <!-- Footer -->\r\n    <?php include(__DIR__ . \"/../../includes/footer.php\"); ?>\r\n\r\n</body>\r\n\r\n</html>', NULL, '2025-11-23 23:00:00', 'published', '2025-11-24 06:09:19', '2025-11-24 06:09:19', NULL),
(7, 'New s news', 'update', 'New s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s news\r\nNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s news   \r\n\r\n\r\nNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s news\r\n\r\nNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsNew s newsv', NULL, '2025-11-23 23:00:00', 'published', '2025-11-24 06:15:54', '2025-11-24 06:15:54', NULL),
(8, 'Home page', 'announcement', '<?php\r\n$title = \'Dashboard\';\r\n\r\ninclude(__DIR__ .  \'/./includes/header.php\');\r\n\r\n$stmt = $conn->prepare(\"SELECT * FROM news ORDER BY created_at DESC limit 6\");\r\n$stmt->execute();\r\n$result = $stmt->get_result();\r\n$news = $result->fetch_all(MYSQLI_ASSOC);\r\n\r\n?>\r\n\r\n<body class=\"bg-gray-50\">\r\n\r\n    <?php include(__DIR__ .  \'/./includes/nav.php\'); ?>\r\n    <!-- Hero Section -->\r\n    <section class=\"bg-gradient-to-r from-pink-700 to-blue-600 text-white py-20\">\r\n        <div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center\">\r\n            <img src=\"<?= asset(\'images/logo.png\') ?>\"\r\n                alt=\"School Logo\"\r\n                class=\"h-32 w-32 mx-auto block mb-6 bg-white rounded-full p-2 object-contain object-center\">\r\n\r\n            <h1 class=\"text-4xl md:text-6xl font-bold mb-4\">Tauheed Academy</h1>\r\n            <p class=\"text-xl md:text-2xl text-blue-200 mb-8\">Nurturing Future Leaders Through Quality Education</p>\r\n            <div class=\"flex flex-wrap justify-center gap-4\">\r\n                <a href=\"<?= route(\'admission\') ?>\" class=\"bg-white text-blue-900 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition\">Apply Now</a>\r\n                <a href=\"<?= route(\'about\') ?>\" class=\"bg-blue-800 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-900 transition\">Learn More</a>\r\n            </div>\r\n        </div>\r\n    </section>\r\n\r\n    <!-- Welcome Message -->\r\n    <section class=\"py-16 bg-white\">\r\n        <div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8\">\r\n            <div class=\"grid md:grid-cols-2 gap-12 items-center\">\r\n                <div>\r\n                    <img src=\"/placeholder.svg?height=400&width=600\" alt=\"Director\" class=\"rounded-lg shadow-xl w-full\">\r\n                </div>\r\n                <div>\r\n                    <h2 class=\"text-3xl font-bold text-gray-900 mb-4\">Welcome from Our Director</h2>\r\n                    <p class=\"text-gray-700 leading-relaxed mb-4\">\r\n                        Dear Parents, Students, and Visitors,\r\n                    </p>\r\n                    <p class=\"text-gray-700 leading-relaxed mb-4\">\r\n                        It is with great pleasure that I welcome you to Excellence Academy. Our institution stands as a beacon of quality education, dedicated to nurturing young minds and preparing them for the challenges of tomorrow.\r\n                    </p>\r\n                    <p class=\"text-gray-700 leading-relaxed mb-4\">\r\n                        We believe in holistic development, combining academic excellence with character building, creativity, and critical thinking. Our experienced faculty, modern facilities, and student-centered approach ensure that every child receives the attention and guidance they deserve.\r\n                    </p>\r\n                    <p class=\"text-gray-700 leading-relaxed mb-4\">\r\n                        Thank you for considering Excellence Academy as your partner in education. Together, we will shape the leaders of tomorrow.\r\n                    </p>\r\n                    <p class=\"text-gray-900 font-semibold\">\r\n                        Dr. Sarah Johnson<br>\r\n                        <span class=\"text-gray-600 text-sm\">Director/CEO, Excellence Academy</span>\r\n                    </p>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </section>\r\n\r\n    <!-- News Grid -->\r\n    <section class=\"py-16 bg-gray-100\">\r\n        <div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8\">\r\n            <h2 class=\"text-3xl font-bold text-center text-gray-900 mb-12\">School News</h2>\r\n            <div class=\"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8\" id=\"news-grid\">\r\n                <?php foreach ($news as $story) : ?>\r\n                    <div class=\"news-item <?= $story[\'category\'] ?> bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:scale-105\">\r\n                        <div class=\"relative overflow-hidden h-48\">\r\n                            <img src=\"/placeholder.svg?height=300&width=400\" alt=\"News\" class=\"w-full h-full object-cover\">\r\n\r\n                            <?php if ($story[\'category\'] === \'event\'): ?>\r\n                                <div class=\"absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-sm font-semibold\">\r\n                                    <i class=\"fas fa-calendar-check mr-2\"></i>Event\r\n                                </div>\r\n                            <?php elseif ($story[\'category\'] === \'achievement\'): ?>\r\n                                <div class=\"absolute top-4 right-4 bg-yellow-600 text-white px-3 py-1 rounded-full text-sm font-semibold\">\r\n                                    <i class=\"fas fa-star mr-2\"></i>Achievement\r\n                                </div>\r\n                            <?php elseif ($story[\'category\'] === \'announcement\'): ?>\r\n                                <div class=\"absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold\">\r\n                                    <i class=\"fas fa-bullhorn mr-2\"></i>Announcement\r\n                                </div>\r\n                            <?php elseif ($story[\'category\'] === \'update\'): ?>\r\n                                <div class=\"absolute top-4 right-4 bg-purple-600 text-white px-3 py-1 rounded-full text-sm font-semibold\">\r\n                                    <i class=\"fas fa-info-circle mr-2\"></i>Update\r\n                                </div>\r\n                            <?php endif ?>\r\n\r\n                        </div>\r\n                        <div class=\"p-6\">\r\n                            <div class=\"flex items-center gap-2 text-gray-500 text-sm mb-3\">\r\n                                <i class=\"fas fa-calendar\"></i>\r\n                                <span><?= date(\'D d M, Y\', strtotime($story[\'created_at\'])); ?></span>\r\n                            </div>\r\n                            <h3 class=\"text-xl font-bold text-gray-900 mb-3\"><?= $story[\'title\'] ?></h3>\r\n                            <p class=\"text-gray-600 mb-4\"><?= htmlspecialchars(substr($story[\'content\'], 0, 50) . \"...\") ?></p>\r\n                            <a href=\"<?= route(\'news-detial\') . \'?id=\' . $story[\'id\']; ?>\" class=\"inline-flex items-center gap-2 text-blue-900 font-semibold hover:text-blue-700\">\r\n                                Read More <i class=\"fas fa-arrow-right\"></i>\r\n                            </a>\r\n                        </div>\r\n                    </div>\r\n                <?php endforeach ?>\r\n\r\n\r\n\r\n            </div>\r\n        </div>\r\n    </section>\r\n\r\n\r\n    <!-- Gallery Slider -->\r\n    <section class=\"py-16 bg-gray-100\">\r\n        <div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8\">\r\n            <h2 class=\"text-3xl font-bold text-center text-gray-900 mb-12\">Our Campus & Activities</h2>\r\n            <div class=\"grid grid-cols-1 md:grid-cols-3 gap-6\">\r\n                <div class=\"relative overflow-hidden rounded-lg shadow-lg group\">\r\n                    <img src=\"/placeholder.svg?height=300&width=400\" alt=\"School Building\" class=\"w-full h-64 object-cover group-hover:scale-110 transition duration-300\">\r\n                    <div class=\"absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4\">\r\n                        <p class=\"text-white font-semibold\">Modern School Building</p>\r\n                    </div>\r\n                </div>\r\n                <div class=\"relative overflow-hidden rounded-lg shadow-lg group\">\r\n                    <img src=\"/placeholder.svg?height=300&width=400\" alt=\"Classroom\" class=\"w-full h-64 object-cover group-hover:scale-110 transition duration-300\">\r\n                    <div class=\"absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4\">\r\n                        <p class=\"text-white font-semibold\">Interactive Classrooms</p>\r\n                    </div>\r\n                </div>\r\n                <div class=\"relative overflow-hidden rounded-lg shadow-lg group\">\r\n                    <img src=\"/placeholder.svg?height=300&width=400\" alt=\"Sports\" class=\"w-full h-64 object-cover group-hover:scale-110 transition duration-300\">\r\n                    <div class=\"absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4\">\r\n                        <p class=\"text-white font-semibold\">Sports & Recreation</p>\r\n                    </div>\r\n                </div>\r\n                <div class=\"relative overflow-hidden rounded-lg shadow-lg group\">\r\n                    <img src=\"/placeholder.svg?height=300&width=400\" alt=\"Library\" class=\"w-full h-64 object-cover group-hover:scale-110 transition duration-300\">\r\n                    <div class=\"absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4\">\r\n                        <p class=\"text-white font-semibold\">Well-Stocked Library</p>\r\n                    </div>\r\n                </div>\r\n                <div class=\"relative overflow-hidden rounded-lg shadow-lg group\">\r\n                    <img src=\"/placeholder.svg?height=300&width=400\" alt=\"Laboratory\" class=\"w-full h-64 object-cover group-hover:scale-110 transition duration-300\">\r\n                    <div class=\"absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4\">\r\n                        <p class=\"text-white font-semibold\">Science Laboratories</p>\r\n                    </div>\r\n                </div>\r\n                <div class=\"relative overflow-hidden rounded-lg shadow-lg group\">\r\n                    <img src=\"/placeholder.svg?height=300&width=400\" alt=\"Computer Lab\" class=\"w-full h-64 object-cover group-hover:scale-110 transition duration-300\">\r\n                    <div class=\"absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4\">\r\n                        <p class=\"text-white font-semibold\">Computer Laboratory</p>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </section>\r\n\r\n    <!-- Quick Links -->\r\n    <section class=\"py-16 bg-white\">\r\n        <div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8\">\r\n            <h2 class=\"text-3xl font-bold text-center text-gray-900 mb-12\">Quick Links</h2>\r\n            <div class=\"grid grid-cols-2 md:grid-cols-5 gap-6\">\r\n                <a href=\"<?= route(\'admission\') ?>\" class=\"bg-blue-900 text-white p-6 rounded-lg text-center hover:bg-blue-800 transition shadow-lg\">\r\n                    <i class=\"fas fa-user-plus text-4xl mb-3\"></i>\r\n                    <p class=\"font-semibold\">Admissions</p>\r\n                </a>\r\n                <a href=\"<?= route(\'fees\') ?>\" class=\"bg-blue-900 text-white p-6 rounded-lg text-center hover:bg-blue-800 transition shadow-lg\">\r\n                    <i class=\"fas fa-money-bill-wave text-4xl mb-3\"></i>\r\n                    <p class=\"font-semibold\">Fees</p>\r\n                </a>\r\n                <a href=\"<?= route(\'timetable\') ?>\" class=\"bg-blue-900 text-white p-6 rounded-lg text-center hover:bg-blue-800 transition shadow-lg\">\r\n                    <i class=\"fas fa-calendar-alt text-4xl mb-3\"></i>\r\n                    <p class=\"font-semibold\">Timetable</p>\r\n                </a>\r\n                <a href=\"<?php\r\n                            if ($is_logged_in) {\r\n                                if ($user_type === \'student\') {\r\n                                    echo (route(\'student-result\'));\r\n                                } else if ($user_type === \'guardian\') {\r\n                                    echo (route(\'my-children\'));\r\n                                } else {\r\n                                    echo ((route(\'results-management\')));\r\n                                }\r\n                            } else {\r\n                                echo (route(\'academics\'));\r\n                            }\r\n                            ?>\" class=\"bg-blue-900 text-white p-6 rounded-lg text-center hover:bg-blue-800 transition shadow-lg\">\r\n                    <i class=\"fas fa-graduation-cap text-4xl mb-3\"></i>\r\n                    <p class=\"font-semibold\">Results</p>\r\n                </a>\r\n                <a href=\"<?= route(\'about\') ?>\" class=\"bg-blue-900 text-white p-6 rounded-lg text-center hover:bg-blue-800 transition shadow-lg\">\r\n                    <i class=\"fas fa-envelope text-4xl mb-3\"></i>\r\n                    <p class=\"font-semibold\">Contact</p>\r\n                </a>\r\n            </div>\r\n        </div>\r\n    </section>\r\n\r\n    <?php include(__DIR__ . \'/includes/footer.php\') ?>\r\n    <script>\r\n        //  Mobile Menu Script\r\n        const mobileMenuBtn = document.getElementById(\"mobile-menu-btn\");\r\n        const mobileMenu = document.getElementById(\"mobile-menu\");\r\n\r\n        mobileMenuBtn.addEventListener(\"click\", () => {\r\n            mobileMenu.classList.toggle(\"hidden\");\r\n        });\r\n    </script>\r\n</body>\r\n\r\n</html>', NULL, '2025-11-23 23:00:00', 'published', '2025-11-24 06:16:15', '2025-11-24 06:16:15', NULL);

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `student_term_record_id`, `subject_id`, `ca`, `exam`, `grade`, `remark`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 8, 5.00, 50.00, 'C', 'Good', '2025-11-17 07:49:27', '2025-11-17 11:34:39', NULL),
(2, 2, 8, 19.00, 18.00, 'F', 'Fail', '2025-11-17 07:49:28', '2025-11-17 11:34:39', NULL),
(3, 3, 8, 35.00, 34.00, 'B', 'Very Good', '2025-11-17 07:52:45', '2025-11-17 07:52:45', NULL),
(4, 4, 8, 30.00, 50.00, 'A', 'Excellent', '2025-11-17 07:52:46', '2025-11-17 07:52:46', NULL),
(9, 3, 4, 20.00, 50.00, 'A', 'Excellent', '2025-11-17 12:32:13', '2025-11-17 12:32:13', NULL),
(10, 4, 4, 35.00, 60.00, 'A', 'Excellent', '2025-11-17 12:32:14', '2025-11-17 12:32:14', NULL);

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`, `motto`, `address`, `phone`, `email`, `whatsapp_number`, `facebook`, `twitter`, `instagram`, `logo_path`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Tauheed Academy', 'Nuturing Future Leaders', 'Maniru Road\r\n', '', '', '', '', '', '', NULL, '2025-11-05 14:32:05', '2025-11-10 12:00:04', NULL);

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `description`, `head_teacher_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Nursery', 'pre primary Education', 1, '2025-11-06 09:29:24', '2025-11-06 09:29:24', NULL),
(2, 'Senoir Secondary', 'senior secondary section', 3, '2025-11-06 09:30:15', '2025-11-06 09:30:15', NULL),
(3, 'Junior Secondary', 'Junior Secondary', 3, '2025-11-06 09:30:46', '2025-11-06 09:30:46', NULL),
(4, 'Primary', 'Basic Education', 3, '2025-11-07 10:43:02', '2025-11-07 10:43:02', NULL),
(5, 'Tahfeez', 'Islamiyya', 2, '2025-11-10 12:49:47', '2025-11-10 12:49:47', NULL);

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `name`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2023/2024', '2024-01-01', '2024-12-31', 'pending', '2025-11-07 14:15:27', '2025-11-25 14:51:12', NULL),
(2, '2024/2025', '2025-01-01', '2025-12-31', 'pending', '2025-11-07 15:14:02', '2025-11-25 14:51:12', NULL),
(3, '2025/2026', '2026-01-01', '2026-12-31', 'pending', '2025-11-10 09:21:50', '2025-11-25 14:51:12', NULL),
(4, '2022/2023', '2023-01-01', '2023-12-31', 'pending', '2025-11-10 11:55:38', '2025-11-25 14:51:12', NULL),
(5, '2026/2027', '2027-01-01', '2028-12-31', 'pending', '2025-11-10 11:56:25', '2025-11-25 14:51:12', NULL);

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
  `reset_expires` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `admission_number`, `email`, `phone`, `guardian_id`, `dob`, `picture`, `password`, `reset_token`, `status`, `gender`, `class_id`, `arm_id`, `term_id`, `created_at`, `updated_at`, `reset_expires`, `deleted_at`) VALUES
(1, 'Abdulrahman Faruk Kalgo', '25/04/001', 'student@email.com', '09061893504', 4, '2005-01-01', NULL, '$2y$10$ocPaYzJd91p9wDzMYHrJ5uQ0aZmNTzFhcfTzFUmoWX01wd18e/Nb2', NULL, 'active', 'male', 1, 1, 1, '2025-11-13 09:49:29', '2025-11-20 05:39:31', NULL, NULL),
(2, 'Sagir yusuf Kaoje', '25/04/002', '', '', 1, '2022-12-12', NULL, '$2y$10$irkhT8/EmOsB8/9CzoajRe6T.HxMV3E2ncG/XMrZ6Qw0NGGb5ADye', NULL, 'active', 'male', 1, 2, 1, '2025-11-13 11:54:58', '2025-11-19 15:25:39', NULL, NULL),
(3, 'Samir Yusuf', '25/04/003', '', '', 1, '2018-01-01', NULL, '$2y$10$irkhT8/EmOsB8/9CzoajRe6T.HxMV3E2ncG/XMrZ6Qw0NGGb5ADye', NULL, 'active', 'male', 2, 1, 1, '2025-11-15 00:26:26', '2025-11-19 15:25:39', NULL, NULL),
(4, 'Kabir Ysusf kaoje', '25/04/004', 'student2@email.com', '', 1, '2018-01-01', NULL, '$2y$10$irkhT8/EmOsB8/9CzoajRe6T.HxMV3E2ncG/XMrZ6Qw0NGGb5ADye', NULL, 'active', 'female', 4, 1, 2, '2025-11-17 14:08:23', '2025-11-19 15:25:39', NULL, NULL),
(5, 'Sadiaya F K', '25/04/005', '', '', 4, '2002-12-12', NULL, '$2y$10$irkhT8/EmOsB8/9CzoajRe6T.HxMV3E2ncG/XMrZ6Qw0NGGb5ADye', NULL, 'active', 'female', 4, 1, 1, '2025-11-17 13:07:23', '2025-11-19 15:25:39', NULL, NULL);

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_class_records`
--

INSERT INTO `student_class_records` (`id`, `student_id`, `session_id`, `class_id`, `arm_id`, `overall_total`, `overall_average`, `overall_position`, `promotion_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, 1, 0.00, 0.00, NULL, 'pending', '2025-11-17 07:47:32', '2025-11-17 07:47:32', NULL),
(2, 2, 1, 1, 2, 0.00, 0.00, NULL, 'pending', '2025-11-17 07:49:27', '2025-11-17 07:49:27', NULL),
(3, 4, 1, 4, 1, 0.00, 0.00, NULL, 'pending', '2025-11-17 14:08:25', '2025-11-17 14:08:25', NULL),
(4, 5, 1, 4, 1, 0.00, 0.00, NULL, 'pending', '2025-11-17 13:07:23', '2025-11-17 13:07:23', NULL);

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_term_records`
--

INSERT INTO `student_term_records` (`id`, `student_class_record_id`, `term_id`, `total_marks`, `average_marks`, `position_in_class`, `class_size`, `overall_grade`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 55.00, 55.00, 1, 2, NULL, '2025-11-17 07:49:25', '2025-11-17 11:34:40', NULL),
(2, 2, 1, 37.00, 37.00, 2, 2, NULL, '2025-11-17 07:49:28', '2025-11-17 11:34:40', NULL),
(3, 1, 2, 139.00, 69.50, 2, 2, NULL, '2025-11-17 07:52:44', '2025-11-17 12:32:18', NULL),
(4, 2, 2, 175.00, 87.50, 1, 2, NULL, '2025-11-17 07:52:45', '2025-11-17 12:32:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Mathematics', '2025-11-06 12:22:34', '2025-11-06 12:22:34', NULL),
(2, 'English', '2025-11-06 13:47:06', '2025-11-06 13:47:06', NULL),
(3, 'bology', '2025-11-06 13:50:44', '2025-11-06 13:50:44', NULL),
(4, 'Basic Technology', '2025-11-06 14:04:36', '2025-11-10 11:41:24', NULL),
(5, 'Quantitave Reasoning', '2025-11-07 08:47:33', '2025-11-07 08:47:33', NULL),
(6, 'Geography', '2025-11-10 10:45:51', '2025-11-10 10:45:51', NULL),
(7, 'Economics', '2025-11-10 10:49:18', '2025-11-10 10:49:18', NULL),
(8, 'Basic Science', '2025-11-10 11:41:53', '2025-11-10 11:41:53', NULL);

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
  `reset_expires` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `email`, `phone`, `address`, `qualification`, `staff_no`, `status`, `picture_path`, `password`, `reset_token`, `created_at`, `updated_at`, `gender`, `experience`, `reset_expires`, `deleted_at`) VALUES
(1, 'Mudassir Ahmad Adili', 'teacher@email.com', '09061893504', 'Maniru Road sokoto', 'B.Sc Mathematics', 'ST/2025/002', 'active', NULL, '$2y$10$HSFjpGyvC0kU5gXC5Ke/XOW0YpOc9pT3/8p4HRoQ0Ur5zOGK/2R7.', NULL, '2025-11-06 07:43:31', '2025-11-22 16:14:35', 'male', NULL, NULL, NULL),
(2, 'Nasir Ahmad Adili', 'nasir@email.com', '09061893504', 'Maniru Road', 'B.Sc Computer Science', 'ST/2025/001', 'active', NULL, '$2y$10$SRxpNUZjWZ2YOemv54dv1O1iqPAKblCMsSvEbbgvZlv6nqC2J24HS', NULL, '2025-11-06 09:26:51', '2025-11-17 13:43:48', 'male', NULL, NULL, NULL),
(3, 'Abdullahi Ahmad Adili', 'abdullahi@email.com', '08012345678', 'Maniru Road', 'B.Sc Mathematics', 'ST/2025/003', 'active', NULL, '$2y$10$SRxpNUZjWZ2YOemv54dv1O1iqPAKblCMsSvEbbgvZlv6nqC2J24HS', NULL, '2025-11-06 09:28:47', '2025-11-17 13:43:48', 'male', NULL, NULL, NULL),
(4, 'Mubarak Ahmad Adili', 'mk@email.com', '09061893504', 'Arkilla', 'B.Sc Accouting', 'ST/2025/005', 'active', NULL, '$2y$10$SRxpNUZjWZ2YOemv54dv1O1iqPAKblCMsSvEbbgvZlv6nqC2J24HS', NULL, '2025-11-10 12:29:49', '2025-11-17 13:43:48', 'male', NULL, NULL, NULL),
(5, 'Abba Ahmad Adili', 'abba@email.com', '090 1934 4018', 'Kofar Marke', 'B.sc Animal Science', 'ST/2025/006', 'active', NULL, '$2y$10$SRxpNUZjWZ2YOemv54dv1O1iqPAKblCMsSvEbbgvZlv6nqC2J24HS', NULL, '2025-11-10 12:32:14', '2025-11-17 13:43:48', 'male', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_section`
--

CREATE TABLE `teacher_section` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `name`, `session_id`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'First Term', 1, '2024-01-01', '2024-04-30', 'finished', '2025-11-09 14:33:02', '2025-11-25 14:51:12', NULL),
(2, 'Second Term', 1, '2024-05-01', '2025-08-30', 'finished', '2025-11-09 14:43:45', '2025-11-25 14:51:12', NULL),
(3, 'First Term', 2, '2025-01-01', '2025-04-30', 'finished', '2025-11-10 07:37:42', '2025-11-25 14:51:12', NULL),
(4, 'Second Term', 2, '2025-04-01', '2025-08-31', 'finished', '2025-11-10 07:43:42', '2025-11-25 14:51:12', NULL),
(5, 'First Term', 3, '2026-01-01', '2026-04-30', 'ongoing', '2025-11-10 09:22:36', '2025-11-25 14:51:12', NULL),
(6, 'Second Term', 3, '2026-05-01', '2026-08-31', 'pending', '2025-11-10 11:57:28', '2025-11-25 14:51:12', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
