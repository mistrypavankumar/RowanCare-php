DELIMITER $$
CREATE TRIGGER trigger__invoice
AFTER INSERT
ON appointment FOR EACH ROW
BEGIN
	INSERT INTO invoice(orderId, patientId, amount, doctorId)
    VALUES (NEW.orderId, NEW.patientId, NEW.amount, NEW.doctorId);
END $$	
DELIMITER ;

