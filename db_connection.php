<?php
$servername = "localhost";
$username = "root";
$password = "7143@Pavan";
$dbname = "mistry64";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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

function updatePatientProfile($conn, $userData, $patientData)
{
    $sql = "UPDATE patient SET dateOfBirth = ?, address = ?, bloodGroup = ?, city = ?, state = ?, country = ?, gender = ?, zipcode = ?, image_path = ? WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssssssss", $patientData['dateOfBirth'], $patientData['address'], $patientData['bloodGroup'], $patientData['city'], $patientData['state'], $patientData['country'], $patientData['gender'], $patientData['zipcode'], $patientData['image_path'], $userData['email']);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    return false;
}

function updateDoctorProfile($conn, $userData, $doctorData)
{
    $sql = "UPDATE doctor SET dateOfBirth = ?, addressLine1 = ?, addressLine2 = ?, city = ?, state = ?, country = ?, gender = ?, zipcode = ?, image_path = ?, specialization = ? WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssssssss", $doctorData['dateOfBirth'], $doctorData['addressLine1'], $doctorData['addressLine2'], $doctorData['city'], $doctorData['state'], $doctorData['country'], $doctorData['gender'], $doctorData['zipcode'], $doctorData['image_path'], $doctorData['specialization'], $userData['email']);

        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    return false;
}

function insertOrUpdateFeeRange($conn, $doctorId, $minFee, $maxFee)
{
    $select = "SELECT * FROM feerange WHERE doctorId = ?";
    $stmt = $conn->prepare($select);
    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("i", $doctorId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $update = "UPDATE feerange SET minFee = ?, maxFee = ? WHERE doctorId = ?";
        $stmt = $conn->prepare($update);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("iii", $minFee, $maxFee, $doctorId);
    } else {
        $insert = "INSERT INTO feerange (doctorId, minFee, maxFee) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("iii", $doctorId, $minFee, $maxFee);
    }

    if (!$stmt->execute()) {
        return false;
    }

    $stmt->close();
    return true;
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
    $sql = "SELECT * from specialization";
    $result = $conn->query($sql);

    if ($result === false) {
        return false;
    }

    $specializations = $result->fetch_all(MYSQLI_ASSOC);
    return $specializations;
}

function getAllDoctors($conn)
{
    $sql = "SELECT * FROM doctor";
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
