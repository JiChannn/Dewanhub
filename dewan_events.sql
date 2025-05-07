-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2025 at 05:56 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dewan_events`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `event_date` date NOT NULL,
  `status` enum('pending','approved','completed','denied') DEFAULT 'pending',
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `user_id`, `title`, `description`, `event_date`, `status`, `deleted_at`, `created_at`) VALUES
(1, 1, 'Majlis Jamuan Raya', 'Jamuan Raya KVKS', '2025-04-18', 'approved', '2025-04-13 23:10:01', '2025-04-13 06:39:15'),
(2, 1, 'Hari Usahawan Muda', 'Didirikan oleh Jabatan Perniagaan', '2025-04-23', 'completed', '2025-05-07 11:49:14', '2025-04-13 06:49:57'),
(3, 1, 'Dante\'s shitting stream', 'we shit with dante', '2025-04-19', 'completed', '2025-04-14 10:48:43', '2025-04-13 15:08:54'),
(4, 1, 'Jamuan Raya KVKS', 'Mengadakan Jamuan Raya pada hari Jumaat, 8 AM - 12 PM', '2025-04-18', 'completed', '2025-04-23 14:39:23', '2025-04-14 02:33:00'),
(5, 1, 'Majlis Jamuan Raya', 'adadada', '2025-04-14', 'completed', '2025-05-07 11:49:18', '2025-04-14 02:46:19'),
(6, 1, 'qiu bday', ':)', '2025-04-14', 'completed', '2025-04-20 22:18:27', '2025-04-14 02:53:14'),
(7, 1, 'Test Event', 'This is a test approved event.', '2025-12-31', 'approved', '2025-04-14 11:08:18', '2025-04-14 03:07:35'),
(8, 1, 'Test Event', 'This is a test approved event.', '2025-12-31', 'approved', '2025-04-14 11:08:21', '2025-04-14 03:07:41'),
(9, 1, 'test2', 'test', '2025-04-24', 'completed', NULL, '2025-04-14 03:08:09'),
(10, 3, 'adadadad', 'adadadad', '2025-04-26', 'completed', NULL, '2025-04-14 03:24:12'),
(11, 4, 'hari usahawan', 'jabatan ICT', '2025-05-05', 'completed', '2025-04-23 10:49:23', '2025-04-14 03:51:42'),
(12, 5, 'Orgy kvks', 'YOOOOOOOOOOOOOOO', '2025-04-23', 'approved', '2025-04-20 22:18:45', '2025-04-20 14:16:29'),
(13, 3, 'this is a test', 'this is a test', '2025-04-23', 'completed', '2025-05-07 11:48:45', '2025-04-23 02:49:53'),
(14, 7, 'adwad', 'awfafawf', '2025-04-23', 'completed', NULL, '2025-04-23 03:21:11'),
(15, 3, 'awagq 5e5h ehe', 'erhehhae', '2025-05-09', 'approved', NULL, '2025-04-23 05:54:05'),
(16, 2, 'agwrarhahawrhaer', 'hrwrhwhwrrhhWH', '2323-12-31', 'approved', NULL, '2025-04-23 05:54:36'),
(17, 1, 'awfwfwf', 'aegewgerg', '2332-02-11', 'completed', NULL, '2025-04-23 06:06:54'),
(18, 2, 'this is a test', 'gawvfhajbghagbwahbga', '2999-12-01', 'completed', '2025-05-07 11:29:51', '2025-04-23 06:39:07'),
(19, 6, 'awgaga', 't42t422', '1232-12-31', 'approved', NULL, '2025-04-23 06:39:50'),
(20, 2, 'w12411', '21321214124', '3233-02-02', 'pending', NULL, '2025-05-07 03:49:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'test1', '$2y$10$AIEA37NC.Yaab/DR4e2wpeZHoXyySbfUJWiMc55oeqvwACNvxenbW', 'user', '2025-04-13 06:36:59'),
(2, 'administrator', '$2y$10$I9B0zpaS9Hlc/UFyq1AeT.1Vc33wnTP/s6doRv9VY1aKNyowMCwKC', 'admin', '2025-04-13 06:38:25'),
(3, 'test2', '$2y$10$HQmnRYFbD3HjaNInYu982uH3I6UDR0lJ/WqnsowGuYwqXXJ50uDgS', 'user', '2025-04-14 03:02:34'),
(4, 'aeriz', '$2y$10$6htksHaFcAudHi135iPQ8.YYcqSXeBwTz4BolO8iZJifW9rqZxgKW', 'user', '2025-04-14 03:51:20'),
(5, 'Nm', '$2y$10$O27wSM1G05c6Hooir2.KFejQ5H8Y16eQ/TLvyCphhcdF/sAk/OXtS', 'user', '2025-04-20 14:15:47'),
(6, 'akmal', '$2y$10$8L4WuM2sZUv4bQyvYcxxfuDWzjhvQ5tObvqsabZgBHjAFZSsXEA0S', 'admin', '2025-04-23 03:10:52'),
(7, 'naqiu', '$2y$10$xT59WDkt2V8Tm5u8QotH/O.KaYY3bMPvvQRqvK4Ne4IwhJ0Cj3i.2', 'user', '2025-04-23 03:18:51'),
(8, 'ahmad', '$2y$10$yUTDAlqHmi9xkBCIYGPD7.hQaid5Y9b96BWjkLd2hL4YXHjUROlzS', 'user', '2025-04-23 06:40:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
