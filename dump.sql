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
  `ttl` int(10) unsigned default NULL,
  `class` varchar(10) default NULL,
  `zone_id` int(10) unsigned NOT NULL default '0',
  `pref` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `mx_name` varchar(255) NOT NULL default '',
  `last_update_ts` int(10) unsigned default NULL,
  `insert_ts` int(10) unsigned default NULL,
  `view` enum('inside','outside','both') default NULL,
  PRIMARY KEY  (`zone_id`,`name`,`mx_name`,`pref`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mx_records`
--

LOCK TABLES `mx_records` WRITE;
/*!40000 ALTER TABLE `mx_records` DISABLE KEYS */;
INSERT INTO `mx_records` VALUES (0,NULL,1,1,'mailmaster.jasonantman.com.','mailmaster.jasonantman.com.',1247609389,1247609389,'inside'),(3600,NULL,1,10,'@','mailmaster.jasonantman.com',1247613459,1247613459,'outside'),(3600,NULL,1,50,'@','web2.jasonantman.com',1247613479,1247613479,'outside'),(3600,NULL,4,1,'@','mailmaster.jasonantman.com.',1247685144,1247685144,'both'),(3600,NULL,4,50,'@','web2.jasonantman.com.',1247685272,1247685272,'outside'),(3600,NULL,3,1,'@','mailmaster.jasonantman.com.',1247685345,1247685345,'both'),(3600,NULL,3,50,'@','web2.jasonantman.com.',1247685359,1247685359,'outside');
/*!40000 ALTER TABLE `mx_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `providers`
--

DROP TABLE IF EXISTS `providers`;
CREATE TABLE `providers` (
  `provider_id` int(10) unsigned NOT NULL auto_increment,
  `provider_name` varchar(255) default NULL,
  `insert_ts` int(10) unsigned default NULL,
  `default_for` varchar(20) default NULL,
  PRIMARY KEY  (`provider_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `providers`
--

LOCK TABLES `providers` WRITE;
/*!40000 ALTER TABLE `providers` DISABLE KEYS */;
INSERT INTO `providers` VALUES (1,'GoDaddy',NULL,''),(2,'INTERNAL',NULL,'inside'),(3,'EXTERNAL',NULL,'outside');
/*!40000 ALTER TABLE `providers` ENABLE KEYS */;
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
  `insert_ts` int(10) unsigned default NULL,
  `view` enum('inside','outside','both') default NULL,
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
  `ttl` int(10) unsigned default NULL,
  `class` varchar(10) default NULL,
  `zone_id` int(10) unsigned NOT NULL default '0',
  `rr_type` varchar(20) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  `last_update_ts` int(10) unsigned default NULL,
  `insert_ts` int(10) unsigned default NULL,
  `view` enum('inside','outside','both') NOT NULL default 'inside',
  `value2` varchar(255) default NULL,
  PRIMARY KEY  (`zone_id`,`rr_type`,`name`,`view`,`value`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `r_records`
--

LOCK TABLES `r_records` WRITE;
/*!40000 ALTER TABLE `r_records` DISABLE KEYS */;
INSERT INTO `r_records` VALUES (0,NULL,1,'A','er01','192.168.0.1',1247607966,1247607966,'inside',NULL),(3600,NULL,1,'CNAME','mpac','web2.jasonantman.com',1247613520,1247613520,'both',NULL),(3600,NULL,1,'A','saturn','192.168.0.6',1247632561,1247632561,'inside',NULL),(0,NULL,1,'NS','jasonantman.com.','svcs1.jasonantman.com.',1247610361,1247610361,'inside',NULL),(0,NULL,1,'A','LRdell','192.168.0.67',1247611392,1247611392,'inside',NULL),(0,NULL,1,'TXT','LRdell','Moms Dell desktop in living room',1247611500,1247611500,'inside',NULL),(3600,NULL,1,'NS','@','ns15.domaincontrol.com',1247612116,1247612116,'outside',NULL),(3600,NULL,1,'NS','@','ns16.domaincontrol.com',1247612194,1247612194,'outside',NULL),(3600,NULL,1,'A','web1','192.168.0.9',1247613229,1247613229,'both','96.57.180.130'),(3600,NULL,1,'A','mon1','192.168.0.8',1247613197,1247613197,'both','96.57.180.133'),(3600,NULL,1,'A','web2','192.168.0.5',1247612853,1247612853,'both','96.57.180.134'),(3600,NULL,1,'A','mailmaster','192.168.0.7',1247613271,1247613271,'both','96.57.180.131'),(3600,NULL,1,'A','svcs1','192.168.0.4',1247613307,1247613307,'both','96.57.180.132'),(3600,NULL,1,'CNAME','openid','web1.jasonantman.com',1247613556,1247613556,'both',NULL),(3600,NULL,1,'CNAME','sandbox2','web2.jasonantman.com',1247613572,1247613572,'both',NULL),(3600,NULL,1,'CNAME','ruslug','web1.jasonantman.com',1247613589,1247613589,'both',NULL),(3600,NULL,1,'CNAME','resume','web1.jasonantman.com',1247613616,1247613616,'both',NULL),(3600,NULL,1,'CNAME','rackman','web2.jasonantman.com',1247613630,1247613630,'both',NULL),(3600,NULL,1,'CNAME','secure','svcs1.jasonantman.com',1247613644,1247613644,'both',NULL),(3600,NULL,1,'CNAME','nagios','mon1.jasonantman.com',1247613666,1247613666,'both',NULL),(3600,NULL,1,'CNAME','admin','web1.jasonantman.com',1247613681,1247613681,'both',NULL),(3600,NULL,1,'CNAME','subversion','svn.jasonantman.com',1247613697,1247613697,'both',NULL),(3600,NULL,1,'CNAME','sandbox','web1.jasonantman.com',1247613712,1247613712,'both',NULL),(3600,NULL,1,'CNAME','wiki','web1.jasonantman.com',1247613726,1247613726,'both',NULL),(3600,NULL,1,'CNAME','tuxostat','web1.jasonantman.com',1247613739,1247613739,'both',NULL),(3600,NULL,1,'CNAME','rutgerswork','web1.jasonantman.com',1247613752,1247613752,'both',NULL),(3600,NULL,1,'CNAME','rpms','web1.jasonantman.com',1247613764,1247613764,'both',NULL),(3600,NULL,1,'CNAME','research','web1.jasonantman.com',1247613774,1247613774,'both',NULL),(3600,NULL,1,'CNAME','repo','web1.jasonantman.com',1247613787,1247613787,'both',NULL),(3600,NULL,1,'CNAME','photos','web1.jasonantman.com',1247613794,1247613794,'both',NULL),(3600,NULL,1,'CNAME','svn','web1.jasonantman.com',1247613804,1247613804,'both',NULL),(3600,NULL,1,'CNAME','cvs','web1.jasonantman.com',1247613812,1247613812,'both',NULL),(3600,NULL,1,'CNAME','consulting','web1.jasonantman.com',1247613822,1247613822,'both',NULL),(3600,NULL,1,'CNAME','bugs','web1.jasonantman.com',1247613831,1247613831,'both',NULL),(3600,NULL,1,'CNAME','blog','web1.jasonantman.com',1247613841,1247613841,'both',NULL),(3600,NULL,1,'CNAME','blacklabauth','web1.jasonantman.com',1247613853,1247613853,'both',NULL),(3600,NULL,1,'CNAME','www','web1.jasonantman.com',1247613864,1247613864,'both',NULL),(3600,NULL,1,'CNAME','smtp','mailmaster.jasonantman.com',1247613876,1247613876,'both',NULL),(3600,NULL,1,'CNAME','mail','mailmaster.jasonantman.com',1247613887,1247613887,'both',NULL),(3600,NULL,1,'A','puppet','192.168.0.10',1247632598,1247632598,'inside',NULL),(3600,NULL,1,'A','stor2','192.168.0.13',1247632630,1247632630,'inside',NULL),(3600,NULL,1,'A','antmanLaptop','192.168.0.21',1247632650,1247632650,'inside',NULL),(3600,NULL,1,'A','eee-jasonantman','192.168.0.22',1247632678,1247632678,'inside',NULL),(3600,NULL,1,'A','antman-thinkpad','192.168.0.23',1247632693,1247632693,'inside',NULL),(3600,NULL,1,'A','stor1','192.168.0.26',1247632705,1247632705,'inside',NULL),(3600,NULL,1,'A','er01-mgmt','192.168.0.95',1247632725,1247632725,'inside',NULL),(3600,NULL,1,'A','gs01','192.168.0.99',1247632737,1247632737,'inside',NULL),(3600,NULL,1,'A','web1-mgmt','192.168.0.100',1247632752,1247632752,'inside',NULL),(3600,NULL,1,'A','svcs1-ilo','192.168.0.101',1247632767,1247632767,'inside',NULL),(3600,NULL,1,'A','svcs1-mgmt','192.168.0.102',1247632784,1247632784,'inside',NULL),(3600,NULL,1,'A','ds1','192.168.0.103',1247632796,1247632796,'inside',NULL),(3600,NULL,1,'A','stor1-mgmt','104',1247632811,1247632811,'inside',NULL),(3600,NULL,1,'A','mailmaster-mgmt','192.168.0.105',1247632827,1247632827,'inside',NULL),(3600,NULL,1,'A','mon1-mgmt','192.168.0.106',1247632855,1247632855,'inside',NULL),(3600,NULL,1,'A','er01-ilo','192.168.0.107',1247632867,1247632867,'inside',NULL),(3600,NULL,1,'A','ups2','192.168.0.108',1247632881,1247632881,'inside',NULL),(3600,NULL,1,'A','ups3','192.168.0.109',1247632891,1247632891,'inside',NULL),(3600,NULL,1,'A','web2-ilo','192.168.0.110',1247632907,1247632907,'inside',NULL),(3600,NULL,1,'A','web2-mgmt','192.168.0.111',1247632918,1247632918,'inside',NULL),(3600,NULL,1,'A','stor2-mgmt','192.168.0.112',1247632933,1247632933,'inside',NULL),(3600,NULL,1,'A','puppet-mgmt','192.168.0.113',1247632945,1247632945,'inside',NULL),(3600,NULL,1,'A','AppleTV','192.168.0.68',1247633096,1247633096,'inside',NULL),(3600,NULL,1,'TXT','AppleTV','AppleTV in den',1247633116,1247633116,'inside',NULL),(3600,NULL,1,'A','lrprint','192.168.0.69',1247633130,1247633130,'inside',NULL),(3600,NULL,1,'TXT','lrprint','Living Room Printer - Brother HL-2170W',1247633146,1247633146,'inside',NULL),(3600,NULL,1,'CNAME','multibindadmin','web1.jasonantman.com',1247667600,1247667600,'both',NULL),(3600,NULL,1,'CNAME','xmlfinal','web1.jasonantman.com',1247667620,1247667620,'both',NULL),(3600,NULL,4,'CNAME','www','web1.jasonantman.com',1247684977,1247684977,'both',NULL),(3600,NULL,4,'CNAME','demo','web1.jasonantman.com',1247685002,1247685002,'both',NULL),(3600,NULL,4,'NS','@','svcs1.jasonantman.com.',1247685082,1247685082,'both',NULL),(3600,NULL,3,'NS','@','svcs1.jasonantman.com.',1247685411,1247685411,'both',NULL),(3600,NULL,3,'CNAME','www','web1.jasonantman.com',1247685453,1247685453,'both',NULL),(3600,NULL,3,'CNAME','bugs','bugs.jasonantman.com.',1247685479,1247685479,'both',NULL);
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
  `insert_ts` int(10) unsigned default NULL,
  `view` enum('inside','outside','both') default NULL,
  PRIMARY KEY  (`soa_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `soa_records`
--

LOCK TABLES `soa_records` WRITE;
/*!40000 ALTER TABLE `soa_records` DISABLE KEYS */;
INSERT INTO `soa_records` VALUES (1,0,'DEFAULT-IN',38400,'IN','svcs1.jasonantman.com.','root.jasonantman.com.',NULL,10800,3600,604800,38400,NULL,NULL,'inside'),(7,0,'DEFAULT-OUT',38400,'IN','svcs1.jasonantman.com.','root.jasonantman.com.',NULL,10800,3600,604800,38400,NULL,NULL,'outside'),(3,1,NULL,38400,'IN','svcs1.jasonantman.com.','root.jasonantman.com.',2009071404,10800,3600,604800,38400,1247599847,1247599847,'inside'),(4,1,NULL,38400,'IN','svcs1.jasonantman.com.','root.jasonantman.com.',2009071535,10800,3600,604800,38400,1247681915,1247600093,'outside'),(5,4,NULL,38400,'IN','svcs1.jasonantman.com.','root.jasonantman.com.',2009071508,10800,3600,604800,38400,1247683688,1247683688,'inside'),(8,4,NULL,38400,'IN','svcs1.jasonantman.com.','root.jasonantman.com.',2009071504,10800,3600,604800,38400,1247683924,1247683924,'outside'),(9,3,NULL,38400,'IN','svcs1.jasonantman.com.','root.jasonantman.com.',2009071541,10800,3600,604800,38400,1247683961,1247683961,'inside'),(10,3,NULL,38400,'IN','svcs1.jasonantman.com.','root.jasonantman.com.',2009071510,10800,3600,604800,38400,1247683990,1247683990,'outside'),(11,5,NULL,38400,'IN','svcs1.jasonantman.com.','root.jasonantman.com.',2009071518,10800,3600,604800,38400,1247683998,1247683998,'inside'),(12,5,NULL,38400,'IN','svcs1.jasonantman.com.','root.jasonantman.com.',2009071523,10800,3600,604800,38400,1247684003,1247684003,'outside'),(13,6,NULL,38400,'IN','svcs1.jasonantman.com.','root.jasonantman.com.',2009071528,10800,3600,604800,38400,1247684008,1247684008,'inside'),(14,6,NULL,38400,'IN','svcs1.jasonantman.com.','root.jasonantman.com.',2009071530,10800,3600,604800,38400,1247684010,1247684010,'outside'),(15,7,NULL,38400,'IN','svcs1.jasonantman.com.','root.jasonantman.com.',2009071535,10800,3600,604800,38400,1247684015,1247684015,'inside'),(16,7,NULL,38400,'IN','svcs1.jasonantman.com.','root.jasonantman.com.',2009071538,10800,3600,604800,38400,1247684018,1247684018,'outside');
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
  `insert_ts` int(10) unsigned default NULL,
  `view` enum('inside','outside','both') default NULL,
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
  `views` enum('inside','outside','both') default NULL,
  `last_update_ts` int(10) unsigned default NULL,
  `inside_provider_id` int(10) unsigned default NULL,
  `outside_provider_id` int(10) unsigned default NULL,
  `insert_ts` int(10) unsigned default NULL,
  `origin` varchar(100) default NULL,
  `ttl` int(10) unsigned default NULL,
  PRIMARY KEY  (`zone_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zones`
--

LOCK TABLES `zones` WRITE;
/*!40000 ALTER TABLE `zones` DISABLE KEYS */;
INSERT INTO `zones` VALUES (1,'jasonantman.com','both',1247594478,2,3,1247594478,'jasonantman.com.',3600),(3,'tuxtruck.org','both',1247595100,2,3,1247595100,'tuxtruck.org.',3600),(4,'php-ems-tools.com','both',1247681750,2,3,1247681750,'php-ems-tools.com.',3600),(5,'openepcr.org','both',1247681786,2,3,1247681786,'openepcr.org.',3600),(6,'kc2ozu.com','both',1247681796,2,3,1247681796,'kc2ozu.com.',3600),(7,'midlandparkambulance.com','both',1247681807,2,3,1247681807,'midlandparkambulance.com.',3600);
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

-- Dump completed on 2009-07-15 19:40:28
