<?php
include 'db_connection.php';
require "constants/data.php";
require "components/getUserType.php";

$result = getUserType();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "Doctor | Profile Settings";
    require_once "components/header.php"
        ?>
</head>

<body>
    <!-- navbar -->
    <?php

    // check weather user is present or not
    if (isset($_COOKIE['rowanCaredoctor'])) {
        $userIdentifier = $_COOKIE['rowanCaredoctor'];
        $userData = getUserData($conn, $userIdentifier, $result["userType"]);
    }

    require_once "components/navbar.php";
    stickyNavbar();
    ?>

    <!-- Banner -->
    <?php
    require_once "components/banner.php";
    banner(title: "Profile Settings", path: "Doctor Profile Settings");
    ?>

    <div class="w-[85%] mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-9 my-20">
            <?php
            require_once "components/dashboard-navigation.php";
            dashboardNavigation($userData, $doctorDashboardNav, $color, $result['userType']);
            ?>
            <div class="col-span-7 bg-red-500 border-white border-2">

            </div>
        </div>
    </div>

    </main>

</body>

</html>