<?php

include '../db_connection.php';

function executeUpdate($conn, $sql = "", $params = null)
{
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return false;
    }

    $stmt->bind_param(...$params);
    $stmt->execute();
    return true;
}

function message($res, $type)
{
    if ($res) {
        $_SESSION['success_message'] = $type . "ed patient appointment";
    } else {
        $_SESSION['error_message'] = "Failed to $type patient appointment";
    }
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if ($_POST['action'] == 'accept') {
        $res =  executeUpdate(conn: $conn, sql: 'UPDATE appointment SET status = "Confirmed" WHERE orderId = ?', params: ['s', $_POST['appointmentOrderId']]);
        message($res, "Accept");
    } elseif ($_POST['action'] == "cancel") {
        $res = executeUpdate(conn: $conn, sql: 'UPDATE appointment SET status = "Cancelled" WHERE orderId = ?', params: ['s', $_POST['appointmentOrderId']]);
        message($res, "Cancell");
    }

    header('location:../doctor-dashboard.php');
}
