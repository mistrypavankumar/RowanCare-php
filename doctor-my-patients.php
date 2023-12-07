<?php

include 'db_connection.php';
require "constants/data.php";
require "components/getUserType.php";
require_once 'components/functions.php';

$result = getUserType();

if (isset($_COOKIE['rowanCaredoctor'])) {
    $userIdentifier = $_COOKIE['rowanCaredoctor'];
    $userData = getUserData($conn, $userIdentifier, $result['userType']);
    $profileImage = getProfileImage($conn, $userData['doctorId'], "doctor");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | My Patients";
    require_once "components/header.php"
    ?>
</head>

<body>
    <?php require_once "components/navbar.php";
    stickyNavbar()
    ?>


    <main>
        <!-- Banner -->
        <?php
        require_once "components/banner.php";
        banner(title: "My Patients", path: "My Patients");
        ?>
        <div class="w-[85%] mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-9 my-20 gap-4">
                <?php
                require_once "components/dashboard-navigation.php";
                dashboardNavigation($conn, $userData, $doctorDashboardNav, $color, $result['userType'], profileImage: $profileImage['imagePath'] ?? "");
                ?>
                <div class="col-span-9 md:col-span-7">
                    <div>
                        <?php if (!empty($profileImage ?? "")) : ?>
                            <div class="w-[150px] h-[150px] rounded-full overflow-hidden flex items-center">
                                <img class="w-full h-full object-cover rounded-full" src="<?php echo $profileImage; ?>" alt="Profile Image">

                            </div>
                        <?php else : ?>
                            <div class="rounded-full bg-gray-200 overflow-hidden flex items-center justify-center w-full h-full">
                                <p class="text-xl font-bold text-gray-500">
                                    <?php
                                    require_once 'components/functions.php';
                                    echo getFirstLetter($userData['firstName']) ? getFirstLetter($userData['firstName']) : "DP";
                                    ?>
                                </p>
                            </div>
                        <?php endif; ?>
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