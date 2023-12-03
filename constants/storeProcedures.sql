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
