-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 23.07.2018 klo 13:43
-- Palvelimen versio: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `harjoitustyojanih`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `bids`
--

DROP TABLE IF EXISTS `bids`;
CREATE TABLE IF NOT EXISTS `bids` (
  `bids_id` int(11) NOT NULL AUTO_INCREMENT,
  `details` varchar(10000) DEFAULT NULL,
  `left_date` datetime DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `answer_date` datetime DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  PRIMARY KEY (`bids_id`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `bids`
--

INSERT INTO `bids` (`bids_id`, `details`, `left_date`, `cost`, `answer_date`, `status`, `username`) VALUES
(2, 'Haluaisin laatoittaa pihan marmormilaatoilla. Pinta-alaa 22m2', '2018-07-21 19:14:14', 12, '2018-07-22 17:07:40', 'VASTATTU', 'asd12');

-- --------------------------------------------------------

--
-- Rakenne taululle `cabin`
--

DROP TABLE IF EXISTS `cabin`;
CREATE TABLE IF NOT EXISTS `cabin` (
  `cabin_id` int(11) NOT NULL AUTO_INCREMENT,
  `cabintype` varchar(100) DEFAULT NULL,
  `area` double DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  PRIMARY KEY (`cabin_id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Rakenne taululle `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `username` varchar(25) NOT NULL COMMENT 'primary key',
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL COMMENT 'Same email cannot be used.',
  `name` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `phone` int(20) NOT NULL,
  `address` varchar(50) NOT NULL,
  `postcode` int(9) NOT NULL,
  `council` varchar(50) NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `client`
--

INSERT INTO `client` (`username`, `password`, `email`, `name`, `dob`, `phone`, `address`, `postcode`, `council`) VALUES
('admin', 'adminpassword', 'admin', 'admin', '2018-02-08', 0, 'admin', 0, 'admin'),
('asd', 'asd1', 'asd', 'das', '2018-02-08', 123, 'asd', 213, 'asd'),
('asd12', 'jamppa', '231s', 'Penes123', '2022-02-01', 44262312, 'Rioskua', 70100, 'Kuopio'),
('jani', 'asdkayra1', 'asd1', 'Jani harjula', '2018-07-18', 44232123, 'Vnaharkiero 21', 70215, 'Kuoipo'),
('janihar', 'jani', 'janihar@uef.fi', 'Jani Har', '2018-04-05', 442757346, 'Rosokuja', 70150, 'Kuopio');

-- --------------------------------------------------------

--
-- Rakenne taululle `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` varchar(12000) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `acc_date` datetime DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `comments` varchar(12000) DEFAULT NULL,
  `hours` double DEFAULT NULL,
  `articles` varchar(12000) DEFAULT NULL,
  `cost` float DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `order`
--

INSERT INTO `order` (`order_id`, `desc`, `order_date`, `acc_date`, `start_date`, `end_date`, `comments`, `hours`, `articles`, `cost`, `status`, `username`) VALUES
(33, 'KyllÃ¤ vain', '2018-07-20 20:49:11', '2018-07-20 00:00:00', '2018-07-31 00:00:00', '2018-07-03 00:00:00', NULL, NULL, NULL, NULL, 'TILATTU', 'asd12'),
(34, 'Omakotini lattia on raapiutunut ja tarvitsisi kiillotusta', '2018-07-21 16:18:38', NULL, '2018-07-21 16:45:31', '2018-07-21 17:03:07', 'asdasd', 0, 'asd', 0, 'HYLATTY', 'asd'),
(35, 'Koti paloi ja pitÃ¤isi rakentaa uusi tilalle! (Ei oikeasti', '2018-07-21 18:21:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'HYLATTY', 'jani');

--
-- Rajoitteet vedostauluille
--

--
-- Rajoitteet taululle `bids`
--
ALTER TABLE `bids`
  ADD CONSTRAINT `bids_ibfk_1` FOREIGN KEY (`username`) REFERENCES `client` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Rajoitteet taululle `cabin`
--
ALTER TABLE `cabin`
  ADD CONSTRAINT `cabin_ibfk_1` FOREIGN KEY (`username`) REFERENCES `client` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Rajoitteet taululle `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`username`) REFERENCES `client` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
