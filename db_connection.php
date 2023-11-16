<?php
$servername = "localhost";
$username = "root";
$password = "7143@Pavan";
$dbname = "mistry64";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function createPatientTable($conn)
{
    $sql = 'CREATE TABLE if not exists patient(
        patientId INT(6) AUTO_INCREMENT PRIMARY KEY,
        firstName VARCHAR(225) NOT NULL,
        lastName VARCHAR(225) NOT NULL,
        email VARCHAR(225) NOT NULL,
        password VARCHAR(225) NOT NULL,
        phoneNumber VARCHAR(20) NOT NULL,
        address VARCHAR(225),
        dateOfBirth DATE,
        gender VARCHAR(20),
        bloodGroup VARCHAR(20),
        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )';

    $result = $conn->query($sql);

    if ($result == True) {
        echo "<script>alert('patient table is successfully created')</script>";
    } else {
        echo "<script>alert('Error in creating patient table')</script>";
    }
}

// createPatientTable($conn);

function createDoctorTable($conn)
{
    $sql = 'CREATE TABLE if not exists doctor(
        doctorId INT(6) AUTO_INCREMENT PRIMARY KEY,
        firstName VARCHAR(225) NOT NULL,
        lastName VARCHAR(225) NOT NULL,
        email VARCHAR(225) NOT NULL,
        password VARCHAR(225) NOT NULL,
        phoneNumber VARCHAR(20) NOT NULL,
        address VARCHAR(225),
        dateOfBirth DATE,
        gender VARCHAR(20),
        specializationId VARCHAR(225),
        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )';

    $result = $conn->query($sql);

    if ($result == True) {
        echo "<script>alert('patient table is successfully created')</script>";
    } else {
        echo "<script>alert('Error in creating patient table')</script>";
    }
}

// createDoctorTable($conn);


function registerUser($conn, $firstName, $lastName, $phoneNumber, $email, $password)
{
    // Check if the user already exists
    $checkQuery = "SELECT * FROM patient WHERE email = ? OR phoneNumber = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $email, $phoneNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User already exists
        return false;
    } else {
        // Insert new user
        $insertQuery = "INSERT INTO patient (firstName, lastName, phoneNumber, email, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bind_param("sssss", $firstName, $lastName, $phoneNumber, $email, $hashedPassword);

        if ($stmt->execute()) {
            // Registration successful
            header("Location: login.php");
            return true;
        } else {
            // Registration failed
            return false;
        }
    }
}


function loginUser($conn, $email, $password)
{
    $checkQuery = "SELECT * FROM patient WHERE email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $cookieValue = $email;
            setcookie("userLogin", $cookieValue, time() + (86400 * 30), "/");

            header("Location: patient/dashboard.php");
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
    if (isset($_COOKIE['userLogin'])) {
        unset($_COOKIE['userLogin']);
        setcookie('userLogin', '', time() - 3600, '/');
    }


    // Now you can use header() without errors
    header("Location: login.php");

    ob_end_flush();
    exit;
}



?>