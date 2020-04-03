-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 02, 2020 at 10:13 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esd`
--
CREATE DATABASE IF NOT EXISTS `esd` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `esd`;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE IF NOT EXISTS `booking` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL,
  `cafeID` int(10) NOT NULL,
  `seat_no` varchar(10) NOT NULL,
  `block` int(2) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Confirmed','Cancelled') NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `userID` (`userID`),
  KEY `cafeID` (`cafeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cafes`
--

DROP TABLE IF EXISTS `cafes`;
CREATE TABLE IF NOT EXISTS `cafes` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `poc` varchar(100) NOT NULL,
  `avg_review` double(3,2) DEFAULT NULL,
  `price` int(1) NOT NULL,
  `location` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `corrid`
--

DROP TABLE IF EXISTS `corrid`;
CREATE TABLE IF NOT EXISTS `corrid` (
  `corrid` varchar(100) NOT NULL,
  `bookingID` int(11) NOT NULL,
  PRIMARY KEY (`corrid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `error_handling`
--

DROP TABLE IF EXISTS `error_handling`;
CREATE TABLE IF NOT EXISTS `error_handling` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `body` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `monitoring`
--

DROP TABLE IF EXISTS `monitoring`;
CREATE TABLE IF NOT EXISTS `monitoring` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `body` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL,
  `cafeID` int(10) NOT NULL,
  `bookingID` int(10) NOT NULL,
  `content` text NOT NULL,
  `stars` int(3) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `userID` (`userID`),
  KEY `cafeID` (`cafeID`),
  KEY `bookingID` (`bookingID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `social_media` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`cafeID`) REFERENCES `cafes` (`ID`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`cafeID`) REFERENCES `cafes` (`ID`),
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`bookingID`) REFERENCES `booking` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
