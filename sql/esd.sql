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
DROP DATABASE IF EXISTS `esd`;
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

Insert into booking
(ID, userID, cafeID, seat_no, block,date, status)
values (1,1,1,"1A",6,"2020-04-02","Confirmed"),
(2,3,2,"6A",3,"2020-04-02","Confirmed"),
(3,2,1,"8A",3,"2020-04-02","Confirmed");

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

Insert into cafes
(ID, name, email, password, phone, poc, avg_review, price, location)
values (1, "Lola","kindadopey@gmail.com", "$2y$10$muXf58lihCL6cmObNmqBH.nr/szrmmrPw3MfQ2dpL/5JZCkM0EGbu","65353535",'Lola', 3, 1, "Bukit Josiah"),
(2, "Kooks","hxchoo@gmail.com","$2y$10$muXf58lihCL6cmObNmqBH.nr/szrmmrPw3MfQ2dpL/5JZCkM0EGbu", "90013113",'Kook', 5,5,"Bukit Lvin"),
(3, "Josies","josie@gmail.com", "$2y$10$muXf58lihCL6cmObNmqBH.nr/szrmmrPw3MfQ2dpL/5JZCkM0EGbu","99009678",'Josie', 3, 1, "Bukit Josie"),
(4, "Joqeewee","joqeewee@gmail.com", "$2y$10$muXf58lihCL6cmObNmqBH.nr/szrmmrPw3MfQ2dpL/5JZCkM0EGbu","81880092",'Joqeewee', 3, 1, "Bukit Joqeewee");

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

Insert into reviews
(ID, userID, cafeID, bookingID, content, stars)
values (1,1,1,1,"The service is excellent. Food was quite good. Ordered the Spinach and Mushroom Quiche and bread was on the crispy side which was delightful. However the serving size for all the dishes we ordered were quite little and I was unfortunately not filled after the meal.",4.25),
(2,3,2,2, "Rude server! He literally was telling me and my friend that he don't want to serve us and was not keen to take our orders. Stay away from this place. Don't spend your money to buy humiliation!", 1.05),
(3,2,1,3, "Such a disappointment. Took them 15 mins to inform that the plain waffles are not available. After we asked for the chocolate waffles, we waited for more than 30 mins before we were informed again that they are unable to produce the waffles. Seriously?? I have been looking at the 3 staff mending at the waffle machine. I am sure something could be done better with their services!", 2.45);

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

Insert into users 
(ID, email, password, first_name, last_name, phone, social_media)
values (1, "joqeewee@gmail.com","$2y$10$muXf58lihCL6cmObNmqBH.nr/szrmmrPw3MfQ2dpL/5JZCkM0EGbu", "Josiah", "Wong", "98575987",NULL),
(2,"lvin_tank_esd@gmail.com", "$2y$10$muXf58lihCL6cmObNmqBH.nr/szrmmrPw3MfQ2dpL/5JZCkM0EGbu", "Lvin", "Shao", "95595559", NULL),
(3,"stay_away_qijin@gmail.com", "$2y$10$muXf58lihCL6cmObNmqBH.nr/szrmmrPw3MfQ2dpL/5JZCkM0EGbu", "Qijon", "Tay", "65353535", NULL);

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
