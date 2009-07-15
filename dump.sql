-- MySQL dump 10.10
--
-- Host: localhost    Database: multibindadmin
-- ------------------------------------------------------
-- Server version	5.0.26

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
-- Table structure for table `mx_records`
--

DROP TABLE IF EXISTS `mx_records`;
CREATE TABLE `mx_records` (
  `mx_id` int(10) unsigned NOT NULL auto_increment,
  `ttl` int(10) unsigned default NULL,
  `class` varchar(10) default NULL,
  `zone_id` int(10) unsigned default NULL,
  `pref` int(10) unsigned default NULL,
  `name` varchar(255) default NULL,
  `mx_name` varchar(255) default NULL,
  `last_update_ts` int(10) unsigned default NULL,
  PRIMARY KEY  (`mx_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mx_records`
--

LOCK TABLES `mx_records` WRITE;
/*!40000 ALTER TABLE `mx_records` DISABLE KEYS */;
/*!40000 ALTER TABLE `mx_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ptr_records`
--

DROP TABLE IF EXISTS `ptr_records`;
CREATE TABLE `ptr_records` (
  `ptr_id` int(10) unsigned NOT NULL auto_increment,
  `ttl` int(10) unsigned default NULL,
  `class` varchar(10) default NULL,
  `zone_id` int(10) unsigned default NULL,
  `ptr_address` varchar(20) default NULL,
  `name` varchar(255) default NULL,
  `last_update_ts` int(10) unsigned default NULL,
  PRIMARY KEY  (`ptr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ptr_records`
--

LOCK TABLES `ptr_records` WRITE;
/*!40000 ALTER TABLE `ptr_records` DISABLE KEYS */;
/*!40000 ALTER TABLE `ptr_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `r_records`
--

DROP TABLE IF EXISTS `r_records`;
CREATE TABLE `r_records` (
  `rr_id` int(10) unsigned NOT NULL auto_increment,
  `ttl` int(10) unsigned default NULL,
  `class` varchar(10) default NULL,
  `zone_id` int(10) unsigned default NULL,
  `rr_type` varchar(20) default NULL,
  `name` varchar(255) default NULL,
  `value` varchar(255) default NULL,
  `last_update_ts` int(10) unsigned default NULL,
  PRIMARY KEY  (`rr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `r_records`
--

LOCK TABLES `r_records` WRITE;
/*!40000 ALTER TABLE `r_records` DISABLE KEYS */;
/*!40000 ALTER TABLE `r_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `soa_records`
--

DROP TABLE IF EXISTS `soa_records`;
CREATE TABLE `soa_records` (
  `soa_id` int(10) unsigned NOT NULL auto_increment,
  `zone_id` int(10) unsigned default NULL,
  `name` varchar(255) default NULL,
  `ttl` int(10) unsigned default NULL,
  `class` varchar(5) default NULL,
  `name_server` varchar(255) default NULL,
  `email_addr` varchar(255) default NULL,
  `current_serial` int(10) unsigned default NULL,
  `refresh` int(10) unsigned default NULL,
  `retry` int(10) unsigned default NULL,
  `expiry` int(10) unsigned default NULL,
  `minimum` int(10) unsigned default NULL,
  `last_update_ts` int(10) unsigned default NULL,
  PRIMARY KEY  (`soa_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `soa_records`
--

LOCK TABLES `soa_records` WRITE;
/*!40000 ALTER TABLE `soa_records` DISABLE KEYS */;
/*!40000 ALTER TABLE `soa_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `srv_records`
--

DROP TABLE IF EXISTS `srv_records`;
CREATE TABLE `srv_records` (
  `srv_id` int(10) unsigned NOT NULL auto_increment,
  `ttl` int(10) unsigned default NULL,
  `class` varchar(10) default NULL,
  `zone_id` int(10) unsigned default NULL,
  `srvce` varchar(100) default NULL,
  `prot` varchar(100) default NULL,
  `name` varchar(100) default NULL,
  `pri` int(10) unsigned default NULL,
  `weight` int(10) unsigned default NULL,
  `port` int(10) unsigned default NULL,
  `target` varchar(255) default NULL,
  `last_update_ts` int(10) unsigned default NULL,
  PRIMARY KEY  (`srv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `srv_records`
--

LOCK TABLES `srv_records` WRITE;
/*!40000 ALTER TABLE `srv_records` DISABLE KEYS */;
/*!40000 ALTER TABLE `srv_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zones`
--

DROP TABLE IF EXISTS `zones`;
CREATE TABLE `zones` (
  `zone_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `inside_provider` varchar(255) default NULL,
  `outside_provider` varchar(255) default NULL,
  `views` enum('inside','outside','both') default NULL,
  `last_update_ts` int(10) unsigned default NULL,
  PRIMARY KEY  (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zones`
--

LOCK TABLES `zones` WRITE;
/*!40000 ALTER TABLE `zones` DISABLE KEYS */;
/*!40000 ALTER TABLE `zones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-07-14 15:09:17
