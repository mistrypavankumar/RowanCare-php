<?php

$servername = "localhost";
$username = "root";
$password = "7143@Pavan";
$dbname = "hospitaldb";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function execuateSqlQuery($conn, $sql = "", $params = null)
{
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return ["status" => 300, "message" => "Failed to prepare the sql query"];
    }

    if ($params) {
        $stmt->bind_param(...$params);
    }

    if (!$stmt->execute()) {
        return ["status" => 300, "message" => "Failed to execute the query"];
    }

    $result = $stmt->get_result();

    if ($result) {
        return ['status' => 200, "data" => $result->fetch_all(MYSQLI_ASSOC)];
    } else {
        return ["status" => 300, "message" => "Failed to fetch result: " . $stmt->error];
    }
}



function registerUser($conn, $firstName, $lastName, $phoneNumber, $email, $password, $userType)
{
    // validate userType
    if ($userType !== 'patient' && $userType !== "doctor") {
        return false;
    }

    // check if user already exists
    $checkQuery = 'SELECT * FROM registration WHERE email = ? OR phoneNumber = ?';
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $email, $phoneNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return false; // user already exists
    }

    // register user
    $conn->begin_transaction();  // start a transaction

    try {
        $registerQuery = "INSERT INTO registration (firstName, lastName, phoneNumber, email, password, userType) VALUES(?,?,?,?,?,?)";
        $stmt = $conn->prepare($registerQuery);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bind_param("ssssss", $firstName, $lastName, $phoneNumber, $email, $hashedPassword, $userType);
        $stmt->execute();

        // get auto-incremented id
        $userId = $conn->insert_id;

        // insert into patient/doctor table
        $insertQuery = 'INSERT INTO ' . $userType . " (" . $userType . "Id, firstName, lastName, email, phoneNumber) VALUES(?,?,?,?,?)";
        $stmt1 = $conn->prepare($insertQuery);
        $stmt1->bind_param("sssss", $userId, $firstName, $lastName, $email, $phoneNumber);
        $stmt1->execute();

        $conn->commit();  // commit the transaction


        // login the user
        loginUser($conn, $email, $password);
    } catch (Exception $err) {
        $conn->rollback();
        return false;
    }
}

function loginUser($conn, $email, $password)
{
    $checkQuery = "SELECT * FROM registration WHERE email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $cookieValue = $email;
            setcookie("rowanCare" . $user["userType"], $cookieValue, time() + (86400 * 30), "/");

            header("Location: " . $user["userType"] . "-dashboard.php");
            return True;
        } else {
            return False;
        }
    } else {
        return false;
    }
}


function logout()
{
    // Start the session
    session_start();
    ob_start();

    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session.
    session_destroy();

    // If you're using a login cookie, clear it as well
    if (isset($_COOKIE['rowanCarepatient'])) {
        unset($_COOKIE['rowanCarepatient']);
        setcookie('rowanCarepatient', '', time() - 3600, '/');
    } else if (isset($_COOKIE['rowanCaredoctor'])) {
        unset($_COOKIE['rowanCaredoctor']);
        setcookie('rowanCaredoctor', '', time() - 3600, '/');
    }


    // Now you can use header() without errors
    header("Location: login.php");

    ob_end_flush();
    exit;
}




function getUserData($conn, $userIdentifier, $userType)
{
    $sql = 'SELECT * FROM ' . $userType . " where email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userIdentifier);
    $stmt->execute();

    // fetch the data
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
    } else {
        $userData = null;
    }

    return $userData;
}

function getBestSixDoctors($conn)
{
    $sql = "SELECT * FROM doctor limit 6";
    $result = $conn->query($sql);

    if ($result === false) {
        return false;
    }

    if ($result->num_rows > 0) {
        $bestSixDoctors = $result->fetch_all(MYSQLI_ASSOC);
        return $bestSixDoctors;
    } else {
        return array(); // if no doctors found
    }
}

function updatePatientAddress($conn, $userId, $addressData)
{
    // Check if the patient address already exists
    $sql = "SELECT * FROM patient_address WHERE patientId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Update existing address
        $updateSql = "UPDATE patient_address SET city = ?, state = ?, country = ?, address = ?, zipcode = ? WHERE patientId = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param('sssssi', $addressData['city'], $addressData['state'], $addressData['country'], $addressData['address'], $addressData['zipcode'], $userId);
    } else {
        // Insert new address record
        $insertSql = "INSERT INTO patient_address (city, state, country, address, zipcode, patientId) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param('sssssi', $addressData['city'], $addressData['state'], $addressData['country'], $addressData['address'], $addressData['zipcode'], $userId);
    }

    // Execute the query and return the result
    return $stmt->execute();
}

function updateDoctorAddress($conn, $userId, $addressData)
{
    // Check if the doctor address already exists
    $sql = "SELECT * FROM doctor_address WHERE doctorId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Update existing address
        $updateSql = "UPDATE doctor_address SET city = ?, state = ?, country = ?, addressLine1 = ?, addressLine2 = ?, zipcode = ? WHERE doctorId = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param('ssssssi', $addressData['city'], $addressData['state'], $addressData['country'], $addressData['addressLine1'], $addressData['addressLine2'], $addressData['zipcode'], $userId);
    } else {
        // Insert new address record
        $insertSql = "INSERT INTO doctor_address (city, state, country, addressLine1, addressLine2, zipcode, doctorId) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param('ssssssi', $addressData['city'], $addressData['state'], $addressData['country'], $addressData['addressLine1'], $addressData['addressLine2'], $addressData['zipcode'], $userId);
    }

    // Execute the query and return the result
    return $stmt->execute();
}



function insertUpdateSpecialization($conn, $data, $doctorId)
{
    $checkQuery = "SELECT * FROM doctor_specialization where doctorId = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("i", $doctorId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $update = "";
    } else {
        $insert = "INSERT INTO doctor_specialization(specialization, doctorId, consultingFee) VALUES(?,?,?)";
        $stmt = $conn->prepare($insert);
        $stmt->bind_param('sii', $data['specialization'], $doctorId, $data['consultingFee']);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}


function getAddress($conn, $userId, $userType)
{
    $sql = "SELECT * FROM $userType" . "_address" . " where $userType" . "Id" . " = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return $result;
    }

    return [];
}



function updatePatientProfile($conn, $userData, $patientData)
{
    $sql = "UPDATE patient SET firstName = ?, lastName = ?, dateOfBirth = ?, bloodGroup = ?, gender = ? WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssss", $patientData['firstName'], $patientData['lastName'], $patientData['dateOfBirth'], $patientData['bloodGroup'], $patientData['gender'], $userData['email']);
        $stmt->execute();
        $stmt->close();

        return updatePatientAddress($conn, $userData['patientId'], $patientData);
    }
    return false;
}

function updateDoctorProfile($conn, $userData, $doctorData)
{
    $sql = "UPDATE doctor SET firstName = ?, lastName = ?, dateOfBirth = ?, gender = ? WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss",  $doctorData['firstName'], $doctorData['lastName'], $doctorData['dateOfBirth'], $doctorData['gender'], $userData['email']);
        $stmt->execute();
        $stmt->close();
        return updateDoctorAddress($conn, $userData['doctorId'], $doctorData);
    }
    return false;
}

function getFeeRange($conn, $doctorId)
{
    $sql = 'SELECT * FROM feerange WHERE doctorId = ?';
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return [];
    }

    $stmt->bind_param('i', $doctorId);

    if (!$stmt->execute()) {
        return [];
    }

    $result = $stmt->get_result();

    $feerange = $result->fetch_assoc();

    $stmt->close();

    return $feerange;
}


function getAllSpecializations($conn)
{
    $sql = "SELECT * from view_specialization";
    $result = $conn->query($sql);

    if ($result === false) {
        return false;
    }

    $specializations = $result->fetch_all(MYSQLI_ASSOC);
    return $specializations;
}

function getAllDoctors($conn)
{
    $sql = "SELECT * from view_doctor";
    $result = $conn->query($sql);

    if ($result === false) {
        return false;
    }

    if ($result->num_rows > 0) {
        $allDoctors = $result->fetch_all(MYSQLI_ASSOC);
        return $allDoctors;
    } else {
        return array(); // if no doctors found
    }
}

function getDoctorDetailsById($conn, $doctorId)
{
    $sql = 'SELECT * FROM doctor WHERE doctorId = ?';
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return [];
    }

    $stmt->bind_param('i', $doctorId);

    if (!$stmt->execute()) {
        return [];
    }

    $result = $stmt->get_result();
    $details = $result->fetch_assoc();
    $stmt->close();

    return $details;
}

function removeProfile($conn, $userType, $userId)
{
    $sql = "Delete FROM " . $userType . "_image_path WHERE " . $userType . "Id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param('i', $userId);

    if (!$stmt->execute()) {
        return false;
    }

    $stmt->close();
    return true;
}


function addProfileImage($conn, $userId, $image_path, $userType)
{
    $checkQuery = "SELECT * from $userType" . "_image_path WHERE $userType" . "Id = ?";
    $checkStmt = $conn->prepare($checkQuery);

    if (!$checkStmt) {
        return false;
    }


    $checkStmt->bind_param("s", $userId);
    $checkStmt->execute();
    $results = $checkStmt->get_result();

    if ($results->num_rows > 0) {
        $sql = "UPDATE $userType" . "_image_path" . " SET imagePath = ? where $userType" . "Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $image_path, $userId);
        $result = $stmt->execute();
        return $result;
    } else {
        $query = "INSERT INTO $userType" . "_image_path (imagePath, $userType" . "Id" . ")" . " VALUES(?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $image_path, $userId);
        $result = $stmt->execute();
        return $result;
    }
}

function getProfileImage($conn, $userId, $userType)
{
    $sql = "SELECT imagePath from $userType" . "_image_path" . " where $userType" . "Id" . " = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $results = $stmt->get_result()->fetch_assoc();

    return $results;
}

function getDoctorSpecialization($conn, $doctorId)
{
    $sql = "SELECT * FROM doctor_specialization WHERE doctorId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $doctorId);
    $stmt->execute();
    $results = $stmt->get_result()->fetch_assoc();
    return $results ?? [];
}

function bookAppointment($conn, $data)
{

    $patientType = "New Patient";

    $isOldPatient = $conn->prepare('SELECT * FROM appointment WHERE patientId = ?');
    $isOldPatient->bind_param('i', $data["patientId"]);
    $isOldPatient->execute();
    $res = $isOldPatient->get_result();

    if ($res->num_rows > 0) {
        $patientType = "Old Patient";
    }

    $sql = "INSERT INTO appointment(patientId, doctorId, appointmentDate, appointmentTime, bookingDate, amount, orderId, patientType) VALUES(?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        error_log('Error in preparing statement: ' . $conn->error);
        return false;
    }

    $stmt->bind_param('iisssdss', $data['patientId'], $data['doctorId'], $data['appointmentDate'], $data['appointmentTime'], $data['bookingDate'], $data['amount'], $data['orderId'], $patientType);

    if ($stmt->execute() === false) {
        error_log('Error in executing statement: ' . $stmt->error);
        return false;
    }

    $stmt->close();

    return true;
}


function genereateInvoice()
{
}


function getPatientAllAppointments($conn, $patientId)
{
    $sql = "CALL getAppointmentsWithDoctorInfo($patientId)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        return array();
    }

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $allAppointments = $result->fetch_all(MYSQLI_ASSOC);
        return $allAppointments;
    } else {
        return array();
    }
}


function getProgressData($conn, $doctorId)
{
    $res = [];

    // Function to handle SQL queries
    function executeQuery($conn, $sql, $params = null)
    {
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            return null;
        }

        if ($params) {
            $stmt->bind_param(...$params);
        }

        if (!$stmt->execute()) {
            return null;
        }

        return $stmt->get_result()->fetch_assoc();
    }

    $result = executeQuery($conn, "SELECT getTotalPatients() as totalPatients");
    if ($result !== null) {
        $res['totalPatients'] = $result['totalPatients'];
    }

    $result = executeQuery($conn, "SELECT getTotalTodaysPatients() as todaysPatients");
    if ($result !== null) {
        $res['todaysPatients'] = $result['todaysPatients'];
    }

    $result = executeQuery($conn, "SELECT COUNT(patientId) as totalAppointments FROM appointment WHERE doctorId = ?", ['i', $doctorId]);
    if ($result !== null) {
        $res['totalAppointments'] = $result['totalAppointments'];
    }

    return $res;
}


function getAppointmentByOrderId($conn, $orderId)
{
    $sql = 'SELECT * FROM appointment WHERE orderId = "' . $orderId . '"';
    $result = $conn->query($sql)->fetch_assoc();
    return $result;
}

function getAppointmentByDoctorId($conn, $doctorId)
{
    $sql = "CALL getAppointmentsByDoctorId($doctorId)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        return array();
    }

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $allAppointments = $result->fetch_all(MYSQLI_ASSOC);
        return $allAppointments;
    } else {
        return array();
    }
}


function getDoctorsPatientData($conn, $doctorId)
{
    $res = execuateSqlQuery(conn: $conn, sql: "CALL getDoctorsPatientData($doctorId)");

    if ($res['status'] == 300) {
        return [];
    } else {
        return $res['data'];
    }
}

function getInvoicesById($conn, $userId, $userType)
{
    $res = execuateSqlQuery(conn: $conn, sql: "SELECT * FROM invoice WHERE " . $userType . "Id = ? ORDER BY invoiceId DESC", params: ['i', $userId]);
    if ($res['status'] == 300) {
        return [];
    } else {
        return $res['data'];
    }
}

function getUserDataByUserId($conn, $userId, $userType)
{
    $res = execuateSqlQuery(conn: $conn, sql: "SELECT * FROM " . $userType . " WHERE " . $userType . "Id = ?", params: ['i', $userId]);
    if ($res['status'] == 300) {
        return [];
    } else {
        return $res['data'];
    }
}


function changePassword($conn, $email, $oldPassword, $newPassword)
{
    // Check if the old password is correct
    $checkQuery = "SELECT password FROM registration WHERE email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return false; // User not found
    }

    $user = $result->fetch_assoc();
    if (!password_verify($oldPassword, $user['password'])) {
        return false; // Old password is incorrect
    }

    // Update the password
    $conn->begin_transaction();
    try {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $updateQuery = "UPDATE registration SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ss", $hashedPassword, $email);
        $stmt->execute();

        $conn->commit();
        return true; // Password successfully updated
    } catch (Exception $err) {
        $conn->rollback();
        return false; // Error occurred
    }
}
