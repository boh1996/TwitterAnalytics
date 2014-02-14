-- MySQL dump 10.13  Distrib 5.5.15, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: %%DATABASE_NAME%%
-- ------------------------------------------------------
-- Server version 5.5.16

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
-- Current Database: `%%DATABASE_NAME%%`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `%%DATABASE_NAME%%` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `%%DATABASE_NAME%%`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_tokens`
--

LOCK TABLES `api_tokens` WRITE;
/*!40000 ALTER TABLE `api_tokens` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
INSERT INTO `ci_sessions` VALUES (1,'4f9872bc26c5adb60dc80ed00e46f4e6','127.0.0.1','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.91 Safari/537.36','1392338799','');
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
  `created_at` varchar(45) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_alert_recievers`
--

LOCK TABLES `email_alert_recievers` WRITE;
/*!40000 ALTER TABLE `email_alert_recievers` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_stats`
--

LOCK TABLES `page_stats` WRITE;
/*!40000 ALTER TABLE `page_stats` DISABLE KEYS */;
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
  `tweets_created` varchar(45) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_tweets`
--

LOCK TABLES `page_tweets` WRITE;
/*!40000 ALTER TABLE `page_tweets` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scrape_statistics`
--

LOCK TABLES `scrape_statistics` WRITE;
/*!40000 ALTER TABLE `scrape_statistics` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scraper_runs`
--

LOCK TABLES `scraper_runs` WRITE;
/*!40000 ALTER TABLE `scraper_runs` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
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
  `exact_match` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistic_pages`
--

LOCK TABLES `statistic_pages` WRITE;
/*!40000 ALTER TABLE `statistic_pages` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistic_strings`
--

LOCK TABLES `statistic_strings` WRITE;
/*!40000 ALTER TABLE `statistic_strings` DISABLE KEYS */;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistic_tweet_strings`
--

LOCK TABLES `statistic_tweet_strings` WRITE;
/*!40000 ALTER TABLE `statistic_tweet_strings` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistic_tweets`
--

LOCK TABLES `statistic_tweets` WRITE;
/*!40000 ALTER TABLE `statistic_tweets` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistic_urls`
--

LOCK TABLES `statistic_urls` WRITE;
/*!40000 ALTER TABLE `statistic_urls` DISABLE KEYS */;
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
  `decrease_email` varchar(45) DEFAULT NULL,
  `increase_email` varchar(45) DEFAULT NULL,
  `email_change_value` varchar(45) DEFAULT NULL,
  `category_difference` varchar(45) DEFAULT NULL,
  `category_change_value` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistic_view_intervals`
--

LOCK TABLES `statistic_view_intervals` WRITE;
/*!40000 ALTER TABLE `statistic_view_intervals` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2014-02-14  1:49:06
