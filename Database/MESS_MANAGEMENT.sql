-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 07, 2019 at 06:40 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MESS_MANAGEMENT`
--

-- --------------------------------------------------------

--
-- Table structure for table `EXTRAS`
--

CREATE TABLE `EXTRAS` (
  `id` int(11) NOT NULL,
  `roll_no` char(9) NOT NULL,
  `mess_name` varchar(5) NOT NULL,
  `item_name` varchar(15) NOT NULL,
  `item_price` double NOT NULL,
  `item_qty` int(11) NOT NULL,
  `total` double NOT NULL DEFAULT 0,
  `time_stamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `EXTRAS`
--

INSERT INTO `EXTRAS` (`id`, `roll_no`, `mess_name`, `item_name`, `item_price`, `item_qty`, `total`, `time_stamp`) VALUES
(5, 'B170499cs', 'D', 's', 10, 3, 30, '2019-11-03 00:14:04');

-- --------------------------------------------------------

--
-- Table structure for table `FEEDBACK`
--

CREATE TABLE `FEEDBACK` (
  `roll_no` char(9) NOT NULL,
  `suggestion` varchar(1000) DEFAULT NULL,
  `mess_name` varchar(5) NOT NULL,
  `time_stamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `FEEDBACK`
--

INSERT INTO `FEEDBACK` (`roll_no`, `suggestion`, `mess_name`, `time_stamp`) VALUES
('B170703cs', 'daal k naam pe pani deta h', 'D', '2019-11-03 01:20:45');

-- --------------------------------------------------------

--
-- Table structure for table `MESS_ADMIN`
--

CREATE TABLE `MESS_ADMIN` (
  `mess_name` varchar(5) NOT NULL,
  `pass` varchar(30) NOT NULL,
  `base` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `MESS_ADMIN`
--

INSERT INTO `MESS_ADMIN` (`mess_name`, `pass`, `base`) VALUES
('A', '123456', 50),
('B', '123456', 50),
('C', '123456', 50),
('D', '123456', 50),
('E', '123456', 50),
('F', '123456', 50),
('G', '123456', 50),
('IH', '123456', 50),
('LH', '123456', 50),
('MBA', '123456', 50),
('Mega', '123456', 50),
('MLH', '123456', 50);

-- --------------------------------------------------------

--
-- Table structure for table `STUDENT`
--

CREATE TABLE `STUDENT` (
  `roll_no` char(9) NOT NULL,
  `name` varchar(80) NOT NULL,
  `pass` varchar(30) NOT NULL,
  `hostel` char(5) NOT NULL,
  `room_no` char(3) NOT NULL,
  `time_stamp` datetime DEFAULT current_timestamp(),
  `mess_name` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `STUDENT`
--

INSERT INTO `STUDENT` (`roll_no`, `name`, `pass`, `hostel`, `room_no`, `time_stamp`, `mess_name`) VALUES
('B170499cs', 'bhand', '12345678', 'C', '121', '2019-11-03 00:14:04', 'D'),
('B170703cs', 'shrey', '12345678', 'C', '148', '2019-11-03 00:14:04', 'D');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `EXTRAS`
--
ALTER TABLE `EXTRAS`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roll_no` (`roll_no`),
  ADD KEY `mess_name` (`mess_name`);

--
-- Indexes for table `FEEDBACK`
--
ALTER TABLE `FEEDBACK`
  ADD KEY `roll_no` (`roll_no`),
  ADD KEY `mess_name` (`mess_name`);

--
-- Indexes for table `MESS_ADMIN`
--
ALTER TABLE `MESS_ADMIN`
  ADD PRIMARY KEY (`mess_name`);

--
-- Indexes for table `STUDENT`
--
ALTER TABLE `STUDENT`
  ADD PRIMARY KEY (`roll_no`),
  ADD KEY `mess_name` (`mess_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `EXTRAS`
--
ALTER TABLE `EXTRAS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `EXTRAS`
--
ALTER TABLE `EXTRAS`
  ADD CONSTRAINT `EXTRAS_ibfk_1` FOREIGN KEY (`roll_no`) REFERENCES `STUDENT` (`roll_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `EXTRAS_ibfk_2` FOREIGN KEY (`mess_name`) REFERENCES `MESS_ADMIN` (`mess_name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `FEEDBACK`
--
ALTER TABLE `FEEDBACK`
  ADD CONSTRAINT `FEEDBACK_ibfk_1` FOREIGN KEY (`roll_no`) REFERENCES `STUDENT` (`roll_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FEEDBACK_ibfk_2` FOREIGN KEY (`mess_name`) REFERENCES `MESS_ADMIN` (`mess_name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `STUDENT`
--
ALTER TABLE `STUDENT`
  ADD CONSTRAINT `STUDENT_ibfk_1` FOREIGN KEY (`mess_name`) REFERENCES `MESS_ADMIN` (`mess_name`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
