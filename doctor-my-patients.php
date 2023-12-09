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

    $patientsData = getDoctorsPatientData($conn, $userData['doctorId']);
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
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <?php foreach ($patientsData as $patient) {
                            $image = getProfileImage($conn, $patient['patientId'], "patient");
                            $address = getAddress($conn, $patient['patientId'], 'patient');

                            $dateOfBirth = new DateTime($patient['dateOfBirth']);
                            $today = new DateTime('today');
                            $age = $dateOfBirth->diff($today)->y;
                        ?>
                            <?php if (!empty($address['state']) && !empty($address['country']) && !empty($age)) : ?>
                                <div class="col-span-12 xl:col-span-3  md:col-span-4 border-2 rounded-lg w-full md:max-w-[220px] md:min-w-[100px] p-5">
                                    <div class="flex items-center justify-center">
                                        <?php if (!empty($image['imagePath'] ?? "")) : ?>
                                            <div class="w-[100px] h-[100px] rounded-full overflow-hidden flex items-center mb-5">
                                                <img class="w-full h-full object-cover rounded-full" src="<?php echo $image['imagePath']; ?>" alt="Profile Image">
                                            </div>
                                        <?php else : ?>
                                            <div class="w-[100px] h-[100px] rounded-full overflow-hidden bg-gray-200 overflow-hidden flex items-center justify-center mb-5">
                                                <p class="text-xl font-bold text-gray-500">
                                                    <?php
                                                    require_once 'components/functions.php';
                                                    echo getFirstLetter($patient['firstName']) ? getFirstLetter($patient['firstName']) : "DP";
                                                    ?>
                                                </p>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="flex flex-col gap-2 items-center justify-center border-b-2 pb-4">
                                        <h2 class="font-semibold capitalize"><?php echo $patient['firstName'] . " " . $patient['lastName'] ?></h2>
                                        <p class="text-xs font-bold text-gray-500">PatientId: <span class="font-normal">#00<?php echo $patient['patientId'] ?></span></p>
                                        <div class="flex items-center gap-2">
                                            <i class="fa fa-map-marker text-gray-500"></i>
                                            <p class="text-xs capitalize"><?php echo $address['state'] . ", " . $address['country'] ?></p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-2 pt-3">
                                        <div class="flex items-center justify-between">
                                            <p class="text-[14px] font-medium">Phone </p>
                                            <p class="text-[14px] text-gray-400"><?php echo $patient['phoneNumber'] ?></p>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <p class="text-[14px] font-medium">Age </p>
                                            <p class="text-[14px] text-gray-400"><?php echo $age ?> Years, <?php echo $patient['gender'] ?></p>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <p class="text-[14px] font-medium">Blood Group </p>
                                            <p class="text-[14px] text-gray-400"><?php echo $patient['bloodGroup'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php } ?>

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