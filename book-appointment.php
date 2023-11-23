<?php

include 'db_connection.php';
require 'constants/data.php';

$doctorId = $_GET['doctorId'];
$doctorData = getDoctorDetailsById($conn, $doctorId);

$doctorName = $doctorData['firstName'] . " " . $doctorData['lastName'];
$location = $doctorData['state'] . ", " . $doctorData['country'];
$doctorImage = $doctorData['image_path'];


$days = [
    "Monday",
    "Tusday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday",
    "Sunday",
];

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
                <div class="flex w-full border-2 rounded-lg p-6 gap-4">
                    <div class="w-[100px] h-[100px] overflow-hidden rounded-md">
                        <img class="w-full object-cover" src="<?php echo $doctorImage; ?>" alt="doctor-profile">
                    </div>
                    <div class="flex flex-col gap-1">
                        <h1 class="text-xl font-medium"><?php echo $doctorName; ?></h1>
                        <p class="text-gray-500">Rating <span class="text-black">(35)</span></p>
                        <div class="flex items-center gap-2 text-gray-500">
                            <i class="fa fa-map-marker text-gray-500"></i>
                            <p><?php echo $location; ?></p>
                        </div>
                    </div>
                </div>
                <div class="mt-3 flex justify-between">
                    <div>
                        <h1 class="font-medium text-xl">11 November, 2023</h1>
                        <p class="text-gray-500">Monday</p>
                    </div>

                </div>
                <div class="w-full border-2 px-5 py-6 rounded-lg">
                    <form class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 items-end" action="" method="POST">
                        <div class="flex flex-col gap-2">
                            <label for="date">Appointment Date</label>
                            <input class="outline-none p-3 rounded-md border-2 text-gray-500" type="date" name="appointmentDate" id="appointmentDate">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="specialization">Appointment Time</label>
                            <select class="outline-none p-3 rounded-md border-2 text-gray-500" name="specialization" id="specialization">
                                <option value="">Select appointment time</option>
                                <option value="9:00AM">9:00AM</option>
                                <option value="10:00AM">10:00AM</option>
                                <option value="11:00AM">11:00AM</option>
                            </select>
                        </div>
                        <div class="w-full">
                            <button type="submit" class="w-full text-center bg-[#0D57E3] hover:bg-[#0a43b0] duration-500   text-white px-10 py-3 rounded-md outline-none border-none cursor-pointer flex items-center sm:w-fit justify-center font-medium">Make Appointment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>

    </script>

</body>

</html>