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
-- Table structure for table `dhcp_hosts`
--

DROP TABLE IF EXISTS `dhcp_hosts`;
CREATE TABLE `dhcp_hosts` (
  `dh_id` int(10) unsigned NOT NULL auto_increment,
  `mac_address` varchar(18) default NULL,
  `rr_name` varchar(255) default NULL,
  `rr_value` varchar(255) default NULL,
  `rr_view` enum('inside','outside','both') default NULL,
  PRIMARY KEY  (`dh_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Table structure for table `dhcp_pools`
--

DROP TABLE IF EXISTS `dhcp_pools`;
CREATE TABLE `dhcp_pools` (
  `dp_id` int(10) unsigned NOT NULL auto_increment,
  `start_ip` varchar(15) default NULL,
  `end_ip` varchar(15) default NULL,
  `subnet_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`dp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Table structure for table `dhcp_subnet_options`
--

DROP TABLE IF EXISTS `dhcp_subnet_options`;
CREATE TABLE `dhcp_subnet_options` (
  `dso_id` int(10) unsigned NOT NULL auto_increment,
  `subnet_id` int(10) unsigned default NULL,
  `option_name` varchar(255) default NULL,
  `option_value` varchar(255) default NULL,
  PRIMARY KEY  (`dso_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `host_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`zone_id`,`name`,`mx_name`,`pref`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `networks`
--

DROP TABLE IF EXISTS `networks`;
CREATE TABLE `networks` (
  `network_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `views` enum('inside','outside','both') default NULL,
  `last_update_ts` int(10) unsigned default NULL,
  `inside_provider_id` int(10) unsigned default NULL,
  `outside_provider_id` int(10) unsigned default NULL,
  `insert_ts` int(10) unsigned default NULL,
  `ttl` int(10) unsigned default NULL,
  PRIMARY KEY  (`network_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `host_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`ptr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `host_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`zone_id`,`rr_type`,`name`,`view`,`value`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

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
  `host_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`srv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `subnets`
--

DROP TABLE IF EXISTS `subnets`;
CREATE TABLE `subnets` (
  `subnet_id` int(10) unsigned NOT NULL auto_increment,
  `firstThree` varchar(12) default NULL,
  `start_ip` tinyint(3) default NULL,
  `end_ip` tinyint(3) default NULL,
  `netmask_cidr` int(11) default NULL,
  `name` varchar(100) default NULL,
  `view` enum('inside','outside','both') default NULL,
  `vlan_number` tinyint(3) default NULL,
  `last_update_ts` int(10) unsigned default NULL,
  `insert_ts` int(10) unsigned default NULL,
  `authoritative` tinyint(1) default '0',
  `allow_unknown` tinyint(1) default '0',
  `allow_ddns` tinyint(1) default '0',
  PRIMARY KEY  (`subnet_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

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
  `type` enum('forward','reverse') default NULL,
  PRIMARY KEY  (`zone_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-03-04 21:07:38
