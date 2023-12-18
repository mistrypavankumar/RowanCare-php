CREATE INDEX idx_orderId ON invoice(orderId);
CREATE INDEX idx_patientId ON invoice(patientId);
CREATE INDEX idx_doctorId ON invoice(doctorId);
CREATE INDEX idx_status ON invoice(status);

CREATE INDEX idx_image_path ON doctor_image_path(imagePath);
