<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Login";
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

    $errorMessage = "";

    //  Handling login
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $phoneNumber = $_POST["phoneNumber"];
        $password = $_POST["password"];

        if (!empty($phoneNumber) && !empty($password)) {
            $errorMessage = "Sorry! But still in under process...";
        } else {
            $errorMessage = "X Please fill all the fields X";
        }
    }

    ?>

    <div class="h-screen flex items-center w-[85%] mx-auto mt-5">
        <div class="hidden md:block w-[70%]">
            <img src="./assets/images/loginImg.png" alt="reg-img">
        </div>
        <div class="bg-white w-full md:w-1/2 px-5 md:px-7 pt-5 pb-7 border-2 rounded-md">

            <?php
            if (!empty($errorMessage)) {
                ?>

                <p class="bg-red-500/20 p-2 rounded-md text-center text-red-500 font-semibold">
                    <?php echo $errorMessage; ?>
                </p>
            <?php }
            ?>

            <div class="flex w-full justify-between py-5">
                <p class="font-semibold text-xl">Login RowanCare</p>
            </div>

            <?php $inputStyle = "border-2 p-3 rounded-md outline-none" ?>

            <form method="POST" action="login.php" class="flex flex-col gap-3 mt-5">
                <input class="<?php echo $inputStyle ?>" type="number" maxlength="10" pattern="\d{10}"
                    placeholder="Mobile Number" name="phoneNumber">
                <input class="<?php echo $inputStyle ?>" type="password" placeholder="Password" name="password">

                <a class="w-full flex justify-end font-semibold text-[#0D57E3]" href="register.php">Forgot Password?</a>
                <button class="font-semibold mt-3 bg-[#0D57E3] text-white p-3 rounded-md">Login</button>

                <p class="mt-3 text-center font-semibold">Don't have an account? <a class=" text-[#0D57E3]"
                        href="register.php">Register</a></p>
            </form>
        </div>
    </div>

</body>

</html>