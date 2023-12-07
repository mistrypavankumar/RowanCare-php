<?php

include '../db_connection.php';

function executeDelete($conn, $sql = "", $params = null)
{
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false;
    }

    $stmt->bind_param(...$params);
    $stmt->execute();
    return true;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    echo $_POST['doctorId'];

    if ($_POST['action'] == "delete-doctor-account") {
        $doctorId = $_POST['doctorId'];
        executeDelete(conn: $conn, sql: "DELETE FROM registration WHERE userId = ?", params: ['i', $doctorId]);
        executeDelete(conn: $conn, sql: "DELETE FROM doctor WHERE doctorId = ?", params: ['i', $doctorId]);
        executeDelete(conn: $conn, sql: "DELETE FROM doctor_image_path WHERE doctorId = ?", params: ['i', $doctorId]);
        executeDelete(conn: $conn, sql: "DELETE FROM doctor_address WHERE doctorId = ?", params: ['i', $doctorId]);
        executeDelete(conn: $conn, sql: "DELETE FROM doctor_specialization WHERE doctorId = ?", params: ['i', $doctorId]);

        header('location: ../logout.php');
    }

    if ($_POST['action'] == "delete-patient-account") {
        $patientid = $_POST['patientid'];
        $res = executeDelete(conn: $conn, sql: "DELETE FROM registration WHERE userId = ?", params: ['i', $patientid]);
        header('location: logout.php');
    }
}
