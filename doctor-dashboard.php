<?php

include 'db_connection.php';
require "constants/data.php";
require "components/getUserType.php";
require_once 'components/functions.php';

$result = getUserType();

session_start();
$_SESSION['userType'] = $result['userType'];
$_SESSION['isLoading'] = $result['isLoading'];


function progressCard($title, $label1, $label2, $progressColor, $iconName)
{
    echo '
    <div class="col-span-9 md:col-span-3 h-[100px] flex items-center gap-4 pb-6 md:pb-0 border-b-2 md:border-b-0 last:border-b-0 md:border-r-2 last:md:border-r-0 ">
        <div class="h-[90px] w-[90px] border-4 rounded-full flex items-center justify-center border-' . $progressColor . '-500 border-l-gray-500/20">
            <img src="assets/icons/' . $iconName . '" alt="total-patients">
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
            $getAllAppointments = getAppointmentByDoctorId($conn, $userData['doctorId']);
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

                            progressCard("Total Patient", $progressCardData['totalPatients'], "Till Today", "red", "icon-01.png");
                            progressCard("Today Patient", $progressCardData['todaysPatients'], "06, Dec 2023", "green", "icon-02.png");
                            progressCard("Appointments", $progressCardData['totalAppointments'], "06, Dec 2023", "blue", "icon-03.png");

                            ?>
                        </div>

                        <div class="py-5">
                            <div class="border-2 rounded-lg p-5">
                                <div>
                                    <h3 class="text-xl font-bold mb-4">Patient Appointment</h3>

                                    <div class="h-[77vh] overflow-y-auto">
                                        <table class="w-full py-2">
                                            <thead class="sticky top-0 bg-white">
                                                <tr class="py-2 border-b-2">
                                                    <th class="py-3 text-left">Patient Name</th>
                                                    <th class="text-left">Appt Date</th>
                                                    <th class="text-left">Purpose</th>
                                                    <th class="text-left">Type</th>
                                                    <th class="text-left">Paid Amount</th>
                                                    <th class="text-left">Action</th>
                                                </tr>
                                            </thead>

                                            <?php foreach ($getAllAppointments as $appt) {

                                                $res = $appt['appointmentDate'];
                                                $apptDate = date('d M Y', strtotime($res));

                                                $bookedAt = date("d M Y", strtotime($appt['bookingDate']));
                                            ?>
                                                <tr class="py-2 border-b-2 last:border-b-0 hover:bg-gray-100 duration-500">
                                                    <td class="py-3">
                                                        <a href="#" class="flex gap-3 items-center">
                                                            <?php if (empty($appt['imagePath'])) : ?>
                                                                <div class="w-[40px] h-[40px] rounded-full bg-gray-200 flex items-center justify-center">
                                                                    <p class="font-semibold text-gray-500"><?php echo getFirstLetter($appt['firstName']) ?></p>
                                                                </div>
                                                            <?php else : ?>
                                                                <img class="w-[40px] h-[40px] rounded-full object-cover" src="<?php echo $appt['imagePath'] ?>" alt="profile">
                                                            <?php endif ?>
                                                            <div>
                                                                <p class="text-[15px]"> <?php echo  $appt['firstName'] . " " . $appt['lastName'] ?>
                                                                </p>
                                                                <p class="text-xs text-gray-500"> #<?php echo explode("_", $appt['orderId'])[1] ?></p>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <p class="text-[15px]"><?php echo $apptDate ?></p>
                                                        <p class="text-[15px] text-blue-500"><?php echo $appt['appointmentTime'] ?></p>
                                                    </td>
                                                    <td>General</td>
                                                    <td><?php echo $appt['patientType'] ?></td>
                                                    <td>$<?php echo $appt['amount'] ?></td>
                                                    <td>
                                                        <?php if ($appt['status'] == "Cancelled") : ?>
                                                            <button disabled class="w-fit px-2 py-1 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg duration-500">X Cancel</button>
                                                        <?php elseif ($appt['status'] == "Confirmed") : ?>
                                                            <button disabled class="w-fit px-2 py-1 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg duration-500">✔ Accept</button>
                                                        <?php else : ?>
                                                            <div>
                                                                <form method="POST" id="actionForm" action="providers/updatePatientStatus.php" class="flex items-center gap-2">
                                                                    <input type="hidden" name="action" id="doctorAction" value="accept">
                                                                    <input type="hidden" name="appointmentOrderId" id="appointmentOrderId" value="<?php echo $appt['orderId'] ?>">
                                                                    <button type="submit" name="accept" id="acceptBtn" class="w-fit px-2 py-1 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg duration-500">✔ Accept</button>
                                                                    <button type="submit" name="cancel" id="cancelBtn" class="w-fit px-2 py-1 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg duration-500">X Cancel</button>
                                                                </form>
                                                            </div>
                                                        <?php endif ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
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


    <?php
    require_once 'components/toaster.php';
    ?>

    <script>
        document.getElementById("cancelBtn").addEventListener("click", function() {
            document.getElementById("doctorAction").value = "cancel";
            document.getElementById("actionForm").submit();
        })
    </script>
</body>

</html>