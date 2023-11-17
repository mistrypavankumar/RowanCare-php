<?php

include 'db_connection.php';
require "constants/data.php";
require "components/getUserType.php";

$result = getUserType();

?>


<?php


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Patient";
    require_once "components/header.php"
        ?>
</head>

<body>

    <?php
    if ($result["isLoading"] === false && $result["userType"] !== "") {

        // check weather user is present or not
        if (isset($_COOKIE['rowanCarepatient'])) {
            $userIdentifier = $_COOKIE['rowanCarepatient'];
            $userData = getUserData($conn, $userIdentifier, $result["userType"]);
        }

        ?>

        <?php require_once "components/navbar.php";
        stickyNavbar();
        ?>


        <main>
            <!-- Banner -->
            <?php
            require_once "components/banner.php";
            banner(title: "Dashboard", path: "Patient Dashboard");
            ?>

            <div class="w-[85%] mx-auto">
                <div class="grid grid-cols-1  md:grid-cols-9 my-20">
                    <?php
                    require_once "components/dashboard-navigation.php";
                    dashboardNavigation($userData, $patientDashboardNav, $color, $result['userType']);
                    ?>
                    <div class="col-span-7 bg-red-500 border-white border-2">

                    </div>
                </div>
            </div>

        </main>

        <?php
    } else {
        echo "loading..." . $userType . $userIdentifier;

    }
    ?>
</body>

</html>