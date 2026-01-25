-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: localhost    Database: db_erronka2
-- ------------------------------------------------------
-- Server version	9.4.0

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
-- Table structure for table `produktuak`
--

DROP TABLE IF EXISTS `produktuak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produktuak` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mota` varchar(45) NOT NULL,
  `izena` varchar(100) NOT NULL,
  `prezioa` decimal(10,2) unsigned NOT NULL,
  `stock` int unsigned NOT NULL,
  `argazkia` varchar(100) NOT NULL,
  `hornitzaile_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hornitzaile_idDB_idx` (`hornitzaile_id`),
  CONSTRAINT `hornitzaile_idDB` FOREIGN KEY (`hornitzaile_id`) REFERENCES `hornitzaileak` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produktuak`
--

LOCK TABLES `produktuak` WRITE;
/*!40000 ALTER TABLE `produktuak` DISABLE KEYS */;
INSERT INTO `produktuak` VALUES (1,'Ordenagailua','Acer Aspire 5',549.99,12,'AcerAspire5.jpg',4),(2,'Tablet','Apple iPad mini 6',649.00,8,'Apple iPad mini 6.jpg',1),(3,'Ordenagailua','Apple MacBook Air',1199.00,5,'Apple Macbook Air.jpg',5),(4,'Tablet','Apple iPad 10.2',389.00,10,'AppleiPad10.2.jpg',6),(5,'Telefonoa','iPhone 14 Pro',1299.00,7,'iphone14pro.jpg',10),(6,'Ordenagailua','Lenovo ThinkPad T14 Gen 2',999.00,6,'Lenovo ThinkPad T14 Gen 2.jpg',7),(7,'Ordenagailua','HP EliteBook 840 G7',1100.00,4,'HP EliteBook 840 G7.jpg',7),(8,'Telefonoa','Samsung Galaxy S21',499.00,15,'Samsung Galaxy S21.jpg',8),(9,'Telefonoa','Samsung Galaxy S23 Ultra',1199.00,9,'Samsung Galaxy S23 Ultra.jpg',9),(10,'Tablet','Samsung Galaxy Tab S9',849.00,5,'Samsung Galaxy Tab S9.jpg',6),(11,'Telefonoa','Google Pixel 8 Pro',999.00,6,'Google Pixel 8 Pro.jpg',3),(12,'Ordenagailua','Microsoft Surface Pro 9',1350.00,3,'Microsoft Surface Pro 9.jpg',4);
/*!40000 ALTER TABLE `produktuak` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-24 11:40:42
