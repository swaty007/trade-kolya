-- MySQL dump 10.13  Distrib 5.6.12, for Win64 (x86_64)
--
-- Host: localhost    Database: site1
-- ------------------------------------------------------
-- Server version	5.6.12-log

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
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(255) DEFAULT NULL,
  `currency_code` varchar(255) DEFAULT NULL,
  `main` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
INSERT INTO `currency` VALUES (1,'US Dollar','USDT',1),(2,'Bitcoin','BTC',0),(3,'ETH','ETH',0),(4,'BNB','BNB',0),(5,'BCC','BCC',0),(6,'NEO','NEO',0),(7,'LTC','LTC',0);
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency_exchange`
--

DROP TABLE IF EXISTS `currency_exchange`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency_exchange` (
  `currency_id` int(11) NOT NULL DEFAULT '0',
  `marketplace_id` int(11) NOT NULL DEFAULT '0',
  `symbol` varchar(255) DEFAULT NULL,
  `date` int(11) NOT NULL DEFAULT '0',
  `price` float(12,8) NOT NULL DEFAULT '0.00000000',
  KEY `index_date` (`date`),
  KEY `index_marketplace_id` (`marketplace_id`),
  KEY `course` (`marketplace_id`,`symbol`(8),`date`),
  KEY `delete_index` (`marketplace_id`,`date`),
  KEY `index_symbol` (`symbol`(8))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency_exchange`
--

LOCK TABLES `currency_exchange` WRITE;
/*!40000 ALTER TABLE `currency_exchange` DISABLE KEYS */;
/*!40000 ALTER TABLE `currency_exchange` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marketplace`
--

DROP TABLE IF EXISTS `marketplace`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marketplace` (
  `marketplace_id` int(11) NOT NULL AUTO_INCREMENT,
  `marketplace_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`marketplace_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marketplace`
--

LOCK TABLES `marketplace` WRITE;
/*!40000 ALTER TABLE `marketplace` DISABLE KEYS */;
INSERT INTO `marketplace` VALUES (1,'Binance'),(2,'Test Place');
/*!40000 ALTER TABLE `marketplace` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `status` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Дмитрий','BrqYG0hVa9dJ9z1NJjxUG6aR9ufrXq9D','$2y$13$6MZATxy3Jsg7pAA4CiyaJulNc0ZruS8YKYRbpilXzr/rbD.Iy/TaK',NULL,'dimamail@ukr.net','10',1521352807,1521352807),(2,'Дмитрий','e4NE-hW4lFbas_7LXi_z_ooOW1fwowYs','$2y$13$7ySU2d.o1o8vIn5hg1pDAuQ5VL86ly9cCUsNf8NtsatRAxIMwExr2',NULL,'d.konnov@bitmarket.com.ua','10',1524037987,1524037987);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_marketplace`
--

DROP TABLE IF EXISTS `user_marketplace`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_marketplace` (
  `user_marketplace_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `marketplace_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `master` tinyint(3) NOT NULL DEFAULT '0',
  `slave` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_marketplace_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_marketplace`
--

LOCK TABLES `user_marketplace` WRITE;
/*!40000 ALTER TABLE `user_marketplace` DISABLE KEYS */;
INSERT INTO `user_marketplace` VALUES (1,1,1,'Binance','0ubnZxTBQeiregtOXf584sJZD37ytC3DwV7Tyar2TtZS8oai83vnOQX5YJ0DlOmE','37j7rHQiGyciwQUlTGbH4QI5jB8QhgStYKy6kZbwQXufYckJYvMHW0Q1koZ4zSSv',0,1,0),(2,1,2,'Биржа','123123123','3213321312',0,0,0),(3,2,1,'Binance основной','0ubnZxTBQeiregtOXf584sJZD37ytC3DwV7Tyar2TtZS8oai83vnOQX5YJ0DlOmE','37j7rHQiGyciwQUlTGbH4QI5jB8QhgStYKy6kZbwQXufYckJYvMHW0Q1koZ4zSSv',0,0,0);
/*!40000 ALTER TABLE `user_marketplace` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_task`
--

DROP TABLE IF EXISTS `user_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_task` (
  `user_task_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_user_task_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_marketplace_id` int(11) NOT NULL DEFAULT '0',
  `master_user_marketplace_id` int(11) NOT NULL DEFAULT '0',
  `date_create` int(11) NOT NULL DEFAULT '0',
  `date_edit` int(11) NOT NULL DEFAULT '0',
  `config` text,
  `result` text,
  `success` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_task`
--

LOCK TABLES `user_task` WRITE;
/*!40000 ALTER TABLE `user_task` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_task` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-07-03 19:11:48
