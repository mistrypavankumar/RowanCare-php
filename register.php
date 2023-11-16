<?php
include 'db_connection.php';
session_start();


// Check if register value is set in session, if not, set to 'patient' as default
if (!isset($_SESSION['register'])) {
    $_SESSION['register'] = 'patient';
}

// Check if user has clicked the switch link to change register type
if (isset($_GET['register'])) {
    $_SESSION['register'] = ($_GET['register'] == 'patient') ? 'patient' : 'doctor';
}

$register = $_SESSION['register'];
$inputStyle = "border-2 p-3 rounded-md outline-none w-full";
?>

<?php

$errorMessage = "";
$successMessage = "";
$firstName = $lastName = $email = $phoneNumber = "";
$password = $confirmPassword = "";

//  Handling registeration
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["firstName"] ?? "";
    $lastName = $_POST["lastName"] ?? "";
    $email = $_POST["email"] ?? null;
    $phoneNumber = $_POST["phoneNumber"] ?? "";
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST['confirmPassword'] ?? "";


    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($phoneNumber) && !empty($password) && !empty($confirmPassword)) {
        if ($password != $confirmPassword) {
            $errorMessage = "X Password doen't match X";
        } else {
            if ($register == "patient") {
                $isResgisterSuccess = registerUser($conn, $firstName, $lastName, $phoneNumber, $email, $password);

                if ($isResgisterSuccess) {
                    $successMessage = "Registered Successfully :) Login Now";
                    $firstName = $lastName = $email = $phoneNumber = "";
                    $password = $confirmPassword = "";
                } else {
                    $errorMessage = "User already exists.";
                }
            }
        }

    } else {
        $errorMessage = "X Please fill all the fields X";

    }
}

require_once "components/navbar.php";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Register";
    require_once "components/header.php"
        ?>
</head>

<body>
    <!-- navbar -->
    <?php
    stickyNavbar()
        ?>

    <div class="h-screen flex items-center w-[92%] md:w-[85%] mx-auto mt-5">
        <div class="hidden md:block">
            <img src="./assets/images/regLog.png" alt="reg-img">
        </div>
        <div class="bg-white w-full md:w-1/2 px-7 pt-5 pb-7 border-2 rounded-md">
            <?php
            if (!empty($errorMessage)) {
                ?>

                <p class="bg-red-500/20 p-2 rounded-md text-center text-red-500 font-semibold">
                    <?php echo $errorMessage; ?>
                </p>
            <?php } else if (!empty($successMessage)) {
                ?>
                    <p class="bg-green-500/20 p-2 rounded-md text-center text-green-500 font-semibold">
                    <?php echo $successMessage; ?>
                    </p>
            <?php } ?>


            <div class="flex w-full justify-between py-5">
                <p class="font-semibold text-xl">
                    <?php echo ucfirst($register); ?> Register
                </p>
                <a href="?register=<?php echo ($register == 'patient') ? 'doctor' : 'patient'; ?>"
                    class="font-semibold text-[#0D57E3] cursor-pointer">
                    Are you a
                    <?php echo ($register == 'patient') ? 'Doctor' : 'Patient'; ?>?
                </a>
            </div>

            <form method="POST" action="register.php" class="flex flex-col gap-3 mt-5">
                <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3 w-full">
                    <input class="<?php echo $inputStyle ?>" type="text"
                        placeholder="<?php echo ($register == 'patient') ? 'Patient' : 'Doctor'; ?> First Name*"
                        name="firstName" value="<?php echo $firstName; ?>">
                    <input class="<?php echo $inputStyle ?>" type="text"
                        placeholder="<?php echo ($register == 'patient') ? 'Patient' : 'Doctor'; ?> Last Name*"
                        name="lastName" value="<?php echo $lastName; ?>">
                </div>
                <input class="<?php echo $inputStyle ?>" type="email" placeholder="Email*" name="email"
                    value="<?php echo $email; ?>">
                <input class="<?php echo $inputStyle ?>" type="number" placeholder="Mobile Number*" name="phoneNumber"
                    value="<?php echo $phoneNumber; ?>">
                <input class="<?php echo $inputStyle ?>" type="password" placeholder="Create Password*" name="password">
                <input class="<?php echo $inputStyle ?>" type="password" placeholder="Confirm Password*"
                    name="confirmPassword">

                <a class="w-full flex justify-end font-semibold text-[#0D57E3]" href="login.php">Already have an
                    account?</a>
                <button
                    class="font-semibold mt-3 bg-[#0D57E3] hover:bg-[#0a43b0] duration-500 text-white p-3 rounded-md">Sign
                    Up</button>
            </form>
        </div>
    </div>

    <!-- footer -->
    <?php
    require_once "components/footer.php";
    footer();
    ?>
</body>

</html>