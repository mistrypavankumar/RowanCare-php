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

    <div class="h-screen flex items-center w-[85%] mx-auto mt-5">
        <div class="hidden md:block">
            <img src="./assets/images/regLog.png" alt="reg-img">
        </div>
        <div class="bg-white w-full md:w-1/2 px-7 pt-5 pb-7 border-2 rounded-md">
            <div class="flex w-full justify-between py-5">
                <p class="font-semibold text-xl">Patient Register</p>
                <p class="font-semibold text-[#0D57E3] cursor-pointer">Are you a Doctor?</p>
            </div>

            <?php $inputStyle = "border-2 p-3 rounded-md outline-none" ?>

            <div class="flex flex-col gap-3 mt-5">
                <input class="<?php echo $inputStyle ?>" type="text" placeholder="Full Name">
                <input class="<?php echo $inputStyle ?>" type="number" placeholder="Mobile Number">
                <input class="<?php echo $inputStyle ?>" type="password" placeholder="Create Password">
                <input class="<?php echo $inputStyle ?>" type="password" placeholder="Confirm Password">

                <a class="w-full flex justify-end font-semibold text-[#0D57E3]" href="login.php">Already have an
                    account?</a>

                <button class="font-semibold mt-3 bg-[#0D57E3] text-white p-3 rounded-md">Sign Up</button>
            </div>
        </div>
    </div>

</body>

</html>