-- MySQL dump 10.13  Distrib 8.0.45, for Win64 (x86_64)
--
-- Host: localhost    Database: denpasar_trip
-- ------------------------------------------------------
-- Server version	8.0.45

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
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
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Nature','2026-10-18 17:25:42','2026-10-18 17:25:42'),(2,'Culture','2026-10-18 17:25:42','2026-10-18 17:25:42'),(3,'Art','2026-10-18 17:25:42','2026-10-18 17:25:42'),(4,'Culinary','2026-10-18 17:25:42','2026-10-18 17:25:42'),(5,'Shopping','2026-10-18 17:25:42','2026-10-18 17:25:42');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_destination`
--

DROP TABLE IF EXISTS `category_destination`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_destination` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `destination_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_destination_category_id_destination_id_unique` (`category_id`,`destination_id`),
  KEY `category_destination_destination_id_foreign` (`destination_id`),
  CONSTRAINT `category_destination_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `category_destination_destination_id_foreign` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_destination`
--

LOCK TABLES `category_destination` WRITE;
/*!40000 ALTER TABLE `category_destination` DISABLE KEYS */;
INSERT INTO `category_destination` VALUES (4,2,4,NULL,NULL),(5,3,4,NULL,NULL),(6,4,5,NULL,NULL),(7,5,5,NULL,NULL),(8,2,6,NULL,NULL),(9,3,6,NULL,NULL);
/*!40000 ALTER TABLE `category_destination` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `destinations`
--

DROP TABLE IF EXISTS `destinations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `destinations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opening_hours` text COLLATE utf8mb4_unicode_ci,
  `entrance_fee` text COLLATE utf8mb4_unicode_ci,
  `average_spending` text COLLATE utf8mb4_unicode_ci,
  `google_maps_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `destinations`
--

LOCK TABLES `destinations` WRITE;
/*!40000 ALTER TABLE `destinations` DISABLE KEYS */;
INSERT INTO `destinations` VALUES (4,'Monumen Bajra Sandhi','Monumen Bajra Sandhi merupakan monumen bersejarah yang menjadi salah satu ikon Kota Denpasar. Monumen ini menggambarkan perjuangan rakyat Bali dalam mempertahankan kemerdekaan dan menyimpan berbagai informasi mengenai sejarah perjuangan masyarakat Bali. Selain menikmati arsitektur monumen, pengunjung dapat mengunjungi museum di dalamnya untuk mengenal lebih jauh sejarah dan budaya Bali.','destinations/1uw1vf9Rw53uqxY9JzK0EBU09oL58T3r8eNqdtsU.jpg','\"{\\\"schedules\\\":[{\\\"days\\\":[\\\"Senin\\\",\\\"Selasa\\\",\\\"Rabu\\\",\\\"Kamis\\\",\\\"Jumat\\\"],\\\"hours\\\":\\\"08.00-17.00\\\"},{\\\"days\\\":[\\\"Sabtu\\\"],\\\"hours\\\":\\\"09.00-17.00\\\"},{\\\"days\\\":[\\\"Minggu\\\"],\\\"hours\\\":\\\"10.00-17.00\\\"}],\\\"notes\\\":\\\"Tutup pada hari libur nasional dan internasional.\\\"}\"','{\"type\":\"range\",\"min\":5000,\"max\":100000,\"amount\":null,\"notes\":\"tergantung jenis wisatawan\"}','{\"type\":\"range\",\"min\":10000,\"max\":200000,\"amount\":null,\"notes\":\"\"}','https://maps.app.goo.gl/6mJ4rUTkoVs4SEPa8?g_st=ic','2026-10-18 22:56:28','2026-10-28 05:17:04'),(5,'Living World','Living World Denpasar merupakan pusat perbelanjaan dengan konsep Home Living, Lifestyle & Eat-ertainment yang menghadirkan berbagai kebutuhan belanja, gaya hidup, dan kuliner dalam satu tempat. Mall ini memadukan konsep modern dengan arsitektur yang terinspirasi dari budaya Bali, serta menyediakan berbagai pilihan tenant seperti fashion, makanan dan minuman, kebutuhan rumah tangga, hiburan, dan lifestyle.','destinations/R2RcWUuBhsWUsj7ANlT9NjGjtkwOasBpXSYpIGlp.jpg','\"{\\\"schedules\\\":[{\\\"days\\\":[\\\"Senin\\\",\\\"Selasa\\\",\\\"Rabu\\\",\\\"Kamis\\\",\\\"Jumat\\\",\\\"Sabtu\\\",\\\"Minggu\\\"],\\\"hours\\\":\\\"10.00-22.00\\\"}],\\\"notes\\\":\\\"\\\"}\"','{\"type\":\"range\",\"min\":2000,\"max\":3000,\"amount\":null,\"notes\":\"Tarif berbeda tergantung jenis kendaraan dan lama berkunjung.\"}','{\"type\":\"range\",\"min\":50000,\"max\":300000,\"amount\":null,\"notes\":\"Perkiraan berdasarkan makanan, minuman, dan belanja.\"}','https://maps.app.goo.gl/25jiz8npiTLxAq1t8?g_st=ic','2026-10-18 23:12:52','2026-10-18 23:12:52'),(6,'Museum Bali','Museum Bali merupakan destinasi wisata sejarah dan budaya yang terletak di Jalan Mayor Wisnu, Denpasar, Bali. Museum ini menyimpan berbagai koleksi bersejarah, seperti pakaian adat, perhiasan tradisional, senjata, dan alat upacara keagamaan. Bangunannya memiliki arsitektur khas Bali dengan ukiran dan ornamen yang mencerminkan nilai seni serta filosofi budaya lokal. Museum Bali menjadi tempat wisata edukatif bagi pengunjung untuk mengenal sejarah, adat istiadat, dan kebudayaan masyarakat Bali.','destinations/WHQ5DaK3fdjvlmx4AHVye29mdVnJj1dm2qoql7mP.jpg','\"{\\\"schedules\\\":[{\\\"days\\\":[\\\"Senin\\\",\\\"Selasa\\\",\\\"Rabu\\\",\\\"Kamis\\\",\\\"Jumat\\\",\\\"Sabtu\\\",\\\"Minggu\\\"],\\\"hours\\\":\\\"08.00-17.00\\\"}],\\\"notes\\\":\\\"\\\"}\"','{\"type\":\"free\",\"min\":null,\"max\":null,\"amount\":null,\"notes\":\"\"}','{\"type\":null,\"min\":null,\"max\":null,\"amount\":null,\"notes\":\"\"}','https://maps.app.goo.gl/KdQjovxSduYrS8K38','2026-10-19 00:43:19','2026-10-19 00:43:19');
/*!40000 ALTER TABLE `destinations` ENABLE KEYS */;
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
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
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
-- Table structure for table `itineraries`
--

DROP TABLE IF EXISTS `itineraries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itineraries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `trip_id` bigint unsigned NOT NULL,
  `destination_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `duration` int unsigned DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `itineraries_trip_id_foreign` (`trip_id`),
  KEY `itineraries_destination_id_foreign` (`destination_id`),
  CONSTRAINT `itineraries_destination_id_foreign` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `itineraries_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itineraries`
--

LOCK TABLES `itineraries` WRITE;
/*!40000 ALTER TABLE `itineraries` DISABLE KEYS */;
INSERT INTO `itineraries` VALUES (3,9,4,'2026-11-25','08:00:00',120,NULL,1,'2026-11-16 02:01:00','2026-11-16 02:01:12'),(4,11,5,'2026-11-19','08:00:00',120,NULL,2,'2026-11-16 04:54:48','2026-11-16 18:03:28'),(5,11,4,'2026-11-19','10:00:00',120,NULL,1,'2026-11-16 04:55:07','2026-11-16 18:03:28'),(6,12,5,'2026-11-16','08:00:00',120,NULL,1,'2026-11-16 05:50:11','2026-11-16 05:50:11'),(7,13,4,'2026-11-18','08:00:00',120,NULL,1,'2026-11-16 06:05:06','2026-11-16 06:05:06');
/*!40000 ALTER TABLE `itineraries` ENABLE KEYS */;
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
  `attempts` smallint unsigned NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_10_13_110322_create_categories_table',1),(5,'2026_10_13_110336_create_destinations_table',1),(6,'2026_10_13_110349_create_trips_table',1),(7,'2026_10_13_110417_create_trip_preferences_table',1),(8,'2026_10_13_110429_create_itineraries_table',1),(9,'2026_10_13_110557_create_category_destination_table',1),(10,'2026_10_28_132406_create_reviews_table',2),(11,'2026_11_16_000000_allow_multiple_destination_reviews_per_user',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `destination_id` bigint unsigned NOT NULL,
  `rating` tinyint unsigned NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_destination_id_foreign` (`destination_id`),
  KEY `reviews_user_id_index` (`user_id`),
  CONSTRAINT `reviews_destination_id_foreign` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,6,5,4,'BAgusss','2026-11-14 20:50:53','2026-11-14 20:50:53'),(2,6,4,5,'mantap','2026-11-15 22:22:03','2026-11-15 22:22:03'),(3,6,6,3,'not bad','2026-11-15 22:22:24','2026-11-15 22:22:24');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
INSERT INTO `sessions` VALUES ('PHk71RSX2ECf3Bv2EapFuHeUkyQysKYnmZIO9Cn1',6,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJBSGt3TGJJc0t6cHdCbG5tVlJ5NHNESDRCUUp3ZEpSZWVsSWcwcTMwIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL3RyaXAtcGxhbm5lciIsInJvdXRlIjoidHJpcHMuY3JlYXRlIn0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjo2LCJwYXNzd29yZF9oYXNoX3dlYiI6IjU0ODI2Mzg4NmNhMGE2YzYxMjVlNWE5YzM4MjkxNWQ2YTBmNzhhODBjNjVlYzQyZTU0NzkwYmE5MjU2N2JkYWMifQ==',1794918994),('TLYZc9P49SBZIr7Zkw89JFuhyUsfGmfRmQkATe0c',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJpSFgwMldhM2I3eGJGOWp5dFFKbmg0WWRiTHZPd2tDMm1Wc1hpNXROIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hdXRoXC9nb29nbGVcL3JlZGlyZWN0Iiwicm91dGUiOiJvYXV0aC5yZWRpcmVjdCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sInVybCI6eyJpbnRlbmRlZCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC90cmlwLXBsYW5uZXIifX0=',1794908913),('WDkXUW1Br5olyCU5L408Bb7Sme2hwbPJy1a3dyc4',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ5YmZpOExrTmNhZWV3VWZBWHkyV0tzS2J1ZXJJTWR6bDdTZFhHWnJVIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9kZXN0aW5hdGlvbnMifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvZGVzdGluYXRpb25zIiwicm91dGUiOiJhZG1pbi5kZXN0aW5hdGlvbnMuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794906881);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trip_preferences`
--

DROP TABLE IF EXISTS `trip_preferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trip_preferences` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `trip_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `trip_preferences_trip_id_category_id_unique` (`trip_id`,`category_id`),
  KEY `trip_preferences_category_id_foreign` (`category_id`),
  CONSTRAINT `trip_preferences_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `trip_preferences_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trip_preferences`
--

LOCK TABLES `trip_preferences` WRITE;
/*!40000 ALTER TABLE `trip_preferences` DISABLE KEYS */;
INSERT INTO `trip_preferences` VALUES (1,1,1,'2026-11-14 06:08:43','2026-11-14 06:08:43'),(4,3,5,'2026-11-14 19:38:08','2026-11-14 19:38:08'),(5,3,1,'2026-11-14 19:53:50','2026-11-14 19:53:50'),(6,4,1,'2026-11-14 20:48:48','2026-11-14 20:48:48'),(7,4,5,'2026-11-14 20:48:48','2026-11-14 20:48:48'),(8,5,5,'2026-11-14 20:50:09','2026-11-14 20:50:09'),(9,6,5,'2026-11-14 20:51:51','2026-11-14 20:51:51'),(10,7,1,'2026-11-14 23:41:57','2026-11-14 23:41:57'),(11,7,5,'2026-11-14 23:41:57','2026-11-14 23:41:57'),(12,8,1,'2026-11-15 02:10:52','2026-11-15 02:10:52'),(13,9,1,'2026-11-16 00:22:17','2026-11-16 00:22:17'),(15,10,1,'2026-11-16 02:10:14','2026-11-16 02:10:14'),(16,10,3,'2026-11-16 02:10:14','2026-11-16 02:10:14'),(17,10,5,'2026-11-16 02:10:14','2026-11-16 02:10:14'),(18,11,2,'2026-11-16 04:54:27','2026-11-16 04:54:27'),(19,11,4,'2026-11-16 04:54:27','2026-11-16 04:54:27'),(20,12,1,'2026-11-16 05:49:53','2026-11-16 05:49:53'),(21,12,5,'2026-11-16 05:49:53','2026-11-16 05:49:53'),(22,13,1,'2026-11-16 06:04:57','2026-11-16 06:04:57'),(23,13,3,'2026-11-16 06:04:57','2026-11-16 06:04:57'),(24,14,1,'2026-11-16 18:12:55','2026-11-16 18:12:55'),(25,14,5,'2026-11-16 18:12:55','2026-11-16 18:12:55'),(26,15,5,'2026-11-16 20:37:56','2026-11-16 20:37:56');
/*!40000 ALTER TABLE `trip_preferences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trips`
--

DROP TABLE IF EXISTS `trips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trips` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `trip_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trips_user_id_foreign` (`user_id`),
  CONSTRAINT `trips_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trips`
--

LOCK TABLES `trips` WRITE;
/*!40000 ALTER TABLE `trips` DISABLE KEYS */;
INSERT INTO `trips` VALUES (1,6,'bbbb','2026-11-19','2026-11-20','2026-11-14 06:08:36','2026-11-14 06:08:36'),(3,6,'gung diah','2026-12-03','2026-12-12','2026-11-14 19:37:52','2026-11-14 19:37:52'),(4,6,'bbbb','2026-11-11','2026-11-13','2026-11-14 20:48:42','2026-11-14 20:48:42'),(5,6,'bbbb','2026-11-15','2026-11-18','2026-11-14 20:50:06','2026-11-14 20:50:06'),(6,6,'gung diah','2026-11-15','2026-11-16','2026-11-14 20:51:47','2026-11-14 20:51:47'),(7,6,'gung diah','2026-11-10','2026-11-15','2026-11-14 23:41:48','2026-11-14 23:41:48'),(8,6,'gung diah','2026-10-28','2026-10-30','2026-11-15 02:10:36','2026-11-15 02:10:36'),(9,6,'Example','2026-11-25','2026-11-26','2026-11-16 00:21:26','2026-11-16 00:21:26'),(10,6,'gung diah','2026-11-12','2026-11-20','2026-11-16 02:10:10','2026-11-16 02:10:10'),(11,6,'gung diah','2026-11-19','2026-11-22','2026-11-16 04:54:21','2026-11-16 04:54:21'),(12,7,'gung diah','2026-11-16','2026-11-16','2026-11-16 05:33:26','2026-11-16 05:33:35'),(13,7,'bbbb','2026-11-18','2026-11-19','2026-11-16 06:04:51','2026-11-16 06:04:51'),(14,6,'gung diah','2026-11-25','2026-11-27','2026-11-16 18:06:01','2026-11-16 18:06:01'),(15,6,'gung diah','2026-11-19','2026-11-21','2026-11-16 20:37:28','2026-11-16 20:37:28');
/*!40000 ALTER TABLE `trips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Gung Diah','agungparwati20@gmail.com','2026-11-14 00:57:47','$2y$12$vvC7uKt0OLGHjLtajWIy/O.RJV1MyH.7xk/IlProaukWzzfhBuANu','admin',NULL,'2026-10-18 23:46:57','2026-11-14 00:57:47'),(2,'Reva','putureva28@gmail.com',NULL,'$2y$12$xMcKRkCuVIHWuJ/g4CUGB.Ma1QuHQSWWTrk29XxmFw1S6yDyFj/26','admin',NULL,'2026-10-18 23:46:58','2026-10-18 23:46:58'),(3,'Rere','revalinagirsang54@gmail.com',NULL,'$2y$12$hKREOhwu9MHqkANxqZkVuOhfNVj3FUZQVrGShdX2hPkSiYuGL3e86','admin',NULL,'2026-10-18 23:46:58','2026-10-18 23:46:58'),(4,'Febri','niputufebriantitrpl@gmail.com',NULL,'$2y$12$PCUCyWomxNuiFyWP.5cDfu9g6q7CvuvDjLLdUPEgtEAwgfxKhrMk6','admin',NULL,'2026-10-18 23:46:58','2026-10-18 23:46:58'),(5,'Natania','taniatasya252@gmail.com',NULL,'$2y$12$TI8MyW/U60oF61juLKMCMOOUB1OBTgOl3ZLacjope80ZuqssOz01e','admin',NULL,'2026-10-18 23:46:58','2026-10-18 23:46:58'),(6,'Victoria Moriarty','victoriamoriarty20@gmail.com','2026-11-14 02:13:20','$2y$12$A7AP6HEjygCM3LbQhCvr8.KvSiXZqpd6Wt5dfi5AYjGd02HDyWiOq','user',NULL,'2026-11-14 02:13:20','2026-11-14 02:13:20'),(7,'ANAK AGUNG ISTRI DIAH PARWATI','2515354015@pnb.ac.id','2026-11-16 05:32:38','$2y$12$e3veAKgNPRhcA3BC1se2gOnM1rIUqT6rLW/IOkNmS1E0QFI4YU5Iu','user',NULL,'2026-11-16 05:32:38','2026-11-16 05:32:38');
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

-- Dump completed on 2026-11-18  8:25:52
