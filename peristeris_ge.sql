-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2024 at 06:51 PM
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
-- Database: `peristeris_ge`
--

-- --------------------------------------------------------

--
-- Table structure for table `ergasia`
--

CREATE TABLE `ergasia` (
  `ergasia_id` int(11) NOT NULL,
  `titlos` varchar(20) NOT NULL,
  `list_ergasia_id` int(11) NOT NULL,
  `id_xristi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ergasia`
--

INSERT INTO `ergasia` (`ergasia_id`, `titlos`, `list_ergasia_id`, `id_xristi`) VALUES
(1, 'Εργασία 1', 4, 2),
(2, 'Εργασία 4', 3, 2),
(4, 'Εργασιά test', 5, 2),
(5, 'Εργασιά 78', 5, 2),
(6, 'εργασία 58', 5, 2),
(7, 'Εργασια 899', 6, 1),
(9, 'Εργασια 89γ', 6, 1),
(10, 'Εργασια 23φ', 6, 1),
(11, 'Εργασια ionsper', 6, 2),
(12, 'Εισαγωγή', 8, 1),
(13, 'Main course', 8, 1),
(14, 'Εργασιά 89', 7, 1),
(15, 'Εργασια 345', 7, 1),
(16, 'Εργασια 55', 10, 1),
(17, 'Admin todo1', 11, 1),
(18, 'Admin todo2', 11, 1),
(20, 'Admin todo4', 11, 1),
(21, 'Admin todo5', 11, 1),
(22, 'Εργασια 555', 12, 3),
(23, 'Εργασια 123', 12, 3),
(24, 'Εργασια 23', 12, 3),
(25, 'Εργασια 22', 13, 4),
(26, 'Εισαγωγή', 13, 4),
(27, 'geger', 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `list_ergasies`
--

CREATE TABLE `list_ergasies` (
  `list_ergasia_id` int(11) NOT NULL,
  `titlos` varchar(20) NOT NULL,
  `category` varchar(10) NOT NULL,
  `status` varchar(15) NOT NULL,
  `id_xristi` int(11) NOT NULL,
  `id_omada` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `list_ergasies`
--

INSERT INTO `list_ergasies` (`list_ergasia_id`, `titlos`, `category`, `status`, `id_xristi`, `id_omada`) VALUES
(1, 'Ατομική 1', 'Εργασία', 'Σε εξέλιξη', 2, NULL),
(3, 'Ατομική 3', 'Εργασία', 'Ολοκληρωμένη', 2, NULL),
(4, 'Ατομική 3', 'Εργασία', 'Νέα', 2, NULL),
(5, 'Ατομικη για ανάθεση', 'Εργασία', 'Σε εξέλιξη', 2, NULL),
(6, 'Ομαδική Λίστα', 'Ομαδική', 'Νέα', 1, 3),
(7, 'Λίστα εργασιών3', 'Ομαδική', 'Ολοκληρωμένη', 1, 3),
(8, 'Project 1', 'Ομαδική', 'Νέα', 1, 2),
(9, 'Project 3', 'Ομαδική', 'Σε εξέλιξη', 1, 1),
(10, 'Project 5', 'Ομαδική', 'Νέα', 1, 1),
(11, 'Personal list', 'Εργασία', 'Νέα', 1, NULL),
(12, 'Personal list', 'Εργασία', 'Σε εξέλιξη', 3, NULL),
(13, 'testuser List', 'Εργασία', 'Σε εξέλιξη', 4, NULL),
(14, 'ggergrgr', 'Ομαδική', 'Νέα', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `omada`
--

CREATE TABLE `omada` (
  `id_omada` int(11) NOT NULL,
  `onoma_omadas` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `omada`
--

INSERT INTO `omada` (`id_omada`, `onoma_omadas`) VALUES
(1, 'Ομάδα 1'),
(2, 'Ομαδά 2'),
(3, 'Ομαδά 3');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_xristi` int(11) NOT NULL,
  `onoma` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(8) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(5) NOT NULL,
  `eggrafi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_xristi`, `onoma`, `email`, `username`, `password`, `type`, `eggrafi`) VALUES
(1, 'Administrator', 'admin@admin.gr', 'Admin', 'Admin', 'admin', '2024-02-25 20:59:02'),
(2, 'Γιάννης Χρήστης1', 'test@gmail.com', 'ionsper', '1234567Gg', 'user', '2024-03-16 18:59:04'),
(3, 'Χρηστης Τεστ1', 'xristis@gmail.com', 'xristis1', 'Ag12345678', 'user', '2024-03-16 19:28:46'),
(4, 'Χρηστης Τεστ2', 'test2@outlook.com', 'testuser', 'HG4582tyf', 'user', '2024-03-16 20:24:25');

-- --------------------------------------------------------

--
-- Table structure for table `user_omada`
--

CREATE TABLE `user_omada` (
  `id_xristi` int(11) NOT NULL,
  `id_omada` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_omada`
--

INSERT INTO `user_omada` (`id_xristi`, `id_omada`) VALUES
(2, 1),
(3, 1),
(1, 2),
(4, 2),
(2, 3),
(3, 3),
(4, 3),
(1, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ergasia`
--
ALTER TABLE `ergasia`
  ADD PRIMARY KEY (`ergasia_id`),
  ADD KEY `ergasia_ibfk_1` (`list_ergasia_id`),
  ADD KEY `ergasia_ibfk_2` (`id_xristi`);

--
-- Indexes for table `list_ergasies`
--
ALTER TABLE `list_ergasies`
  ADD PRIMARY KEY (`list_ergasia_id`),
  ADD KEY `list_ergasies_ibfk_1` (`id_xristi`);

--
-- Indexes for table `omada`
--
ALTER TABLE `omada`
  ADD PRIMARY KEY (`id_omada`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_xristi`);

--
-- Indexes for table `user_omada`
--
ALTER TABLE `user_omada`
  ADD KEY `user_omada_ibfk_1` (`id_xristi`),
  ADD KEY `user_omada_ibfk_2` (`id_omada`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ergasia`
--
ALTER TABLE `ergasia`
  MODIFY `ergasia_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `list_ergasies`
--
ALTER TABLE `list_ergasies`
  MODIFY `list_ergasia_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `omada`
--
ALTER TABLE `omada`
  MODIFY `id_omada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_xristi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ergasia`
--
ALTER TABLE `ergasia`
  ADD CONSTRAINT `ergasia_ibfk_1` FOREIGN KEY (`list_ergasia_id`) REFERENCES `list_ergasies` (`list_ergasia_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ergasia_ibfk_2` FOREIGN KEY (`id_xristi`) REFERENCES `user` (`id_xristi`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `list_ergasies`
--
ALTER TABLE `list_ergasies`
  ADD CONSTRAINT `list_ergasies_ibfk_1` FOREIGN KEY (`id_xristi`) REFERENCES `user` (`id_xristi`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user_omada`
--
ALTER TABLE `user_omada`
  ADD CONSTRAINT `user_omada_ibfk_1` FOREIGN KEY (`id_xristi`) REFERENCES `user` (`id_xristi`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_omada_ibfk_2` FOREIGN KEY (`id_omada`) REFERENCES `omada` (`id_omada`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
