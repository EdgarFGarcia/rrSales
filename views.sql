-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 28, 2019 at 11:20 PM
-- Server version: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `RSalesAnalytics`
--

-- --------------------------------------------------------

--
-- Structure for view `sales`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `sales_all`  AS  select upper(ifnull(convert(ltrim(rtrim(((`d`.`First Name` + ' ') + `d`.`Last Name`))) using latin1),`S`.`Name`)) AS `MD Name`,`d`.`Specialty` AS `specialty`,`d`.`Frequency` AS `frequency`,`S`.`item_name` AS `Product`,(case when (`d`.`City` > '') then `d`.`City` else '(Unknown City)' end) AS `City`,`d`.`Medrep Name` AS `Medrep Name`,`d`.`Manager Name` AS `Manager Name`,`P`.`class` AS `TC`,`P`.`subclass` AS `subclass`,`d`.`MD Class` AS `MD Class`,`S`.`Qty` AS `Volume`,`S`.`Amount` AS `Value` from ((`SalesByRep` `S` join `Doctor` `d` on((`S`.`MD ID` = `d`.`MD ID`))) join `PRODUCT_TC` `P` on((`P`.`item_code` = `S`.`item_code`))) ;

--
-- VIEW  `sales`
-- Data: None
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
