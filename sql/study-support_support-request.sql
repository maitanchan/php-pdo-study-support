-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: localhost    Database: study-support
-- ------------------------------------------------------
-- Server version	8.1.0
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!50503 SET NAMES utf8 */
;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */
;
/*!40103 SET TIME_ZONE='+00:00' */
;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */
;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */
;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */
;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */
;
--
-- Table structure for table `support-request`
--
DROP TABLE IF EXISTS `support-request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `support-request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nameProject` text NOT NULL,
  `completionTime` text NOT NULL,
  `fee` text NOT NULL,
  `contact` text NOT NULL,
  `schedule` text NOT NULL,
  `studyRequest` text,
  `filePath` varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `handleActor` text,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 67 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `support-request`
--
LOCK TABLES `support-request` WRITE;
/*!40000 ALTER TABLE `support-request` DISABLE KEYS */
;
INSERT INTO `support-request`
VALUES (
    64,
    'dự án 2',
    '2 ngày',
    4534540,
    'liên lạc45',
    'etwqfd',
    'gsfgsdfgs',
    'uploads/Câu-hỏi.docx, uploads/câu-hỏi-đề-tài-phụ.docx',
    '2023-12-05 08:47:36',
    NULL
  ),
(
    65,
    'dự án 2',
    '2 ngày',
    4534540,
    'liên lạc45',
    'etwqfd',
    'gsfgsdfgs',
    'uploads/Câu-hỏi.docx, uploads/câu-hỏi-đề-tài-phụ.docx',
    '2023-12-05 08:47:38',
    NULL
  );
/*!40000 ALTER TABLE `support-request` ENABLE KEYS */
;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */
;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */
;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */
;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */
;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */
;
-- Dump completed on 2023-12-05 16:25:19