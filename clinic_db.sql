-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2021 at 08:12 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clinic_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news`
--

CREATE TABLE `tbl_news` (
  `newsid` int(6) NOT NULL,
  `news` varchar(200) NOT NULL,
  `newsdate` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_news`
--

INSERT INTO `tbl_news` (`newsid`, `news`, `newsdate`) VALUES
(1, 'Test news today we are open', '2021-06-21 10:56:23.000000'),
(2, 'New doctor in house ', '2021-06-21 13:56:27.000000'),
(3, 'This is current news. Welcome to our clinic.', '2021-06-21 10:56:38.000000'),
(5, 'Welcome to Unique Clinic. New package available', '2021-06-21 15:58:48.297198'),
(6, 'Dr Nik is available today', '2021-06-21 16:06:15.391439'),
(7, 'Cuti keputeraaan sultan kedah hari ini', '2021-06-21 16:13:34.478658');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patients`
--

CREATE TABLE `tbl_patients` (
  `icno` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(300) NOT NULL,
  `citizenship` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `date_reg` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_patients`
--

INSERT INTO `tbl_patients` (`icno`, `name`, `address`, `citizenship`, `email`, `phone`, `date_reg`) VALUES
('6566545030485', 'Amran Rasli', 'Jalan ABC\r\nTaman CDE\r\nKedah', 'Indonesia', 'slumberjer@gmail.com', '0188855556', '2021-06-15 16:36:25.607241'),
('730499075544', 'Ah Cong Weng', 'Jalan Cheng Hong\r\nTaman Lok\r\nIpoh Perak', 'Malaysia', 'ahchong@gmail.com', '018889996', '2021-06-14 22:53:24.098921'),
('750222095555', 'Ali bin Abu', 'Jalan Abu\r\nTaman ABC\r\nJalan DEF\r\nKlang', 'Bangladesh', 'allg@gmail.com', '0177444554', '2021-06-14 18:59:51.723638'),
('781223085959', 'Azman Aziz', 'School of Computing', 'Malaysia', 'azmun@gmail.com', '0185552235', '2021-06-14 18:58:59.048972');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `email` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`email`, `password`) VALUES
('slumberjer@gmail.com', '6367c48dd193d56ea7b0baad25b19455e529f5ee');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_visits`
--

CREATE TABLE `tbl_visits` (
  `visit_id` int(5) NOT NULL,
  `icno` varchar(20) NOT NULL,
  `date_visit` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `remarks` varchar(500) NOT NULL,
  `payment` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_visits`
--

INSERT INTO `tbl_visits` (`visit_id`, `icno`, `date_visit`, `remarks`, `payment`) VALUES
(2, '781223085959', '2021-06-15 22:09:58.000000', 'Another test of remarks. Just to see more data here.', '35.00'),
(3, '781223085959', '2021-06-16 22:10:57.000000', 'More data needed to see if this ok or not.', '33.50'),
(4, '781223085959', '2021-06-02 22:12:01.000000', 'Medication given to this person is as follows\r\n1. vocadin\r\n2. Tableron\r\n3. Octasin', '30.40'),
(15, '730499075544', '2021-06-01 13:38:10.067564', 'Dental cleaning', '56.60'),
(16, '730499075544', '2021-06-02 13:39:38.285005', 'cleaning', '65.50'),
(17, '730499075544', '2021-06-03 14:22:23.286068', 'Dental check\r\nCleaning\r\nWhitening', '120.50'),
(18, '730499075544', '2021-06-04 14:33:57.016011', 'Deep Clean, plague quit tick\r\nMedication: Paracetamol, pain killer.', '0.00'),
(19, '750222095555', '2021-06-09 14:35:38.768220', 'Test remarks', '56.60'),
(20, '730499075544', '2021-06-09 15:20:13.242783', 'Teeth cleaning\r\n- Medication: Paracetamol\r\n', '56.50'),
(21, '730499075544', '2021-06-15 15:20:55.823667', 'Check, Cleaning, Removal\r\nMedication: Paracetamol', '56.50'),
(22, '750222095555', '2021-06-15 15:47:44.185326', 'Drilling, Crown, Cleaning\r\nPain Killer', '50.60'),
(23, '6566545030485', '2021-06-15 18:35:27.390592', 'Tooth removed number 7\r\nMed: Pain killer', '65.50'),
(24, '730499075544', '2021-06-18 12:58:08.988655', 'Dental removal no 11\r\nPainkiller', '90.50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_news`
--
ALTER TABLE `tbl_news`
  ADD PRIMARY KEY (`newsid`);

--
-- Indexes for table `tbl_patients`
--
ALTER TABLE `tbl_patients`
  ADD PRIMARY KEY (`icno`);

--
-- Indexes for table `tbl_visits`
--
ALTER TABLE `tbl_visits`
  ADD PRIMARY KEY (`visit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_news`
--
ALTER TABLE `tbl_news`
  MODIFY `newsid` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_visits`
--
ALTER TABLE `tbl_visits`
  MODIFY `visit_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
