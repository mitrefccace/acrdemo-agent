-- MySQL dump 10.13  Distrib 5.6.31, for Win32 (AMD64)
--
-- Host: localhost    Database: agentdb_coa2
-- ------------------------------------------------------
-- Server version	5.6.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES UTF8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- ADDED THIS BLOCK
CREATE DATABASE IF NOT EXISTS agentdb_coa2;
USE agentdb_coa2;
-- create the database user if it does not exist; grant privileges
GRANT ALL PRIVILEGES  ON agentdb_coa2.* TO 'user1'@'localhost' IDENTIFIED BY 'password' WITH GRANT OPTION;

--
-- Table structure for table `agent_data`
--

DROP TABLE IF EXISTS `agent_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agent_data` (
  `agent_id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) NOT NULL,
  `password` varchar(30) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `role` varchar(50) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `email` varchar(40) NOT NULL,
  `organization` varchar(50) NOT NULL,
  `is_approved` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `extension_id` int(10) DEFAULT NULL,
  `queue_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`agent_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agent_data`
--

LOCK TABLES `agent_data` WRITE;
/*!40000 ALTER TABLE `agent_data` DISABLE KEYS */;
INSERT INTO `agent_data` VALUES (1,'cagent1','password','John','Smith','ACL Agent','111-111-1111','cagent1@portal.com','Organization Charlie',1,1,1,1),(2,'cagent2','password','Jane','Jones','ACL Agent','222-222-2222','cagent2@portal.com','Organization Delta',1,1,2,1),(3,'cagent3','password','Jim','Kelly','ACL Agent','333-333-3333','agent3@portal.com','Organization Echo',1,1,3,1),(4,'dagent1','password','Joan','Peters','AD Agent','444-444-4444','dagent4@portal.com','Organization Foxtrot',1,1,4,1),(5,'dagent2','password','Mary','Wilson','AD Agent','555-555-5555','dagent5@portal.com','Organization Golf',1,1,5,1),(6,'dagent3','password','Mark','Sanchez','AD Agent','888-888-8888','dagent6@portal.com','Organization Mike',1,1,6,1),(7,'manager','password','George','Washington','Manager','000-000-0000','manager@portal.com','Organization Lima',1,1,7,2);
/*!40000 ALTER TABLE `agent_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asterisk_extensions`
--

DROP TABLE IF EXISTS `asterisk_extensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asterisk_extensions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `extension` int(4) DEFAULT NULL,
  `extension_secret` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asterisk_extensions`
--

LOCK TABLES `asterisk_extensions` WRITE;
/*!40000 ALTER TABLE `asterisk_extensions` DISABLE KEYS */;
INSERT INTO `asterisk_extensions` VALUES (1,6001,'password'),(2,6002,'password'),(3,6003,'password'),(4,30001,'password'),(5,30002,'password'),(6,30003,'password'),(7,0,NULL);
/*!40000 ALTER TABLE `asterisk_extensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asterisk_queues`
--

DROP TABLE IF EXISTS `asterisk_queues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asterisk_queues` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `queue_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asterisk_queues`
--

LOCK TABLES `asterisk_queues` WRITE;
/*!40000 ALTER TABLE `asterisk_queues` DISABLE KEYS */;
INSERT INTO `asterisk_queues` VALUES (1,'InboundQueue'),(2,NULL);
/*!40000 ALTER TABLE `asterisk_queues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `outgoing_channels`
--

DROP TABLE IF EXISTS `outgoing_channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `outgoing_channels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `outgoing_channels`
--

LOCK TABLES `outgoing_channels` WRITE;
/*!40000 ALTER TABLE `outgoing_channels` DISABLE KEYS */;
INSERT INTO `outgoing_channels` VALUES (1,'SIP/7001'),(2,'SIP/7002'),(3,'SIP/7003'),(4,NULL),(5,NULL),(6,NULL),(7,NULL);
/*!40000 ALTER TABLE `outgoing_channels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scripts`
--

DROP TABLE IF EXISTS `scripts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scripts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `text` varchar(10000) NOT NULL,
  `queue_name` varchar(50) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scripts`
--

LOCK TABLES `scripts` WRITE;
/*!40000 ALTER TABLE `scripts` DISABLE KEYS */;
INSERT INTO `scripts` VALUES (1,'General','Hello [CUSTOMER NAME], this is [AGENT NAME] calling from Agent Portal Services. Have I caught you in the middle of anything? The purpose for my call is to help improve our service to customers. I do not know the nature of your complaint, and this is why I have a couple of questions. How do you feel about our service? When was the last time you used our service? Well, based on your answers, it sounds like we can learn a lot from you if we were to talk in more detail. Are you available to put a brief 15 to 20 minute meeting on the calendar where we can discuss this in more detail and share any insight and value you may have to offer?','InboundQueue','2016-04-01'),(2,'Complaint','Hello [CUSTOMER NAME], this is [AGENT NAME] calling from Agent Portal Services. I understand that you have a complaint to discuss with us?','InboundQueue','2016-04-01');
/*!40000 ALTER TABLE `scripts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-07 15:09:32
