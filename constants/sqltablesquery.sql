CREATE TABLE `registration` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(225) NOT NULL,
  `lastName` varchar(225) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(255) NOT NULL, -- Adjusted for hashed password storage
  `userType` enum('patient', 'doctor', 'admin') NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `phoneNumber` (`phoneNumber`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `patient_address` (
  `addressId` int NOT NULL AUTO_INCREMENT,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `address` varchar(225) DEFAULT NULL,
  `zipcode` varchar(6) DEFAULT NULL,
  `patientId` int NOT NULL,
  PRIMARY KEY (`addressId`),
  FOREIGN KEY (`patientId`) REFERENCES `patient`(`patientId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `patient_image_path` (
  `imageId` int NOT NULL AUTO_INCREMENT,
  `imagePath` varchar(225) DEFAULT NULL,
  `patientId` int NOT NULL,
  PRIMARY KEY (`imageId`),
  FOREIGN KEY (`patientId`) REFERENCES `patient`(`patientId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `doctor` (
  `doctorId` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(225) NOT NULL,
  `lastName` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`doctorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `doctor_specialization` (
  `specializationId` int NOT NULL AUTO_INCREMENT,
  `specialization` varchar(225) DEFAULT NULL,
  `doctorId` int NOT NULL,
  `consultingFee` int NOT NULL,
  PRIMARY KEY (`specializationId`),
  KEY `doctorId` (`doctorId`),
  CONSTRAINT `doctor_specialization_ibfk_1` FOREIGN KEY (`doctorId`) REFERENCES `doctor` (`doctorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  FOREIGN KEY (`doctorId`) REFERENCES `doctor`(`doctorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `doctor_image_path` (
  `imageId` int NOT NULL AUTO_INCREMENT,
  `imagePath` varchar(225) DEFAULT NULL,
  `doctorId` int NOT NULL,
  PRIMARY KEY (`imageId`),
  FOREIGN KEY (`doctorId`) REFERENCES `doctor`(`doctorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `appointment` (
  `appointmentId` int NOT NULL AUTO_INCREMENT,
  `patientId` int NOT NULL,
  `doctorId` int NOT NULL,
  `appointmentDate` datetime NOT NULL,
  `bookingDate` datetime NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `orderId` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`appointmentId`),
  KEY `patientId` (`patientId`),
  KEY `doctorId` (`doctorId`),
  CONSTRAINT `fk_appointment_doctor` FOREIGN KEY (`doctorId`) REFERENCES `doctor` (`doctorId`),
  CONSTRAINT `fk_appointment_patient` FOREIGN KEY (`patientId`) REFERENCES `patient` (`patientId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/* CREATE TABLE `payment` (
  `paymentId` int NOT NULL AUTO_INCREMENT,
  `appointmentId` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paymentDate` datetime NOT NULL,
  `paymentMethod` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending', -- Assuming 'Pending' is a common initial status
  PRIMARY KEY (`paymentId`),
  KEY `appointmentId` (`appointmentId`),
  CONSTRAINT `fk_payment_appointment` FOREIGN KEY (`appointmentId`) REFERENCES `appointment` (`appointmentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci; */


CREATE TABLE `specialization` (
  `specializationId` int NOT NULL AUTO_INCREMENT,
  `name` varchar(225) NOT NULL,
  PRIMARY KEY (`specializationId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `specialization` (`name`) 
VALUES 
('Cardiology'),
('Neurology'),
('Pediatrics'),
('Orthopedics'),
('Dentist');