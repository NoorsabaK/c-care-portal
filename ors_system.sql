-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2026 at 09:18 PM
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
-- Database: `ors_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `details`, `ip_address`, `created_at`) VALUES
(1, 'PAT202605021026', 'appointment_booking', 'Booked appointment with ID: APT202605029574', '::1', '2026-05-02 17:44:13'),
(2, 'PAT202605021026', 'appointment_booking', 'Booked appointment with ID: APT202605093896', '::1', '2026-05-09 12:31:35'),
(3, 'PAT202605091740', 'appointment_booking', 'Booked appointment with ID: APT202605095416', '::1', '2026-05-09 12:41:59'),
(4, 'Noor', 'login', 'Admin logged in', '::1', '2026-05-09 18:00:55');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `phone`, `full_name`, `created_at`) VALUES
(2, 'admin', 'admin@ors.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1234567890', 'Super Admin', '2026-05-09 15:49:26'),
(3, 'admin2', 'admin2@ors.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1234567891', 'Admin User', '2026-05-09 15:49:26'),
(4, 'Noor', 'admin@1gmail.com', '$2y$10$tLimSIxxlHP7wXpws6GYFufLb1BLDvPIpmTbDPifIWGpubiwC7g8e', '09090909', 'khan', '2026-05-09 17:33:53');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `appointment_id` varchar(50) NOT NULL,
  `patient_id` varchar(50) NOT NULL,
  `hospital_id` varchar(50) NOT NULL,
  `appointment_type` enum('test','vaccination','consultation') NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('pending','confirmed','completed','cancelled','missed') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `appointment_id`, `patient_id`, `hospital_id`, `appointment_type`, `appointment_date`, `appointment_time`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'APT202605029574', 'PAT202605021026', 'HOS001', 'test', '2060-05-06', '10:00:00', 'pending', '', '2026-05-02 17:44:13', '2026-05-02 17:44:13'),
(2, 'APT202605093896', 'PAT202605021026', 'HOS001', 'test', '0089-03-04', '10:00:00', 'pending', '67yu', '2026-05-09 12:31:35', '2026-05-09 12:31:35'),
(3, 'APT202605095416', 'PAT202605091740', 'HOS002', 'vaccination', '2026-05-13', '10:00:00', 'pending', 'nce', '2026-05-09 12:41:59', '2026-05-09 12:41:59');

-- --------------------------------------------------------

--
-- Table structure for table `covid_tests`
--

CREATE TABLE `covid_tests` (
  `id` int(11) NOT NULL,
  `test_id` varchar(50) NOT NULL,
  `patient_id` varchar(50) NOT NULL,
  `hospital_id` varchar(50) NOT NULL,
  `test_type` enum('PCR','Rapid Antigen','Antibody') DEFAULT 'PCR',
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `test_date` date DEFAULT NULL,
  `result_status` enum('pending','positive','negative','inconclusive') DEFAULT 'pending',
  `result_details` text DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE `hospitals` (
  `id` int(11) NOT NULL,
  `hospital_id` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `zip_code` varchar(20) DEFAULT NULL,
  `approval_status` enum('pending','approved','rejected') DEFAULT 'pending',
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`id`, `hospital_id`, `name`, `email`, `password`, `phone`, `address`, `city`, `state`, `zip_code`, `approval_status`, `registration_date`) VALUES
(1, 'HOS202605096434', 'Agha Khan', 'aghakhan@gmail.com', '$2y$10$Wo6Dc.L8Bkv6WvxFreKkh.HHBQwzy/vfNndaVUpAxyowqQCBcUddO', '22334455661', 'karachi', 'karachi', 'sindh', '75850', 'approved', '2026-05-09 12:55:35');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `patient_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `blood_group` varchar(5) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `patient_id`, `name`, `email`, `phone`, `password`, `date_of_birth`, `gender`, `address`, `city`, `blood_group`, `registration_date`) VALUES
(1, 'PAT202605021026', 'Noor', 'noor@gmail.com', '09090909', '$2y$10$d8Tb4VngezEDvSAkuYdQquN/VFv6qBBRsjZ8agXT3jYhFdVQ4Utwq', '2007-02-05', 'female', 'flat-1c block', 'lahore', NULL, '2026-05-02 17:43:17'),
(2, 'PAT202605091740', 'Ali', 'ali@gmail.com', '1234567890', '$2y$10$FvC23iinkq/4BdGLKpPR9eqTDnNAkd4q2bfylnyfB21314xLUsode', NULL, NULL, NULL, NULL, NULL, '2026-05-09 12:41:59'),
(3, 'PAT202605091372', 'kashif', 'kashif@gmail.com', '23453535890', '$2y$10$ygAgGe3Nd6Wv3TNj7HirbuAHpzK8DbxU1Nvh37t7QvUsEH3FSfjx.', '2026-05-14', 'male', 'hhahiiha', 'lahore', NULL, '2026-05-09 12:48:07');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `request_id` varchar(50) NOT NULL,
  `patient_id` varchar(50) NOT NULL,
  `hospital_id` varchar(50) NOT NULL,
  `request_type` enum('test','vaccination') NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `hospital_remarks` text DEFAULT NULL,
  `processed_by` varchar(50) DEFAULT NULL,
  `processed_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_logs`
--

CREATE TABLE `sms_logs` (
  `id` int(11) NOT NULL,
  `recipient_phone` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `reference_id` varchar(50) DEFAULT NULL,
  `status` enum('pending','sent','failed') DEFAULT 'pending',
  `error_message` text DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vaccinations`
--

CREATE TABLE `vaccinations` (
  `id` int(11) NOT NULL,
  `vaccination_id` varchar(50) NOT NULL,
  `patient_id` varchar(50) NOT NULL,
  `hospital_id` varchar(50) NOT NULL,
  `vaccine_id` varchar(50) DEFAULT NULL,
  `dose_number` int(11) DEFAULT 1,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `vaccination_date` date DEFAULT NULL,
  `status` enum('scheduled','completed','cancelled','missed') DEFAULT 'scheduled',
  `certificate_file` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vaccines`
--

CREATE TABLE `vaccines` (
  `id` int(11) NOT NULL,
  `vaccine_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `manufacturer` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `dosage_interval` int(11) DEFAULT NULL,
  `total_doses` int(11) DEFAULT 2,
  `availability_status` enum('available','low_stock','unavailable') DEFAULT 'available',
  `quantity` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_action` (`action`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appointment_id` (`appointment_id`),
  ADD KEY `idx_patient` (`patient_id`),
  ADD KEY `idx_hospital` (`hospital_id`),
  ADD KEY `idx_date` (`appointment_date`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `covid_tests`
--
ALTER TABLE `covid_tests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `test_id` (`test_id`),
  ADD KEY `hospital_id` (`hospital_id`),
  ADD KEY `idx_patient` (`patient_id`),
  ADD KEY `idx_result` (`result_status`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hospital_id` (`hospital_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_approval` (`approval_status`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_id` (`patient_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_phone` (`phone`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `request_id` (`request_id`),
  ADD KEY `idx_patient` (`patient_id`),
  ADD KEY `idx_hospital` (`hospital_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_recipient` (`recipient_phone`);

--
-- Indexes for table `vaccinations`
--
ALTER TABLE `vaccinations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vaccination_id` (`vaccination_id`),
  ADD KEY `idx_patient` (`patient_id`),
  ADD KEY `idx_hospital` (`hospital_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `vaccines`
--
ALTER TABLE `vaccines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vaccine_id` (`vaccine_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `covid_tests`
--
ALTER TABLE `covid_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hospitals`
--
ALTER TABLE `hospitals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_logs`
--
ALTER TABLE `sms_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vaccinations`
--
ALTER TABLE `vaccinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vaccines`
--
ALTER TABLE `vaccines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `covid_tests`
--
ALTER TABLE `covid_tests`
  ADD CONSTRAINT `covid_tests_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `covid_tests_ibfk_2` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
