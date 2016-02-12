-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 12, 2016 at 12:00 AM
-- Server version: 5.5.45-cll-lve
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `indemp`
--

-- --------------------------------------------------------

--
-- Table structure for table `alpp_adminlog`
--

CREATE TABLE IF NOT EXISTS `alpp_adminlog` (
  `adminlog_id` int(11) NOT NULL AUTO_INCREMENT,
  `adminlog_email` varchar(50) NOT NULL,
  `adminlog_password` varchar(200) NOT NULL,
  `adminlog_name` varchar(20) NOT NULL,
  PRIMARY KEY (`adminlog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `alpp_emp`
--

CREATE TABLE IF NOT EXISTS `alpp_emp` (
  `emp_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_file` varchar(30) NOT NULL,
  `emp_department` varchar(50) NOT NULL,
  `emp_name` varchar(30) NOT NULL,
  `emp_current_contract` datetime NOT NULL,
  `emp_first_contract` datetime NOT NULL,
  `emp_fathername` varchar(20) NOT NULL,
  `emp_gender` varchar(7) NOT NULL,
  `emp_designation` varchar(20) NOT NULL,
  `emp_account_no` varchar(50) NOT NULL,
  `emp_cellnum` varchar(15) NOT NULL,
  `emp_landline` varchar(15) NOT NULL,
  `emp_address` varchar(50) NOT NULL,
  `emp_qualification` varchar(20) NOT NULL,
  `emp_pic` varchar(200) NOT NULL,
  `emp_email` varchar(50) NOT NULL,
  `emp_password` varchar(50) NOT NULL,
  `emp_status` int(11) NOT NULL,
  `emp_count` int(11) NOT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=133 ;

-- --------------------------------------------------------

--
-- Table structure for table `alpp_emp1`
--

CREATE TABLE IF NOT EXISTS `alpp_emp1` (
  `emp_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_file` varchar(30) NOT NULL,
  `emp_name` varchar(30) NOT NULL,
  `emp_current_contract` datetime NOT NULL,
  `emp_first_contract` datetime NOT NULL,
  `emp_fathername` varchar(20) NOT NULL,
  `emp_gender` varchar(7) NOT NULL,
  `emp_designation` varchar(20) NOT NULL,
  `emp_account_no` varchar(50) NOT NULL,
  `emp_cellnum` varchar(15) NOT NULL,
  `emp_landline` varchar(15) NOT NULL,
  `emp_address` varchar(50) NOT NULL,
  `emp_qualification` varchar(20) NOT NULL,
  `emp_pic` varchar(200) NOT NULL,
  `emp_email` varchar(50) NOT NULL,
  `emp_password` varchar(50) NOT NULL,
  `emp_status` int(11) NOT NULL,
  `emp_salary` int(11) NOT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=119 ;

-- --------------------------------------------------------

--
-- Table structure for table `alpp_emp2`
--

CREATE TABLE IF NOT EXISTS `alpp_emp2` (
  `emp_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_file` varchar(30) NOT NULL,
  `emp_department` varchar(50) NOT NULL,
  `emp_name` varchar(30) NOT NULL,
  `emp_current_contract` datetime NOT NULL,
  `emp_first_contract` datetime NOT NULL,
  `emp_fathername` varchar(20) NOT NULL,
  `emp_gender` varchar(7) NOT NULL,
  `emp_designation` varchar(20) NOT NULL,
  `emp_account_no` varchar(50) NOT NULL,
  `emp_cellnum` varchar(15) NOT NULL,
  `emp_landline` varchar(15) NOT NULL,
  `emp_address` varchar(50) NOT NULL,
  `emp_qualification` varchar(20) NOT NULL,
  `emp_pic` varchar(200) NOT NULL,
  `emp_email` varchar(50) NOT NULL,
  `emp_password` varchar(50) NOT NULL,
  `emp_status` int(11) NOT NULL,
  `emp_salary` int(11) NOT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=109 ;

-- --------------------------------------------------------

--
-- Table structure for table `alpp_holidays`
--

CREATE TABLE IF NOT EXISTS `alpp_holidays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `date` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alpp_leave`
--

CREATE TABLE IF NOT EXISTS `alpp_leave` (
  `leave_id` int(11) NOT NULL AUTO_INCREMENT,
  `leave_emp_id` int(11) NOT NULL,
  `leave_reason` text NOT NULL,
  `leave_duration` varchar(50) NOT NULL,
  `leave_duration_from` datetime NOT NULL,
  `leave_duration_to` datetime NOT NULL,
  `leave_approval` int(11) NOT NULL,
  `leave_datetime` datetime NOT NULL,
  `leave_user` varchar(50) NOT NULL,
  `leave_balance_type` enum('D','I') DEFAULT NULL,
  PRIMARY KEY (`leave_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `alpp_transactions`
--

CREATE TABLE IF NOT EXISTS `alpp_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `end_month_data` datetime NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `trans_type` enum('C','I','M','L','D') NOT NULL,
  `date` datetime NOT NULL,
  `done_by` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=262 ;

-- --------------------------------------------------------

--
-- Table structure for table `alpp_transactions2`
--

CREATE TABLE IF NOT EXISTS `alpp_transactions2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `end_month_data` datetime NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `trans_type` enum('C','D') NOT NULL,
  `date` datetime NOT NULL,
  `done_by` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=121 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
