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
        header("Location: login.php");

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



?>