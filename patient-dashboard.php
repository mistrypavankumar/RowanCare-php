<?php

include 'db_connection.php';
require "constants/data.php";
require "components/getUserType.php";

$result = getUserType();

session_start();
$_SESSION['userType'] = $result['userType'];
$_SESSION['isLoading'] = $result['isLoading'];
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
            $profileImage = getProfileImage($conn, $userData['patientId'], 'patient');

            $getAllAppointments = getPatientAllAppointments($conn, $userData['patientId']);
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
                <div class="grid grid-cols-1 md:grid-cols-9 my-20 gap-4">
                    <?php
                    require_once "components/dashboard-navigation.php";
                    dashboardNavigation($conn, $userData, $patientDashboardNav, $color, $result['userType'], $profileImage['imagePath'] ?? "");
                    ?>
                    <div class="col-span-9 md:col-span-7 border-white border-2">
                        <div class="border-2 rounded-lg p-5">
                            <div>
                                <h3 class="text-xl font-bold mb-4">Appointments</h3>

                                <div class="h-[77vh] overflow-y-auto">
                                    <table class="w-full py-2">
                                        <tr class="py-2 border-b-2">
                                            <th class="py-3 text-left">Doctor</th>
                                            <th class="text-left">Appt Date</th>
                                            <th class="text-left">Booking Date</th>
                                            <th class="text-left">Amount</th>
                                            <th class="text-left">Status</th>
                                            <th class="text-left">Action</th>
                                        </tr>

                                        <?php foreach ($getAllAppointments as $appt) {

                                            $res = $appt['appointmentDate'];
                                            $apptDate = date('d M Y', strtotime($res));

                                            $bookedAt = date("d M Y", strtotime($appt['bookingDate']));
                                        ?>
                                            <tr class="py-2 border-b-2 last:border-b-0 hover:bg-gray-100 duration-500">
                                                <td class="py-3">
                                                    <a href="#" class="flex gap-3 items-center">
                                                        <img class="w-[40px] h-[40px] rounded-full object-cover" src="<?php echo $appt['imagePath'] ?>" alt="profile">
                                                        <div>
                                                            <p class="text-[15px]"> <?php echo  $appt['firstName'] . " " . $appt['lastName'] ?>
                                                            </p>
                                                            <p class="text-xs text-gray-500"> <?php echo  $appt['specialization'] ?></p>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <p class="text-[15px]"><?php echo $apptDate ?></p>
                                                    <p class="text-[15px] text-blue-500"><?php echo $appt['appointmentTime'] ?></p>
                                                </td>
                                                <td><?php echo $bookedAt ?></td>
                                                <td>$<?php echo $appt['amount'] ?></td>
                                                <td>
                                                    <p class="<?php
                                                                if ($appt['status'] == "Confirmed") {
                                                                    echo "bg-green-500/20 text-green-500 ";
                                                                } elseif ($appt['status'] == "Cancelled") {
                                                                    echo "bg-red-500/20 text-red-500 ";
                                                                } else {
                                                                    echo "bg-orange-500/20 text-orange-500 ";
                                                                }
                                                                ?> text-center rounded-full text-xs font-semibold py-[1px] w-fit px-2"><?php echo $appt['status'] ?></p>
                                                </td>
                                                <td>View</td>
                                            </tr>
                                        <?php } ?>
                                    </table>
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

    <?php
    } else {
        echo "loading..." . $userType . $userIdentifier;
    }
    ?>
</body>

</html>