-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2023 at 08:41 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo_hris`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_new_user`
--

CREATE TABLE `add_new_user` (
  `id` int(11) NOT NULL,
  `upload_Image` varchar(255) NOT NULL,
  `department` varchar(50) NOT NULL,
  `fUrl` varchar(255) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `MiddleInitial` varchar(1) DEFAULT NULL,
  `lname` varchar(50) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `birthDate` varchar(30) NOT NULL,
  `Suffix` varchar(10) DEFAULT NULL,
  `StreetAdd` varchar(255) NOT NULL,
  `country` varchar(50) NOT NULL,
  `MobNo` varchar(15) NOT NULL,
  `AltCon` varchar(15) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `pno` int(4) NOT NULL,
  `city` varchar(50) NOT NULL,
  `province` varchar(50) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `workposition` varchar(255) NOT NULL,
  `userRole` enum('admin','employee') NOT NULL,
  `regular` varchar(50) DEFAULT 'pending',
  `fingerprint_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dtr_record`
--

CREATE TABLE `dtr_record` (
  `id` int(11) NOT NULL,
  `employee_number` int(11) NOT NULL,
  `action` enum('time_in','time_out') NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `time` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `upload_Image` varchar(255) NOT NULL,
  `department` varchar(50) NOT NULL,
  `fUrl` varchar(255) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `MiddleInitial` varchar(1) DEFAULT NULL,
  `lname` varchar(50) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `birthDate` varchar(30) NOT NULL,
  `Suffix` varchar(10) DEFAULT NULL,
  `StreetAdd` varchar(255) NOT NULL,
  `country` varchar(50) NOT NULL,
  `MobNo` varchar(15) NOT NULL,
  `AltCon` varchar(15) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `pno` int(11) NOT NULL,
  `city` varchar(50) NOT NULL,
  `province` varchar(50) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `workposition` varchar(255) NOT NULL,
  `userRole` enum('admin','employee') NOT NULL,
  `regular` varchar(50) DEFAULT NULL,
  `fingerprint_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_application`
--

CREATE TABLE `leave_application` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `leave_type` varchar(50) NOT NULL,
  `reason` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_application`
--

INSERT INTO `leave_application` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `leave_type`, `reason`, `created_at`) VALUES
(2, 'jonathan', 'jaquias', 'sample@gmail.com', '1234', 'sample leave type', 'sadhiashd', '2023-11-16 14:10:32'),
(3, 'asdasdad', 'asdasd', 'asdasdas@email.com', '1231', 'asdafdsfsdg', 'sdfsdf', '2023-11-16 15:23:11'),
(4, 'asdasdad', 'asdasd', 'asdasdas@email.com', '1231', 'asdafdsfsdg', 'sdfsdf', '2023-11-16 15:48:10'),
(5, 'jonathan', 'asdasd', 'sample@gmail.com', '1234', 'sample leave type', 'asdadsdfasdfas', '2023-11-16 15:51:48'),
(6, 'jonathan', 'turner', 'sample@gmail.com', '123123', 'sample leave type', 'sdfsfasdfsdf', '2023-11-16 15:59:37'),
(7, 'asdasdad', 'asdasd', 'asdasdas@email.com', '12312312', 'sadasd', 'asdasdasdasdas', '2023-11-16 16:33:56');

-- --------------------------------------------------------

--
-- Table structure for table `newemployees`
--

CREATE TABLE `newemployees` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `middleInitial` varchar(1) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `phone` int(11) NOT NULL,
  `altContanct` int(11) DEFAULT NULL,
  `birthDate` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `streetAdd` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `province` varchar(50) NOT NULL,
  `postalCode` int(4) NOT NULL,
  `jobTitle` varchar(50) NOT NULL,
  `fileResume` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `new_overseas`
--

CREATE TABLE `new_overseas` (
  `id` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `middleInitial` varchar(10) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `suffix` varchar(50) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` int(15) NOT NULL,
  `birthdate` varchar(50) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `streetAdd` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(50) NOT NULL,
  `postalCode` int(4) NOT NULL,
  `fileResume` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `new_overseas`
--

INSERT INTO `new_overseas` (`id`, `firstName`, `middleInitial`, `lastName`, `suffix`, `email`, `phone`, `birthdate`, `gender`, `streetAdd`, `city`, `province`, `postalCode`, `fileResume`) VALUES
(2, 'Zabdiel Lyka Evanne', 'C', 'Tosio', '', 'tosiolyka0414@gmail.com', 2147483647, '2002-04-14', 'female', 'Bricks Cuidad Real', 'San Jose Del Monte', 'Bulacan', 3023, 'uploads/Resume.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `server_to_hw_status`
--

CREATE TABLE `server_to_hw_status` (
  `id` int(11) NOT NULL,
  `status` enum('enrolling','dtr','down') NOT NULL DEFAULT 'dtr',
  `last_updated` datetime NOT NULL,
  `action_key` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `server_to_hw_status`
--

INSERT INTO `server_to_hw_status` (`id`, `status`, `last_updated`, `action_key`) VALUES
(1, 'dtr', '2023-12-04 18:24:27', 'dbhris');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_new_user`
--
ALTER TABLE `add_new_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dtr_record`
--
ALTER TABLE `dtr_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_application`
--
ALTER TABLE `leave_application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newemployees`
--
ALTER TABLE `newemployees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_overseas`
--
ALTER TABLE `new_overseas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `server_to_hw_status`
--
ALTER TABLE `server_to_hw_status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_new_user`
--
ALTER TABLE `add_new_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dtr_record`
--
ALTER TABLE `dtr_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_application`
--
ALTER TABLE `leave_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `newemployees`
--
ALTER TABLE `newemployees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `new_overseas`
--
ALTER TABLE `new_overseas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `server_to_hw_status`
--
ALTER TABLE `server_to_hw_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
