-- MySQL dump 10.13  Distrib 5.5.15, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: twitter_analytics
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
-- Current Database: `twitter_analytics`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `twitter_analytics` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `twitter_analytics`;

--
-- Table structure for table `access_control`
--

DROP TABLE IF EXISTS `access_control`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_control` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(200) DEFAULT NULL,
  `mode` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_UNIQUE` (`page`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access_control`
--

LOCK TABLES `access_control` WRITE;
/*!40000 ALTER TABLE `access_control` DISABLE KEYS */;
INSERT INTO `access_control` VALUES (1,'admin_status','login'),(2,'user_home','login'),(3,'admin_alerts','login'),(4,'admin_access_control','login'),(5,'admin_topics','login'),(6,'admin_blocked_strings','login'),(7,'admin_string_to_remove','login'),(8,'admin_urls','login'),(9,'admin_settings','login'),(11,'admin_twitter','login'),(12,'user_alerts','login');
/*!40000 ALTER TABLE `access_control` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alert_strings`
--

DROP TABLE IF EXISTS `alert_strings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alert_strings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `value_UNIQUE` (`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alert_strings`
--

LOCK TABLES `alert_strings` WRITE;
/*!40000 ALTER TABLE `alert_strings` DISABLE KEYS */;
/*!40000 ALTER TABLE `alert_strings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_tokens`
--

DROP TABLE IF EXISTS `api_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(200) DEFAULT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `ip_address` varchar(90) DEFAULT NULL,
  `is_private_key` varchar(40) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `token_user_id` (`user_id`),
  CONSTRAINT `token_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
-- Table structure for table `blocked_strings`
--

DROP TABLE IF EXISTS `blocked_strings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blocked_strings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `value_UNIQUE` (`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blocked_strings`
--

LOCK TABLES `blocked_strings` WRITE;
/*!40000 ALTER TABLE `blocked_strings` DISABLE KEYS */;
/*!40000 ALTER TABLE `blocked_strings` ENABLE KEYS */;
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
  `error_string` varchar(255) DEFAULT NULL,
  `url` text,
  `run_uuid` varchar(255) DEFAULT NULL,
  `item_type` varchar(255) DEFAULT NULL,
  `item_id` varchar(255) DEFAULT NULL,
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
-- Table structure for table `hidden_connected_words`
--

DROP TABLE IF EXISTS `hidden_connected_words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hidden_connected_words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(200) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `word_UNIQUE` (`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hidden_connected_words`
--

LOCK TABLES `hidden_connected_words` WRITE;
/*!40000 ALTER TABLE `hidden_connected_words` DISABLE KEYS */;
/*!40000 ALTER TABLE `hidden_connected_words` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hidden_words`
--

DROP TABLE IF EXISTS `hidden_words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hidden_words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(200) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hidden_words`
--

LOCK TABLES `hidden_words` WRITE;
/*!40000 ALTER TABLE `hidden_words` DISABLE KEYS */;
/*!40000 ALTER TABLE `hidden_words` ENABLE KEYS */;
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
  `tweets_created` varchar(255) DEFAULT NULL,
  `scraper` varchar(255) DEFAULT NULL,
  `tweets_fetched` varchar(255) DEFAULT NULL,
  `run_uuid` varchar(255) DEFAULT NULL,
  `end_microtime` varchar(45) DEFAULT NULL,
  `tweets_blocked` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `removed_strings`
--

DROP TABLE IF EXISTS `removed_strings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `removed_strings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(45) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `value_UNIQUE` (`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `removed_strings`
--

LOCK TABLES `removed_strings` WRITE;
/*!40000 ALTER TABLE `removed_strings` DISABLE KEYS */;
/*!40000 ALTER TABLE `removed_strings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scrape_statistics`
--

DROP TABLE IF EXISTS `scrape_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scrape_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) DEFAULT NULL,
  `item_id` varchar(45) DEFAULT NULL,
  `tweets_fetched` varchar(45) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `url` text,
  `microtime` varchar(45) DEFAULT NULL,
  `item_number` varchar(255) DEFAULT NULL,
  `run_uuid` varchar(255) DEFAULT NULL,
  `tweets_created` varchar(255) DEFAULT NULL,
  `tweets_blocked` varchar(255) DEFAULT NULL,
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
  `start_microtime` varchar(255) DEFAULT NULL,
  `item_count` varchar(45) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scrapers`
--

LOCK TABLES `scrapers` WRITE;
/*!40000 ALTER TABLE `scrapers` DISABLE KEYS */;
INSERT INTO `scrapers` VALUES (1,'admin_scraper_users','users_followers','scrape/users'),(2,'admin_scraper_urls','urls','scrape/urls'),(3,'admin_scraper_topics','topics','scrape/topics');
/*!40000 ALTER TABLE `scrapers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `key` varchar(200) NOT NULL,
  `value` varchar(45) DEFAULT NULL,
  `updated_at` varchar(30) DEFAULT NULL,
  `section` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`key`),
  UNIQUE KEY `idsettings_UNIQUE` (`key`)
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
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  `latest_cursor` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `value_UNIQUE` (`value`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topics`
--

LOCK TABLES `topics` WRITE;
/*!40000 ALTER TABLE `topics` DISABLE KEYS */;
/*!40000 ALTER TABLE `topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tweet_alert_strings`
--

DROP TABLE IF EXISTS `tweet_alert_strings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tweet_alert_strings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tweet_id` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alert_string_id` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweet_alert_strings`
--

LOCK TABLES `tweet_alert_strings` WRITE;
/*!40000 ALTER TABLE `tweet_alert_strings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tweet_alert_strings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tweet_hashtags`
--

DROP TABLE IF EXISTS `tweet_hashtags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tweet_hashtags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash_tag` text,
  `tweet_id` varchar(45) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `url` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweet_hashtags`
--

LOCK TABLES `tweet_hashtags` WRITE;
/*!40000 ALTER TABLE `tweet_hashtags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tweet_hashtags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tweet_media`
--

DROP TABLE IF EXISTS `tweet_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tweet_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` varchar(45) DEFAULT NULL,
  `url` text,
  `tweet_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweet_media`
--

LOCK TABLES `tweet_media` WRITE;
/*!40000 ALTER TABLE `tweet_media` DISABLE KEYS */;
/*!40000 ALTER TABLE `tweet_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tweet_mentions`
--

DROP TABLE IF EXISTS `tweet_mentions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tweet_mentions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `tweet_id` varchar(45) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweet_mentions`
--

LOCK TABLES `tweet_mentions` WRITE;
/*!40000 ALTER TABLE `tweet_mentions` DISABLE KEYS */;
/*!40000 ALTER TABLE `tweet_mentions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tweet_urls`
--

DROP TABLE IF EXISTS `tweet_urls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tweet_urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` varchar(45) DEFAULT NULL,
  `url` text,
  `tco_url` text,
  `tweet_id` varchar(45) DEFAULT NULL,
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweet_urls`
--

LOCK TABLES `tweet_urls` WRITE;
/*!40000 ALTER TABLE `tweet_urls` DISABLE KEYS */;
/*!40000 ALTER TABLE `tweet_urls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tweet_words`
--

DROP TABLE IF EXISTS `tweet_words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tweet_words` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `word_id` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tweet_id` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweet_words`
--

LOCK TABLES `tweet_words` WRITE;
/*!40000 ALTER TABLE `tweet_words` DISABLE KEYS */;
/*!40000 ALTER TABLE `tweet_words` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tweets`
--

DROP TABLE IF EXISTS `tweets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tweets` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tweet` text,
  `created_at` varchar(45) DEFAULT NULL,
  `tweet_id` varchar(255) DEFAULT NULL,
  `twitter_user_id` varchar(255) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `user_title` varchar(45) DEFAULT NULL,
  `tweet_source_url` text,
  `tweet_topic_id` varchar(45) DEFAULT NULL,
  `tweet_source_url_id` varchar(45) DEFAULT NULL,
  `tweet_source_user_id` varchar(45) DEFAULT NULL,
  `inserted_at` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tweet_id_UNIQUE` (`tweet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweets`
--

LOCK TABLES `tweets` WRITE;
/*!40000 ALTER TABLE `tweets` DISABLE KEYS */;
/*!40000 ALTER TABLE `tweets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twitter_users`
--

DROP TABLE IF EXISTS `twitter_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twitter_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `latest_cursor` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twitter_users`
--

LOCK TABLES `twitter_users` WRITE;
/*!40000 ALTER TABLE `twitter_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `twitter_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `urls`
--

DROP TABLE IF EXISTS `urls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  `latest_cursor` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `value_UNIQUE` (`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `urls`
--

LOCK TABLES `urls` WRITE;
/*!40000 ALTER TABLE `urls` DISABLE KEYS */;
/*!40000 ALTER TABLE `urls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `user_token` varchar(200) DEFAULT NULL,
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

--
-- Table structure for table `words`
--

DROP TABLE IF EXISTS `words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `word_UNIQUE` (`word`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `words`
--

LOCK TABLES `words` WRITE;
/*!40000 ALTER TABLE `words` DISABLE KEYS */;
/*!40000 ALTER TABLE `words` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-02-01  0:22:22
