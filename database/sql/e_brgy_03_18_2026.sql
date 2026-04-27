-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2026 at 05:47 AM
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
-- Database: `e_brgy_03_15_2026`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_type` varchar(255) NOT NULL,
  `reference_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `scheduled_at` datetime NOT NULL,
  `status` enum('scheduled','rescheduled','completed','cancelled','no-show') NOT NULL DEFAULT 'scheduled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` char(36) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `auditable_type` varchar(255) NOT NULL,
  `auditable_id` bigint(20) UNSIGNED NOT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barangay_id_requests`
--

CREATE TABLE `barangay_id_requests` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `gender` varchar(24) NOT NULL,
  `age` int(24) NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `date_of_birth` date NOT NULL,
  `civil_status` enum('Single','Married','Widowed','Separated') DEFAULT 'Single',
  `email_address` varchar(255) DEFAULT NULL,
  `purok_zone` varchar(50) NOT NULL,
  `street_address` text NOT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_number` varchar(20) DEFAULT NULL,
  `blood_type` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') DEFAULT NULL,
  `valid_id_file_path` varchar(511) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('Pending','Verified','Rejected','') NOT NULL,
  `payment_status` enum('Pending','Paid') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay_id_requests`
--

INSERT INTO `barangay_id_requests` (`id`, `full_name`, `gender`, `age`, `reference_number`, `contact_number`, `date_of_birth`, `civil_status`, `email_address`, `purok_zone`, `street_address`, `emergency_contact_name`, `emergency_contact_number`, `blood_type`, `valid_id_file_path`, `created_at`, `updated_at`, `status`, `payment_status`) VALUES
(61, 'Garcia, Alexandria', 'Male', 0, 'BID-2026-00001', '09123213123', '2003-12-09', 'Single', 'aggabao.renz.abellanosa@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Corazon', '09123213123', 'A+', 'barangay_ids/ohFxCTC4tpKvIWv5HFnt19sOsaKEUkvTVysqflWG.png', '2026-03-05 23:28:26', '2026-03-11 06:26:20', 'Rejected', 'Pending'),
(62, 'Merge', 'Female', 0, 'BID-2026-00062', '09123213123', '2003-12-09', 'Single', 'aggabao.renz.abellanosa@gmail.com', 'Purok/Zone 1', '81', 'Corazon', '09123213123', 'A+', 'barangay_ids/I3P6NlwWE7w6SozwBQn4VImiYCFkQ3LtVSbdSwjJ.png', '2026-03-07 22:59:16', '2026-03-11 06:25:41', 'Verified', 'Pending'),
(63, 'Renz Aggabao', 'Female', 0, 'BID-2026-00063', '09123213123', '2003-09-16', 'Single', 'aggabao.renz.abellanosa@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Corazon', '09123213123', 'A+', 'barangay_ids/Dwbmiq2vKbusEvM9JHS2f0p7yLCmcBTW94eTViiT.pdf', '2026-03-08 02:01:53', '2026-03-11 06:25:24', 'Pending', 'Pending'),
(64, 'Tests', 'Female', 22, 'BID-2026-00064', '09123213123', '2003-08-16', 'Single', 'aggabao.renz.abellanosa@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Corazon', '09123213123', 'A+', 'barangay_ids/USiIpi5yfcJWYwnJcP6moRddNvKmhZONtgQ7vseX.pdf', '2026-03-08 03:41:26', '2026-03-08 11:47:22', 'Rejected', 'Pending'),
(65, 'Testinglang', 'Female', 45, 'BID-2026-00065', '09123213123', '2003-09-16', 'Single', 'garciaalexandria824@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Corazon', '09123213123', 'A+', 'barangay_ids/sMpsXCkQmrY0JS5PKIWDJMXz4MyvJX3pmHEJWgFl.png', '2026-03-08 17:53:29', '2026-03-15 10:45:35', 'Verified', 'Pending'),
(66, 'Testinglang', 'Female', 22, 'BID-2026-00066', '09123213123', '2003-09-16', 'Single', 'garciaalexandria824@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Corazon', '09123213123', 'A+', 'barangay_ids/PLVrLzP8TwHJtXVtHmFSphkhyn54sQUC0ILgI0CD.png', '2026-03-08 17:53:56', '2026-03-15 12:04:42', 'Rejected', 'Paid'),
(67, 'Russel Veloria', 'Male', 21, 'BID-2026-00067', '09123213123', '2004-09-25', 'Single', 'davesampaga0@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Corazon', '09123213123', 'A+', 'barangay_ids/U5o1mDNy52djUpcegpjjrgpL6rRcLRduijJEwOkb.png', '2026-03-10 22:36:03', '2026-03-15 12:00:32', 'Verified', 'Paid'),
(68, 'Russel Veloria', 'Male', 21, 'BID-2026-00068', '09123213123', '2004-09-25', 'Single', 'davesampaga0@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Corazon', '09123213123', 'A+', 'barangay_ids/KGJYzi0Xe8HcjYTcCuUNPsoD2GYxwkInHEA9Rr68.png', '2026-03-10 22:36:30', '2026-03-15 11:58:46', 'Rejected', 'Paid'),
(69, 'Dave Sampaga', 'Male', 20, 'BID-2026-00069', '09123213123', '2005-05-10', 'Single', 'garciaalexandria824@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Garcia, Alexandria', '09123213123', 'A+', 'barangay_ids/iFgDMaaUAtLVpv2GqdGPzG34JvNzK6qZbhPnAK5d.png', '2026-03-11 00:09:43', '2026-03-15 11:47:58', 'Verified', 'Paid'),
(70, 'Renz Aggabao', 'Male', 22, 'BID-2026-00070', '09123213123', '2003-12-09', 'Single', 'aggabao.renz.abellanosa@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Corazon', '09123213123', 'A+', 'barangay_ids/XWt6lEx2Y9SQrXTGhJ9Ze5dxyxjByuXl2HxMoVFG.png', '2026-03-17 08:02:05', '2026-03-17 08:02:05', 'Pending', 'Pending'),
(71, 'Renz A', 'Male', 22, 'BID-2026-00071', '09123213123', '2003-09-16', 'Single', 'aggabao.renz.abellanosa@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Corazon', '09123213123', 'A+', 'barangay_ids/dPaS4RJVLF7CtqZeN4wsucKapJ1Fll0TmTsbKYV7.png', '2026-03-17 09:24:38', '2026-03-17 17:42:13', 'Verified', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `case_updates`
--

CREATE TABLE `case_updates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_type` varchar(255) NOT NULL,
  `reference_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `event_type` varchar(255) NOT NULL,
  `old_status` varchar(255) DEFAULT NULL,
  `new_status` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `attachment_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coi_requests`
--

CREATE TABLE `coi_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `civil_status` varchar(50) NOT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `purok_zone` varchar(50) NOT NULL,
  `street_address` varchar(255) NOT NULL,
  `purpose_of_request` varchar(255) NOT NULL,
  `specific_purpose` varchar(255) DEFAULT NULL,
  `uploaded_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('Pending','Verified','Rejected','') NOT NULL,
  `payment_status` enum('Pending','Paid','','') NOT NULL,
  `gender` varchar(23) NOT NULL,
  `age` int(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coi_requests`
--

INSERT INTO `coi_requests` (`id`, `full_name`, `reference_number`, `contact_number`, `date_of_birth`, `civil_status`, `email_address`, `purok_zone`, `street_address`, `purpose_of_request`, `specific_purpose`, `uploaded_file`, `created_at`, `updated_at`, `status`, `payment_status`, `gender`, `age`) VALUES
(25, 'test2', 'COI-2026-00001', '09123213123', '2003-12-09', 'Single', 'aggabao.renz.abellanosa@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Scholarship', '5', 'coi_uploads/AbQsZ5CsYBLaHQvtOQUM1NNmJuteh8m3SnFgLNDk.png', '2026-03-05 19:30:01', '2026-03-06 13:06:44', 'Rejected', 'Pending', '', 0),
(26, 'test2', 'COI-2026-00026', '09123213123', '2003-12-09', 'Single', 'aggabao.renz.abellanosa@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Scholarship', '5', 'coi_uploads/nGzO0OwgaAQ0sptfuTfzwSvmOS1bfbpTdmB6aZHi.png', '2026-03-05 19:31:02', '2026-03-06 13:03:52', 'Rejected', 'Pending', '', 0),
(27, 'test2', 'COI-2026-00027', '09123213123', '2003-12-09', 'Single', 'aggabao.renz.abellanosa@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Scholarship', '5', 'coi_uploads/0LCQ3r2sGbLVB6vCipYUkhoMUpAq8h4f72O2f7J4.png', '2026-03-05 19:35:05', '2026-03-06 12:55:21', 'Rejected', 'Pending', '', 0),
(28, 'test2', 'COI-2026-00028', '09123213123', '2003-12-09', 'Single', 'aggabao.renz.abellanosa@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Scholarship', '5', 'coi_uploads/9lbsvJtYoZ2owNARHGd9GZyX4zlUwYGLlj7gzyFq.png', '2026-03-05 19:35:19', '2026-03-08 06:13:20', 'Rejected', 'Pending', '', 0),
(29, 'Tranilla', 'COI-2026-00029', '09123213123', '2003-12-09', 'Single', 'cd99322@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Scholarship', '5', 'coi_uploads/Y4q38mfX1d695DhMaMxmY9tpeB7RDj1ZOKWl3dkz.png', '2026-03-07 23:16:29', '2026-03-07 23:16:29', 'Pending', 'Pending', '', 0),
(30, 'Tranilla', 'COI-2026-00030', '09123213123', '2003-09-16', 'Single', 'cd99322@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Scholarship', '09123213123', 'coi_uploads/y6fxrR0kBIJDVGguLwsH64HugQGEcG5Iux9P4IG3.pdf', '2026-03-08 04:00:57', '2026-03-15 10:45:25', 'Pending', 'Pending', 'Male', 26),
(31, 'Renz Aggabao', 'COI-2026-00031', '09123213123', '2003-09-16', 'Single', 'aggabao.renz.abellanosa@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Scholarship', NULL, 'coi_uploads/TVacoklSwqGdtWHvdQ6SfvKG9zwXXrggsgdvUuSb.png', '2026-03-16 03:21:50', '2026-03-16 03:21:50', 'Pending', 'Pending', 'Male', 22);

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `incident_date` date NOT NULL,
  `incident_time` time NOT NULL,
  `location` text NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `type` varchar(255) NOT NULL,
  `severity` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `complainant_name` varchar(255) NOT NULL,
  `complainant_contact` varchar(255) NOT NULL,
  `respondent_name` varchar(255) NOT NULL,
  `respondent_address` varchar(255) DEFAULT NULL,
  `desired_resolution` varchar(255) DEFAULT NULL,
  `evidence_path` varchar(255) DEFAULT NULL,
  `additional_notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_requests`
--

CREATE TABLE `cor_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `gender` varchar(23) NOT NULL,
  `age` int(25) NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `civil_status` varchar(50) NOT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `purok_zone` varchar(50) NOT NULL,
  `street_address` varchar(255) NOT NULL,
  `purpose_of_request` varchar(255) NOT NULL,
  `years_of_residency` int(11) NOT NULL,
  `uploaded_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('Pending','Verified','Rejected','') NOT NULL,
  `payment_status` enum('Pending','Paid') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cor_requests`
--

INSERT INTO `cor_requests` (`id`, `full_name`, `gender`, `age`, `reference_number`, `contact_number`, `date_of_birth`, `civil_status`, `email_address`, `purok_zone`, `street_address`, `purpose_of_request`, `years_of_residency`, `uploaded_file`, `created_at`, `updated_at`, `status`, `payment_status`) VALUES
(13, 'Tranilla', '', 0, 'COR-2026-00001', '09123213123', '2003-12-09', 'Single', 'cd99322@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Employment', 5, NULL, '2026-03-07 23:19:25', '2026-03-07 23:19:25', 'Pending', 'Pending'),
(14, 'Tranillas', '', 0, 'COR-2026-00014', '09123213123', '2003-12-09', 'Single', 'cd99322@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'School Enrollment', 3, NULL, '2026-03-08 04:24:48', '2026-03-11 06:20:54', 'Verified', 'Pending'),
(15, 'Tran', 'Female', 4, 'COR-2026-00015', '09123213123', '2003-09-16', 'Married', 'cd99233@gmail.com', 'Purok/Zone 1', '006 Kabaitan St. Villareal', 'Employment', 3, NULL, '2026-03-08 04:30:46', '2026-03-08 13:15:38', 'Verified', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE `custom_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `field_for` enum('incident','complaint') NOT NULL DEFAULT 'incident',
  `field_label` varchar(255) NOT NULL,
  `field_type` varchar(255) NOT NULL,
  `field_description` text DEFAULT NULL,
  `field_options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`field_options`)),
  `field_rules` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_field_values`
--

CREATE TABLE `custom_field_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `custom_field_id` bigint(20) UNSIGNED NOT NULL,
  `complaint_id` bigint(20) UNSIGNED DEFAULT NULL,
  `incident_id` bigint(20) UNSIGNED DEFAULT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `education_data`
--

CREATE TABLE `education_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `resident_id` bigint(20) UNSIGNED NOT NULL,
  `educational_status` enum('Currently Studying','Graduated','Not Studying','N/A') NOT NULL DEFAULT 'N/A',
  `school_type` enum('Public','Private','N/A') NOT NULL DEFAULT 'N/A',
  `school_level` enum('Pre-School','Elementary','Junior High School','Senior High School','College','Vocational','Masteral','N/A') NOT NULL DEFAULT 'N/A',
  `school_name` varchar(200) DEFAULT NULL,
  `course_program` varchar(200) DEFAULT NULL,
  `highest_grade_completed` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `education_data`
--

INSERT INTO `education_data` (`id`, `resident_id`, `educational_status`, `school_type`, `school_level`, `school_name`, `course_program`, `highest_grade_completed`, `created_at`, `updated_at`) VALUES
(1, 1, 'N/A', 'N/A', 'N/A', NULL, NULL, 'N/A', '2026-03-17 15:57:45', '2026-03-17 15:57:45'),
(2, 2, 'N/A', 'N/A', 'N/A', NULL, NULL, 'N/A', '2026-03-17 18:55:02', '2026-03-17 18:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `employment_data`
--

CREATE TABLE `employment_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `resident_id` bigint(20) UNSIGNED NOT NULL,
  `employment_status` varchar(50) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `employer_name` varchar(200) DEFAULT NULL,
  `work_address` varchar(255) DEFAULT NULL,
  `business_name` varchar(200) DEFAULT NULL,
  `business_type` varchar(100) DEFAULT NULL,
  `business_status` enum('Permanent','Contractual','Business Owner','Shared','Corporate','N/A') DEFAULT NULL,
  `income_source` enum('Employment','Business','Remittance','Investments','Others','N/A') DEFAULT NULL,
  `monthly_income` varchar(50) DEFAULT NULL,
  `income_bracket` enum('Below 10,000','10,000 - 20,000','20,001 - 30,000','30,001 - 50,000','Above 50,000','N/A') NOT NULL DEFAULT 'N/A',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employment_data`
--

INSERT INTO `employment_data` (`id`, `resident_id`, `employment_status`, `occupation`, `employer_name`, `work_address`, `business_name`, `business_type`, `business_status`, `income_source`, `monthly_income`, `income_bracket`, `created_at`, `updated_at`) VALUES
(1, 1, 'N/A', NULL, NULL, NULL, NULL, NULL, NULL, 'N/A', '0', 'N/A', '2026-03-17 15:57:45', '2026-03-17 15:57:45'),
(2, 2, 'N/A', NULL, NULL, NULL, NULL, NULL, NULL, 'N/A', '0', 'N/A', '2026-03-17 18:55:02', '2026-03-17 18:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `households`
--

CREATE TABLE `households` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `household_id` varchar(50) NOT NULL,
  `house_number` varchar(50) NOT NULL,
  `purok_id` bigint(20) UNSIGNED NOT NULL,
  `street_id` bigint(20) UNSIGNED NOT NULL,
  `head_resident_id` bigint(20) UNSIGNED DEFAULT NULL,
  `established_date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `wall_material` varchar(50) DEFAULT NULL,
  `roof_material` varchar(50) DEFAULT NULL,
  `water_source` varchar(50) DEFAULT NULL,
  `toilet_facility` varchar(50) DEFAULT NULL,
  `tenure_status` varchar(50) DEFAULT NULL,
  `num_families_reported` int(11) DEFAULT 1,
  `is_indigent` tinyint(1) DEFAULT 0,
  `admin_remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `households`
--

INSERT INTO `households` (`id`, `household_id`, `house_number`, `purok_id`, `street_id`, `head_resident_id`, `established_date`, `is_active`, `created_at`, `updated_at`, `deleted_at`, `wall_material`, `roof_material`, `water_source`, `toilet_facility`, `tenure_status`, `num_families_reported`, `is_indigent`, `admin_remarks`) VALUES
(1, 'HH-00001', '81 SItio Ruby', 2, 3, NULL, '2026-03-17', 1, '2026-03-17 15:58:46', '2026-03-17 15:58:46', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
(2, 'HH-00002', '23', 1, 1, 2, '2026-03-18', 1, '2026-03-17 18:55:47', '2026-03-17 18:55:47', NULL, 'Wood', 'G.I. Sheet', 'Maynilad', NULL, 'Rented', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `household_edit_logs`
--

CREATE TABLE `household_edit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `household_id` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED NOT NULL,
  `action_type` varchar(20) NOT NULL DEFAULT 'edit',
  `field_changed` varchar(255) DEFAULT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incidents`
--

CREATE TABLE `incidents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `evidence_path` varchar(255) DEFAULT NULL,
  `location` text NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `additional_notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incident_incident_type`
--

CREATE TABLE `incident_incident_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `incident_id` bigint(20) UNSIGNED NOT NULL,
  `incident_type_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incident_types`
--

CREATE TABLE `incident_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_custom` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incident_types`
--

INSERT INTO `incident_types` (`id`, `name`, `is_custom`) VALUES
(1, 'Waste Management ', 0),
(2, 'Flooding', 0),
(3, 'Pollution', 0),
(4, 'Traffic ', 0),
(5, 'Infrastructure', 0),
(6, 'Water Supply', 0),
(7, 'Public Safety', 0);

-- --------------------------------------------------------

--
-- Table structure for table `marital_statuses`
--

CREATE TABLE `marital_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marital_statuses`
--

INSERT INTO `marital_statuses` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Single', '2026-02-14 10:51:10', '2026-02-14 10:51:10'),
(2, 'Married', '2026-02-14 10:51:10', '2026-02-14 10:51:10'),
(3, 'Living-in', '2026-02-14 10:51:10', '2026-02-14 10:51:10'),
(4, 'Widowed', '2026-02-14 10:51:10', '2026-02-14 10:51:10'),
(5, 'Separated', '2026-02-14 10:51:10', '2026-02-14 10:51:10'),
(6, 'Divorced', '2026-02-14 10:51:10', '2026-02-14 10:51:10'),
(7, 'Unknown', '2026-02-14 10:51:10', '2026-02-14 10:51:10');

-- --------------------------------------------------------

--
-- Table structure for table `nationalities`
--

CREATE TABLE `nationalities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nationalities`
--

INSERT INTO `nationalities` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Filipino', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(2, 'American', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(3, 'Chinese', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(4, 'Japanese', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(5, 'Korean', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(6, 'Taiwanese', '2026-02-10 17:31:20', '2026-02-10 17:31:20'),
(7, 'Indian', '2026-02-15 02:06:19', '2026-02-15 02:06:19'),
(8, 'Indonesian', '2026-02-15 02:08:17', '2026-02-15 02:08:17'),
(9, 'Brazilian', '2026-02-15 02:19:14', '2026-02-15 02:19:14'),
(10, 'Russian', '2026-02-15 04:35:09', '2026-02-15 04:35:09');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
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
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(2, 'App\\Models\\User', 3, 'api-token', '2751e48d1b37c1694cd42fe1683d42dd28c0df043b6490795847794040a1af95', '[\"*\"]', '2026-03-15 12:12:31', NULL, '2026-03-15 04:11:10', '2026-03-15 12:12:31'),
(4, 'App\\Models\\User', 3, 'api-token', '6442493f14f2eb474290a9d6d65045f70846e1664877a275a4b55e3a0196f93a', '[\"*\"]', '2026-03-17 08:49:33', NULL, '2026-03-17 07:51:18', '2026-03-17 08:49:33'),
(6, 'App\\Models\\User', 3, 'api-token', 'df890eeb200e9bf29b3b7209b724e8d07812d8ff3dfdc11f5c89e1af77683f78', '[\"*\"]', '2026-03-17 18:03:59', NULL, '2026-03-17 09:25:14', '2026-03-17 18:03:59'),
(9, 'App\\Models\\User', 6, 'api-token', '92af3f4f8edd2fad5ec53cf33fcbfd837f5bd36c0be25eb1f83ce3a9f5a7a8c1', '[\"*\"]', '2026-03-17 12:34:15', NULL, '2026-03-17 10:57:03', '2026-03-17 12:34:15'),
(11, 'App\\Models\\User', 5, 'api-token', 'fda21b6ba1ee22300850dabe2776d9d739b871980fc7b28c4b42384d33db1049', '[\"*\"]', '2026-03-17 20:46:58', NULL, '2026-03-17 20:36:28', '2026-03-17 20:46:58'),
(12, 'App\\Models\\User', 3, 'api-token', '1b4c4d96eb6bbc342a32e9b0e0aa526d33fe5c70528b1c74fb8639de63dd80e1', '[\"*\"]', '2026-03-17 20:46:59', NULL, '2026-03-17 20:38:30', '2026-03-17 20:46:59');

-- --------------------------------------------------------

--
-- Table structure for table `puroks`
--

CREATE TABLE `puroks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `puroks`
--

INSERT INTO `puroks` (`id`, `number`, `name`, `created_at`, `updated_at`) VALUES
(1, '1', 'Purok 1', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(2, '2', 'Purok 2', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(3, '3', 'Purok 3', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(4, '4', 'Purok 4', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(5, '5', 'Purok 5', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(6, '6', 'Purok 6', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(7, '7', 'Purok 7', '2026-02-09 19:46:35', '2026-02-09 19:46:35');

-- --------------------------------------------------------

--
-- Table structure for table `residents`
--

CREATE TABLE `residents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `barangay_id` varchar(50) DEFAULT NULL,
  `tracking_number` varchar(50) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `birthdate` date NOT NULL,
  `birth_registration` enum('Registered','Not Registered') DEFAULT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `contact_number` varchar(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `temp_house_number` varchar(50) DEFAULT NULL,
  `temp_purok_id` bigint(20) UNSIGNED DEFAULT NULL,
  `temp_street_id` bigint(20) UNSIGNED DEFAULT NULL,
  `household_id` bigint(20) UNSIGNED DEFAULT NULL,
  `household_position` enum('Head of Family','Spouse','Son','Daughter','Relative','Househelp','Others') NOT NULL,
  `marital_status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nationality_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `sector_id` bigint(20) UNSIGNED DEFAULT NULL,
  `residency_status` enum('Old Resident','New Resident') DEFAULT NULL,
  `residency_start_date` date DEFAULT NULL,
  `is_voter` tinyint(1) DEFAULT 0,
  `id_type` varchar(50) DEFAULT NULL,
  `id_front_path` varchar(255) NOT NULL,
  `id_back_path` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `visit_set_at` datetime DEFAULT NULL,
  `visit_set_by` bigint(20) UNSIGNED DEFAULT NULL,
  `rejection_reason` varchar(255) DEFAULT NULL,
  `rejection_remarks` text DEFAULT NULL,
  `rejected_by` bigint(20) UNSIGNED DEFAULT NULL,
  `registration_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`registration_payload`)),
  `verified_at` timestamp NULL DEFAULT NULL,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `residents`
--

INSERT INTO `residents` (`id`, `barangay_id`, `tracking_number`, `first_name`, `middle_name`, `last_name`, `suffix`, `birthdate`, `birth_registration`, `gender`, `contact_number`, `email`, `temp_house_number`, `temp_purok_id`, `temp_street_id`, `household_id`, `household_position`, `marital_status_id`, `nationality_id`, `sector_id`, `residency_status`, `residency_start_date`, `is_voter`, `id_type`, `id_front_path`, `id_back_path`, `status`, `visit_set_at`, `visit_set_by`, `rejection_reason`, `rejection_remarks`, `rejected_by`, `registration_payload`, `verified_at`, `verified_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '26-00001', 'BGN08734', 'Renz', 'A', 'Aggabao', NULL, '2003-09-16', 'Registered', 'Male', '09351111111', 'aggabaorenz16@gmail.com', '81 SItio Ruby', 2, 3, 1, 'Spouse', 1, 1, 7, 'Old Resident', '2003-12-09', 1, NULL, 'resident_ids/front/w1FyPc0tLQFIygQhRBN8ZT481WVFlRLmGkzC8kK2.jpg', 'resident_ids/back/yPvStHirjWDzr8RCG9GqouVdb7T878nqDxshoCN3.jpg', 'Verified', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-17 15:58:46', 3, '2026-03-17 15:57:45', '2026-03-17 15:58:46', NULL),
(2, '26-00002', 'BGN08233', 'Renz TV', 'A', 'Aggabao', 'Jr.', '2003-09-16', 'Registered', 'Male', '09911111111', 'aggabaotest@gmail.com', '23', 1, 1, 2, 'Head of Family', 1, 1, 3, 'Old Resident', '1998-12-12', 1, NULL, 'resident_ids/front/OHbncZH7oLVLG6wSzNa7kLAWITF1v9wwWqbK7CrW.jpg', 'resident_ids/back/N7NohAVGMbren5k7P0wv7CfzI3a9thaGM963MxV2.jpg', 'Verified', NULL, NULL, NULL, NULL, NULL, '{\"tenure_status\":\"Rented\",\"wall_material\":\"Wood\",\"roof_material\":\"G.I. Sheet\",\"water_source\":\"Maynilad\",\"num_families_reported\":\"1\"}', '2026-03-17 18:55:47', 5, '2026-03-17 18:55:02', '2026-03-17 18:55:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `residents_update_logs`
--

CREATE TABLE `residents_update_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `resident_id` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `action_type` varchar(50) NOT NULL DEFAULT 'update',
  `field_changed` varchar(100) DEFAULT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `resident_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sectors`
--

CREATE TABLE `sectors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sectors`
--

INSERT INTO `sectors` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Solo Parent', 'Single parents with custody of children', 1, '2026-02-14 11:33:59', '2026-02-14 11:33:59'),
(2, 'PWD', 'Persons with Disabilities', 1, '2026-02-14 11:33:59', '2026-02-14 11:33:59'),
(3, 'Senior Citizen', 'Residents aged 60 and above', 1, '2026-02-14 11:33:59', '2026-02-14 11:33:59'),
(4, 'LGBTQIA+', 'Inclusivity sector for diverse orientations', 1, '2026-02-14 11:33:59', '2026-02-14 11:33:59'),
(5, 'Kasambahay', 'Domestic workers within the barangay', 1, '2026-02-14 11:33:59', '2026-02-14 11:33:59'),
(6, 'OFW', 'Overseas Filipino Workers', 1, '2026-02-14 11:33:59', '2026-02-14 11:33:59'),
(7, 'General Population', 'Regular residents with no special sector classification', 1, '2026-02-14 11:36:39', '2026-02-14 11:36:39');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `streets`
--

CREATE TABLE `streets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purok_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `streets`
--

INSERT INTO `streets` (`id`, `purok_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sisa St.', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(2, 1, 'Crisostomo St.', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(3, 2, 'Ibarra St.', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(4, 2, 'Elias St.', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(5, 3, 'Maria Clara St.', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(6, 3, 'Basilio St.', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(7, 4, 'Salvi St.', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(8, 4, 'Victoria St.', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(9, 5, 'Tiago St.', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(10, 5, 'Tasio St.', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(11, 6, 'Guevarra St.', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(12, 6, 'Sinang St.', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(13, 7, 'Alfarez St.', '2026-02-09 19:46:35', '2026-02-09 19:46:35'),
(14, 7, 'Doña Victorina St.', '2026-02-09 19:46:35', '2026-02-09 19:46:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `resident_id` bigint(20) UNSIGNED DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff','resident') DEFAULT 'resident',
  `qr_token` varchar(64) DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `must_change_password` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `resident_id`, `username`, `password`, `role`, `qr_token`, `last_login_at`, `must_change_password`, `is_active`, `created_at`, `updated_at`, `remember_token`) VALUES
(3, 'Admin User', 'admin@gmail.com', NULL, 'admin', '$2y$12$pt.n./gWzboxdZjZzRrLueqzmZT8/CYy52sGBH91HhmjGdaF1hpNW', 'admin', NULL, NULL, 1, 1, '2026-03-15 04:09:41', '2026-03-15 04:09:41', NULL),
(4, 'Renz Aggabao', 'aggabaorenz16@gmail.com', 1, 'bgn00001', '$2y$12$6pqG7t/9buO5CzUHIjEGZO1sDpc5buFEmmHBDhLGtpNhgSQLtlmie', 'resident', '266ac0fe-9191-493d-a246-70e3cd692d4f', NULL, 0, 1, '2026-03-17 15:58:47', '2026-03-18 04:41:26', NULL),
(5, 'Renz', 'aggabaorenz17@gmail.com', NULL, 'renz.aggabao', '$2y$12$8JbpzkHN4FF8sGSl/oGYseGO.ql2P8kp2s2GoC2Pa1eEKW7suYWhe', 'admin', NULL, NULL, 0, 1, '2026-03-17 17:53:24', '2026-03-17 17:53:24', NULL),
(6, 'Renz TV Aggabao', 'aggabaotest@gmail.com', 2, 'bgn00002', '$2y$12$10HCbGJ0fAsn30NGkIVfQuNUpVovKbVzpeNYFY5YBHQcFxMZ7rs62', 'resident', '52d77aa8-5803-4a46-9151-11c9c8951151', NULL, 1, 1, '2026-03-17 18:55:52', '2026-03-17 18:55:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `witnesses`
--

CREATE TABLE `witnesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `complaint_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_reference_type_reference_id_index` (`reference_type`,`reference_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`),
  ADD KEY `audit_logs_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`),
  ADD KEY `audit_logs_batch_id_index` (`batch_id`);

--
-- Indexes for table `barangay_id_requests`
--
ALTER TABLE `barangay_id_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_updates`
--
ALTER TABLE `case_updates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_updates_reference_type_reference_id_index` (`reference_type`,`reference_id`),
  ADD KEY `case_updates_user_id_foreign` (`user_id`);

--
-- Indexes for table `coi_requests`
--
ALTER TABLE `coi_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaints_user_id_foreign` (`user_id`);

--
-- Indexes for table `cor_requests`
--
ALTER TABLE `cor_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_field_values`
--
ALTER TABLE `custom_field_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_field_values_custom_field_id_foreign` (`custom_field_id`),
  ADD KEY `custom_field_values_complaint_id_foreign` (`complaint_id`),
  ADD KEY `custom_field_values_incident_id_foreign` (`incident_id`);

--
-- Indexes for table `education_data`
--
ALTER TABLE `education_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `education_data_resident_id_index` (`resident_id`);

--
-- Indexes for table `employment_data`
--
ALTER TABLE `employment_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employment_data_resident_id_index` (`resident_id`);

--
-- Indexes for table `households`
--
ALTER TABLE `households`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_address` (`house_number`,`street_id`,`purok_id`),
  ADD UNIQUE KEY `households_household_id_unique` (`household_id`),
  ADD UNIQUE KEY `household_id` (`household_id`),
  ADD KEY `households_purok_id_foreign` (`purok_id`),
  ADD KEY `households_street_id_foreign` (`street_id`),
  ADD KEY `households_head_resident_id_index` (`head_resident_id`);

--
-- Indexes for table `household_edit_logs`
--
ALTER TABLE `household_edit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_logs_updated_by` (`updated_by`),
  ADD KEY `idx_hel_action_type` (`action_type`),
  ADD KEY `idx_hel_household_created` (`household_id`,`created_at`);

--
-- Indexes for table `incidents`
--
ALTER TABLE `incidents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incidents_user_id_foreign` (`user_id`);

--
-- Indexes for table `incident_incident_type`
--
ALTER TABLE `incident_incident_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incident_incident_type_incident_id_foreign` (`incident_id`),
  ADD KEY `incident_incident_type_incident_type_id_foreign` (`incident_type_id`);

--
-- Indexes for table `incident_types`
--
ALTER TABLE `incident_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marital_statuses`
--
ALTER TABLE `marital_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `marital_statuses_name_unique` (`name`);

--
-- Indexes for table `nationalities`
--
ALTER TABLE `nationalities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nationalities_name_unique` (`name`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `puroks`
--
ALTER TABLE `puroks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `puroks_number_unique` (`number`);

--
-- Indexes for table `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `residents_tracking_number_unique` (`tracking_number`),
  ADD UNIQUE KEY `residents_barangay_id_unique` (`barangay_id`),
  ADD UNIQUE KEY `barangay_id` (`barangay_id`),
  ADD KEY `residents_marital_status_id_foreign` (`marital_status_id`),
  ADD KEY `residents_nationality_id_foreign` (`nationality_id`),
  ADD KEY `residents_sector_id_foreign` (`sector_id`),
  ADD KEY `residents_verified_by_foreign` (`verified_by`),
  ADD KEY `residents_barangay_id_index` (`barangay_id`),
  ADD KEY `residents_tracking_number_index` (`tracking_number`),
  ADD KEY `residents_status_index` (`status`),
  ADD KEY `residents_household_id_index` (`household_id`),
  ADD KEY `residents_last_name_first_name_index` (`last_name`,`first_name`),
  ADD KEY `fk_residents_rejected_by` (`rejected_by`),
  ADD KEY `fk_visit_set_by` (`visit_set_by`);

--
-- Indexes for table `residents_update_logs`
--
ALTER TABLE `residents_update_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_rul_resident` (`resident_id`),
  ADD KEY `idx_rul_updated_by` (`updated_by`),
  ADD KEY `idx_rul_created_at` (`created_at`);

--
-- Indexes for table `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sectors_name_unique` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `streets`
--
ALTER TABLE `streets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `streets_purok_id_index` (`purok_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `resident_accounts_username_unique` (`username`),
  ADD UNIQUE KEY `resident_accounts_resident_id_unique` (`resident_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `qr_token_index` (`qr_token`),
  ADD KEY `resident_accounts_username_index` (`username`);

--
-- Indexes for table `witnesses`
--
ALTER TABLE `witnesses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `witnesses_complaint_id_foreign` (`complaint_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barangay_id_requests`
--
ALTER TABLE `barangay_id_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `case_updates`
--
ALTER TABLE `case_updates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coi_requests`
--
ALTER TABLE `coi_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cor_requests`
--
ALTER TABLE `cor_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_field_values`
--
ALTER TABLE `custom_field_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `education_data`
--
ALTER TABLE `education_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employment_data`
--
ALTER TABLE `employment_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `households`
--
ALTER TABLE `households`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `household_edit_logs`
--
ALTER TABLE `household_edit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incidents`
--
ALTER TABLE `incidents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incident_incident_type`
--
ALTER TABLE `incident_incident_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incident_types`
--
ALTER TABLE `incident_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `marital_statuses`
--
ALTER TABLE `marital_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `nationalities`
--
ALTER TABLE `nationalities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `puroks`
--
ALTER TABLE `puroks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `residents`
--
ALTER TABLE `residents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `residents_update_logs`
--
ALTER TABLE `residents_update_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sectors`
--
ALTER TABLE `sectors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `streets`
--
ALTER TABLE `streets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `witnesses`
--
ALTER TABLE `witnesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `case_updates`
--
ALTER TABLE `case_updates`
  ADD CONSTRAINT `case_updates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `custom_field_values`
--
ALTER TABLE `custom_field_values`
  ADD CONSTRAINT `custom_field_values_complaint_id_foreign` FOREIGN KEY (`complaint_id`) REFERENCES `complaints` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `custom_field_values_custom_field_id_foreign` FOREIGN KEY (`custom_field_id`) REFERENCES `custom_fields` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `custom_field_values_incident_id_foreign` FOREIGN KEY (`incident_id`) REFERENCES `incidents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `education_data`
--
ALTER TABLE `education_data`
  ADD CONSTRAINT `education_data_resident_id_foreign` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employment_data`
--
ALTER TABLE `employment_data`
  ADD CONSTRAINT `employment_data_resident_id_foreign` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `households`
--
ALTER TABLE `households`
  ADD CONSTRAINT `households_head_resident_id_foreign` FOREIGN KEY (`head_resident_id`) REFERENCES `residents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `households_purok_id_foreign` FOREIGN KEY (`purok_id`) REFERENCES `puroks` (`id`),
  ADD CONSTRAINT `households_street_id_foreign` FOREIGN KEY (`street_id`) REFERENCES `streets` (`id`);

--
-- Constraints for table `household_edit_logs`
--
ALTER TABLE `household_edit_logs`
  ADD CONSTRAINT `fk_logs_household_id` FOREIGN KEY (`household_id`) REFERENCES `households` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_logs_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `incidents`
--
ALTER TABLE `incidents`
  ADD CONSTRAINT `incidents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `incident_incident_type`
--
ALTER TABLE `incident_incident_type`
  ADD CONSTRAINT `incident_incident_type_incident_id_foreign` FOREIGN KEY (`incident_id`) REFERENCES `incidents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `incident_incident_type_incident_type_id_foreign` FOREIGN KEY (`incident_type_id`) REFERENCES `incident_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `residents`
--
ALTER TABLE `residents`
  ADD CONSTRAINT `fk_residents_rejected_by` FOREIGN KEY (`rejected_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_visit_set_by` FOREIGN KEY (`visit_set_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `residents_household_id_foreign` FOREIGN KEY (`household_id`) REFERENCES `households` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `residents_marital_status_id_foreign` FOREIGN KEY (`marital_status_id`) REFERENCES `marital_statuses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `residents_nationality_id_foreign` FOREIGN KEY (`nationality_id`) REFERENCES `nationalities` (`id`),
  ADD CONSTRAINT `residents_sector_id_foreign` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `residents_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `residents_update_logs`
--
ALTER TABLE `residents_update_logs`
  ADD CONSTRAINT `fk_rul_resident` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_rul_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `streets`
--
ALTER TABLE `streets`
  ADD CONSTRAINT `streets_purok_id_foreign` FOREIGN KEY (`purok_id`) REFERENCES `puroks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `resident_accounts_resident_id_foreign` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `witnesses`
--
ALTER TABLE `witnesses`
  ADD CONSTRAINT `witnesses_complaint_id_foreign` FOREIGN KEY (`complaint_id`) REFERENCES `complaints` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
