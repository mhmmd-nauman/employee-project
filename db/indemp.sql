-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2016 at 07:01 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_emp`
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
-- Table structure for table `alpp_alert_systems`
--

CREATE TABLE IF NOT EXISTS `alpp_alert_systems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `alpp_emp`
--

CREATE TABLE IF NOT EXISTS `alpp_emp` (
  `emp_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_file` varchar(30) NOT NULL,
  `emp_department` varchar(50) NOT NULL,
  `emp_name` varchar(60) NOT NULL,
  `emp_current_contract` datetime NOT NULL,
  `emp_first_contract` datetime NOT NULL,
  `emp_fathername` varchar(20) NOT NULL,
  `emp_gender` varchar(7) NOT NULL,
  `emp_designation` varchar(20) NOT NULL,
  `emp_account_no` varchar(50) NOT NULL,
  `emp_cellnum` varchar(30) NOT NULL,
  `emp_landline` varchar(15) NOT NULL,
  `emp_address` varchar(50) NOT NULL,
  `emp_qualification` varchar(20) NOT NULL,
  `emp_pic` varchar(200) NOT NULL,
  `emp_email` varchar(50) NOT NULL,
  `emp_password` varchar(50) NOT NULL,
  `emp_status` int(11) NOT NULL,
  `emp_count` int(11) NOT NULL,
  `emp_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=148 ;

-- --------------------------------------------------------

--
-- Table structure for table `alpp_emp_notes`
--

CREATE TABLE IF NOT EXISTS `alpp_emp_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) DEFAULT NULL,
  `notes` text,
  `file` varchar(50) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `filetype` varchar(50) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `entered_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `alpp_holidays`
--

CREATE TABLE IF NOT EXISTS `alpp_holidays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL,
  `title` text NOT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `alpp_holidays_type`
--

CREATE TABLE IF NOT EXISTS `alpp_holidays_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `alpp_leave`
--

CREATE TABLE IF NOT EXISTS `alpp_leave` (
  `leave_id` int(11) NOT NULL AUTO_INCREMENT,
  `leave_emp_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `leave_reason` text NOT NULL,
  `leave_duration` varchar(50) NOT NULL,
  `leave_duration_from` datetime NOT NULL,
  `leave_duration_to` datetime NOT NULL,
  `leave_approval` int(11) NOT NULL,
  `leave_datetime` datetime NOT NULL,
  `leave_user` varchar(50) NOT NULL,
  `leave_balance_type` enum('D','I') DEFAULT NULL,
  `half_day` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`leave_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `alpp_permissions`
--

CREATE TABLE IF NOT EXISTS `alpp_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `file` varchar(50) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `alpp_transactions`
--

CREATE TABLE IF NOT EXISTS `alpp_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `end_month_data` datetime NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `trans_type` enum('C','I','M','L','D','F') NOT NULL,
  `date` datetime NOT NULL,
  `done_by` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=236 ;

-- --------------------------------------------------------

--
-- Table structure for table `alpp_user_groups`
--

CREATE TABLE IF NOT EXISTS `alpp_user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `alpp_user_permissions`
--

CREATE TABLE IF NOT EXISTS `alpp_user_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `per_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `twillio`
--

CREATE TABLE IF NOT EXISTS `twillio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `From` text,
  `Body` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `social_id` varchar(100) NOT NULL,
  `picture` varchar(500) NOT NULL,
  `created` datetime NOT NULL,
  `uuid` varchar(70) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `email` (`email`),
  KEY `password` (`password`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
