-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2025 at 08:26 AM
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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `reset_token`, `reset_expires`, `type`, `staff_no`, `address`, `qualification`, `experience`, `gender`, `department`, `status`, `phone`, `picture_path`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin@emial.com', '$2y$10$bUZPk9sINCfqwty1GQttsOCV0XmbW5vsmsusziT5JtifMQ4br2XjW', NULL, NULL, 'superAdmin', 'STAFF/A/001', 'addressaddress addressaddress', 'qualification qualificationqualification qualification', 'experienceexperience experienceexperience experience', 'male', 'Super Admin', 'active', '+234 01 23457 689', NULL, '2025-12-23 07:24:18', '2025-12-23 07:25:19');

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `class_class_arms`
--

CREATE TABLE `class_class_arms` (
  `class_id` int(11) NOT NULL,
  `arm_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `registration` decimal(10,2) DEFAULT NULL,
  `pta` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `islamiyya_classes`
--

CREATE TABLE `islamiyya_classes` (
  `id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `level` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `islamiyya_class_arms`
--

CREATE TABLE `islamiyya_class_arms` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `islamiyya_class_class_arms`
--

CREATE TABLE `islamiyya_class_class_arms` (
  `class_id` int(11) NOT NULL,
  `arm_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `islamiyya_class_subjects`
--

CREATE TABLE `islamiyya_class_subjects` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `islamiyya_fees`
--

CREATE TABLE `islamiyya_fees` (
  `id` int(11) NOT NULL,
  `islamiyya_class_id` int(11) NOT NULL,
  `first_term` decimal(10,2) DEFAULT NULL,
  `second_term` decimal(10,2) DEFAULT NULL,
  `third_term` decimal(10,2) DEFAULT NULL,
  `materials` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `islamiyya_results`
--

CREATE TABLE `islamiyya_results` (
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

-- --------------------------------------------------------

--
-- Table structure for table `islamiyya_sections`
--

CREATE TABLE `islamiyya_sections` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `head_teacher_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `islamiyya_student_class_records`
--

CREATE TABLE `islamiyya_student_class_records` (
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

-- --------------------------------------------------------

--
-- Table structure for table `islamiyya_student_term_records`
--

CREATE TABLE `islamiyya_student_term_records` (
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

-- --------------------------------------------------------

--
-- Table structure for table `islamiyya_subjects`
--

CREATE TABLE `islamiyya_subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`, `motto`, `address`, `phone`, `email`, `about_message`, `welcome_message`, `whatsapp_number`, `facebook`, `twitter`, `instagram`, `admission_number_format`, `admission_number_format_description`, `created_at`, `updated_at`) VALUES
(1, 'Tauheed Academy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-23 07:21:56', '2025-12-23 07:21:56');

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

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `picture_path` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `gender` enum('male','female') DEFAULT 'male',
  `class_id` int(11) DEFAULT NULL,
  `arm_id` int(11) DEFAULT NULL,
  `term_id` int(11) DEFAULT NULL,
  `islamiyya_class_id` int(11) DEFAULT NULL,
  `islamiyya_arm_id` int(11) DEFAULT NULL,
  `registration_session_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_section`
--

CREATE TABLE `teacher_section` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Indexes for table `islamiyya_classes`
--
ALTER TABLE `islamiyya_classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `level` (`level`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `islamiyya_class_arms`
--
ALTER TABLE `islamiyya_class_arms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `islamiyya_class_class_arms`
--
ALTER TABLE `islamiyya_class_class_arms`
  ADD PRIMARY KEY (`class_id`,`arm_id`),
  ADD KEY `arm_id` (`arm_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `islamiyya_class_subjects`
--
ALTER TABLE `islamiyya_class_subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `class_id` (`class_id`,`subject_id`,`teacher_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `islamiyya_fees`
--
ALTER TABLE `islamiyya_fees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_islamiyya_fees_class` (`islamiyya_class_id`);

--
-- Indexes for table `islamiyya_results`
--
ALTER TABLE `islamiyya_results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_term_record_id` (`student_term_record_id`,`subject_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `islamiyya_sections`
--
ALTER TABLE `islamiyya_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `head_teacher_id` (`head_teacher_id`);

--
-- Indexes for table `islamiyya_student_class_records`
--
ALTER TABLE `islamiyya_student_class_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`session_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `arm_id` (`arm_id`);

--
-- Indexes for table `islamiyya_student_term_records`
--
ALTER TABLE `islamiyya_student_term_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_class_record_id` (`student_class_record_id`,`term_id`),
  ADD KEY `term_id` (`term_id`);

--
-- Indexes for table `islamiyya_subjects`
--
ALTER TABLE `islamiyya_subjects`
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
  ADD KEY `term_id` (`term_id`),
  ADD KEY `islamiyya_class_id` (`islamiyya_class_id`),
  ADD KEY `islamiyya_arm_id` (`islamiyya_arm_id`),
  ADD KEY `registration_session_id` (`registration_session_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class_arms`
--
ALTER TABLE `class_arms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class_subjects`
--
ALTER TABLE `class_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `islamiyya_classes`
--
ALTER TABLE `islamiyya_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `islamiyya_class_arms`
--
ALTER TABLE `islamiyya_class_arms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `islamiyya_class_subjects`
--
ALTER TABLE `islamiyya_class_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `islamiyya_fees`
--
ALTER TABLE `islamiyya_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `islamiyya_results`
--
ALTER TABLE `islamiyya_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `islamiyya_sections`
--
ALTER TABLE `islamiyya_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `islamiyya_student_class_records`
--
ALTER TABLE `islamiyya_student_class_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `islamiyya_student_term_records`
--
ALTER TABLE `islamiyya_student_term_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `islamiyya_subjects`
--
ALTER TABLE `islamiyya_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_class_records`
--
ALTER TABLE `student_class_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_term_records`
--
ALTER TABLE `student_term_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacher_section`
--
ALTER TABLE `teacher_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `islamiyya_classes`
--
ALTER TABLE `islamiyya_classes`
  ADD CONSTRAINT `islamiyya_classes_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `islamiyya_sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `islamiyya_class_class_arms`
--
ALTER TABLE `islamiyya_class_class_arms`
  ADD CONSTRAINT `islamiyya_class_class_arms_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `islamiyya_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `islamiyya_class_class_arms_ibfk_2` FOREIGN KEY (`arm_id`) REFERENCES `islamiyya_class_arms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `islamiyya_class_class_arms_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `islamiyya_class_subjects`
--
ALTER TABLE `islamiyya_class_subjects`
  ADD CONSTRAINT `islamiyya_class_subjects_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `islamiyya_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `islamiyya_class_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `islamiyya_subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `islamiyya_class_subjects_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `islamiyya_fees`
--
ALTER TABLE `islamiyya_fees`
  ADD CONSTRAINT `fk_islamiyya_fees_class` FOREIGN KEY (`islamiyya_class_id`) REFERENCES `islamiyya_classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `islamiyya_results`
--
ALTER TABLE `islamiyya_results`
  ADD CONSTRAINT `islamiyya_results_ibfk_1` FOREIGN KEY (`student_term_record_id`) REFERENCES `islamiyya_student_term_records` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `islamiyya_results_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `islamiyya_subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `islamiyya_sections`
--
ALTER TABLE `islamiyya_sections`
  ADD CONSTRAINT `islamiyya_sections_ibfk_1` FOREIGN KEY (`head_teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `islamiyya_student_class_records`
--
ALTER TABLE `islamiyya_student_class_records`
  ADD CONSTRAINT `islamiyya_student_class_records_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `islamiyya_student_class_records_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `islamiyya_student_class_records_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `islamiyya_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `islamiyya_student_class_records_ibfk_4` FOREIGN KEY (`arm_id`) REFERENCES `islamiyya_class_arms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `islamiyya_student_term_records`
--
ALTER TABLE `islamiyya_student_term_records`
  ADD CONSTRAINT `islamiyya_student_term_records_ibfk_1` FOREIGN KEY (`student_class_record_id`) REFERENCES `islamiyya_student_class_records` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `islamiyya_student_term_records_ibfk_2` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `students_ibfk_4` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_ibfk_5` FOREIGN KEY (`islamiyya_class_id`) REFERENCES `islamiyya_classes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_ibfk_6` FOREIGN KEY (`islamiyya_arm_id`) REFERENCES `islamiyya_class_arms` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_ibfk_7` FOREIGN KEY (`registration_session_id`) REFERENCES `sessions` (`id`) ON DELETE SET NULL;

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
