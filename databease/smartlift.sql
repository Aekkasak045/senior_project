-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2024 at 04:51 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smartlift`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_calls`
--

CREATE TABLE `app_calls` (
  `id` int(11) NOT NULL,
  `lift_id` int(11) NOT NULL,
  `floor_no` varchar(3) NOT NULL DEFAULT '1',
  `direction` char(1) NOT NULL DEFAULT 'U',
  `client_id` varchar(30) NOT NULL,
  `is_processed` enum('N','Y') NOT NULL DEFAULT 'N',
  `created_user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_calls1`
--

CREATE TABLE `app_calls1` (
  `id` int(11) NOT NULL,
  `lift_id` int(11) NOT NULL,
  `floor_no` varchar(3) NOT NULL DEFAULT '1',
  `direction` char(1) NOT NULL DEFAULT 'U',
  `client_id` varchar(30) NOT NULL,
  `is_processed` enum('N','Y') NOT NULL DEFAULT 'N',
  `created_user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE `building` (
  `id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `building_name` varchar(255) NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `update_user_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `building`
--

INSERT INTO `building` (`id`, `org_id`, `building_name`, `created_user_id`, `created_at`, `update_user_id`, `updated_at`) VALUES
(1, 1, 'อาคาร 19', 1, '2023-10-07 15:16:25', 1, '2023-10-07 15:16:25'),
(2, 2, 'อาคาร 1 เทคนิคสกล', 1, '2023-10-07 15:21:12', 1, '2023-10-07 15:21:12'),
(3, 3, 'อาคารเย็นศิระ', 1, '2023-10-07 15:21:35', 1, '2023-10-07 15:21:35'),
(4, 1, 'อาคาร 1', 1, '2023-10-10 20:01:06', 1, '2023-10-10 20:01:06');

-- --------------------------------------------------------

--
-- Table structure for table `lifts`
--

CREATE TABLE `lifts` (
  `id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `building_id` int(11) DEFAULT NULL,
  `lift_name` varchar(100) NOT NULL,
  `max_level` int(11) NOT NULL,
  `mac_address` varchar(30) NOT NULL,
  `floor_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `lift_state` char(12) NOT NULL DEFAULT '000000000000',
  `up_status` char(8) NOT NULL DEFAULT '00000000',
  `down_status` char(8) NOT NULL DEFAULT '00000000',
  `car_status` char(8) NOT NULL DEFAULT '00000000',
  `created_user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lifts`
--

INSERT INTO `lifts` (`id`, `org_id`, `building_id`, `lift_name`, `max_level`, `mac_address`, `floor_name`, `description`, `lift_state`, `up_status`, `down_status`, `car_status`, `created_user_id`, `created_at`, `updated_user_id`, `updated_at`) VALUES
(1, 1, 1, 'KUSE', 15, 'DEADBEEF01ED', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15', 'KUSE', '030900000000', '00000000', '00000000', '00000000', 1, '2022-10-31 11:41:50', 2, '2023-06-01 13:46:19'),
(2, 2, 2, 'SNKTC', 4, 'DEADBEEF02ED', '1,2,3,4', 'SNKTC', '018C00000000', '00000000', '00000000', '00000000', 1, '2022-12-06 03:08:32', 2, '2023-06-01 08:46:25'),
(3, 3, 3, 'FL1', 14, 'DEADBEEF03ED', '1,1A,2,2A,3,4,5,6,7,8,9,10,11,12', 'Fire Lift 1', '000000000000', '00000000', '00000000', '00000000', 1, '2023-06-01 14:10:50', 1, '2023-06-01 14:10:50'),
(4, 3, 3, 'PL1', 14, 'DEADBEEF04ED', '1,1A,2,2A,3,4,5,6,7,8,9,10,11,12', 'Patient 1', '000000000000', '00000000', '00000000', '00000000', 1, '2023-06-01 14:11:43', 1, '2023-06-01 14:11:43'),
(5, 3, 3, 'BL1', 14, 'DEADBEEF05ED', '1,1A,2,2A,3,4,5,6,7,8,9,10,11,12', 'Bed 1', '000000000000', '00000000', '00000000', '00000000', 1, '2023-06-01 14:12:17', 1, '2023-06-01 14:12:17'),
(6, 3, 3, 'PL2', 14, 'DEADBEEF06ED', '1,1A,2,2A,3,4,5,6,7,8,9,10,11,12', 'Patient 2', '000000000000', '00000000', '00000000', '00000000', 1, '2023-06-01 14:12:43', 1, '2023-06-01 14:12:43'),
(7, 3, 3, 'PL3', 14, 'DEADBEEF07ED', '1,1A,2,2A,3,4,5,6,7,8,9,10,11,12', 'Patient 3', '000000000000', '00000000', '00000000', '00000000', 1, '2023-06-01 14:13:10', 1, '2023-06-01 14:13:10'),
(8, 1, 4, 'CSC01', 4, 'DEADBEEF08ED', '1,2,3,4', 'Building 1', '000000000000', '00000000', '00000000', '00000000', 1, '2023-09-24 17:34:19', 1, '2023-09-24 17:34:19'),
(22, 18, NULL, 'TEST', 5, 'DEADBEEF09ED', '1,2,3,4,5', '', '000000000000', '00000000', '00000000', '00000000', 1, '2024-05-27 12:35:25', 1, '2024-05-27 12:35:25');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` int(11) NOT NULL,
  `org_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `org_name`, `description`, `created_user_id`, `created_at`, `updated_user_id`, `updated_at`) VALUES
(1, 'KU CSC', 'มหาวิทยาลัยเกษตรศาสตร์\r\nวิทยาเขตเฉลิมพระเกียรติ จังหวัดสกลนคร\r\n59 หมู่ 1 ถ.วปรอ 366 ต.เชียงเครือ อ.เมือง จ.สกลนคร 47000 โทรศัพท์ 061-0287788', 1, '2022-10-31 11:40:46', 1, '2022-10-31 11:40:46'),
(2, 'SNKTC', '\r\nวิทยาลัยเทคนิคสกลนคร', 1, '2023-02-13 12:30:16', 1, '2023-02-13 12:30:16'),
(3, 'PSU', 'มหาวิทยาลัยสงขลานครินทร์', 1, '2023-06-01 14:10:06', 1, '2023-06-01 14:10:06'),
(18, 'TEST', '', 1, '2024-02-18 15:55:15', 1, '2024-02-18 15:55:15');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `rp_id` int(11) NOT NULL,
  `date_rp` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `lift_id` int(11) NOT NULL,
  `detail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`rp_id`, `date_rp`, `user_id`, `org_id`, `building_id`, `lift_id`, `detail`) VALUES
(15, '2024-08-04', 4, 1, 1, 1, 'เซนเซอร์ประตูไม่ทำงาน เกือบหนีบตัวแล้ว'),
(20, '2024-08-11', 27, 1, 1, 1, 'ประตูลิฟต์เปิดไม่สุด'),
(24, '2024-08-11', 24, 1, 1, 1, 'ลิฟต์ไม่ทำงาน');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `tk_id` int(11) NOT NULL,
  `tk_status` enum('1','2','3','4','5') NOT NULL,
  `tk_data` varchar(255) NOT NULL,
  `task_start_date` datetime DEFAULT NULL,
  `rp_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `mainten_id` int(11) NOT NULL,
  `org_name` varchar(255) NOT NULL,
  `building_name` varchar(255) NOT NULL,
  `lift_id` varchar(255) NOT NULL,
  `tools` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_status`
--

CREATE TABLE `task_status` (
  `tk_status_id` int(11) NOT NULL,
  `tk_id` int(11) NOT NULL,
  `status` enum('preparing','working','finish','prepared','assign') NOT NULL,
  `time` datetime NOT NULL,
  `detail` varchar(255) NOT NULL,
  `tk_status_tool` longtext DEFAULT NULL,
  `tk_img` longblob DEFAULT NULL,
  `section` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tools`
--

CREATE TABLE `tools` (
  `tool_id` int(11) NOT NULL,
  `tool_name` varchar(255) NOT NULL,
  `cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `bd` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `org_id` int(11) NOT NULL,
  `user_img` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work`
--

CREATE TABLE `work` (
  `wk_id` int(11) NOT NULL,
  `wk_status` enum('1','2','3','4') NOT NULL,
  `tk_id` int(11) NOT NULL,
  `wk_detail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lifts`
--
ALTER TABLE `lifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`rp_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`tk_id`);

--
-- Indexes for table `task_status`
--
ALTER TABLE `task_status`
  ADD PRIMARY KEY (`tk_status_id`);

--
-- Indexes for table `tools`
--
ALTER TABLE `tools`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work`
--
ALTER TABLE `work`
  ADD PRIMARY KEY (`wk_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `building`
--
ALTER TABLE `building`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lifts`
--
ALTER TABLE `lifts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `rp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `tk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_status`
--
ALTER TABLE `task_status`
  MODIFY `tk_status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tools`
--
ALTER TABLE `tools`
  MODIFY `tool_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work`
--
ALTER TABLE `work`
  MODIFY `wk_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
