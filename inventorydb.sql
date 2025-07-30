-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2025 at 07:38 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventorydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cctv`
--

CREATE TABLE `cctv` (
  `id` int(11) NOT NULL,
  `assetcode` varchar(50) NOT NULL,
  `accountable_person` varchar(100) NOT NULL,
  `device_name` varchar(100) NOT NULL,
  `model` varchar(100) DEFAULT NULL,
  `line_type` varchar(50) DEFAULT NULL,
  `loc` varchar(100) DEFAULT NULL,
  `stat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `desktop`
--

CREATE TABLE `desktop` (
  `id` int(11) NOT NULL,
  `assetcode` varchar(50) NOT NULL,
  `accountable_person` varchar(100) NOT NULL,
  `device_name` varchar(100) NOT NULL,
  `model` varchar(100) DEFAULT NULL,
  `line_type` varchar(50) DEFAULT NULL,
  `loc` varchar(100) DEFAULT NULL,
  `stat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dvr`
--

CREATE TABLE `dvr` (
  `id` int(11) NOT NULL,
  `assetcode` varchar(50) NOT NULL,
  `accountable_person` varchar(100) NOT NULL,
  `device_name` varchar(100) NOT NULL,
  `model` varchar(100) DEFAULT NULL,
  `line_type` varchar(50) DEFAULT NULL,
  `loc` varchar(100) DEFAULT NULL,
  `stat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `laptop`
--

CREATE TABLE `laptop` (
  `id` int(11) NOT NULL,
  `assetcode` varchar(50) NOT NULL,
  `accountable_person` varchar(100) NOT NULL,
  `device_name` varchar(100) NOT NULL,
  `model` varchar(100) DEFAULT NULL,
  `line_type` varchar(50) DEFAULT NULL,
  `loc` varchar(100) DEFAULT NULL,
  `stat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `manageswitch`
--

CREATE TABLE `manageswitch` (
  `id` int(11) NOT NULL,
  `assetcode` varchar(50) NOT NULL,
  `accountable_person` varchar(100) NOT NULL,
  `device_name` varchar(100) NOT NULL,
  `model` varchar(100) DEFAULT NULL,
  `line_type` varchar(50) DEFAULT NULL,
  `loc` varchar(100) DEFAULT NULL,
  `stat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `printer`
--

CREATE TABLE `printer` (
  `id` int(11) NOT NULL,
  `assetcode` varchar(50) NOT NULL,
  `accountable_person` varchar(100) NOT NULL,
  `device_name` varchar(100) NOT NULL,
  `model` varchar(100) DEFAULT NULL,
  `line_type` varchar(50) DEFAULT NULL,
  `loc` varchar(100) DEFAULT NULL,
  `stat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `server`
--

CREATE TABLE `server` (
  `id` int(11) NOT NULL,
  `assetcode` varchar(50) NOT NULL,
  `accountable_person` varchar(100) NOT NULL,
  `device_name` varchar(100) NOT NULL,
  `model` varchar(100) DEFAULT NULL,
  `line_type` varchar(50) DEFAULT NULL,
  `loc` varchar(100) DEFAULT NULL,
  `stat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `software`
--

CREATE TABLE `software` (
  `id` int(11) NOT NULL,
  `assetcode` varchar(50) NOT NULL,
  `accountable_person` varchar(100) NOT NULL,
  `device_name` varchar(100) NOT NULL,
  `model` varchar(100) DEFAULT NULL,
  `line_type` varchar(50) DEFAULT NULL,
  `loc` varchar(100) DEFAULT NULL,
  `stat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `telephone`
--

CREATE TABLE `telephone` (
  `id` int(11) NOT NULL,
  `assetcode` varchar(50) NOT NULL,
  `accountable_person` varchar(100) NOT NULL,
  `device_type` enum('Telephone','PBX') DEFAULT NULL,
  `device_name` varchar(100) NOT NULL,
  `model` varchar(100) DEFAULT NULL,
  `line_type` varchar(50) DEFAULT NULL,
  `loc` varchar(100) DEFAULT NULL,
  `stat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cctv`
--
ALTER TABLE `cctv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `desktop`
--
ALTER TABLE `desktop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dvr`
--
ALTER TABLE `dvr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laptop`
--
ALTER TABLE `laptop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manageswitch`
--
ALTER TABLE `manageswitch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `printer`
--
ALTER TABLE `printer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `server`
--
ALTER TABLE `server`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `software`
--
ALTER TABLE `software`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `telephone`
--
ALTER TABLE `telephone`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cctv`
--
ALTER TABLE `cctv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `desktop`
--
ALTER TABLE `desktop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dvr`
--
ALTER TABLE `dvr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `laptop`
--
ALTER TABLE `laptop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `manageswitch`
--
ALTER TABLE `manageswitch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `printer`
--
ALTER TABLE `printer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `server`
--
ALTER TABLE `server`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `software`
--
ALTER TABLE `software`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `telephone`
--
ALTER TABLE `telephone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
