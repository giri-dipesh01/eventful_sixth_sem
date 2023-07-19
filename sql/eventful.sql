-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2023 at 04:57 AM
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
-- Database: `eventful`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(6, 'Art & Design'),
(5, 'Education Fair'),
(3, 'Hackathon'),
(2, 'Internet of Things'),
(4, 'Music & Culutral Events'),
(8, 'Others'),
(9, 'Programming'),
(1, 'Sports');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `event_organizers` varchar(255) NOT NULL,
  `event_startdate` date NOT NULL,
  `event_enddate` date NOT NULL,
  `event_category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `event_description`, `event_organizers`, `event_startdate`, `event_enddate`, `event_category`) VALUES
(9, 'A', '        B            ', 'A', '2023-06-30', '2023-06-30', 'Art'),
(13, 'Danfe BasketBall 2023', '                    ', 'Sports Club', '2023-06-30', '2023-07-01', 'Art'),
(14, 'C', '                    ', 'A', '2023-06-30', '2023-07-08', 'Music');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `images_id` int(11) NOT NULL,
  `image_url` text DEFAULT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `image_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `gender` varchar(25) NOT NULL,
  `turegno` varchar(11) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `batch` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `register_date` datetime NOT NULL DEFAULT current_timestamp(),
  `verification` varchar(50) NOT NULL DEFAULT 'unverified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `email`, `full_name`, `gender`, `turegno`, `phone`, `batch`, `semester`, `password`, `register_date`, `verification`) VALUES
(1, 'shree@gmail.com', 'Shree Krishna Ghimere', 'Male', '6292062019', '9864333333', '2076 BS', 'Sixth', 'ab014527d87677e59e870300aacce7b2', '2023-06-25 11:23:54', 'Verified'),
(2, 'joshi@gmail.com', 'Shrinkhala Joshi', 'Female', '6292092019', '9845666666', '2076 BS', 'Sixth', '6c0b60847442ae2c9d4c6a592fbc48f8', '2023-06-26 07:36:50', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `students_profile`
--

CREATE TABLE `students_profile` (
  `profile_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `photo` text NOT NULL,
  `id_card` text NOT NULL,
  `interests` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_profile`
--

INSERT INTO `students_profile` (`profile_id`, `email`, `full_name`, `photo`, `id_card`, `interests`) VALUES
(1, 'shree@gmail.com', 'Shree Krishna Ghimere', '../profile/Logo11.png', '../card/logo.png', ''),
(2, 'joshi@gmail.com', 'Shrinkhala Joshi', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD UNIQUE KEY `event_name` (`event_name`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`images_id`),
  ADD KEY `event_name` (`event_name`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `turegno` (`turegno`);

--
-- Indexes for table `students_profile`
--
ALTER TABLE `students_profile`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `images_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students_profile`
--
ALTER TABLE `students_profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`event_name`) REFERENCES `events` (`event_name`);

--
-- Constraints for table `students_profile`
--
ALTER TABLE `students_profile`
  ADD CONSTRAINT `students_profile_ibfk_1` FOREIGN KEY (`email`) REFERENCES `students` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
