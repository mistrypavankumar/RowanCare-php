-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: hospitaldb
-- ------------------------------------------------------
-- Server version	8.0.34

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
-- Table structure for table `appointment`
--

DROP TABLE IF EXISTS `appointment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointment` (
  `appointmentId` int NOT NULL AUTO_INCREMENT,
  `patientId` int NOT NULL,
  `doctorId` int NOT NULL,
  `appointmentDate` datetime NOT NULL,
  `appointmentTime` varchar(255) NOT NULL,
  `bookingDate` datetime NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `orderId` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`appointmentId`),
  KEY `patientId` (`patientId`),
  KEY `doctorId` (`doctorId`),
  CONSTRAINT `fk_appointment_doctor` FOREIGN KEY (`doctorId`) REFERENCES `doctor` (`doctorId`),
  CONSTRAINT `fk_appointment_patient` FOREIGN KEY (`patientId`) REFERENCES `patient` (`patientId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment`
--

LOCK TABLES `appointment` WRITE;
/*!40000 ALTER TABLE `appointment` DISABLE KEYS */;
INSERT INTO `appointment` VALUES (1,5,6,'2023-12-29 00:00:00','9:00AM','2023-12-01 16:40:00',160.00,'Pending','order_1701445198976_532'),(2,7,6,'2023-12-13 00:00:00','10:00AM','2023-12-01 16:52:26',160.00,'Cancelled','order_1701445944329_670'),(3,7,6,'2023-12-21 00:00:00','11:00AM','2023-12-01 17:28:54',160.00,'Pending','order_1701448132265_984');
/*!40000 ALTER TABLE `appointment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctor`
--

DROP TABLE IF EXISTS `doctor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctor` (
  `doctorId` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(225) NOT NULL,
  `lastName` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`doctorId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor`
--

LOCK TABLES `doctor` WRITE;
/*!40000 ALTER TABLE `doctor` DISABLE KEYS */;
INSERT INTO `doctor` VALUES (6,'Pavan Kumar','Mistry','pavansharma.mg3108@gmail.com','1478523691','2023-12-07','Male');
/*!40000 ALTER TABLE `doctor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctor_address`
--

DROP TABLE IF EXISTS `doctor_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctor_address` (
  `addressId` int NOT NULL AUTO_INCREMENT,
  `city` varchar(225) DEFAULT NULL,
  `state` varchar(225) DEFAULT NULL,
  `country` varchar(225) DEFAULT NULL,
  `addressLine1` varchar(225) DEFAULT NULL,
  `addressLine2` varchar(225) DEFAULT NULL,
  `zipcode` varchar(6) DEFAULT NULL,
  `doctorId` int NOT NULL,
  PRIMARY KEY (`addressId`),
  KEY `doctorId` (`doctorId`),
  CONSTRAINT `doctor_address_ibfk_1` FOREIGN KEY (`doctorId`) REFERENCES `doctor` (`doctorId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor_address`
--

LOCK TABLES `doctor_address` WRITE;
/*!40000 ALTER TABLE `doctor_address` DISABLE KEYS */;
INSERT INTO `doctor_address` VALUES (1,'Pitman, NJ, USA','New Jersey','United States','202, ','Cedar Avenue','008071',6);
/*!40000 ALTER TABLE `doctor_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctor_image_path`
--

DROP TABLE IF EXISTS `doctor_image_path`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctor_image_path` (
  `imageId` int NOT NULL AUTO_INCREMENT,
  `imagePath` varchar(225) DEFAULT NULL,
  `doctorId` int NOT NULL,
  PRIMARY KEY (`imageId`),
  KEY `doctorId` (`doctorId`),
  CONSTRAINT `doctor_image_path_ibfk_1` FOREIGN KEY (`doctorId`) REFERENCES `doctor` (`doctorId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor_image_path`
--

LOCK TABLES `doctor_image_path` WRITE;
/*!40000 ALTER TABLE `doctor_image_path` DISABLE KEYS */;
INSERT INTO `doctor_image_path` VALUES (1,'uploads/doctors/doctor_65698024c86c54.69232471.png',6);
/*!40000 ALTER TABLE `doctor_image_path` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctor_specialization`
--

DROP TABLE IF EXISTS `doctor_specialization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctor_specialization` (
  `specializationId` int NOT NULL AUTO_INCREMENT,
  `specialization` varchar(225) DEFAULT NULL,
  `doctorId` int NOT NULL,
  `consultingFee` int NOT NULL,
  PRIMARY KEY (`specializationId`),
  KEY `doctorId` (`doctorId`),
  CONSTRAINT `doctor_specialization_ibfk_1` FOREIGN KEY (`doctorId`) REFERENCES `doctor` (`doctorId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor_specialization`
--

LOCK TABLES `doctor_specialization` WRITE;
/*!40000 ALTER TABLE `doctor_specialization` DISABLE KEYS */;
INSERT INTO `doctor_specialization` VALUES (1,'Cardiology',6,100);
/*!40000 ALTER TABLE `doctor_specialization` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patient` (
  `patientId` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(225) NOT NULL,
  `lastName` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `bloodGroup` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`patientId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient`
--

LOCK TABLES `patient` WRITE;
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` VALUES (5,'Pavan Kumar','Mistry','pavansharma.m0114si@gmail.com','18565268949','1999-10-31','Male','O+'),(7,'Pinky','Sharma','pinky@gmail.com','1478523695','2023-12-14','Female','O+');
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_address`
--

DROP TABLE IF EXISTS `patient_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patient_address` (
  `addressId` int NOT NULL AUTO_INCREMENT,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `address` varchar(225) DEFAULT NULL,
  `zipcode` varchar(6) DEFAULT NULL,
  `patientId` int NOT NULL,
  PRIMARY KEY (`addressId`),
  KEY `patientId` (`patientId`),
  CONSTRAINT `patient_address_ibfk_1` FOREIGN KEY (`patientId`) REFERENCES `patient` (`patientId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_address`
--

LOCK TABLES `patient_address` WRITE;
/*!40000 ALTER TABLE `patient_address` DISABLE KEYS */;
INSERT INTO `patient_address` VALUES (1,'Pitman, NJ, USA','New Jersey','United States','202, Cedar Avenue','008071',5),(2,'Hyderabad','Telangana','India','Bandlaguda','500001',7);
/*!40000 ALTER TABLE `patient_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_image_path`
--

DROP TABLE IF EXISTS `patient_image_path`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patient_image_path` (
  `imageId` int NOT NULL AUTO_INCREMENT,
  `imagePath` varchar(225) DEFAULT NULL,
  `patientId` int NOT NULL,
  PRIMARY KEY (`imageId`),
  KEY `patientId` (`patientId`),
  CONSTRAINT `patient_image_path_ibfk_1` FOREIGN KEY (`patientId`) REFERENCES `patient` (`patientId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_image_path`
--

LOCK TABLES `patient_image_path` WRITE;
/*!40000 ALTER TABLE `patient_image_path` DISABLE KEYS */;
INSERT INTO `patient_image_path` VALUES (3,'',7);
/*!40000 ALTER TABLE `patient_image_path` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration`
--

DROP TABLE IF EXISTS `registration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registration` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(225) NOT NULL,
  `lastName` varchar(225) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userType` enum('patient','doctor','admin') NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `phoneNumber` (`phoneNumber`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration`
--

LOCK TABLES `registration` WRITE;
/*!40000 ALTER TABLE `registration` DISABLE KEYS */;
INSERT INTO `registration` VALUES (5,'Pavan Kumar','Mistry','18565268949','pavansharma.m0114si@gmail.com','$2y$10$0o7tE4Lh5y4UDxluUM9fze8/QKrVGbfzIyXEhbAIfKj7JHhZsaCpG','patient'),(6,'Pavan Kumar','Mistry','1478523691','pavansharma.mg3108@gmail.com','$2y$10$cX1Ws2Mw.hgZmJ9rO/qxBevZt.ESlKDZFWzyGm.bodezLA3M7HXxW','doctor'),(7,'Pinky','Sharma','1478523695','pinky@gmail.com','$2y$10$Dgvq2AiGqYpvpZrSTR8eI.WMGw/jel/5uD5A/r6bF2gZPv2dumOOi','patient');
/*!40000 ALTER TABLE `registration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specialization`
--

DROP TABLE IF EXISTS `specialization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `specialization` (
  `specializationId` int NOT NULL AUTO_INCREMENT,
  `name` varchar(225) NOT NULL,
  PRIMARY KEY (`specializationId`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specialization`
--

LOCK TABLES `specialization` WRITE;
/*!40000 ALTER TABLE `specialization` DISABLE KEYS */;
INSERT INTO `specialization` VALUES (11,'Cardiology'),(12,'Neurology'),(13,'Pediatrics'),(14,'Orthopedics'),(15,'Dentist');
/*!40000 ALTER TABLE `specialization` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-02 21:38:40
