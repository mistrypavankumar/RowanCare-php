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
  `patientType` varchar(255) DEFAULT 'New Patient',
  PRIMARY KEY (`appointmentId`),
  KEY `patientId` (`patientId`),
  KEY `doctorId` (`doctorId`),
  CONSTRAINT `fk_appointment_doctor` FOREIGN KEY (`doctorId`) REFERENCES `doctor` (`doctorId`),
  CONSTRAINT `fk_appointment_patient` FOREIGN KEY (`patientId`) REFERENCES `patient` (`patientId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment`
--

LOCK TABLES `appointment` WRITE;
/*!40000 ALTER TABLE `appointment` DISABLE KEYS */;
INSERT INTO `appointment` VALUES (1,13,10,'2023-12-30 00:00:00','10:00AM','2023-12-09 07:29:38',165.00,'Confirmed','order_1702103377219_279','New Patient'),(2,18,10,'2023-12-14 00:00:00','10:00AM','2023-12-09 07:30:18',165.00,'Cancelled','order_1702103417140_329','New Patient');
/*!40000 ALTER TABLE `appointment` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trigger__invoice` AFTER INSERT ON `appointment` FOR EACH ROW BEGIN
	INSERT INTO invoice(orderId, patientId, amount, doctorId)
    VALUES (NEW.orderId, NEW.patientId, NEW.amount, NEW.doctorId);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor`
--

LOCK TABLES `doctor` WRITE;
/*!40000 ALTER TABLE `doctor` DISABLE KEYS */;
INSERT INTO `doctor` VALUES (10,'Pavan Kumar','Mistry','pavansharma.m0114si@gmail.com','18565268949','2023-12-21','Male'),(12,'Avansh','Sharma','avansh@gmail.com','4152365215','1999-11-24','Male'),(15,'Rithvik','Bura','rithvik@gmail.com','5142367891','2024-01-03','Male');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor_address`
--

LOCK TABLES `doctor_address` WRITE;
/*!40000 ALTER TABLE `doctor_address` DISABLE KEYS */;
INSERT INTO `doctor_address` VALUES (2,'Pitman, NJ, USA','New Jersey','United States','202, Cedar Avenue','1','008071',12),(3,'Pitman, NJ, USA','New Jersey','United States','202, Cedar Avenue','1','008071',12),(4,'Pitman, NJ, USA','New Jersey','United States','202, Cedar Avenue','2','008071',10),(6,'TATTIANNARAM','TELANGANA','India','SRI LAXMI GANAPATHI COLONY','Nagole','500068',15);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor_image_path`
--

LOCK TABLES `doctor_image_path` WRITE;
/*!40000 ALTER TABLE `doctor_image_path` DISABLE KEYS */;
INSERT INTO `doctor_image_path` VALUES (2,'uploads/doctors/doctor_65716b5b306646.74658396.png',10),(3,'uploads/doctors/doctor_6572cdeca42f34.86260605.png',12),(5,'',15);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor_specialization`
--

LOCK TABLES `doctor_specialization` WRITE;
/*!40000 ALTER TABLE `doctor_specialization` DISABLE KEYS */;
INSERT INTO `doctor_specialization` VALUES (1,'Cardiology',10,105),(2,'Cardiology',12,152),(4,'Pediatrics',15,120);
/*!40000 ALTER TABLE `doctor_specialization` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoice` (
  `invoiceId` int NOT NULL AUTO_INCREMENT,
  `orderId` varchar(255) NOT NULL,
  `patientId` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paid_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `doctorId` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(255) DEFAULT 'Paid',
  PRIMARY KEY (`invoiceId`),
  KEY `patientId` (`patientId`),
  KEY `doctorId` (`doctorId`),
  CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`patientId`) REFERENCES `patient` (`patientId`),
  CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`doctorId`) REFERENCES `doctor` (`doctorId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice`
--

LOCK TABLES `invoice` WRITE;
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
INSERT INTO `invoice` VALUES (1,'order_1702103377219_279',13,165.00,'2023-12-09 06:29:38',10,'2023-12-09 06:29:38','Paid'),(2,'order_1702103417140_329',18,165.00,'2023-12-09 06:30:18',10,'2023-12-09 06:30:18','Refunded');
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient`
--

LOCK TABLES `patient` WRITE;
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` VALUES (13,'Sai','Teja','sai@gamil.com','5142368741','2002-04-16','Male','A-'),(17,'vaibhav','R','vibhav@gmail.com','14521456987','1997-06-17','Male','B+'),(18,'Pinky','Sharma','pinky@gmail.com','143143143143','1999-04-23','Female','O+');
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_address`
--

LOCK TABLES `patient_address` WRITE;
/*!40000 ALTER TABLE `patient_address` DISABLE KEYS */;
INSERT INTO `patient_address` VALUES (2,'Pitman, NJ, USA','New Jersey','United States','202, Cedar Avenue','008071',17),(3,'Pitman, NJ, USA','New Jersey','United States','202, Cedar Avenue','008071',17),(6,'Pitman, NJ, USA','New Jersey','United States','202, Cedar Avenue','008071',17),(7,'Pitman, NJ, USA','New Jersey','United States','202, Cedar Avenue','008071',17),(8,'Pitman, NJ, USA','New Jersey','United States','202, Cedar Avenue','008071',17),(9,'Pitman, NJ, USA','New Jersey','United States','202, Cedar Avenue','008071',17),(10,'Pitman, NJ, USA','New Jersey','United States','202, Cedar Avenue','008071',13),(11,'Hyderabad','Telangana','India','Bandlaguda','500001',18);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_image_path`
--

LOCK TABLES `patient_image_path` WRITE;
/*!40000 ALTER TABLE `patient_image_path` DISABLE KEYS */;
INSERT INTO `patient_image_path` VALUES (3,'uploads/patients/patient_6572ceb441c1b1.80314936.png',13),(5,'',17),(6,'',18);
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
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `phoneNumber` (`phoneNumber`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration`
--

LOCK TABLES `registration` WRITE;
/*!40000 ALTER TABLE `registration` DISABLE KEYS */;
INSERT INTO `registration` VALUES (10,'Pavan Kumar','Mistry','18565268949','pavansharma.m0114si@gmail.com','$2y$10$kgPxnTvpnWbM5LWPlkb/h.lX84uVkhSbCRrof8Be9WGT.zYCd2BSS','doctor','2023-12-07 06:50:33'),(12,'Avansh','Sharma','4152365215','avansh@gmail.com','$2y$10$7M0xn1dW.fFscHvFeQbwpe6PKguauiQcPofPeEr5scQCQ3JroCjU.','doctor','2023-12-08 08:02:50'),(13,'Sai','Teja','5142368741','sai@gamil.com','$2y$10$ciokunPt0jNTzPXA/wtuQ./opjhpuhkpgD1Sh2Dp2uJ.0Y.CNCvia','patient','2023-12-08 08:06:31'),(15,'Rithvik','Bura','5142367891','rithvik@gmail.com','$2y$10$c7rZA1k8axGL7egdnu56e.C9Q0g0lDsdrJNDhs9hk4lsUP8TA95YS','doctor','2023-12-08 08:16:34'),(17,'vibhav','R','14521456987','vibhav@gmail.com','$2y$10$NCdf8oHD.2oR14CPSH9BBOy0ZEUL8DqbN8oBrWMwGwq6vVyRUIZs.','patient','2023-12-09 02:11:38'),(18,'Pinky','Sharma','143143143143','pinky@gmail.com','$2y$10$NFTL2/I3.kW9yJyrta6ZnecSqDUxX48OnZ0KtNht/nooDLXIRPP42','patient','2023-12-09 03:29:31');
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

-- Dump completed on 2023-12-10 17:38:44
