<?php

include 'db_connection.php';
require 'constants/data.php';
require 'components/functions.php';

session_start();

$doctorId = $_GET['doctorId'];
$doctorData = getDoctorDetailsById($conn, $doctorId);
$profileImage = getProfileImage($conn, $doctorId, 'doctor');
$doctorAddress = getAddress($conn, $doctorId, 'doctor');
$specializaiton = getDoctorSpecialization($conn, $doctorId);

$doctorName = $doctorData['firstName'] . " " . $doctorData['lastName'];
$location = $doctorAddress['state'] . ", " . $doctorAddress['country'];
$doctorImage = $profileImage['imagePath'] ?? "";

$firstLetters = getFirstLetter($doctorData['firstName']);


global $isPatient;

if (!isset($_COOKIE['rowanCarepatient'])) {
    $isPatient = true;
} else {
    $isPatient = false;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $appointmentDate = $_POST['appointmentDate'];
    $appointmentTime = $_POST['appointmentTime'];

    if (!empty($appointmentDate) && !empty($appointmentTime)) {
        // Check if the login cookie exists
        if (!isset($_COOKIE['rowanCarepatient'])) {
            $_SESSION['error_message'] = "Sorry! </br>Please login as patient to book appointment";
        } else {
            $_SESSION['appointmentDate'] = $appointmentDate;
            $_SESSION['appointmentTime'] = $appointmentTime;
            $_SESSION['doctorId'] = $_GET['doctorId'];

            header("Location: appointment-checkout.php");
            exit();
        }
    }
}


function timeButton($time, $day)
{
    echo '
    <td class="timeSelection bg-gray-200 border-2 text-gray-500 hover:bg-white hover:border-2 duration-500 cursor-pointer">
        <button class="timeSelection w-full" type="submit" name="selectedTime" data-day="' . $day . '" value="' . $time . '">' . $time . '</button>
    </td>
    ';
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Book Appointment";
    require_once "components/header.php";
    ?>

    <style>
        .selected {
            background-color: #0D57E3 !important;
            color: #fff !important;
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
        banner(title: "Book Appointment", path: "Book Appointment");
        ?>

        <div class="w-[92%] md:w-[85%] mx-auto py-20">
            <div class="flex flex-col gap-4">
                <?php if ($isPatient) : ?>
                    <div class="flex w-full border-2 border-red-500 rounded-lg px-6 py-2 gap-4">
                        <p class="text-red-500">Please make sure you login as patient, if not you won't be able to make appointment!!</p>
                    </div>
                <?php endif; ?>
                <div class="flex w-full border-2 rounded-lg p-6 gap-4">
                    <?php if (!empty($doctorImage)) : ?>
                        <div class="w-[100px] h-[100px] overflow-hidden rounded-md">
                            <img class="w-full object-cover" src="<?php echo $doctorImage ?>" alt="doctor" srcset="">
                        </div>
                    <?php else : ?>
                        <div class="w-[100px] h-[100px] overflow-hidden rounded-lg bg-gray-200 flex items-center justify-center">
                            <h1 class="font-bold text-2xl text-gray-500"><?php echo $firstLetters ?></h1>
                        </div>
                    <?php endif; ?>
                    <div class="flex flex-col gap-1">
                        <h1 class="text-xl font-medium">Dr. <?php echo $doctorName; ?></h1>
                        <p class="text-gray-500">Rating <span class="text-black">(35)</span></p>
                        <div class="flex items-center gap-2 text-gray-500">
                            <i class="fa fa-map-marker text-gray-500"></i>
                            <p><?php echo $location; ?></p>
                        </div>
                    </div>
                </div>
                <div class="mt-3 flex justify-between">
                    <div>
                        <h1 id="currentDate" class="font-medium text-xl"></h1>
                        <p id="currentDay" class="text-gray-500"></p>
                    </div>

                </div>
                <div class="w-full border-2 px-5 py-6 rounded-lg">
                    <form id="appointmentForm" class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 items-end" action="" method="POST">
                        <div class="flex flex-col gap-2">
                            <label for="appointmentDate">Appointment Date</label>
                            <input class="outline-none p-3 rounded-md border-2 text-gray-500" type="date" name="appointmentDate" id="appointmentDate" required>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="appointmentTime">Appointment Time</label>
                            <select class="outline-none p-3 rounded-md border-2 text-gray-500" name="appointmentTime" id="appointmentTime" required>
                                <option value="">Select your appointment time</option>
                                <option value="9:00AM">9:00AM</option>
                                <option value="10:00AM">10:00AM</option>
                                <option value="11:00AM">11:00AM</option>
                            </select>
                        </div>

                        <div class="w-full">
                            <button id="makeAppointmentBtn" type="submit" class="w-full text-center bg-[#0D57E3] hover:bg-[#0a43b0] duration-500   text-white px-10 py-3 rounded-md outline-none border-none cursor-pointer flex items-center sm:w-fit justify-center font-medium">Proceed to pay</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>


    <!-- footer -->
    <?php
    require_once "components/footer.php";
    footer();
    ?>

    <?php
    require_once 'components/toaster.php';
    ?>

    <script src="js/scripts.js?v=1"></script>


</body>

</html>