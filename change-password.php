<?php

include 'db_connection.php';
require "constants/data.php";
require "components/getUserType.php";
require "components/functions.php";


session_start();

$userType = $_SESSION['userType'];
$isLoading = $_SESSION['isLoading'];

// check weather user is present or not
if (isset($_COOKIE['rowanCarepatient'])) {
    $userIdentifier = $_COOKIE['rowanCarepatient'];
    $userData = getUserData($conn, $userIdentifier, $userType);
    $profileImage = getProfileImage($conn, $userData['patientId'], 'patient');
} elseif (isset($_COOKIE['rowanCaredoctor'])) {
    $userIdentifier = $_COOKIE['rowanCaredoctor'];
    $userData = getUserData($conn, $userIdentifier, $userType);
    $profileImage = getProfileImage($conn, $userData['doctorId'], "doctor");
}


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($_POST['action'] == "saveChanges") {
        if ($newPassword == $confirmPassword) {
            $res = changePassword($conn, $userData["email"], $oldPassword, $newPassword);

            if ($res) {
                header("Location: change-password.php");
                $_SESSION['success_message'] = 'Password changed successfully';
                exit();
            } else {
                $_SESSION['error_message'] = 'Password change failed';
            }
        } else {
            $_SESSION['error_message'] = 'Passwords do not match';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Change Password";
    require_once "components/header.php"
    ?>
</head>

<body>


    <?php require_once "components/navbar.php";
    stickyNavbar();
    ?>


    <main>
        <!-- Banner -->
        <?php
        require_once "components/banner.php";
        banner(title: "Change Password", path: "Change Password");
        ?>

        <div class="w-[85%] mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-9 my-20 gap-4">
                <?php
                require_once "components/dashboard-navigation.php";
                dashboardNavigation($conn, $userData, $userType == "patient" ? $patientDashboardNav : $doctorDashboardNav, $color, $userType, $profileImage['imagePath'] ?? "");
                ?>
                <div class="col-span-9 md:col-span-7 border-white border-2">
                    <div class="border-2 rounded-lg p-5">
                        <form action="change-password.php" method="POST">
                            <div class="grid grid-cols-2 gap-5">
                                <div class="flex flex-col gap-2">
                                    <div class="flex flex-col gap-2 col-span-1">
                                        <label for="htmlFor">Old Password</label>
                                        <input class="outline-none p-3 text-gray-500 rounded-md border-2" type="password" name="oldPassword" placeholder="Enter your old password" value="" required>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label for="htmlFor">New Password</label>
                                        <input class="outline-none p-3 text-gray-500 rounded-md border-2" type="password" name="newPassword" placeholder="Enter your new password" value="" required>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label for="htmlFor">Confirm Password</label>
                                        <input class="outline-none p-3 text-gray-500 rounded-md border-2" type="password" name="confirmPassword" placeholder="Enter your confirm password" value="" required>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="action" id="changePasswordAction" value="saveChanges">

                            <div class="mt-5">
                                <button class="w-full md:w-fit disabled:opacity-50  text-center bg-[<?php echo $color['primary'] ?>]/80 hover:bg-[<?php echo $color['primary'] ?>] duration-500 text-white px-10 py-3 rounded-md outline-none border-none cursor-pointer flex items-center sm:w-fit justify-center font-medium" type="submit">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php
    require_once 'components/toaster.php';
    ?>

    <!-- footer -->
    <?php
    require_once "components/footer.php";
    footer();
    ?>


</body>

</html>