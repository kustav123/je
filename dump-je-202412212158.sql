-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: je
-- ------------------------------------------------------
-- Server version	9.0.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `appinfo`
--

DROP TABLE IF EXISTS `appinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `appinfo` (
  `id` int DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gstno` varchar(17) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apptype` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cont1` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cont2` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `bank_account_holder_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_qr` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_branch` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_ac_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_ifsc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `due_ammount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `earning_yr` decimal(15,2) NOT NULL DEFAULT '0.00',
  `earning_lt` decimal(15,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appinfo`
--

LOCK TABLES `appinfo` WRITE;
/*!40000 ALTER TABLE `appinfo` DISABLE KEYS */;
INSERT INTO `appinfo` VALUES (1,'Jaysree Enterprise','fe.png','446/2 Durga Apartment, Kalighat, Kolkata  700026','','p','sc','electronics.falcon@gmail.com','+91 9830050569','+91 9830484889',1,'FALCON  ELECTRONICS','feqr.png','UCO','Bhowanipore','00310200011038','UCBA0000031',0.00,0.00,0.00);
/*!40000 ALTER TABLE `appinfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appuser`
--

DROP TABLE IF EXISTS `appuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `appuser` (
  `id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sign` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_logedin` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastlogin_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastlogin_from` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appuser`
--

LOCK TABLES `appuser` WRITE;
/*!40000 ALTER TABLE `appuser` DISABLE KEYS */;
INSERT INTO `appuser` VALUES ('A01','admin','9999999999','admin@gmail.com','2024-12-21 20:21:33','$2y$12$XRs1JWhO1e.RsFQ9z6UJyO2unrAvsbInAVh9/bzaRdPTQWOpepzsi','AD',NULL,'1',NULL,'CrBwih0lO2eCCJR9jvrdNUx9Fmk1bCrHVO1grRWbob7TW1DiwjID7WWqPAov','2024-12-21 16:24:36','127.0.0.1','admin','2024-12-21 20:21:34','2024-12-21 21:23:22');
/*!40000 ALTER TABLE `appuser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asso_ext`
--

DROP TABLE IF EXISTS `asso_ext`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asso_ext` (
  `id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uidtype` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `asso_ext_created_by_foreign` (`created_by`),
  CONSTRAINT `asso_ext_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `appuser` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asso_ext`
--

LOCK TABLES `asso_ext` WRITE;
/*!40000 ALTER TABLE `asso_ext` DISABLE KEYS */;
INSERT INTO `asso_ext` VALUES ('AE_001','ram das','8787878787',NULL,1,'dfdbdfb g rg','EPIC','vndngn','2024-12-21 21:25:21','2024-12-21 21:30:27','A01');
/*!40000 ALTER TABLE `asso_ext` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asso_int`
--

DROP TABLE IF EXISTS `asso_int`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asso_int` (
  `id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uidtype` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `asso_int_created_by_foreign` (`created_by`),
  CONSTRAINT `asso_int_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `appuser` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asso_int`
--

LOCK TABLES `asso_int` WRITE;
/*!40000 ALTER TABLE `asso_int` DISABLE KEYS */;
/*!40000 ALTER TABLE `asso_int` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit`
--

DROP TABLE IF EXISTS `audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `audit` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit`
--

LOCK TABLES `audit` WRITE;
/*!40000 ALTER TABLE `audit` DISABLE KEYS */;
INSERT INTO `audit` VALUES (1,'A01','Client created','New client created successfully id CL-00001 ','2024-12-21 21:56:14','2024-12-21 21:56:14'),(2,'A01','Client created','New client created successfully id CL-00002 ','2024-12-21 21:56:34','2024-12-21 21:56:34');
/*!40000 ALTER TABLE `audit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client` (
  `id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int DEFAULT NULL,
  `due_ammount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `gst` varchar(17) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_additonal` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_created_by_foreign` (`created_by`),
  CONSTRAINT `client_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `appuser` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` VALUES ('CL-00001','Kustav Chatterjee','9808535745','kustav@live.com','Building no 1240\r\nWay no 277 Ghsla Sanniah\r\nSultanate of Oman','West Bengal',1,0.00,'22ABBAA0000A1Z5','fhghg','A01',NULL,'2024-12-21 21:56:14','2024-12-21 21:56:14'),('CL-00002','Amit Kar','8900089000','trisha9851@gmail.com','jugyutvitur t','West Bengal',1,0.00,'22ABBAA0000A1Z5',NULL,'A01',NULL,'2024-12-21 21:56:34','2024-12-21 21:56:34');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finish_product`
--

DROP TABLE IF EXISTS `finish_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `finish_product` (
  `id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_stock` int NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `finish_product_created_by_foreign` (`created_by`),
  CONSTRAINT `finish_product_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `appuser` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finish_product`
--

LOCK TABLES `finish_product` WRITE;
/*!40000 ALTER TABLE `finish_product` DISABLE KEYS */;
INSERT INTO `finish_product` VALUES ('F_001','finishi h 1','Gram','A01',800,1,'ckhzv d','2024-12-21 21:26:46','2024-12-21 21:33:12'),('F_002','Raw Casse','KG','A01',0,1,'Raw Cashue 500G','2024-12-21 21:57:37','2024-12-21 21:57:37'),('F_003','Demo Product1','KG','A01',0,1,'Demo Ddj j fjdf bfk fdbfb','2024-12-21 21:57:57','2024-12-21 21:57:57');
/*!40000 ALTER TABLE `finish_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finproduct_in_his_ext`
--

DROP TABLE IF EXISTS `finproduct_in_his_ext`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `finproduct_in_his_ext` (
  `id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aid` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `finproduct_in_his_ext_aid_index` (`aid`),
  KEY `finproduct_in_his_ext_product_index` (`product`),
  CONSTRAINT `finproduct_in_his_ext_aid_foreign` FOREIGN KEY (`aid`) REFERENCES `asso_ext` (`id`),
  CONSTRAINT `finproduct_in_his_ext_product_foreign` FOREIGN KEY (`product`) REFERENCES `finish_product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finproduct_in_his_ext`
--

LOCK TABLES `finproduct_in_his_ext` WRITE;
/*!40000 ALTER TABLE `finproduct_in_his_ext` DISABLE KEYS */;
INSERT INTO `finproduct_in_his_ext` VALUES ('ST/0001','AE_001','F_001','2024-12-21',800,NULL,NULL);
/*!40000 ALTER TABLE `finproduct_in_his_ext` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finproduct_in_his_int`
--

DROP TABLE IF EXISTS `finproduct_in_his_int`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `finproduct_in_his_int` (
  `id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aid` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `finproduct_in_his_int_aid_index` (`aid`),
  KEY `finproduct_in_his_int_product_index` (`product`),
  CONSTRAINT `finproduct_in_his_int_aid_foreign` FOREIGN KEY (`aid`) REFERENCES `asso_int` (`id`),
  CONSTRAINT `finproduct_in_his_int_product_foreign` FOREIGN KEY (`product`) REFERENCES `finish_product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finproduct_in_his_int`
--

LOCK TABLES `finproduct_in_his_int` WRITE;
/*!40000 ALTER TABLE `finproduct_in_his_int` DISABLE KEYS */;
/*!40000 ALTER TABLE `finproduct_in_his_int` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hsn`
--

DROP TABLE IF EXISTS `hsn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hsn` (
  `id` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `status` tinyint NOT NULL,
  `cgst` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sgst` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hsn`
--

LOCK TABLES `hsn` WRITE;
/*!40000 ALTER TABLE `hsn` DISABLE KEYS */;
/*!40000 ALTER TABLE `hsn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leadger_sc`
--

DROP TABLE IF EXISTS `leadger_sc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leadger_sc` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `clid` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_amomount` double DEFAULT NULL,
  `truns_ammount` double DEFAULT NULL,
  `mode` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refno` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tid` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `leadger_sc_clid_foreign` (`clid`),
  CONSTRAINT `leadger_sc_clid_foreign` FOREIGN KEY (`clid`) REFERENCES `supplier` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leadger_sc`
--

LOCK TABLES `leadger_sc` WRITE;
/*!40000 ALTER TABLE `leadger_sc` DISABLE KEYS */;
INSERT INTO `leadger_sc` VALUES (1,'S-00001','2024-12-16','due',6666,6666,'Stock Entry','Stk/00001','1234fdvjjj','2024-12-21 21:28:02','1234fdvjjj'),(2,'S-00001','2024-12-16','pay',1666,5000,'Cash','SP/00001',' ','2024-12-21 21:34:59','neyupi223'),(3,'S-00001','2024-12-21','pay',-5000,6666,'Cash','SP/00002',' ','2024-12-21 21:35:39','dddd'),(4,'S-00001','2024-12-16','pay',-10000,5000,'Cheque','SP/00003',' ','2024-12-21 21:37:05',NULL);
/*!40000 ALTER TABLE `leadger_sc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (38,'0001_01_01_000000_create_users_table',1),(39,'0001_01_01_000001_create_cache_table',1),(40,'0001_01_01_000002_create_jobs_table',1),(41,'2024_08_18_093943_create_base_table',1),(42,'2024_10_25_112237_create_product_tables',1),(43,'2024_12_20_174620_finence',1),(44,'2024_12_21_161504_sc_payment_entry',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nextval`
--

DROP TABLE IF EXISTS `nextval`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nextval` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `head` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sno` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nextval`
--

LOCK TABLES `nextval` WRITE;
/*!40000 ALTER TABLE `nextval` DISABLE KEYS */;
/*!40000 ALTER TABLE `nextval` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_entry_history`
--

DROP TABLE IF EXISTS `product_entry_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_entry_history` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `product` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`,`entry_id`),
  KEY `product_entry_history_entry_id_foreign` (`entry_id`),
  KEY `product_entry_history_product_foreign` (`product`),
  CONSTRAINT `product_entry_history_entry_id_foreign` FOREIGN KEY (`entry_id`) REFERENCES `product_entry_main` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_entry_history`
--

LOCK TABLES `product_entry_history` WRITE;
/*!40000 ALTER TABLE `product_entry_history` DISABLE KEYS */;
INSERT INTO `product_entry_history` VALUES (1,'Stk/00001','2024-12-21 21:28:02','R_001','900',NULL,NULL);
/*!40000 ALTER TABLE `product_entry_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_entry_main`
--

DROP TABLE IF EXISTS `product_entry_main`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_entry_main` (
  `id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chalan_no` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recived_date` date DEFAULT NULL,
  `delivary_mode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `total_cgst` double DEFAULT NULL,
  `total_sgst` double DEFAULT NULL,
  `remarks` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_entry_main_created_by_foreign` (`created_by`),
  KEY `product_entry_main_from_foreign` (`from`),
  CONSTRAINT `product_entry_main_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `appuser` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_entry_main_from_foreign` FOREIGN KEY (`from`) REFERENCES `supplier` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_entry_main`
--

LOCK TABLES `product_entry_main` WRITE;
/*!40000 ALTER TABLE `product_entry_main` DISABLE KEYS */;
INSERT INTO `product_entry_main` VALUES ('Stk/00001','1234fdvjjj','S-00001','2024-12-16',NULL,6666,NULL,NULL,NULL,'A01','2024-12-21 21:28:02','2024-12-21 21:28:02');
/*!40000 ALTER TABLE `product_entry_main` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_st_out_ext`
--

DROP TABLE IF EXISTS `product_st_out_ext`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_st_out_ext` (
  `id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entry_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date DEFAULT NULL,
  `entry_by` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_st_out_ext_to_index` (`to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_st_out_ext`
--

LOCK TABLES `product_st_out_ext` WRITE;
/*!40000 ALTER TABLE `product_st_out_ext` DISABLE KEYS */;
INSERT INTO `product_st_out_ext` VALUES ('TE/0001','AE_001','2024-12-21 16:01:12','2024-12-21','A01',NULL,'2024-12-21 21:31:12','2024-12-21 21:31:12');
/*!40000 ALTER TABLE `product_st_out_ext` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_st_out_ext_dtl`
--

DROP TABLE IF EXISTS `product_st_out_ext_dtl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_st_out_ext_dtl` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `eid` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Main Entry ID',
  `product` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_st_out_ext_dtl_eid_index` (`eid`),
  KEY `product_st_out_ext_dtl_product_index` (`product`),
  CONSTRAINT `product_st_out_ext_dtl_eid_foreign` FOREIGN KEY (`eid`) REFERENCES `product_st_out_ext` (`id`),
  CONSTRAINT `product_st_out_ext_dtl_product_foreign` FOREIGN KEY (`product`) REFERENCES `raw_product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_st_out_ext_dtl`
--

LOCK TABLES `product_st_out_ext_dtl` WRITE;
/*!40000 ALTER TABLE `product_st_out_ext_dtl` DISABLE KEYS */;
INSERT INTO `product_st_out_ext_dtl` VALUES (1,'TE/0001','R_001',900);
/*!40000 ALTER TABLE `product_st_out_ext_dtl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_st_out_ext_map`
--

DROP TABLE IF EXISTS `product_st_out_ext_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_st_out_ext_map` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `aid` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Assosiate ID',
  `product` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_st_out_ext_map_aid_index` (`aid`),
  KEY `product_st_out_ext_map_product_index` (`product`),
  CONSTRAINT `product_st_out_ext_map_aid_foreign` FOREIGN KEY (`aid`) REFERENCES `asso_ext` (`id`),
  CONSTRAINT `product_st_out_ext_map_product_foreign` FOREIGN KEY (`product`) REFERENCES `raw_product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_st_out_ext_map`
--

LOCK TABLES `product_st_out_ext_map` WRITE;
/*!40000 ALTER TABLE `product_st_out_ext_map` DISABLE KEYS */;
INSERT INTO `product_st_out_ext_map` VALUES (1,'AE_001','R_001',300);
/*!40000 ALTER TABLE `product_st_out_ext_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_st_out_int`
--

DROP TABLE IF EXISTS `product_st_out_int`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_st_out_int` (
  `id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entry_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date DEFAULT NULL,
  `entry_by` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_st_out_int_to_index` (`to`),
  CONSTRAINT `product_st_out_int_to_foreign` FOREIGN KEY (`to`) REFERENCES `asso_int` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_st_out_int`
--

LOCK TABLES `product_st_out_int` WRITE;
/*!40000 ALTER TABLE `product_st_out_int` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_st_out_int` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_st_out_int_dtl`
--

DROP TABLE IF EXISTS `product_st_out_int_dtl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_st_out_int_dtl` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `eid` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Main Entry ID',
  `product` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_st_out_int_dtl_eid_index` (`eid`),
  KEY `product_st_out_int_dtl_product_index` (`product`),
  CONSTRAINT `product_st_out_int_dtl_eid_foreign` FOREIGN KEY (`eid`) REFERENCES `product_st_out_int` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_st_out_int_dtl_product_foreign` FOREIGN KEY (`product`) REFERENCES `raw_product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_st_out_int_dtl`
--

LOCK TABLES `product_st_out_int_dtl` WRITE;
/*!40000 ALTER TABLE `product_st_out_int_dtl` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_st_out_int_dtl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_st_out_int_map`
--

DROP TABLE IF EXISTS `product_st_out_int_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_st_out_int_map` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `aid` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Assosiate ID',
  `product` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_st_out_int_map_aid_index` (`aid`),
  KEY `product_st_out_int_map_product_index` (`product`),
  CONSTRAINT `product_st_out_int_map_aid_foreign` FOREIGN KEY (`aid`) REFERENCES `asso_int` (`id`),
  CONSTRAINT `product_st_out_int_map_product_foreign` FOREIGN KEY (`product`) REFERENCES `raw_product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_st_out_int_map`
--

LOCK TABLES `product_st_out_int_map` WRITE;
/*!40000 ALTER TABLE `product_st_out_int_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_st_out_int_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `raw_product`
--

DROP TABLE IF EXISTS `raw_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `raw_product` (
  `id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_stock` int NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `raw_product_created_by_foreign` (`created_by`),
  CONSTRAINT `raw_product_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `appuser` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `raw_product`
--

LOCK TABLES `raw_product` WRITE;
/*!40000 ALTER TABLE `raw_product` DISABLE KEYS */;
INSERT INTO `raw_product` VALUES ('R_001','raw 1','KG','A01',0,1,'Type Good','2024-12-21 21:26:17','2024-12-21 21:31:12');
/*!40000 ALTER TABLE `raw_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rawproduct_adj_his_ext`
--

DROP TABLE IF EXISTS `rawproduct_adj_his_ext`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rawproduct_adj_his_ext` (
  `id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Assosiate ID',
  `entry_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date DEFAULT NULL,
  `product` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `entry_by` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rawproduct_adj_his_ext_from_index` (`from`),
  KEY `rawproduct_adj_his_ext_product_index` (`product`),
  CONSTRAINT `rawproduct_adj_his_ext_from_foreign` FOREIGN KEY (`from`) REFERENCES `asso_ext` (`id`),
  CONSTRAINT `rawproduct_adj_his_ext_product_foreign` FOREIGN KEY (`product`) REFERENCES `raw_product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rawproduct_adj_his_ext`
--

LOCK TABLES `rawproduct_adj_his_ext` WRITE;
/*!40000 ALTER TABLE `rawproduct_adj_his_ext` DISABLE KEYS */;
INSERT INTO `rawproduct_adj_his_ext` VALUES ('ST/0001','AE_001','2024-12-21 16:02:41','2024-12-21','R_001',600,'A01',NULL,NULL,NULL);
/*!40000 ALTER TABLE `rawproduct_adj_his_ext` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rawproduct_adj_his_int`
--

DROP TABLE IF EXISTS `rawproduct_adj_his_int`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rawproduct_adj_his_int` (
  `id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Assosiate ID',
  `entry_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date DEFAULT NULL,
  `product` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  `entry_by` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rawproduct_adj_his_int_from_index` (`from`),
  KEY `rawproduct_adj_his_int_product_index` (`product`),
  CONSTRAINT `rawproduct_adj_his_int_from_foreign` FOREIGN KEY (`from`) REFERENCES `asso_int` (`id`),
  CONSTRAINT `rawproduct_adj_his_int_product_foreign` FOREIGN KEY (`product`) REFERENCES `raw_product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rawproduct_adj_his_int`
--

LOCK TABLES `rawproduct_adj_his_int` WRITE;
/*!40000 ALTER TABLE `rawproduct_adj_his_int` DISABLE KEYS */;
/*!40000 ALTER TABLE `rawproduct_adj_his_int` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_payment_entry`
--

DROP TABLE IF EXISTS `sc_payment_entry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sc_payment_entry` (
  `id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scid` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` double DEFAULT NULL,
  `mode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hisamount` double DEFAULT NULL,
  `curamount` double DEFAULT NULL,
  `frmaccount` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frmbnk` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trid` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `compid` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sc_payment_entry_scid_foreign` (`scid`),
  CONSTRAINT `sc_payment_entry_scid_foreign` FOREIGN KEY (`scid`) REFERENCES `supplier` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_payment_entry`
--

LOCK TABLES `sc_payment_entry` WRITE;
/*!40000 ALTER TABLE `sc_payment_entry` DISABLE KEYS */;
INSERT INTO `sc_payment_entry` VALUES ('SP/00001','S-00001','2024-12-21 21:34:59',5000,'Cash',6666,1666,'dd','uc','Paid agaings upi','A01','neyupi223',NULL),('SP/00002','S-00001','2024-12-21 21:35:39',6666,'Cash',1666,-5000,'dd','uc','gg','A01','dddd',NULL),('SP/00003','S-00001','2024-12-21 21:37:05',5000,'Cheque',-5000,-10000,'dd','uc','444','A01',NULL,1);
/*!40000 ALTER TABLE `sc_payment_entry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `secuence`
--

DROP TABLE IF EXISTS `secuence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `secuence` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `head` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sno` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secuence`
--

LOCK TABLES `secuence` WRITE;
/*!40000 ALTER TABLE `secuence` DISABLE KEYS */;
INSERT INTO `secuence` VALUES (1,'client','CL','2','client',1,'2024-12-21 14:51:34'),(2,'supplier','S','1','supplier',1,'2024-12-21 14:51:34'),(3,'asso_ext','AE','1','external assosite',1,'2024-12-21 14:51:34'),(4,'asso_int','AI','0','internal assosite',1,'2024-12-21 14:51:34'),(5,'rp','R','1','Raw Product',1,'2024-12-21 14:51:34'),(6,'fp','F','3','Raw Product',1,'2024-12-21 14:51:34'),(7,'paysup','SP','3','Supp Payment',1,'2024-12-21 14:51:34'),(8,'stkent','Stk','1','Stock Entry',1,'2024-12-21 14:51:34'),(9,'stkintout','TI','0','Stock Internal Transfer',1,'2024-12-21 14:51:34'),(10,'stkextout','TE','1','Stock External Transfer',1,'2024-12-21 14:51:34'),(11,'stlintin','RI','0','Stock Internal Return',1,'2024-12-21 14:51:34'),(12,'stlintin','ST','0','Stock Internal Adjustments',1,'2024-12-21 14:51:34'),(13,'fstlintin','ST','0','Stock Internal Recives',1,'2024-12-21 14:51:34'),(14,'stlextit','ST','1','Stock Exnternal Adjustments',1,'2024-12-21 14:51:34'),(15,'fstlextin','ST','1','Stock External Recives',1,'2024-12-21 14:51:34');
/*!40000 ALTER TABLE `secuence` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier` (
  `id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merchant_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_additonal` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL,
  `due_ammount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `gst` varchar(17) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supplier_created_by_foreign` (`created_by`),
  CONSTRAINT `supplier_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `appuser` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier`
--

LOCK TABLES `supplier` WRITE;
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` VALUES ('S-00001','Kustav Chatterjee','9808535712',NULL,'kustav@live.com','Building no 1240\r\nWay no 277 Ghsla Sanniah\r\nSultanate of Oman','West Bengal','A01',1,-10000.00,'22ABBAA0000A1Z5',NULL,'2024-12-21 21:24:06','2024-12-21 21:37:05');
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'je'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-21 21:58:30
