-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2026 at 01:47 PM
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
-- Database: `registration`
--

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `idNum` int(11) NOT NULL,
  `campus` varchar(200) NOT NULL,
  `studFName` varchar(200) NOT NULL,
  `studLName` varchar(200) NOT NULL,
  `amountPaid` float NOT NULL,
  `attended` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`idNum`, `campus`, `studFName`, `studLName`, `amountPaid`, `attended`) VALUES
(1, 'Main', 'Niña Dianne', 'Dangcalan', 600, 'Yes'),
(2, 'Main', 'Kevin', 'Asendiente', 600, 'Yes'),
(3, 'Banilad', 'Angelito', 'Lingo', 600, 'Yes'),
(5, 'Banilad', 'Jhanna', 'Durano', 600, 'No'),
(6, 'LM', 'Liezel', 'Tumbaga', 600, 'Yes'),
(7, 'Main', 'Dennis', 'Durano', 600, 'No'),
(8, 'LM', 'Neil', 'Basabe', 600, 'No'),
(9, 'Banilad', 'Jia', 'Montecino', 600, 'No'),
(10, 'Main', 'Shawn', 'Mendes', 600, 'Yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`idNum`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
