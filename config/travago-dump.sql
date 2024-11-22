-- MySQL dump 10.13  Distrib 8.3.0, for Linux (x86_64)
--
-- Host: localhost    Database: travago
-- ------------------------------------------------------
-- Server version	8.3.0

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
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `companies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'TravaGo','contact@TravaGo.com','+1234567890','123 Main Street, City, Country','2024-03-31 19:19:42'),(2,'ExploreMore','contact@exploremore.com','+9876543210','456 Elm Street, Town, Country','2024-03-31 19:19:42'),(3,'TUI Travel',NULL,NULL,NULL,'2024-03-31 20:23:06');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tours`
--

DROP TABLE IF EXISTS `tours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tours` (
  `id` int NOT NULL AUTO_INCREMENT,
  `program` varchar(255) NOT NULL,
  `desciption` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `number_of_seats` int NOT NULL,
  `departure_date` date NOT NULL,
  `arrival_date` date NOT NULL,
  `accomodation` varchar(255) NOT NULL,
  `transport_type` varchar(255) NOT NULL,
  `price` int NOT NULL,
  `company_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tours`
--

LOCK TABLES `tours` WRITE;
/*!40000 ALTER TABLE `tours` DISABLE KEYS */;
INSERT INTO `tours` VALUES (1,'European Adventure','Explore the best of Europe!','London, Paris, Rome',20,'2024-06-01','2024-06-15','Luxury Hotels','Bus',2000,1),(2,'Asian Expedition','Discover the wonders of Asia!','Tokyo, Beijing, Bangkok',15,'2024-07-01','2024-07-15','Resorts','Plane',2500,2);
/*!40000 ALTER TABLE `tours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trips`
--

DROP TABLE IF EXISTS `trips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trips` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Destination` varchar(255) NOT NULL,
  `Flight_number` int NOT NULL,
  `Number_of_seats` int NOT NULL,
  `Plan` varchar(255) NOT NULL,
  `Departure_date` date NOT NULL,
  `Arrival_date` date NOT NULL,
  `Hotel` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `company_id` int NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `company_id` (`company_id`),
  CONSTRAINT `trips_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trips`
--

LOCK TABLES `trips` WRITE;
/*!40000 ALTER TABLE `trips` DISABLE KEYS */;
INSERT INTO `trips` VALUES (1,'Paris',12345,50,'Full Board','2024-04-15','2024-04-20','Paris Hotel','2024-03-31 19:20:08',1),(2,'Tokyo',54321,40,'Half Board','2024-05-10','2024-05-15','Tokyo Inn','2024-03-31 19:20:08',2);
/*!40000 ALTER TABLE `trips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `isVerified` tinyint(1) DEFAULT '0',
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_type` enum('admin','user','agency') NOT NULL DEFAULT 'user',
  `company_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `company_id` (`company_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Hamma Terbah','hamma@travago.com','$2y$10$DK6IcqV93Jrf/ezUZTaLGeZdvrqUPxXZnFu/tlBn1gbFrOJozKXH2',0,'789 Oak Avenue, City, Country','+1122334455','2024-03-31 19:19:59','admin',1),(2,'Elyes','elyes@travago.com','password123',0,'789 Oak Avenue, City, Country','+1122334455','2024-03-31 19:19:59','admin',1),(3,'Nermine','nermine@travago.com','password123',0,'789 Oak Avenue, City, Country','+1122334455','2024-03-31 19:19:59','admin',1),(4,'Mariem','mariem@travago.com','password123',0,'789 Oak Avenue, City, Country','+1122334455','2024-03-31 19:19:59','admin',1),(5,'jane_smith','jane@exploremore.com','pass456',0,'567 Pine Street, Town, Country','+9988776655','2024-03-31 19:19:59','user',2),(6,'john_smith','john@exploremore.com','pass456',0,'567 Pine Street, Town, Country','+9988776655','2024-03-31 19:19:59','user',2),(7,'hamadi','hamadi@gmail.com','$2y$12$nLAqTm5.B3PpYuVTUNfeM.w4MOsQleFEiCUhaZkKizHDlKwc0b4mK',0,NULL,'12345','2024-03-31 20:11:11','user',1),(8,'Tui Admin','travel@tui.com','$2y$12$.JJUBCm2wqfPi0VwI2jBQe7TwYTJzCB6GK9plDb0eLlyL9AFJknUO',0,NULL,'123','2024-03-31 20:23:06','agency',3),(9,'Nesrine','nesrine@travago.com','password123',0,'789 Oak Avenue, City, Country','+1122334455','2024-03-31 20:38:53','admin',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `number_of_seats` int NOT NULL,
  `plate_number` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `company_id` int DEFAULT NULL,
  `availablabity` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicles`
--

LOCK TABLES `vehicles` WRITE;
/*!40000 ALTER TABLE `vehicles` DISABLE KEYS */;
INSERT INTO `vehicles` VALUES (1,'Toyota','Camry',5,'ABC123','2024-03-31 19:20:18',1,1),(2,'Ford','Explorer',7,'XYZ789','2024-03-31 19:20:18',2,1);
/*!40000 ALTER TABLE `vehicles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-31 20:39:44
