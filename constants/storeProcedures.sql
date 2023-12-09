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
	SELECT *
	FROM patient p
	LEFT JOIN appointment a ON p.patientId = a.patientId AND a.doctorId = doctorId;
END $$
DELIMITER ;