/* store procedures */
DELIMITER $$
CREATE PROCEDURE `getAppointmentsWithDoctorInfo`(IN patientID INT)
BEGIN
    SELECT a.appointmentId, a.patientId, a.appointmentDate, a.appointmentTime, 
           a.bookingDate, a.amount, a.status, a.orderId, a.doctorId, 
           d.firstName, d.lastName, ds.specializationId, ds.specialization,img.imagePath
    FROM appointment a
    JOIN doctor d ON d.doctorId = a.doctorId
    JOIN doctor_specialization ds ON ds.doctorId = a.doctorId
    JOIN doctor_image_path img ON img.doctorId = a.doctorId
    WHERE a.patientId = patientId
    ORDER BY a.bookingDate DESC;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE `getAppointmentsByDoctorId`(IN doctorId INT)
BEGIN
    SELECT 
    (SELECT COUNT(*) FROM appointment WHERE doctorId = doctorId) as totalAppointment,
    a.appointmentId, a.patientId, a.appointmentDate, a.appointmentTime, 
    a.bookingDate, a.amount, a.status, a.orderId, a.doctorId, 
    p.firstName, p.lastName, img.imagePath
    FROM 
        appointment a
    LEFT JOIN 
        patient p ON p.patientId = a.patientid
    LEFT JOIN 
        patient_image_path img ON img.patientId = a.patientId
    WHERE 
        a.doctorId = doctorId
    ORDER BY 
        a.bookingDate DESC;
    
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE getDoctorsPatientData(IN doctorId INT)
BEGIN
	SELECT DISTINCT p.*
	FROM patient p
	JOIN appointment a ON p.patientId = a.patientId AND a.doctorId = doctorId ORDER BY p.patientId DESC;
END $$
DELIMITER ;


DELIMITER $$

CREATE PROCEDURE GetMaleDoctorsOrSpecialization(IN genderList VARCHAR(255), IN specializationList VARCHAR(255))
BEGIN
    SET @genderQuery = IF(genderList = '', '', CONCAT('d.gender IN (', genderList, ')'));
    SET @specializationQuery = IF(specializationList = '', '', CONCAT('ds.specialization IN (', specializationList, ')'));
    SET @andClause = IF(@genderQuery != '' AND @specializationQuery != '', ' AND ', '');

    SET @baseQuery = 'SELECT d.* FROM doctor d JOIN doctor_specialization ds ON ds.doctorId = d.doctorId';
    SET @whereClause = IF(@genderQuery = '' AND @specializationQuery = '', '', ' WHERE ');
    SET @query = CONCAT(@baseQuery, @whereClause, @genderQuery, @andClause, @specializationQuery);

    PREPARE stmt FROM @query;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END $$

DELIMITER ;