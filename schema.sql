-- MySQL dump 10.13  Distrib 5.5.40, for Linux (x86_64)
--
-- Host: localhost    Database: radiology
-- ------------------------------------------------------
-- Server version	5.5.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `show_name` varchar(100) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `protocol`
--

DROP TABLE IF EXISTS `protocol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `protocol` (
  `Protocol ID` varchar(50) DEFAULT NULL,
  `Protocol Name` varchar(255) DEFAULT NULL,
  `Protocol Category` varchar(255) DEFAULT NULL,
  `Report Template` text,
  `Indications` text,
  FULLTEXT KEY `protocol_name` (`Protocol Name`,`Indications`,`Protocol Category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `protocol_backup`
--

DROP TABLE IF EXISTS `protocol_backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `protocol_backup` (
  `Protocol ID` varchar(50) DEFAULT NULL,
  `Protocol Name` varchar(255) DEFAULT NULL,
  `Protocol Category` varchar(255) DEFAULT NULL,
  `Report Template` text,
  `Indications` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `record`
--

DROP TABLE IF EXISTS `record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `record` (
  `Protocol ID` varchar(50) NOT NULL,
  `Protocol Name` varchar(50) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `series_ct`
--

DROP TABLE IF EXISTS `series_ct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `series_ct` (
  `Series` varchar(1000) NOT NULL,
  `Orientation` text,
  `Intravenous Contrast` text,
  `Oral Contrast` varchar(1000) DEFAULT NULL,
  `Scout` varchar(1000) DEFAULT NULL,
  `Scanning Mode` varchar(1000) DEFAULT NULL,
  `Range/Direction` text,
  `Gantry Angle` text,
  `Algorithm` varchar(1000) DEFAULT NULL,
  `Beam Collimation / Detector Configuration` varchar(1000) DEFAULT NULL,
  `Slice Thickness` varchar(1000) DEFAULT NULL,
  `Interval` varchar(1000) DEFAULT NULL,
  `Table Speed (mm/rotation)` varchar(1000) DEFAULT NULL,
  `Pitch` varchar(1000) DEFAULT NULL,
  `kVp` varchar(1000) DEFAULT NULL,
  `mA` varchar(1000) DEFAULT NULL,
  `Noise Index` varchar(1000) DEFAULT NULL,
  `Noise Reduction` varchar(1000) DEFAULT NULL,
  `Rotation Time` varchar(1000) DEFAULT NULL,
  `Scan FOV` varchar(1000) DEFAULT NULL,
  `Display FOV` varchar(1000) DEFAULT NULL,
  `Scan Delay` varchar(1000) DEFAULT NULL,
  `Post Processing` text,
  `Transfer Images` text,
  `Notes` text,
  `CTDI` text,
  `Protocol ID` varchar(100) DEFAULT NULL,
  `Scanner` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `series_ct_backup`
--

DROP TABLE IF EXISTS `series_ct_backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `series_ct_backup` (
  `Series` varchar(1000) NOT NULL,
  `Orientation` text,
  `Intravenous Contrast` text,
  `Oral Contrast` varchar(1000) DEFAULT NULL,
  `Scout` varchar(1000) DEFAULT NULL,
  `Scanning Mode` varchar(1000) DEFAULT NULL,
  `Range/Direction` text,
  `Gantry Angle` text,
  `Algorithm` varchar(1000) DEFAULT NULL,
  `Beam Collimation / Detector Configuration` varchar(1000) DEFAULT NULL,
  `Slice Thickness` varchar(1000) DEFAULT NULL,
  `Interval` varchar(1000) DEFAULT NULL,
  `Table Speed (mm/rotation)` varchar(1000) DEFAULT NULL,
  `Pitch` varchar(1000) DEFAULT NULL,
  `kVp` varchar(1000) DEFAULT NULL,
  `mA` varchar(1000) DEFAULT NULL,
  `Noise Index` varchar(1000) DEFAULT NULL,
  `Noise Reduction` varchar(1000) DEFAULT NULL,
  `Rotation Time` varchar(1000) DEFAULT NULL,
  `Scan FOV` varchar(1000) DEFAULT NULL,
  `Display FOV` varchar(1000) DEFAULT NULL,
  `Scan Delay` varchar(1000) DEFAULT NULL,
  `Post Processing` text,
  `Transfer Images` text,
  `Notes` text,
  `CTDI` text,
  `Protocol ID` varchar(100) DEFAULT NULL,
  `Scanner` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `series_mr`
--

DROP TABLE IF EXISTS `series_mr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `series_mr` (
  `Series` varchar(1000) NOT NULL,
  `Pulse Sequence` varchar(255) DEFAULT NULL,
  `Plane` varchar(255) DEFAULT NULL,
  `Imaging Mode` varchar(255) DEFAULT NULL,
  `Sequence Description` text,
  `Localization` varchar(1000) DEFAULT NULL,
  `FOV` varchar(255) DEFAULT NULL,
  `MATRIX (1.5T)` varchar(255) DEFAULT NULL,
  `MATRIX (3T)` varchar(255) DEFAULT NULL,
  `NEX` varchar(1000) DEFAULT NULL,
  `Bandwidth` varchar(1000) DEFAULT NULL,
  `THK/SPACE` varchar(255) DEFAULT NULL,
  `Sequence options` varchar(200) DEFAULT NULL,
  `Injection options` text,
  `Time` varchar(255) DEFAULT NULL,
  `Protocol ID` varchar(100) DEFAULT NULL,
  `Scanner` text,
  `Notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `series_mr_backup`
--

DROP TABLE IF EXISTS `series_mr_backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `series_mr_backup` (
  `Series` varchar(1000) NOT NULL,
  `Pulse Sequence` varchar(255) DEFAULT NULL,
  `Plane` varchar(255) DEFAULT NULL,
  `Imaging Mode` varchar(255) DEFAULT NULL,
  `Sequence Description` text,
  `Localization` varchar(1000) DEFAULT NULL,
  `FOV` varchar(255) DEFAULT NULL,
  `MATRIX (1.5T)` varchar(255) DEFAULT NULL,
  `MATRIX (3T)` varchar(255) DEFAULT NULL,
  `NEX` varchar(1000) DEFAULT NULL,
  `Bandwidth` varchar(1000) DEFAULT NULL,
  `THK/SPACE` varchar(255) DEFAULT NULL,
  `Sequence options` varchar(200) DEFAULT NULL,
  `Injection options` text,
  `Time` varchar(255) DEFAULT NULL,
  `Protocol ID` varchar(100) DEFAULT NULL,
  `Scanner` text,
  `Notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `reg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-13 21:22:33
