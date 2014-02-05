-- MySQL dump 10.13  Distrib 5.5.15, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: twitter_statistics
-- ------------------------------------------------------
-- Server version	5.5.16

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
-- Current Database: `twitter_statistics`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `twitter_statistics` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `twitter_statistics`;

--
-- Table structure for table `access_control`
--

DROP TABLE IF EXISTS `access_control`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_control` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) DEFAULT NULL,
  `mode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access_control`
--

LOCK TABLES `access_control` WRITE;
/*!40000 ALTER TABLE `access_control` DISABLE KEYS */;
/*!40000 ALTER TABLE `access_control` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_tokens`
--

DROP TABLE IF EXISTS `api_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `is_private_key` varchar(45) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_tokens`
--

LOCK TABLES `api_tokens` WRITE;
/*!40000 ALTER TABLE `api_tokens` DISABLE KEYS */;
INSERT INTO `api_tokens` VALUES (1,'msCsfuAKQSoMzWkghY5WOVMbQsi8dcjoNCVtTad6HFDbdAoAtoYzs82nxbIoyCzj','1390337215','127.0.0.1','0',1),(2,'3JCMPvSkwW6eR3gnIyMNJGh9rPmHlMDXOb78Y62jdH5cRArUKCRZ0MSYE7ygRQZf','1390656000','127.0.0.1','0',1),(3,'dIUD3x8NHeV54k8Pb6uxd2LqMPdVUZQIEnoQvXt0QmHA5z2h0lSghYfpc14UOEoW','1391377389','127.0.0.1','0',1),(4,'RxFpiMeFeEwg5WhrJj2yFpWlCFGR2yri3UOp8kTUaEBuJt8obDMPK0WQpBh6wHS8','1391377422','127.0.0.1','0',1),(5,'EMnpKZjXRQHK0cmdXP7REUYDI51vLtn3RAkXDcErkR61cOdQwek6IykTnXUY17Kl','1391377484','127.0.0.1','0',1),(6,'coMgZUJbkdrAFUqMflad6fxz7wHromOEovfZCZvqXSWynIZ4JbStCFA6Cc0iXNOu','1391377544','127.0.0.1','0',1),(7,'c0iXNOuMKBXvxiAYk4z9eojy05bvDRLJz05OKlQxYOHwFkyqW4Lcw2jdty0AMRLe','1391457838','127.0.0.1','0',1),(8,'pci7E2927JZRP5jhcOqchtdZ8dJOrEbPMmhUdqMx7YmglUgy6jHh3tJC5yJ0qzOm','1391457839','127.0.0.1','0',1),(9,'jShVRLhvYhRo5q047znHMSra57HXxHYGEocKb4zpJqaN4Xu45yvS5U6fGwMJNeFR','1391468535','127.0.0.1','0',1),(11,'vumQwLnpwrx49JEgF28oVrY4c02UokUhnzPnmimNWH4VCWCoYmgNmuUmdF49JdN2','1391470305','127.0.0.1','0',1),(13,'VPKqZAS6tfH4DFpikM20X3jiQIW9mZWdRqIwjaxFWm7H0rnHSofwm8mUyileN7fd','1391550437','127.0.0.1','0',1),(14,'5YPOBtOecwoWyOzUKUnWHxY6wz80sJpAB0W9TEYVqklErRUodWaCliOsLElnwn2Q','1391619252','127.0.0.1','0',1);
/*!40000 ALTER TABLE `api_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` text,
  `ip_address` text,
  `user_agent` text,
  `last_activity` text,
  `user_data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
INSERT INTO `ci_sessions` VALUES (10,'93c1a66921b28dd4646d06e8b99d421f','127.0.0.1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.58 Safari/537.36','1391628894','a:5:{s:9:\"user_data\";s:0:\"\";s:5:\"token\";s:64:\"5YPOBtOecwoWyOzUKUnWHxY6wz80sJpAB0W9TEYVqklErRUodWaCliOsLElnwn2Q\";s:7:\"user_id\";s:1:\"1\";s:12:\"signed_in_at\";i:1391619252;s:9:\"signed_in\";b:1;}');
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_alert_recievers`
--

DROP TABLE IF EXISTS `email_alert_recievers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_alert_recievers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_alert_recievers`
--

LOCK TABLES `email_alert_recievers` WRITE;
/*!40000 ALTER TABLE `email_alert_recievers` DISABLE KEYS */;
INSERT INTO `email_alert_recievers` VALUES (1,'boh1996@gmail.com');
/*!40000 ALTER TABLE `email_alert_recievers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `errors`
--

DROP TABLE IF EXISTS `errors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `errors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` varchar(45) DEFAULT NULL,
  `error_string` text,
  `url` text,
  `run_uuid` varchar(255) DEFAULT NULL,
  `item_type` varchar(255) DEFAULT NULL,
  `item_id` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `errors`
--

LOCK TABLES `errors` WRITE;
/*!40000 ALTER TABLE `errors` DISABLE KEYS */;
/*!40000 ALTER TABLE `errors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` varchar(45) DEFAULT NULL,
  `tweets_created` int(11) DEFAULT NULL,
  `scraper` varchar(255) DEFAULT NULL,
  `run_uuid` varchar(255) DEFAULT NULL,
  `end_microtime` varchar(45) DEFAULT NULL,
  `tweets_fetched` int(11) DEFAULT NULL,
  `tweets_blocked` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
INSERT INTO `history` VALUES (13,'1390836037',0,'pages','00c17bf8-2e0c-41b4-8ace-43758b5efe52','1390836037.4291',20,NULL),(14,'1390836123',0,'pages','bbb9b52e-fd8a-4633-bc75-5b8b3be68624','1390836123.6855',20,NULL),(15,'1390836126',0,'pages','eca825cf-0bc4-4b03-93e5-0bd420456f43','1390836126.0298',20,NULL),(16,'1390836178',0,'pages','c5422dfb-cba9-4079-ae46-2ff666bf0f97','1390836178.9173',20,NULL),(17,'1390836181',0,'pages','7869f058-b25f-4edd-a52b-ef8f9abc9249','1390836181.006',20,NULL),(18,'1390836311',0,'pages','fe065d57-9341-42e6-9f3d-6020d78f539c','1390836311.4177',20,NULL),(19,'1390836357',0,'pages','dc24dacf-9dc4-40c3-87ed-3247ee910bbd','1390836357.3391',20,NULL),(20,'1390836359',0,'pages','88f7eadc-aebc-44d4-9f98-8b0699e9e4c8','1390836359.6269',20,NULL),(21,'1390836381',0,'pages','9fa41ddd-5579-4beb-95f8-b2322e533b9a','1390836381.3025',20,NULL),(22,'1390836383',0,'pages','d13a217d-0a17-42d8-9e61-9e6ddad11b5e','1390836383.6729',20,NULL),(23,'1390836436',0,'pages','88f81be1-9a9a-4675-ab88-b26a46a46124','1390836436.8237',20,NULL),(24,'1390836438',0,'pages','5d1851e8-ca68-45c2-95a6-ba34f5912a7b','1390836438.8321',20,NULL),(25,'1391024562',0,'pages','ef592053-2717-44ca-a1c8-ce6d884ffdce','1391024562.4826',20,NULL),(26,'1391024564',0,'pages','e771ace0-effc-4381-ae9c-528226c50ed6','1391024564.6153',20,NULL),(27,'1391024833',0,'pages','5c9292ad-88c0-4fb4-bc67-7934671e7fce','1391024833.1022',20,NULL),(28,'1391024835',0,'pages','6c5fd3cc-f76f-4ea0-b618-caf2408c80ef','1391024835.0648',20,NULL),(29,'1391024858',0,'pages','b42d4782-9be6-47a3-8e5f-77572e327cf1','1391024858.743',20,NULL),(30,'1391024860',0,'pages','3352f032-403f-4cda-bd4c-ebcb95e0cbfd','1391024860.6947',20,NULL),(31,'1391024888',0,'pages','d0f95273-948d-47e0-99f3-22e0de9fe1c1','1391024888.7992',20,NULL),(32,'1391024890',0,'pages','4067f94e-7d28-4dcf-acc6-61ea2fbe2b4d','1391024890.7768',20,NULL),(33,'1391027170',0,'pages','5565ca70-8635-454b-b0cf-78036d8ac973','1391027170.7194',20,NULL),(34,'1391027172',0,'pages','2d50e093-0abf-4d4d-87d7-b01a1a63ffbb','1391027172.6815',20,NULL),(35,'1391027230',0,'pages','fbb0b85b-fce0-4be8-a27f-bdb356560432','1391027230.2583',20,NULL),(36,'1391027232',0,'pages','eb2599ed-0c26-4469-a5d6-44df8d34b73e','1391027232.6569',20,NULL),(37,'1391027554',0,'pages','4001d251-7285-4df4-a306-373422314ac2','1391027554.518',20,NULL),(38,'1391027561',0,'pages','1e8abe5f-9ff0-48f7-807e-85c0cb7eb23e','1391027561.7031',20,NULL),(39,'1391027592',0,'pages','cb7e0c1e-8b9b-4725-8ed2-5bbcba84d28d','1391027592.0918',20,NULL),(40,'1391027594',0,'pages','1d81225b-e5da-4da0-8d5d-594f256ba92b','1391027594.6239',20,NULL),(41,'1391031550',0,'pages','43ff24e9-3675-4ff2-befb-09ead24cabda','1391031550.4136',20,NULL),(42,'1391031553',0,'pages','f941bfcf-8e31-49a2-b3f6-aa926cc47807','1391031553.2913',20,NULL),(43,'1391031594',0,'pages','b25a4bb9-7692-4ae7-84fb-7ca050922cc2','1391031594.0414',20,NULL),(44,'1391031624',0,'pages','c29c67d0-45a3-4289-8db9-a4d69d2eaeb7','1391031624.9318',20,NULL),(45,'1391031627',0,'pages','3411bef8-7695-4d11-bd65-a5c183ddf30c','1391031627.09',20,NULL),(46,'1391031643',0,'pages','5373e666-762c-41ea-acb6-2b6fc36a147b','1391031643.5686',20,NULL),(47,'1391031645',0,'pages','b3407568-3a11-48d1-8991-b7259599f85e','1391031645.8094',20,NULL),(48,'1391031733',0,'pages','a13d6fc4-0769-4b20-a0b9-44e44fafb54b','1391031733.7545',20,NULL),(49,'1391031779',0,'pages','aab2ea2a-5263-4cc3-8df3-fc2cb6add166','1391031779.7496',20,NULL),(50,'1391031782',0,'pages','2fa2a6be-a186-485e-8f29-bab6baa9c523','1391031782.0384',20,NULL),(51,'1391468878',0,'pages','09e87419-6c02-46e3-a869-54872f4ad17c','1391468878.2395',20,NULL),(52,'1391468880',0,'pages','67bf12a3-cc47-45b0-9d65-a56e33c7de27','1391468880.3415',20,NULL),(53,'1391545736',0,'pages','0725ecc4-1a56-4b65-b98e-67f40b10fefd','1391545736.0032',20,NULL),(54,'1391545738',0,'pages','89f37727-7ae8-479b-9114-d4b8f9af4766','1391545738.2751',20,NULL),(55,'1391546114',0,'pages','bfee4074-35b6-4e25-8a6b-46b65572317c','1391546114.4406',20,NULL),(56,'1391546117',0,'pages','2091713a-7585-4f7a-92d4-facb2d7d1686','1391546117.549',20,NULL),(57,'1391626187',0,'pages','d262e319-e095-4b59-83d8-d73e4056e978','1391626187.2854',20,NULL),(58,'1391626191',0,'pages','083d958c-fc20-46d8-bd7f-1bd9da4fa5b7','1391626191.3467',20,NULL);
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_stats`
--

DROP TABLE IF EXISTS `page_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `tweets_created` varchar(45) DEFAULT NULL,
  `tweets_fetched` varchar(45) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_stats`
--

LOCK TABLES `page_stats` WRITE;
/*!40000 ALTER TABLE `page_stats` DISABLE KEYS */;
INSERT INTO `page_stats` VALUES (1,1,'0','40','1391027561'),(2,1,'0','40','1391027594'),(3,1,'0','40','1391031553'),(4,1,'0','40','1391031627'),(5,1,'0','40','1391031645'),(6,1,'0','40','1391031782'),(7,1,'0','40','1391468880'),(8,1,'0','40','1391545738'),(9,1,'0','40','1391546117'),(10,1,'0','40','1391626191');
/*!40000 ALTER TABLE `page_stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_tweets`
--

DROP TABLE IF EXISTS `page_tweets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_tweets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tweet_id` varchar(45) DEFAULT NULL,
  `page_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_tweets`
--

LOCK TABLES `page_tweets` WRITE;
/*!40000 ALTER TABLE `page_tweets` DISABLE KEYS */;
INSERT INTO `page_tweets` VALUES (1,'292','1'),(2,'312','1'),(3,'313','1'),(4,'314','1'),(5,'315','1'),(6,'316','1'),(7,'317','1'),(8,'318','1'),(9,'319','1'),(10,'320','1'),(11,'321','1'),(12,'322','1'),(13,'323','1'),(14,'324','1'),(15,'325','1'),(16,'326','1'),(17,'327','1'),(18,'328','1'),(19,'329','1'),(20,'330','1'),(21,'331','1'),(22,'332','1'),(23,'333','1'),(24,'334','1'),(25,'335','1'),(26,'336','1'),(27,'337','1'),(28,'338','1'),(29,'339','1'),(30,'340','1'),(31,'341','1'),(32,'342','1'),(33,'343','1'),(34,'344','1'),(35,'345','1'),(36,'346','1'),(37,'347','1'),(38,'348','1'),(39,'349','1'),(40,'350','1'),(41,'351','1'),(42,'352','1'),(43,'353','1'),(44,'354','1'),(45,'355','1'),(46,'356','1'),(47,'357','1'),(48,'358','1'),(49,'359','1'),(50,'360','1'),(51,'361','1'),(52,'362','1'),(53,'363','1'),(54,'364','1'),(55,'365','1'),(56,'366','1'),(57,'367','1'),(58,'368','1'),(59,'369','1'),(60,'370','1'),(61,'371','1'),(62,'372','1'),(63,'373','1'),(64,'374','1');
/*!40000 ALTER TABLE `page_tweets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scrape_statistics`
--

DROP TABLE IF EXISTS `scrape_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scrape_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `tweets_fetched` int(11) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `microtime` varchar(45) DEFAULT NULL,
  `item_number` int(11) DEFAULT NULL,
  `url` text,
  `run_uuid` varchar(255) DEFAULT NULL,
  `tweets_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scrape_statistics`
--

LOCK TABLES `scrape_statistics` WRITE;
/*!40000 ALTER TABLE `scrape_statistics` DISABLE KEYS */;
INSERT INTO `scrape_statistics` VALUES (13,'url',1,20,'1390836037','1390836031.2398',1,'https://twitter.com/google','00c17bf8-2e0c-41b4-8ace-43758b5efe52',0),(14,'url',1,20,'1390836123','1390836121.4512',1,'https://twitter.com/google','bbb9b52e-fd8a-4633-bc75-5b8b3be68624',0),(15,'url',2,20,'1390836126','1390836123.7224',1,'https://twitter.com/twitter','eca825cf-0bc4-4b03-93e5-0bd420456f43',0),(16,'url',1,20,'1390836178','1390836176.493',1,'https://twitter.com/google','c5422dfb-cba9-4079-ae46-2ff666bf0f97',0),(17,'url',2,20,'1390836180','1390836178.9845',1,'https://twitter.com/twitter','7869f058-b25f-4edd-a52b-ef8f9abc9249',0),(18,'url',1,20,'1390836311','1390836309.2477',1,'https://twitter.com/google','fe065d57-9341-42e6-9f3d-6020d78f539c',0),(19,'url',1,20,'1390836357','1390836355.5977',1,'https://twitter.com/google','dc24dacf-9dc4-40c3-87ed-3247ee910bbd',0),(20,'url',2,20,'1390836359','1390836357.3411',1,'https://twitter.com/twitter','88f7eadc-aebc-44d4-9f98-8b0699e9e4c8',0),(21,'url',1,20,'1390836381','1390836378.9938',1,'https://twitter.com/google','9fa41ddd-5579-4beb-95f8-b2322e533b9a',0),(22,'url',2,20,'1390836383','1390836381.3533',1,'https://twitter.com/twitter','d13a217d-0a17-42d8-9e61-9e6ddad11b5e',0),(23,'url',1,20,'1390836436','1390836434.9127',1,'https://twitter.com/google','88f81be1-9a9a-4675-ab88-b26a46a46124',0),(24,'url',2,20,'1390836438','1390836436.8681',1,'https://twitter.com/twitter','5d1851e8-ca68-45c2-95a6-ba34f5912a7b',0),(25,'url',1,20,'1391024562','1391024559.5013',1,'https://twitter.com/google','ef592053-2717-44ca-a1c8-ce6d884ffdce',0),(26,'url',2,20,'1391024564','1391024562.5522',1,'https://twitter.com/twitter','e771ace0-effc-4381-ae9c-528226c50ed6',0),(27,'url',1,20,'1391024833','1391024831.2087',1,'https://twitter.com/google','5c9292ad-88c0-4fb4-bc67-7934671e7fce',0),(28,'url',2,20,'1391024835','1391024833.105',1,'https://twitter.com/twitter','6c5fd3cc-f76f-4ea0-b618-caf2408c80ef',0),(29,'url',1,20,'1391024858','1391024853.4274',1,'https://twitter.com/google','b42d4782-9be6-47a3-8e5f-77572e327cf1',0),(30,'url',2,20,'1391024860','1391024858.7449',1,'https://twitter.com/twitter','3352f032-403f-4cda-bd4c-ebcb95e0cbfd',0),(31,'url',1,20,'1391024888','1391024887.061',1,'https://twitter.com/google','d0f95273-948d-47e0-99f3-22e0de9fe1c1',0),(32,'url',2,20,'1391024890','1391024888.8021',1,'https://twitter.com/twitter','4067f94e-7d28-4dcf-acc6-61ea2fbe2b4d',0),(33,'url',1,20,'1391027170','1391027167.9362',1,'https://twitter.com/google','5565ca70-8635-454b-b0cf-78036d8ac973',0),(34,'url',2,20,'1391027172','1391027170.7615',1,'https://twitter.com/twitter','2d50e093-0abf-4d4d-87d7-b01a1a63ffbb',0),(35,'url',1,20,'1391027230','1391027228.0962',1,'https://twitter.com/google','fbb0b85b-fce0-4be8-a27f-bdb356560432',0),(36,'url',2,20,'1391027232','1391027230.2619',1,'https://twitter.com/twitter','eb2599ed-0c26-4469-a5d6-44df8d34b73e',0),(37,'url',1,20,'1391027554','1391027552.4678',1,'https://twitter.com/google','4001d251-7285-4df4-a306-373422314ac2',0),(38,'url',2,20,'1391027561','1391027554.5582',1,'https://twitter.com/twitter','1e8abe5f-9ff0-48f7-807e-85c0cb7eb23e',0),(39,'url',1,20,'1391027592','1391027589.9821',1,'https://twitter.com/google','cb7e0c1e-8b9b-4725-8ed2-5bbcba84d28d',0),(40,'url',2,20,'1391027594','1391027592.0944',1,'https://twitter.com/twitter','1d81225b-e5da-4da0-8d5d-594f256ba92b',0),(41,'url',1,20,'1391031550','1391031547.6261',1,'https://twitter.com/google','43ff24e9-3675-4ff2-befb-09ead24cabda',0),(42,'url',2,20,'1391031553','1391031550.418',1,'https://twitter.com/twitter','f941bfcf-8e31-49a2-b3f6-aa926cc47807',0),(43,'url',1,20,'1391031594','1391031592.0418',1,'https://twitter.com/google','b25a4bb9-7692-4ae7-84fb-7ca050922cc2',0),(44,'url',1,20,'1391031624','1391031622.7346',1,'https://twitter.com/google','c29c67d0-45a3-4289-8db9-a4d69d2eaeb7',0),(45,'url',2,20,'1391031627','1391031625.0235',1,'https://twitter.com/twitter','3411bef8-7695-4d11-bd65-a5c183ddf30c',0),(46,'url',1,20,'1391031643','1391031641.6042',1,'https://twitter.com/google','5373e666-762c-41ea-acb6-2b6fc36a147b',0),(47,'url',2,20,'1391031645','1391031643.6205',1,'https://twitter.com/twitter','b3407568-3a11-48d1-8991-b7259599f85e',0),(48,'url',1,20,'1391031733','1391031731.6341',1,'https://twitter.com/google','a13d6fc4-0769-4b20-a0b9-44e44fafb54b',0),(49,'url',1,20,'1391031779','1391031777.6538',1,'https://twitter.com/google','aab2ea2a-5263-4cc3-8df3-fc2cb6add166',0),(50,'url',2,20,'1391031782','1391031779.8749',1,'https://twitter.com/twitter','2fa2a6be-a186-485e-8f29-bab6baa9c523',0),(51,'url',1,20,'1391468878','1391468876.0181',1,'https://twitter.com/google','09e87419-6c02-46e3-a869-54872f4ad17c',0),(52,'url',2,20,'1391468880','1391468878.2852',1,'https://twitter.com/twitter','67bf12a3-cc47-45b0-9d65-a56e33c7de27',0),(53,'url',1,20,'1391545735','1391545732.2291',1,'https://twitter.com/google','0725ecc4-1a56-4b65-b98e-67f40b10fefd',0),(54,'url',2,20,'1391545738','1391545736.1816',1,'https://twitter.com/twitter','89f37727-7ae8-479b-9114-d4b8f9af4766',0),(55,'url',1,20,'1391546114','1391546109.9115',1,'https://twitter.com/google','bfee4074-35b6-4e25-8a6b-46b65572317c',0),(56,'url',2,20,'1391546117','1391546114.4444',1,'https://twitter.com/twitter','2091713a-7585-4f7a-92d4-facb2d7d1686',0),(57,'url',1,20,'1391626187','1391626184.4054',1,'https://twitter.com/google','d262e319-e095-4b59-83d8-d73e4056e978',0),(58,'url',2,20,'1391626191','1391626187.3256',1,'https://twitter.com/twitter','083d958c-fc20-46d8-bd7f-1bd9da4fa5b7',0);
/*!40000 ALTER TABLE `scrape_statistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scraper_runs`
--

DROP TABLE IF EXISTS `scraper_runs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scraper_runs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `run_uuid` varchar(255) DEFAULT NULL,
  `start_microtime` varchar(45) DEFAULT NULL,
  `item_count` int(11) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scraper_runs`
--

LOCK TABLES `scraper_runs` WRITE;
/*!40000 ALTER TABLE `scraper_runs` DISABLE KEYS */;
INSERT INTO `scraper_runs` VALUES (18,'url','00c17bf8-2e0c-41b4-8ace-43758b5efe52','1390836031.0958',1,'1390836031'),(19,'url','bbb9b52e-fd8a-4633-bc75-5b8b3be68624','1390836121.4345',1,'1390836121'),(20,'url','eca825cf-0bc4-4b03-93e5-0bd420456f43','1390836123.7205',1,'1390836123'),(21,'url','c5422dfb-cba9-4079-ae46-2ff666bf0f97','1390836176.4752',1,'1390836176'),(22,'url','7869f058-b25f-4edd-a52b-ef8f9abc9249','1390836178.967',1,'1390836178'),(23,'url','fe065d57-9341-42e6-9f3d-6020d78f539c','1390836309.2453',1,'1390836309'),(24,'url','dc24dacf-9dc4-40c3-87ed-3247ee910bbd','1390836355.5953',1,'1390836355'),(25,'url','88f7eadc-aebc-44d4-9f98-8b0699e9e4c8','1390836357.3401',1,'1390836357'),(26,'url','9fa41ddd-5579-4beb-95f8-b2322e533b9a','1390836378.9912',1,'1390836378'),(27,'url','d13a217d-0a17-42d8-9e61-9e6ddad11b5e','1390836381.3237',1,'1390836381'),(28,'url','88f81be1-9a9a-4675-ab88-b26a46a46124','1390836434.9058',1,'1390836434'),(29,'url','5d1851e8-ca68-45c2-95a6-ba34f5912a7b','1390836436.8669',1,'1390836436'),(30,'url','ef592053-2717-44ca-a1c8-ce6d884ffdce','1391024559.4482',1,'1391024559'),(31,'url','e771ace0-effc-4381-ae9c-528226c50ed6','1391024562.5506',1,'1391024562'),(32,'url','5c9292ad-88c0-4fb4-bc67-7934671e7fce','1391024831.2066',1,'1391024831'),(33,'url','6c5fd3cc-f76f-4ea0-b618-caf2408c80ef','1391024833.1041',1,'1391024833'),(34,'url','b42d4782-9be6-47a3-8e5f-77572e327cf1','1391024853.4254',1,'1391024853'),(35,'url','3352f032-403f-4cda-bd4c-ebcb95e0cbfd','1391024858.7442',1,'1391024858'),(36,'url','d0f95273-948d-47e0-99f3-22e0de9fe1c1','1391024887.0576',1,'1391024887'),(37,'url','4067f94e-7d28-4dcf-acc6-61ea2fbe2b4d','1391024888.8007',1,'1391024888'),(38,'url','5565ca70-8635-454b-b0cf-78036d8ac973','1391027167.8732',1,'1391027167'),(39,'url','2d50e093-0abf-4d4d-87d7-b01a1a63ffbb','1391027170.7598',1,'1391027170'),(40,'url','fbb0b85b-fce0-4be8-a27f-bdb356560432','1391027228.0937',1,'1391027228'),(41,'url','eb2599ed-0c26-4469-a5d6-44df8d34b73e','1391027230.2602',1,'1391027230'),(42,'url','4001d251-7285-4df4-a306-373422314ac2','1391027552.4507',1,'1391027552'),(43,'url','1e8abe5f-9ff0-48f7-807e-85c0cb7eb23e','1391027554.5198',1,'1391027554'),(44,'url','cb7e0c1e-8b9b-4725-8ed2-5bbcba84d28d','1391027589.9681',1,'1391027589'),(45,'url','1d81225b-e5da-4da0-8d5d-594f256ba92b','1391027592.0932',1,'1391027592'),(46,'url','43ff24e9-3675-4ff2-befb-09ead24cabda','1391031547.6079',1,'1391031547'),(47,'url','f941bfcf-8e31-49a2-b3f6-aa926cc47807','1391031550.416',1,'1391031550'),(48,'url','b25a4bb9-7692-4ae7-84fb-7ca050922cc2','1391031592.0396',1,'1391031592'),(49,'url','c29c67d0-45a3-4289-8db9-a4d69d2eaeb7','1391031622.7323',1,'1391031622'),(50,'url','3411bef8-7695-4d11-bd65-a5c183ddf30c','1391031624.977',1,'1391031624'),(51,'url','5373e666-762c-41ea-acb6-2b6fc36a147b','1391031641.6027',1,'1391031641'),(52,'url','b3407568-3a11-48d1-8991-b7259599f85e','1391031643.6196',1,'1391031643'),(53,'url','a13d6fc4-0769-4b20-a0b9-44e44fafb54b','1391031731.6323',1,'1391031731'),(54,'url','aab2ea2a-5263-4cc3-8df3-fc2cb6add166','1391031777.6516',1,'1391031777'),(55,'url','2fa2a6be-a186-485e-8f29-bab6baa9c523','1391031779.8738',1,'1391031779'),(56,'url','09e87419-6c02-46e3-a869-54872f4ad17c','1391468876.0165',1,'1391468876'),(57,'url','67bf12a3-cc47-45b0-9d65-a56e33c7de27','1391468878.2844',1,'1391468878'),(58,'url','0725ecc4-1a56-4b65-b98e-67f40b10fefd','1391545732.1963',1,'1391545732'),(59,'url','89f37727-7ae8-479b-9114-d4b8f9af4766','1391545736.1797',1,'1391545736'),(60,'url','bfee4074-35b6-4e25-8a6b-46b65572317c','1391546109.8873',1,'1391546109'),(61,'url','2091713a-7585-4f7a-92d4-facb2d7d1686','1391546114.4425',1,'1391546114'),(62,'url','d262e319-e095-4b59-83d8-d73e4056e978','1391626184.3442',1,'1391626184'),(63,'url','083d958c-fc20-46d8-bd7f-1bd9da4fa5b7','1391626187.3241',1,'1391626187');
/*!40000 ALTER TABLE `scraper_runs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scrapers`
--

DROP TABLE IF EXISTS `scrapers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scrapers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_key` varchar(255) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  `url` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scrapers`
--

LOCK TABLES `scrapers` WRITE;
/*!40000 ALTER TABLE `scrapers` DISABLE KEYS */;
INSERT INTO `scrapers` VALUES (1,'admin_scrapers_pages','pages','scrape/pages');
/*!40000 ALTER TABLE `scrapers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) DEFAULT NULL,
  `value` text,
  `updated_at` varchar(45) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `section` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'setting_email_decrease_alert','','1391468584',NULL,'email'),(2,'setting_email_increase_alert','1','1391468584',NULL,'email'),(3,'setting_email_sender','support@illution.dk','1391468584',NULL,'email'),(4,'setting_email_zero_minimum_change_amount','2000','1391468584',NULL,'email');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statistic_pages`
--

DROP TABLE IF EXISTS `statistic_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistic_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `embed` text,
  `email_change_value` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistic_pages`
--

LOCK TABLES `statistic_pages` WRITE;
/*!40000 ALTER TABLE `statistic_pages` DISABLE KEYS */;
INSERT INTO `statistic_pages` VALUES (1,'Google','false','TEST',0);
/*!40000 ALTER TABLE `statistic_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statistic_strings`
--

DROP TABLE IF EXISTS `statistic_strings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistic_strings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `statistic_page_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistic_strings`
--

LOCK TABLES `statistic_strings` WRITE;
/*!40000 ALTER TABLE `statistic_strings` DISABLE KEYS */;
INSERT INTO `statistic_strings` VALUES (2,'Google','1',1),(4,'GMail','2',1),(5,'doodle','2',1),(6,'Google+','2',1),(10,'Internet','2',1);
/*!40000 ALTER TABLE `statistic_strings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statistic_tweet_strings`
--

DROP TABLE IF EXISTS `statistic_tweet_strings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistic_tweet_strings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tweet_id` int(11) DEFAULT NULL,
  `statistic_tweet_string_id` int(11) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  `category` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistic_tweet_strings`
--

LOCK TABLES `statistic_tweet_strings` WRITE;
/*!40000 ALTER TABLE `statistic_tweet_strings` DISABLE KEYS */;
INSERT INTO `statistic_tweet_strings` VALUES (65,312,2,'1391031779','1391031779','1'),(66,313,2,'1391031779','1391031779','1'),(67,314,2,'1391031779','1391031779','1'),(68,315,2,'1391031779','1391031779','1'),(69,318,2,'1391031779','1391031779','1'),(70,319,2,'1391031779','1391031779','1'),(71,320,2,'1391031779','1391031779','1'),(72,321,2,'1391031779','1391031779','1'),(73,323,2,'1391031779','1391031779','1'),(74,324,2,'1391031779','1391031779','1'),(75,325,2,'1391031779','1391031779','1'),(76,326,5,'1391031779','1391031779','2'),(77,327,2,'1391031779','1391031779','1'),(78,328,2,'1391031779','1391031779','1'),(79,331,2,'1391031779','1391031779','1'),(80,352,2,'1391468878','1391468878','1'),(81,354,2,'1391468878','1391468878','1'),(82,355,2,'1391468878','1391468878','1'),(83,356,2,'1391468878','1391468878','1'),(84,358,5,'1391468878','1391468878','2'),(85,359,2,'1391468878','1391468878','1'),(86,361,2,'1391468878','1391468878','1'),(87,362,2,'1391468878','1391468878','1'),(88,364,2,'1391468878','1391468878','1'),(89,370,2,'1391545736','1391545736','1'),(90,371,2,'1391545736','1391545736','1');
/*!40000 ALTER TABLE `statistic_tweet_strings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statistic_tweets`
--

DROP TABLE IF EXISTS `statistic_tweets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistic_tweets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tweet_id` varchar(255) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `inserted_at` varchar(45) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `user_title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=375 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistic_tweets`
--

LOCK TABLES `statistic_tweets` WRITE;
/*!40000 ALTER TABLE `statistic_tweets` DISABLE KEYS */;
INSERT INTO `statistic_tweets` VALUES (312,'428603480602075136','1391022007','1391031779','google','A Googler'),(313,'428387393805099009','1390970488','1391031779','google','A Googler'),(314,'428301482501615616','1390950005','1391031779','google','A Googler'),(315,'428279908557541376','1390944861','1391031779','google','A Googler'),(316,'428241098561970176','1390935608','1391031779','google','A Googler'),(317,'428208918725021696','1390927936','1391031779','google','A Googler'),(318,'426815022254157824','1390595605','1391031779','google','A Googler'),(319,'426785655599792128','1390588604','1391031779','google','A Googler'),(320,'426432921432752128','1390504505','1391031779','google','A Googler'),(321,'426414076148072448','1390500012','1391031779','google','A Googler'),(322,'426398361395011584','1390496266','1391031779','google','A Googler'),(323,'425735726395691008','1390338281','1391031779','google','A Googler'),(324,'425684981969473536','1390326183','1391031779','google','A Googler'),(325,'425659761216868352','1390320170','1391031779','google','A Googler'),(326,'425345177947869184','1390245167','1391031779','google','A Googler'),(327,'424255974388404224','1389985481','1391031779','google','A Googler'),(328,'424241186950238208','1389981955','1391031779','GoogleCR','GoogleCrisisResponse'),(329,'424239738456145920','1389981610','1391031779','google','A Googler'),(330,'424073639903100928','1389942009','1391031779','google','A Googler'),(331,'423998139939704832','1389924008','1391031779','google','A Googler'),(332,'428602381920514048','1391021745','1391031782','twitter','Twitter'),(333,'428521604541202432','1391002486','1391031782','gov','Twitter Government'),(334,'428231926810308608','1390933422','1391031782','gov','Twitter Government'),(335,'428212647016677376','1390928825','1391031782','twitter','Twitter'),(336,'427836080948133888','1390839045','1391031782','twitter','Twitter'),(337,'426808231474630656','1390593986','1391031782','TwitterData','Twitter Data'),(338,'426517622666956800','1390524700','1391031782','twitter','Twitter'),(339,'426485553387679745','1390517054','1391031782','TwitterSports','Twitter Sports'),(340,'425734699814633472','1390338036','1391031782','twittertv','Twitter TV'),(341,'424291859125395457','1389994036','1391031782','TwitterSports','Twitter Sports'),(342,'424291586684362752','1389993971','1391031782','TwitterSports','Twitter Sports'),(343,'424291226414620672','1389993885','1391031782','TwitterSports','Twitter Sports'),(344,'424290949364072448','1389993819','1391031782','TwitterSports','Twitter Sports'),(345,'422841285339131904','1389648193','1391031782','twitter','Twitter'),(346,'422840296175443968','1389647957','1391031782','twitter','Twitter'),(347,'422598069549805568','1389590205','1391031782','twittertv','Twitter TV'),(348,'420668929451626496','1389130263','1391031782','TwitterSports','Twitter Sports'),(349,'419193088515375104','1388778395','1391031782','vineapp','Vine'),(350,'418874784798089217','1388702505','1391031782','twitter','Twitter'),(351,'418473226537164801','1388606766','1391031782','twitter','Twitter'),(352,'430431742281797632','1391457899','1391468878','google','A Googler'),(353,'430402544783728640','1391450937','1391468878','google','A Googler'),(354,'430191356720340994','1391400586','1391468878','google','A Googler'),(355,'430160660324810752','1391393268','1391468878','google','A Googler'),(356,'430154968864018432','1391391911','1391468878','google','A Googler'),(357,'430109077373337600','1391380969','1391468878','google','A Googler'),(358,'429693682439041024','1391281931','1391468878','google','A Googler'),(359,'429343384457998336','1391198414','1391468878','google','A Googler'),(360,'429320701078929408','1391193006','1391468878','google','A Googler'),(361,'429290512861110272','1391185808','1391468878','google','A Googler'),(362,'429032247392366592','1391124233','1391468878','google','A Googler'),(363,'428943218055843840','1391103007','1391468878','google','A Googler'),(364,'428920597843042304','1391097614','1391468878','google','A Googler'),(365,'428653486490664960','1391033929','1391468878','google','A Googler'),(366,'430452138716569600','1391462761','1391468880','TwitterSports','Twitter Sports'),(367,'430209046017089537','1391404804','1391468880','twitter','Twitter'),(368,'429994093863641089','1391353555','1391468880','300','300 Entertainment'),(369,'428917514035142656','1391096878','1391468880','TwitterSports','Twitter Sports'),(370,'430752010799837184','1391534257','1391545735','google','A Googler'),(371,'430702304028016640','1391522406','1391545735','google','A Googler'),(372,'430475807388356608','1391468404','1391545735','YouTube','YouTube'),(373,'431110498352787456','1391619727','1391626187','google','A Googler'),(374,'430818617806954497','1391550137','1391626187','google','A Googler');
/*!40000 ALTER TABLE `statistic_tweets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statistic_urls`
--

DROP TABLE IF EXISTS `statistic_urls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistic_urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text,
  `statistic_page_id` int(11) DEFAULT NULL,
  `latest_cursor` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistic_urls`
--

LOCK TABLES `statistic_urls` WRITE;
/*!40000 ALTER TABLE `statistic_urls` DISABLE KEYS */;
INSERT INTO `statistic_urls` VALUES (1,'https://twitter.com/google',1,'431110498352787456'),(2,'https://twitter.com/twitter',1,'430452138716569600');
/*!40000 ALTER TABLE `statistic_urls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statistic_view_intervals`
--

DROP TABLE IF EXISTS `statistic_view_intervals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistic_view_intervals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistic_view_intervals`
--

LOCK TABLES `statistic_view_intervals` WRITE;
/*!40000 ALTER TABLE `statistic_view_intervals` DISABLE KEYS */;
INSERT INTO `statistic_view_intervals` VALUES (1,'login','per_month','1','0',0),(2,'nologin','per_year','1','0',0);
/*!40000 ALTER TABLE `statistic_view_intervals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_token` varchar(255) DEFAULT NULL,
  `hashing_iterations` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'test','a36b217aac90cad1a64bd57e52cac19584fa5d815ad7c3a810e44ffc37256166680e179a5d2040f4aac45a7227d542371d2ac33f6b92d8b67d8b7b728fe819b6','Q7HmwwAH',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-02-05 20:47:01
