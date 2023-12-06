<?php

include 'db_connection.php';
require "constants/data.php";
require "components/getUserType.php";


$result = getUserType();



function progressCard($title, $label1, $label2, $progressColor)
{
    echo '
    <div class="col-span-9 md:col-span-3 h-[100px] flex items-center gap-4 pb-6 md:pb-0 border-b-2 md:border-b-0 last:border-b-0 md:border-r-2 last:md:border-r-0 ">
        <div class="h-[90px] w-[90px] border-4 rounded-full flex items-center justify-center border-' . $progressColor . '-500 border-l-gray-500/20">
            <img src="assets/icons/icon-01.png" alt="total-patients">
        </div>
        <div>
            <h3 class = "text-[17px]">' . $title . '</h3>
            <h2 class = "text-2xl font-bold">' . $label1 . '</h2>
            <p class = "text-xs text-gray-500">' . $label2 . '</p>
        </div>
    </div>
    ';
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Doctor";
    require_once "components/header.php"
    ?>
</head>

<body>

    <?php
    if ($result['isLoading'] === false && $result['userType'] == "doctor" && isset($_COOKIE['rowanCaredoctor'])) {

        // check weather user is present or not
        if (isset($_COOKIE['rowanCaredoctor'])) {
            $userIdentifier = $_COOKIE['rowanCaredoctor'];
            $userData = getUserData($conn, $userIdentifier, $result['userType']);
            $profileImage = getProfileImage($conn, $userData['doctorId'], "doctor");
            $progressCardData = getProgressData($conn, $userData['doctorId']);
        }

    ?>

        <?php require_once "components/navbar.php";
        stickyNavbar()
        ?>


        <main>
            <!-- Banner -->
            <?php
            require_once "components/banner.php";
            banner(title: "Dashboard", path: "Doctor Dashboard");
            ?>

            <div class="w-[85%] mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-9 my-20 gap-4">
                    <?php
                    require_once "components/dashboard-navigation.php";
                    dashboardNavigation($conn, $userData, $doctorDashboardNav, $color, $result['userType'], profileImage: $profileImage['imagePath'] ?? "");
                    ?>
                    <div class="col-span-9 md:col-span-7 border-2 border-white">
                        <div class="grid grid-cols-1 md:grid-cols-9 border-2 rounded-lg p-7 flex justify-between gap-8">
                            <?php

                            progressCard("Total Patient", $progressCardData['totalPatients'], "Till Today", "red");
                            progressCard("Today Patient", $progressCardData['todaysPatients'], "06, Dec 2023", "green");
                            progressCard("Appointments", $progressCardData['totalAppointments'], "06, Dec 2023", "blue");

                            ?>
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

    <?php
    } else {
        echo "loading..." . $userType . $userIdentifier;
    }
    ?>
</body>

</html>