<?php

include '../db_connection.php';

function executeDelete($conn, $sql, $params)
{
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        error_log("Prepare failed: " . $conn->error);
        return false;
    }

    $stmt->bind_param(...$params);

    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        return false;
    }

    $stmt->close();
    return true;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == "delete-account") {

        $userType = $_POST['userType'] ?? '';

        // Sanitize and validate user inputs
        if (!in_array($userType, ['patient', 'doctor'])) {
            // Handle error - unknown user type
            exit('Invalid user type');
        }

        $userId = $_POST[$userType . "Id"] ?? '';

        if (!is_numeric($userId)) {
            // Handle error - invalid user ID
            exit('Invalid user ID');
        }

        // Begin transaction
        $conn->begin_transaction();

        $deleteSuccess = true;

        // Delete from child tables first
        if ($userType == 'doctor') {
            $deleteSuccess &= executeDelete($conn, "DELETE FROM doctor_specialization WHERE doctorId = ?", ['i', $userId]);
        }

        $deleteSuccess &= executeDelete($conn, "DELETE FROM " . $userType . "_address WHERE " . $userType . "Id = ?", ['i', $userId]);
        $deleteSuccess &= executeDelete($conn, "DELETE FROM " . $userType . "_image_path WHERE " . $userType . "Id = ?", ['i', $userId]);

        // Finally, delete from parent tables
        $deleteSuccess &= executeDelete($conn, "DELETE FROM appointment WHERE patientId = ?", ['i', $userId]);
        $deleteSuccess &= executeDelete($conn, "DELETE FROM " . $userType . " WHERE " . $userType . "Id = ?", ['i', $userId]);
        $deleteSuccess &= executeDelete($conn, "DELETE FROM registration WHERE userId = ?", ['i', $userId]);


        if ($deleteSuccess) {
            $conn->commit();
            header('Location: ../logout.php');
            exit();
        } else {
            // Handle error - deletion failed
            $conn->rollback();
            exit('Error in deletion process');
        }
    }
}
