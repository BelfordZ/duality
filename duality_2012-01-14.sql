# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 50.63.244.137 (MySQL 5.0.91-log)
# Database: duality
# Generation Time: 2012-01-13 21:08:38 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table ARTICLE
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ARTICLE`;

CREATE TABLE `ARTICLE` (
  `type` varchar(11) NOT NULL default '',
  `cost` double NOT NULL,
  PRIMARY KEY  (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ARTICLE` WRITE;
/*!40000 ALTER TABLE `ARTICLE` DISABLE KEYS */;

INSERT INTO `ARTICLE` (`type`, `cost`)
VALUES
	('Bandana',7.5),
	('Hood',40),
	('HoodCuff',45),
	('TShirt',15);

/*!40000 ALTER TABLE `ARTICLE` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table CUSTOMER
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CUSTOMER`;

CREATE TABLE `CUSTOMER` (
  `username` varchar(11) NOT NULL default '',
  `pword` varchar(32) NOT NULL default '',
  `name_first` varchar(11) default NULL,
  `name_last` varchar(11) default NULL,
  `address` varchar(11) default NULL,
  `postcode` varchar(11) default NULL,
  `city` varchar(11) default NULL,
  `country` varchar(11) default NULL,
  `company_name` varchar(11) default NULL,
  `phone` int(10) NOT NULL,
  PRIMARY KEY  (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `CUSTOMER` WRITE;
/*!40000 ALTER TABLE `CUSTOMER` DISABLE KEYS */;

INSERT INTO `CUSTOMER` (`username`, `pword`, `name_first`, `name_last`, `address`, `postcode`, `city`, `country`, `company_name`, `phone`)
VALUES
	('test','098f6bcd4621d373cade4e832627b4f6','test','test','test','test','test','test','test',93284);

/*!40000 ALTER TABLE `CUSTOMER` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ITEM
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ITEM`;

CREATE TABLE `ITEM` (
  `name` varchar(15) NOT NULL default '',
  `season` int(2) unsigned NOT NULL,
  `type` varchar(11) NOT NULL default '',
  `iid` int(11) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`iid`),
  KEY `type` (`type`),
  CONSTRAINT `ITEM_ibfk_1` FOREIGN KEY (`type`) REFERENCES `ARTICLE` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ITEM` WRITE;
/*!40000 ALTER TABLE `ITEM` DISABLE KEYS */;

INSERT INTO `ITEM` (`name`, `season`, `type`, `iid`)
VALUES
	('Acid TShirt',0,'TShirt',1);

/*!40000 ALTER TABLE `ITEM` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ORDER
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ORDER`;

CREATE TABLE `ORDER` (
  `oid` int(11) unsigned NOT NULL auto_increment,
  `username` varchar(11) NOT NULL default '',
  `total_cost` int(11) default NULL,
  `date` int(11) default NULL,
  PRIMARY KEY  (`oid`),
  KEY `username` (`username`),
  CONSTRAINT `ORDER_ibfk_1` FOREIGN KEY (`username`) REFERENCES `CUSTOMER` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ORDER_ARTICLE
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ORDER_ARTICLE`;

CREATE TABLE `ORDER_ARTICLE` (
  `oaid` int(11) unsigned NOT NULL auto_increment,
  `iid` int(11) unsigned NOT NULL,
  `qty` int(4) NOT NULL,
  `items_cost` int(6) default NULL,
  `oid` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`oaid`),
  KEY `iid` (`iid`),
  KEY `oid` (`oid`),
  CONSTRAINT `ORDER_ARTICLE_ibfk_2` FOREIGN KEY (`oid`) REFERENCES `ORDER` (`oid`),
  CONSTRAINT `ORDER_ARTICLE_ibfk_1` FOREIGN KEY (`iid`) REFERENCES `ITEM` (`iid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table STOCK
# ------------------------------------------------------------

DROP TABLE IF EXISTS `STOCK`;

CREATE TABLE `STOCK` (
  `colour` varchar(10) NOT NULL default '0',
  `xl_stock` int(3) default NULL,
  `l_stock` int(3) default NULL,
  `m_stock` int(3) default NULL,
  `s_stock` int(3) default NULL,
  `iid` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`colour`),
  KEY `iid` (`iid`),
  CONSTRAINT `STOCK_ibfk_1` FOREIGN KEY (`iid`) REFERENCES `ITEM` (`iid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `STOCK` WRITE;
/*!40000 ALTER TABLE `STOCK` DISABLE KEYS */;

INSERT INTO `STOCK` (`colour`, `xl_stock`, `l_stock`, `m_stock`, `s_stock`, `iid`)
VALUES
	('Black',30,30,30,30,1),
	('Blue',30,30,30,30,1),
	('Yellow',30,30,30,30,1);

/*!40000 ALTER TABLE `STOCK` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
