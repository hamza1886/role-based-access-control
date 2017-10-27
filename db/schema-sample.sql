-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2017 at 11:31 AM
-- Server version: 5.6.15-log
-- PHP Version: 5.6.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `role_based_access_control`
--
CREATE DATABASE IF NOT EXISTS `role_based_access_control` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `role_based_access_control`;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `perm_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `perm_desc` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`perm_id`),
  UNIQUE KEY (`perm_desc`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=45 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`perm_id`, `perm_desc`) VALUES
(1, 'add_user'),
(2, 'update_user'),
(3, 'delete_user'),
(4, 'view_user'),
(5, 'add_accounts_info'),
(6, 'update_accounts_info'),
(7, 'delete_accounts_info'),
(8, 'view_accounts_info'),
(9, 'generate_balance_sheet'),
(10, 'update_balance_sheet'),
(11, 'delete_balance_sheet'),
(12, 'view_balance_sheet'),
(13, 'add_sales_info'),
(14, 'update_sales_info'),
(15, 'delete_sales_info'),
(16, 'view_sales_info'),
(17, 'add_billing_info'),
(18, 'update_billing_info'),
(19, 'delete_billing_info'),
(20, 'view_billing_info'),
(21, 'add_marketing_info'),
(22, 'update_marketing_info'),
(23, 'delete_marketing_info'),
(24, 'view_marketing_info'),
(25, 'generate_reports'),
(26, 'update_reports'),
(27, 'delete_reports'),
(28, 'view_reports'),
(29, 'generate_system_alert'),
(30, 'update_system_alert'),
(31, 'delete_system_alert'),
(32, 'view_system_alert'),
(33, 'add_role'),
(34, 'update_role'),
(35, 'delete_role'),
(36, 'view_role'),
(37, 'add_permission'),
(38, 'update_permission'),
(39, 'delete_permission'),
(40, 'view_permission');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY (`role_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'sales'),
(3, 'marketing'),
(4, 'finance'),
(5, 'it'),
(6, 'staff');

-- --------------------------------------------------------

--
-- Table structure for table `role_perm`
--

CREATE TABLE IF NOT EXISTS `role_perm` (
  `role_id` int(10) unsigned NOT NULL,
  `perm_id` int(10) unsigned NOT NULL,
  KEY `role_id` (`role_id`),
  UNIQUE KEY (`role_id`, `perm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_perm`
--

INSERT INTO `role_perm` (`role_id`, `perm_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 32),
(2, 36),
(3, 21),
(3, 22),
(3, 23),
(3, 24),
(3, 32),
(3, 36),
(4, 5),
(4, 6),
(4, 7),
(4, 8),
(4, 17),
(4, 18),
(4, 19),
(4, 20),
(4, 32),
(4, 36),
(5, 29),
(5, 30),
(5, 31),
(5, 32),
(5, 36),
(6, 25),
(6, 26),
(6, 27),
(6, 28),
(6, 32),
(6, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY (`username`),
  UNIQUE KEY (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `created_on`) VALUES
(1, 'hamza', '750be7cc52ba8d5066381c5f35c9152c41d958a206cf0c5ef42602362a47d98aed6e0d978bd702430489553ee667dfa6ea4c7f6641bba87143c908937ed8e1aa', 'hamza@company.com', '2017-10-25 18:07:47'),
(2, 'ali', '142ec5ad652a5fdb259e34b5f6316027a5067a633ce6ebe29622863f892f400da1ad3cdf482e58db0d06f04b25d70ec2ac489838608b88ed8f9553b53fd15eda', 'ali@company.com', '2017-10-25 19:44:31');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  KEY `user_id` (`user_id`),
  UNIQUE KEY (`user_id`, `role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(2, 3);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_perm`
--
ALTER TABLE `role_perm`
  ADD CONSTRAINT `role_perm_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`),
  ADD CONSTRAINT `role_perm_ibfk_2` FOREIGN KEY (`perm_id`) REFERENCES `permissions` (`perm_id`);

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
