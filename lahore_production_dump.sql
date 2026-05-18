-- MySQL dump 10.13  Distrib 8.0.46, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: lahore_aesthetics_traders
-- ------------------------------------------------------
-- Server version	8.0.46

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
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brands_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'MAC','mac',NULL,NULL,'active',0,'2026-05-14 18:59:56','2026-05-14 18:59:56'),(2,'Huda Beauty','huda-beauty',NULL,NULL,'active',1,'2026-05-14 18:59:56','2026-05-14 18:59:56'),(3,'L\'Oreal','loreal',NULL,NULL,'active',2,'2026-05-14 18:59:56','2026-05-14 18:59:56'),(4,'Maybelline','maybelline',NULL,NULL,'active',3,'2026-05-14 18:59:56','2026-05-14 18:59:56'),(5,'NYX','nyx',NULL,NULL,'active',4,'2026-05-14 18:59:56','2026-05-14 18:59:56'),(6,'Charlotte Tilbury','charlotte-tilbury',NULL,NULL,'active',5,'2026-05-14 18:59:56','2026-05-14 18:59:56'),(7,'Fenty Beauty','fenty-beauty',NULL,NULL,'active',6,'2026-05-14 18:59:56','2026-05-14 18:59:56'),(8,'NARS','nars',NULL,NULL,'active',7,'2026-05-14 18:59:56','2026-05-14 18:59:56');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
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
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Laser Machines','laser-machines',NULL,'categories/4f7b617e-3bba-4930-be7d-0fc4854478ee.webp','active',1,'2026-05-14 18:59:55','2026-05-18 06:20:07',NULL),(2,'HydraFacial','hydrafacial',NULL,NULL,'active',2,'2026-05-14 18:59:55','2026-05-14 18:59:55',NULL),(3,'Aesthetic Products','aesthetic-products',NULL,NULL,'active',3,'2026-05-14 18:59:55','2026-05-14 18:59:55',NULL),(4,'Exosomes','exosomes',NULL,'categories/3ff1f09a-45cb-4a5f-bef1-9586b8046cb9.webp','active',5,'2026-05-14 18:59:55','2026-05-18 06:23:30',3),(5,'Botox','botox',NULL,NULL,'active',5,'2026-05-14 18:59:55','2026-05-14 18:59:55',3),(6,'Dermal Fillers','dermal-fillers',NULL,NULL,'active',6,'2026-05-14 18:59:55','2026-05-14 18:59:55',3),(7,'Numbing Creams','numbing-creams',NULL,NULL,'active',7,'2026-05-14 18:59:55','2026-05-14 18:59:55',3),(8,'Otesaly Meso Serum','otesaly-meso-serum',NULL,NULL,'active',8,'2026-05-14 18:59:55','2026-05-14 18:59:55',3),(9,'Skin Whitening Injections','skin-whitening-injections',NULL,NULL,'active',9,'2026-05-14 18:59:55','2026-05-14 18:59:55',3),(10,'Stayve BB Glow','stayve-bb-glow',NULL,NULL,'active',10,'2026-05-14 18:59:55','2026-05-14 18:59:55',3),(11,'Microneedling','microneedling',NULL,NULL,'active',11,'2026-05-14 18:59:55','2026-05-14 18:59:55',3),(12,'Injectables','injectables',NULL,NULL,'active',12,'2026-05-14 18:59:55','2026-05-14 18:59:55',3),(13,'Peels & Serums','peels-serums',NULL,NULL,'active',13,'2026-05-14 18:59:55','2026-05-14 18:59:55',3),(14,'Tools & Devices','tools-devices',NULL,NULL,'active',14,'2026-05-14 18:59:55','2026-05-14 18:59:55',3),(15,'Other Equipment','other-equipment',NULL,NULL,'active',15,'2026-05-14 18:59:55','2026-05-14 18:59:55',NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_05_04_170419_create_categories_table',1),(5,'2026_05_04_170420_create_brands_table',1),(6,'2026_05_04_170420_create_products_table',1),(7,'2026_05_04_170421_create_settings_table',1),(8,'2026_05_06_073206_rename_is_best_seller_to_is_hot_seller_in_products_table',1),(9,'2026_05_06_204148_add_brand_id_to_products_table',1),(10,'2026_05_06_205721_remove_is_featured_from_products_table',1),(11,'2026_05_14_235452_add_parent_id_to_categories_table',1),(12,'2026_05_15_000001_remove_is_hot_seller_from_products_table',2),(13,'2026_05_16_000001_create_reviews_table',2);
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
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned DEFAULT NULL,
  `brand_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `main_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery_images` json DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_brand_id_foreign` (`brand_id`),
  CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,NULL,'IPL 3-in-1','ipl-3-in-1',2447200.00,NULL,7,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:55','2026-05-14 19:55:18'),(2,1,NULL,'IPL 4-in-1 UK Lamp','ipl-4-in-1-uk-lamp',1573829.00,NULL,8,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:55','2026-05-14 19:55:18'),(3,1,NULL,'Diode 810','diode-810',1926190.00,NULL,6,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:55','2026-05-14 19:55:18'),(4,1,NULL,'Black Swann','black-swann',1473280.00,NULL,10,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:55','2026-05-14 19:55:18'),(5,1,NULL,'Soprano Titanium (1600W, Chinese Bar)','soprano-titanium-1600w-chinese-bar',2129073.00,NULL,9,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:55','2026-05-14 19:55:18'),(6,1,NULL,'Soprano Titanium (1600W, USA Coherent Bar)','soprano-titanium-1600w-usa-coherent-bar',988218.00,NULL,6,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:55','2026-05-14 19:55:18'),(7,1,NULL,'Soprano Titanium (1600W, Diode Single Handle)','soprano-titanium-1600w-diode-single-handle',2004794.00,NULL,8,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:56','2026-05-14 19:55:18'),(8,1,NULL,'Soprano Titanium New Shape','soprano-titanium-new-shape',2041431.00,NULL,7,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:56','2026-05-14 19:55:18'),(9,1,NULL,'Soprano Titanium (1600W, 3in1 Diode+IPL+PICO)','soprano-titanium-1600w-3in1-diodeiplpico',805035.00,NULL,6,NULL,NULL,'products/e722df29-72a7-4054-9c37-d9e48e1cd180.webp','[\"products/46063e74-04d7-49e3-9996-5d3907930c0a.webp\", \"products/8dab9c12-27e2-4b6f-a8d9-c7883dd5c893.webp\", \"products/fa3c0b86-22cb-4317-8509-25a4eeb06bb8.webp\"]','active',NULL,NULL,'2026-05-14 18:59:56','2026-05-18 06:26:29'),(10,1,NULL,'BV Laser Single Handle Diode','bv-laser-single-handle-diode',1334121.00,NULL,7,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:56','2026-05-14 19:55:18'),(11,1,NULL,'BV Laser 2in1 Diode+Pico','bv-laser-2in1-diodepico',850737.00,NULL,2,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:56','2026-05-14 19:55:18'),(12,1,NULL,'BV Laser 3in1 Diode+IPL+PICO','bv-laser-3in1-diodeiplpico',1515894.00,NULL,9,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:56','2026-05-14 19:55:18'),(13,2,NULL,'HydraFacial 7-in-1 (Dual Pump)','hydrafacial-7-in-1-dual-pump',250064.00,NULL,5,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:56','2026-05-14 19:55:18'),(14,2,NULL,'HydraFacial 7-in-1 (Mechanical Pump)','hydrafacial-7-in-1-mechanical-pump',202031.00,NULL,3,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:56','2026-05-14 19:55:18'),(15,2,NULL,'HydraFacial 9-in-1 (Mechanical Pump + Metal body)','hydrafacial-9-in-1-mechanical-pump-metal-body',434281.00,NULL,9,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:56','2026-05-14 19:55:18'),(16,2,NULL,'HydraFacial 11-in-1 (Mechanical Pump + Metal Body)','hydrafacial-11-in-1-mechanical-pump-metal-body',331468.00,NULL,7,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:56','2026-05-14 19:55:18'),(17,2,NULL,'HydraFacial 12-in-1 with Skin Analyser','hydrafacial-12-in-1-with-skin-analyser',414901.00,NULL,6,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:56','2026-05-14 19:55:18'),(18,2,NULL,'HydraFacial 14-in-1 (Mechanical Pump + Metal Body)','hydrafacial-14-in-1-mechanical-pump-metal-body',264568.00,NULL,13,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:56','2026-05-14 19:55:18'),(19,2,NULL,'HydraFacial 17-in-1 (Mechanical Pump + Metal Body + PDT Light)','hydrafacial-17-in-1-mechanical-pump-metal-body-pdt-light',219270.00,NULL,11,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:56','2026-05-14 19:55:18'),(20,2,NULL,'Alice Water Bubble','alice-water-bubble',153204.00,NULL,2,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:56','2026-05-14 19:55:18'),(21,2,NULL,'Alice Water Bubble Max','alice-water-bubble-max',285472.00,NULL,13,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:56','2026-05-14 19:55:18'),(22,2,NULL,'Hydrafacial New Face Oxygeno 10in1','hydrafacial-new-face-oxygeno-10in1',354828.00,NULL,5,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:56','2026-05-14 19:55:18'),(23,2,NULL,'HydraFacial 15-in-1 with Skin Analyser','hydrafacial-15-in-1-with-skin-analyser',265973.00,NULL,15,NULL,NULL,NULL,NULL,'active',NULL,NULL,'2026-05-14 18:59:56','2026-05-14 19:55:18'),(24,12,NULL,'ami eyes','ami-eyes',20000.00,18000.00,100,'ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo','ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo ajfaiof afonafo','products/7e1fdfb3-3c32-4d66-b68a-6d18b72d354e.webp','[\"products/08b56c46-7b03-4e76-938e-a7d3bf10600d.webp\", \"products/052e29fc-3515-44f2-b88a-82d442c19204.webp\", \"products/88422384-4b65-4caa-ab69-893b3e45b878.webp\"]','active','ami eyes','ami eyes','2026-05-15 05:37:46','2026-05-18 06:20:24');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `reviewer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reviewer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` tinyint NOT NULL DEFAULT '5',
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('olCW176qrE2JJbYUa9XlUT42PsO96TpHQioPwQu6',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJrZFNFYk9iNGIycndhY1FGUElrMHFqSnprM1U5cHlrcEU4V3RTWXZsIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pbiIsInJvdXRlIjoiYWRtaW4uZGFzaGJvYXJkIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwidXJsIjpbXSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjJ9',1779098031),('UUoNlDxXW9ZKJVMxzzWyy3mSPDz7zEzinxS2m9tf',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI0Q0FoMVlhR1pnam1WS1BBUVI5Q3VFMVQ5TjJTR2FISmNlUkVIRDB6IiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hZG1pblwvY2F0ZWdvcmllcyIsInJvdXRlIjoiYWRtaW4uY2F0ZWdvcmllcy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoyfQ==',1779103410),('Yp2YvI1ieKWb6WDxNYIyBYKGmu3bXPOpWgESEO3y',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJtb2l2TXloQXJ6eHVrd0NVNVF5VHRiSFFmU3lyQjlKYWs3NGxlVGREIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9wcm9kdWN0c1wvc29wcmFuby10aXRhbml1bS0xNjAwdy0zaW4xLWRpb2RlaXBscGljbyIsInJvdXRlIjoicHJvZHVjdHMuc2hvdyJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sInVybCI6W10sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoyfQ==',1779103599);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'site_name','Lahore Aesthetics','2026-05-14 18:59:56','2026-05-14 19:22:21'),(2,'site_tagline','Professional Aesthetic Products & Machines','2026-05-14 18:59:56','2026-05-14 19:22:21'),(3,'contact_email','info@lahoreaestheticstraders.com','2026-05-14 18:59:56','2026-05-14 19:22:21'),(4,'contact_phone','+92 300 1234567','2026-05-14 18:59:56','2026-05-14 18:59:56'),(5,'whatsapp_number','923001234567','2026-05-14 18:59:56','2026-05-14 18:59:56'),(6,'address','Lahore, Pakistan','2026-05-14 18:59:56','2026-05-14 18:59:56'),(7,'facebook_url','','2026-05-14 18:59:56','2026-05-14 18:59:56'),(8,'instagram_url','','2026-05-14 18:59:56','2026-05-14 18:59:56'),(9,'tiktok_url','','2026-05-14 18:59:56','2026-05-14 18:59:56');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@makeupwaly.pk',NULL,'$2y$12$YUj2FtqrTlgRj4B/ZBEWT.ZS/S5eFg8KqaJjraDNQIrMtWHYTzxG6','admin',NULL,'2026-05-14 18:59:55','2026-05-14 19:40:01'),(2,'Admin','admin@lahoreaestheticstraders.com',NULL,'$2y$12$790tvwRzu6aRILiqj0x22u4ePvyqWpYA7kE.JHXng/cZLdX28txWy','admin',NULL,'2026-05-14 19:55:18','2026-05-14 19:55:18');
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

-- Dump completed on 2026-05-18 17:19:03
