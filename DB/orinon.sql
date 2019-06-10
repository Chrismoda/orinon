-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2019 at 02:35 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orinon`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `emailAddress` varchar(100) NOT NULL,
  `passWord` varchar(100) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `surName` varchar(100) NOT NULL,
  `nationalId` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`emailAddress`, `passWord`, `firstName`, `surName`, `nationalId`) VALUES
('chris@gmail.com', 'Password', 'Christopher', 'Nyandoro', '63 - 1499998 Q 48'),
('echishanu05@gmail.com', 'Elma1986&', 'Ephraim', 'Chishanu', '63-1304862L47');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `nationalId` varchar(15) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `surName` varchar(50) NOT NULL,
  `emailAddress` varchar(100) NOT NULL,
  `passWord` varchar(50) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `maritalStatus` varchar(20) NOT NULL,
  `phoneNumber` int(11) NOT NULL,
  `nameOfemployer` varchar(50) NOT NULL,
  `institution` varchar(50) NOT NULL,
  `c_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`nationalId`, `firstName`, `surName`, `emailAddress`, `passWord`, `sex`, `address`, `occupation`, `maritalStatus`, `phoneNumber`, `nameOfemployer`, `institution`, `c_score`) VALUES
('24-199675T24', 'leon', 'lankeni', 'lankenileon@yahoo.com', 'Nyashaleon19', '', '', '', '', 0, '', '', 0),
('63-1304862L47', 'Ephraim', 'Chishanu', 'echishanu05@gmail.com', 'Elma1986&', '', '', '', '', 0, '', '', 0),
('63-77777887-D89', 'Chris', 'Nyandoro', 'chris@gmail.com', 'Password', '', '', '', '', 0, '', '', 1343);

-- --------------------------------------------------------

--
-- Table structure for table `creditscoreuploads`
--

CREATE TABLE `creditscoreuploads` (
  `id` int(11) NOT NULL,
  `user` varchar(200) NOT NULL,
  `file` varchar(100) NOT NULL,
  `job` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `cat` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `creditscoreuploads`
--

INSERT INTO `creditscoreuploads` (`id`, `user`, `file`, `job`, `date`, `cat`, `status`) VALUES
(46, '63-77777887-D89', 'AI.pdf', '6268', '2019-06-08', 4, '1'),
(47, '63-77777887-D89', 'HCS 404-Notes.pdf', '6268', '2019-06-08', 5, '1'),
(48, '63-77777887-D89', 'overview.pdf', '6268', '2019-06-08', 6, '1');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `user` varchar(100) NOT NULL,
  `path` varchar(200) NOT NULL,
  `cat` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `user`, `path`, `cat`) VALUES
(7, '63-77777887-D89', '/account/users/files/AI.pdf', '4'),
(8, '63-77777887-D89', '/account/users/files/HCS 404-Notes.pdf', '5'),
(9, '63-77777887-D89', '/account/users/files/overview.pdf', '6');

-- --------------------------------------------------------

--
-- Table structure for table `f_cat`
--

CREATE TABLE `f_cat` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `f_cat`
--

INSERT INTO `f_cat` (`id`, `name`) VALUES
(4, 'National ID'),
(5, 'Car Registration Book'),
(6, 'Title Deeds');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` varchar(200) NOT NULL,
  `user` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `finishDate` datetime NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `user`, `date`, `finishDate`, `status`) VALUES
('6268', '63-77777887-D89', '2019-06-08 12:17:49', '0000-00-00 00:00:00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `loanapps`
--

CREATE TABLE `loanapps` (
  `id` varchar(200) NOT NULL,
  `user` varchar(200) NOT NULL,
  `amnt` double NOT NULL,
  `dt` datetime NOT NULL,
  `ltype` enum('4','5','6') NOT NULL,
  `due_dt` int(11) NOT NULL,
  `interest` decimal(10,0) NOT NULL,
  `status` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loancat`
--

CREATE TABLE `loancat` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loancat`
--

INSERT INTO `loancat` (`id`, `name`, `score`) VALUES
(1, 'Educational', 100),
(2, 'Bisiness', 1000),
(3, 'Mortgages', 5000);

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` varchar(100) NOT NULL,
  `us_id` varchar(100) NOT NULL,
  `type` enum('1','2','3') NOT NULL,
  `amnt` double NOT NULL,
  `interest` decimal(10,0) NOT NULL,
  `dt_applied` datetime NOT NULL,
  `due_dt` varchar(200) NOT NULL,
  `ack_recpt` enum('0','1') NOT NULL DEFAULT '0',
  `status` enum('0','1','2','3') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`nationalId`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`nationalId`);

--
-- Indexes for table `creditscoreuploads`
--
ALTER TABLE `creditscoreuploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `f_cat`
--
ALTER TABLE `f_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loanapps`
--
ALTER TABLE `loanapps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loancat`
--
ALTER TABLE `loancat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `creditscoreuploads`
--
ALTER TABLE `creditscoreuploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `f_cat`
--
ALTER TABLE `f_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `loancat`
--
ALTER TABLE `loancat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
