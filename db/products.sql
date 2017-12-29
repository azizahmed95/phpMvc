-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 21, 2017 at 10:42 AM
-- Server version: 5.7.20-0ubuntu0.16.04.1
-- PHP Version: 5.6.31-1~ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `products`
--

-- --------------------------------------------------------

--
-- Table structure for table `myproducts`
--

CREATE TABLE `myproducts` (
  `pid` int(10) NOT NULL,
  `pname` varchar(100) NOT NULL,
  `bname` varchar(100) NOT NULL,
  `qty` int(10) NOT NULL,
  `price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `myproducts`
--

INSERT INTO `myproducts` (`pid`, `pname`, `bname`, `qty`, `price`) VALUES
(1, 'HP Laptop', 'HP', 25, 25000),
(2, 'Dell Laptop', 'Dell', 30, 30000),
(3, 'Nokia x6', 'nokia', 10, 10000),
(5, 'Samsung j5', 'samsung', 16, 35000),
(7, 'Xiomi Redmi 3s', 'xiomi', 20, 25300),
(9, 'abc', 'samsung', 10, 25000),
(12, 'Nikon camera ', 'nikon', 20, 15000),
(13, 'HP Laptop', 'xyz', 25, 25000),
(14, 'Dell Laptop', 'xyz', 25, 0),
(16, 'Iphone 6s', 'apple', 5, 50000),
(17, 'lenovo laptop', 'lenovo', 26, 45000),
(28, 'sjhklsdh', 'dfjkgh', 8, 8932),
(29, 'Samsung j7', 'samsung', 8, 47387),
(30, 'Samsung j5', 'HP', 5, 54556),
(45, 'jkhdfh', 'yjgu', 65, 67676),
(46, 'nokia x6', 'nokia ', 40, 45000),
(47, 'Samsung j8', 'samsung', 5, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `address1` varchar(100) NOT NULL,
  `address2` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `pincode` int(10) NOT NULL,
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`firstname`, `lastname`, `email`, `contact`, `address1`, `address2`, `country`, `state`, `city`, `pincode`, `id`) VALUES
('sdf', 'asdad', 'asdasd', 'asdad', 'asad', 'ada', 'aasdasd', 'asdasd', 'asasd', 3434, 1),
('sdf', 'sdfgsd', 'sdfsdf', 'sdfsdf', 'sdf', 'sdf', 'sdfsdf', 'dgfg', 'sdf', 234, 2),
('hjfgh', 'dxfxdf', 'dfdf', 'dfg', 'dfgdfg', 'dfgdfg', 'dfgdfg', 'dfgdg', 'dgdg', 445, 3),
('sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsf', 'sdfsdf', 'zfsdf', 'sdfsdf', 3434, 4),
('aziz', 'ahmed', 'jshjjfjjh', '7675568', 'jgjgklg', 'ghgjkgj', 'jkgjkgjkg', 'ghjgjkgj', 'jkgjkgjkg', 88787, 5),
('msdjkj', 'cjdjj', 'jdfjjhjh', '84848499', 'sdfdfbnfjh', 'dfbdf', 'dfujsdf', 'jkhsdf', 'ghysdg', 787879, 6);

-- --------------------------------------------------------

--
-- Table structure for table `test2`
--

CREATE TABLE `test2` (
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test2`
--

INSERT INTO `test2` (`fname`, `lname`, `id`) VALUES
('dfgdfg', 'sdfgsg', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `myproducts`
--
ALTER TABLE `myproducts`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test2`
--
ALTER TABLE `test2`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `myproducts`
--
ALTER TABLE `myproducts`
  MODIFY `pid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `test2`
--
ALTER TABLE `test2`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
