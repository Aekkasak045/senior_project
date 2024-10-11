-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2024 at 04:44 PM
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

--
-- Dumping data for table `building`
--

INSERT INTO `building` (`id`, `org_id`, `building_name`, `created_user_id`, `created_at`, `update_user_id`, `updated_at`) VALUES
(1, 1, 'อาคาร 19', 1, '2023-10-07 15:16:25', 1, '2023-10-07 15:16:25'),
(2, 2, 'อาคาร 1 เทคนิคสกล', 1, '2023-10-07 15:21:12', 1, '2023-10-07 15:21:12'),
(3, 3, 'อาคารเย็นศิระ', 1, '2023-10-07 15:21:35', 1, '2023-10-07 15:21:35'),
(4, 1, 'อาคาร 1', 1, '2023-10-10 20:01:06', 1, '2023-10-10 20:01:06');

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

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `org_name`, `description`, `created_user_id`, `created_at`, `updated_user_id`, `updated_at`) VALUES
(1, 'KU CSC', 'มหาวิทยาลัยเกษตรศาสตร์\r\nวิทยาเขตเฉลิมพระเกียรติ จังหวัดสกลนคร\r\n59 หมู่ 1 ถ.วปรอ 366 ต.เชียงเครือ อ.เมือง จ.สกลนคร 47000 โทรศัพท์ 061-0287788', 1, '2022-10-31 11:40:46', 1, '2022-10-31 11:40:46'),
(2, 'SNKTC', '\r\nวิทยาลัยเทคนิคสกลนคร', 1, '2023-02-13 12:30:16', 1, '2023-02-13 12:30:16'),
(3, 'PSU', 'มหาวิทยาลัยสงขลานครินทร์', 1, '2023-06-01 14:10:06', 1, '2023-06-01 14:10:06'),
(18, 'TEST', '', 1, '2024-02-18 15:55:15', 1, '2024-02-18 15:55:15');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
