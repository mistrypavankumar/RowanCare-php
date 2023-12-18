<?php

include 'db_connection.php';
require "constants/data.php";
require "components/getUserType.php";
require "components/functions.php";
require 'components/doctorCard.php';

$specializaitons = getAllSpecializations($conn);
$doctorDetails = getDoctorDetailsById($conn, $_GET['doctorId']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Doctor Profile";
    require_once "components/header.php";
    ?>

    <style>
        .form-checkbox input:checked+label span {
            background-color: transparent;
            border-color: #4c51bf;
            position: relative;
            display: hidden;
        }

        .form-checkbox input:checked+label span:after {
            content: "✔";
            color: #4c51bf;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <!-- navbar -->
    <?php
    require_once "components/navbar.php";
    stickyNavbar()
    ?>

    <main>
        <!-- Banner -->
        <?php
        require_once "components/banner.php";
        banner(title: "Doctor Profile", path: "View Doctor Details");
        ?>

        <div class="w-[92%] md:w-[80%] mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-9 my-20 gap-4">
                <div id="beforeSearchItems" class="grid col-span-9 md:col-span-9 gap-4">
                    <?php

                    $doctor = [
                        "doctorId" => $_GET['doctorId']
                    ];

                    $profileImage = getProfileImage($conn, $doctor['doctorId'], 'doctor');
                    $doctorAddress = getAddress($conn, $doctor['doctorId'], 'doctor');
                    $specializaiton = getDoctorSpecialization($conn, $doctor['doctorId']);

                    if (!empty($doctorAddress["state"]) && !empty($doctorAddress['country'])) {
                        doctorCard($doctorDetails, $specializaiton, $profileImage, $doctorAddress, firstLetters: getFirstLetter($doctorDetails['firstName']), color: $color, viewProfileBtn: false);
                    }

                    ?>
                </div>

                <div class="h-auto col-span-9 md:col-span-9 border-2 rounded-lg p-6">
                    <div>
                        <h1 class="text-xl font-bold pb-5">About Me</h1>
                        <p class="text-gray-500">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut <br>
                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi<br>
                            ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum<br>
                            dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia<br>
                            deserunt mollit anim id est laborum.
                        </p>
                    </div>
                    <div class="mt-10">
                        <h1 class="text-xl font-bold pb-5">Contact Number</h1>
                        <div class="flex gap-5">
                            <p class="bg-gray-100 border-2 border-gray-200 w-fit rounded-full text-gray-500 px-3">+1<?php echo $doctorDetails['phoneNumber'] ?></p>
                        </div>
                    </div>
                    <div class="mt-10">
                        <h1 class="text-xl font-bold pb-5">Services</h1>
                        <div class="flex gap-5">
                            <p class="bg-gray-100 border-2 border-gray-200 w-fit rounded-full text-gray-500 px-3">Root Canal Therapy</p>
                            <p class="bg-gray-100 border-2 border-gray-200 w-fit rounded-full text-gray-500 px-3">Implants</p>
                            <p class="bg-gray-100 border-2 border-gray-200 w-fit rounded-full text-gray-500 px-3">Fissure Sealants</p>
                            <p class="bg-gray-100 border-2 border-gray-200 w-fit rounded-full text-gray-500 px-3">Surgical Extractions</p>
                        </div>
                    </div>
                    <div class="mt-10">
                        <h1 class="text-xl font-bold pb-5">Specialization</h1>
                        <div class="flex gap-5">
                            <p class="bg-gray-100 border-2 border-gray-200 w-fit rounded-full text-gray-500 px-3"><?php echo ($specializaiton['specialization']) ?></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- footer -->
    <?php
    require_once "components/footer.php";
    footer();
    ?>

    <script src="js/search.js?v=1"></script>
</body>

</html>