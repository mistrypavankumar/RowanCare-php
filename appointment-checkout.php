<?php

include 'db_connection.php';
require 'constants/data.php';
require 'components/functions.php';
session_start();

$appointmentDate = isset($_SESSION['appointmentDate']) ? $_SESSION['appointmentDate'] : null;
$appointmentTime = isset($_SESSION['appointmentTime']) ? $_SESSION['appointmentTime'] : null;
$doctorId = isset($_SESSION['doctorId']) ? $_SESSION['doctorId'] : null;


if ($appointmentDate == null || $appointmentTime == null || $doctorId == null) {
    header("Location: page-not-found.php");
    return;
} else {
    if (isset($_COOKIE['rowanCarepatient'])) {
        $userIdentifier = $_COOKIE['rowanCarepatient'];
        $patientData = getUserData($conn, $userIdentifier, "patient");
        $doctorData = getDoctorDetailsById($conn, $doctorId);


        $doctorName = $doctorData['firstName'] . " " . $doctorData['lastName'];
        $location = $doctorData['state'] . ", " . $doctorData['country'];
        $doctorImage = $doctorData['image_path'];
        $firstLetters = getFirstLetter($doctorData['firstName']);


        $consultingFee = 100;
        $bookingFee = 10;
        $vedioCallingFee = 50;
        $totalAmount = $consultingFee + $bookingFee + $vedioCallingFee;
    }
}




// component
function textInputForm($uniqueIdName, $label, $value)
{
    echo '
    <div class="flex flex-col gap-2">
    <label for="' . $uniqueIdName . '" class="font-semibold">' . $label . '</label>
    <input type="text" value="' . $value . '" class="outline-none p-3 rounded-md border-2 text-gray-500" name="' . $uniqueIdName . '" id="' . $uniqueIdName . '" disabled>
    </div>
    ';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Checkout";
    require_once "components/header.php";
    ?>
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
        banner(title: "Checkout", path: "Appointment Checkout");
        ?>

        <div class="w-[92%] md:w-[60%] mx-auto py-16">
            <div class="grid grid-cols-1 md:grid-cols-9 gap-6">
                <div class="col-span-9 md:col-span-5 border-2 h-auto rounded-lg p-6">
                    <h2 class="text-2xl font-semibold">Appointment Checkout</h2>
                    <form method="POST" class="pt-7 flex flex-col gap-5">

                        <?php
                        textInputForm(uniqueIdName: "orderId", label: "Order Id", value: "");
                        textInputForm(uniqueIdName: "patientEmail", label: "Patient Email", value: $patientData['email']);
                        textInputForm(uniqueIdName: "amount", label: "Amount", value: $totalAmount);
                        ?>

                        <div class="flex flex-col sm:flex-row items-center justify-between w-full gap-5">
                            <button class="text-center bg-[#0D57E3] hover:bg-[#0a43b0] duration-500 text-white px-10 py-3 rounded-md outline-none border-none cursor-pointer flex items-center w-full sm:w-fit justify-center font-medium">Check out</button>

                            <a href="search-appointment.php" class="text-center bg-gray-500 hover:bg-gray-600 duration-500 text-white px-10 py-3 rounded-md outline-none border-none cursor-pointer flex items-center  w-full sm:w-fit justify-center font-medium">Cancel</a>
                        </div>
                    </form>
                </div>
                <div class="col-span-9 md:col-span-4 border-2 h-fit py-6 rounded-lg">
                    <div class="px-6 pb-6 border-b-2">
                        <h2 class="text-xl font-medium">Booking Summary</h2>
                    </div>
                    <div class="px-6">
                        <div class="flex w-full py-6 gap-4">
                            <?php if (!empty($doctorImage)) : ?>
                                <div class="w-[80px] h-[80px] overflow-hidden rounded-md">
                                    <img class="w-full object-cover" src="<?php echo $doctorImage ?>" alt="doctor" srcset="">
                                </div>
                            <?php else : ?>
                                <div class="w-[80px] h-[80px] overflow-hidden rounded-lg bg-gray-200 flex items-center justify-center">
                                    <h1 class="font-bold text-2xl text-gray-500"><?php echo $firstLetters ?></h1>
                                </div>
                            <?php endif; ?>
                            <div class="flex flex-col gap-1">
                                <h1 class="text-[17px] font-medium">Dr. <?php echo $doctorName; ?></h1>
                                <p class="text-xs text-gray-500">Rating <span class="text-black">(35)</span></p>
                                <div class="text-[12px] flex items-center gap-2 text-gray-500">
                                    <i class="fa fa-map-marker text-gray-500"></i>
                                    <p><?php echo $location; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-5">
                            <p>Date: <span class="text-gray-500"><?php echo $appointmentDate ?></span></p>
                            <p>Time: <span class="text-gray-500"><?php echo $appointmentTime ?></span></p>
                        </div>
                        <div class="flex flex-col gap-2 mt-12">
                            <div class="flex items-center justify-between">
                                <p>Consulting Fee</p>
                                <p class="text-gray-500">$<?php echo $consultingFee ?></p>
                            </div>
                            <div class="flex items-center justify-between">
                                <p>Booking Fee</p>
                                <p class="text-gray-500">$<?php echo $bookingFee ?></p>
                            </div>
                            <div class="flex items-center justify-between">
                                <p>Vedio Calling</p>
                                <p class="text-gray-500">$<?php echo $vedioCallingFee ?></p>
                            </div>

                            <div class="flex items-center justify-between border-t-2 mt-5 pt-3">
                                <p class="text-xl font-bold">Total</p>
                                <p class="text-[<?php echo $color['primary'] ?>] font-bold text-xl">$<?php echo $totalAmount ?></p>
                            </div>

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
</body>

</html>