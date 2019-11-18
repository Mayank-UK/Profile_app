-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 03, 2018 at 11:02 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id5556677_user`
--

-- --------------------------------------------------------

--
-- Table structure for table `active`
--

CREATE TABLE `active` (
  `resourceId` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `card_generator`
--

CREATE TABLE `card_generator` (
  `id` int(11) NOT NULL,
  `text` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `designation` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `card_generator`
--

INSERT INTO `card_generator` (`id`, `text`, `name`, `designation`, `company`, `email`, `number`) VALUES
(22, NULL, 'Mak', 'CEO', 'WorldGen2', 'mayankupadhyay191298@gmail.com', NULL),
(23, 'Boss', 'Mak', 'CEO', 'WorldGen2', 'mayankupadhyay191298@gmail.com', '+91-8279335158'),
(24, NULL, 'Mak', 'CEO', 'WorldGen2', 'mayankupadhyay191298@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `user_id` int(11) NOT NULL,
  `time` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`user_id`, `time`) VALUES
(8, '1535466337');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `email`, `password`) VALUES
(8, 'mak', 'm@gmail.com', '$2y$10$RDfPl5L9jsifROo0OMttOOV0WHbxnegs2qZ1uNLL7glpcsr8LPu9i'),
(9, 'any', 'a@gmail.com', '$2y$10$xjQ4r7KJ2O2vstqaHywsROQBhRKQMpVn58FfC9omDQtb7VgV/g6bW'),
(12, 'Mayank', 'mayankupadhyay191298@gmail.com', '$2y$10$wc571NbvRb7M9KzXDG6QKu.wOD0u4Q/zI0wTsCoAjZtZjv82PChA.'),
(13, 'alice', 'alice@gmail.com', '$2y$10$K6pQhHfdNf4hCvueqSg81Orgl2SkxWNebvVaCLzfBD5ibno6UFZd.'),
(14, 'vector', 'vector@gmail.com', '$2y$10$aIK/KvLwjI7TD8JNITK7cezsWrkMAAAR1rhEBAwYbEcdrddSXTzv.'),
(15, 'Anupsaini', 'Rajeev70@gmail.com', '$2y$10$4TWC/JM4uWRgmt.kPqMFfOGzKb/GIyOlA/eT0s7KT1sodQKH5Pxyy'),
(16, 'any', 'any@gmail.com', '$2y$10$uwCKa0A0JlJJlnoD4Tu6KOzX7lHjIzEr88YTTEYxTZiY.icqHcBIa');

-- --------------------------------------------------------

--
-- Table structure for table `profile_members`
--

CREATE TABLE `profile_members` (
  `id` int(10) NOT NULL,
  `oname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `education` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `quote` tinytext COLLATE utf8_unicode_ci,
  `location` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `profile_members`
--

INSERT INTO `profile_members` (`id`, `oname`, `name`, `email`, `education`, `company`, `url`, `bio`, `quote`, `location`, `img`) VALUES
(5, 'mak', 'Mak', 'm@gmail.com', '12', 'business', 'Mak.com', 'ass not fucked', 'work ethic!', 'India', 'uploads/1528458745mak.jpg'),
(6, 'any', 'any', 'a@gmail.com', '12', 'business', 'any.com', 'ass not fucked', 'work ethic!', 'India', 'uploads/1525071764any.png'),
(8, 'Mayank', 'Mayank', 'mayank@gmail.com', '12+\nEnterpreneur', 'WorldGen2', '', '', '', '', 'uploads/1528458852Mayank.jpg'),
(9, 'alice', 'alice', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `task` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `email`, `task`, `time`) VALUES
(17, 'm@gmail.com', 'Breakfast', '8:00'),
(18, 'm@gmail.com', 'Lunch', '12:00'),
(22, 'm@gmail.com', 'Dinner', '10:00'),
(25, 'any@gmail.com', 'Breakfast', '7:00'),
(26, 'any@gmail.com', 'Lunch', '12:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active`
--
ALTER TABLE `active`
  ADD PRIMARY KEY (`resourceId`);

--
-- Indexes for table `card_generator`
--
ALTER TABLE `card_generator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile_members`
--
ALTER TABLE `profile_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `card_generator`
--
ALTER TABLE `card_generator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `profile_members`
--
ALTER TABLE `profile_members`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
