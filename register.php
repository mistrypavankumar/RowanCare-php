<?php
session_start();
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
    require_once "components/navbar.php";
    stickyNavbar()
        ?>

    <?php

    // Check if register value is set in session, if not, set to 'patient' as default
    if (!isset($_SESSION['register'])) {
        $_SESSION['register'] = 'patient';
    }

    // Check if user has clicked the switch link to change register type
    if (isset($_GET['register'])) {
        $_SESSION['register'] = ($_GET['register'] == 'patient') ? 'patient' : 'doctor';
    }

    $register = $_SESSION['register'];
    $inputStyle = "border-2 p-3 rounded-md outline-none";
    ?>

    <?php

    $errorMessage = "";
    $successMessage = "";
    //  Handling registeration
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $phoneNumber = $_POST["phoneNumber"];
        $password = $_POST["password"];
        $confirmPassword = $_POST['confirmPassword'];

        if (!empty($name) && !empty($phoneNumber) && !empty($password) && !empty($confirmPassword)) {
            if ($password != $confirmPassword) {
                $errorMessage = "X Password doesn't match!! X ";
            } else {
                // echo $errorMessage;
                // echo $name;
                // echo $phoneNumber;
                // echo $password;
                $successMessage = "Registered Successfully :) Login Now";
            }


        } else {
            $errorMessage = "X Please fill all the fields X";
        }


    }

    ?>

    <div class="h-screen flex items-center w-[85%] mx-auto mt-5">
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
                <input class="<?php echo $inputStyle ?>" type="text"
                    placeholder="<?php echo ($register == 'patient') ? 'Patient' : 'Doctor'; ?> Full Name" name="name">
                <input class="<?php echo $inputStyle ?>" type="number" placeholder="Mobile Number" name="phoneNumber">
                <input class="<?php echo $inputStyle ?>" type="password" placeholder="Create Password" name="password">
                <input class="<?php echo $inputStyle ?>" type="password" placeholder="Confirm Password"
                    name="confirmPassword">

                <a class="w-full flex justify-end font-semibold text-[#0D57E3]" href="login.php">Already have an
                    account?</a>
                <button class="font-semibold mt-3 bg-[#0D57E3] text-white p-3 rounded-md">Sign Up</button>
            </form>
        </div>
    </div>

</body>

</html>