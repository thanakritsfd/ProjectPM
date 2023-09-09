-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 09, 2023 at 05:01 AM
-- Server version: 8.0.17
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
-- Database: `aqi_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `value_tb`
--

CREATE TABLE `value_tb` (
  `ID` int(11) UNSIGNED NOT NULL,
  `PM` double NOT NULL,
  `Temperature` double NOT NULL,
  `Humidity` double NOT NULL,
  `Air_Pressure` double NOT NULL,
  `Wind_Speed` double NOT NULL,
  `Wind_Direction` double NOT NULL,
  `Reading_Time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `value_tb`
--
ALTER TABLE `value_tb`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `value_tb`
--
ALTER TABLE `value_tb`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

/*http://localhost/pm/api/value_Sensor/api_insertValue.php?pm=1&Temperature=32&Humidity=24&Air_Pressure=1013&Wind_Speed=40&Wind_Direction=360*/