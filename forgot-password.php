<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Forgot Password";
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
        $email = $_POST["email"];

        if (!empty($email)) {
            $errorMessage = "Sorry! But still in under process...";
        } else {
            $errorMessage = "X Please enter your email X";
        }
    }

    ?>

    <div class="h-screen flex items-center w-[92%] md:w-[85%] mx-auto mt-5">
        <div class="hidden md:block w-[70%]">
            <img src="./assets/images/forgotpassword.png" alt="reg-img">
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

            <div class="flex flex-col w-full py-5">
                <p class="font-semibold text-xl">Forgot Password?</p>
                <p class="text-gray-500">Enter your email to get a password reset link</p>
            </div>

            <?php $inputStyle = "border-2 p-3 rounded-md outline-none" ?>

            <form method="POST" action="forgot-password.php" class="flex flex-col gap-3 mt-5">
                <input class="<?php echo $inputStyle ?>" type="email" placeholder="Email" name="email">

                <a class="w-full flex justify-end font-semibold text-[#0D57E3]" href="login.php">Remember your
                    Password?</a>
                <button
                    class="font-semibold mt-3 bg-[#0D57E3] hover:bg-[#0a43b0] duration-500 text-white p-3 rounded-md">Reset
                    Password</button>
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