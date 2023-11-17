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
    $pageTitle = "Patient | Profile Settings";
    require_once "components/header.php"
        ?>
</head>

<body>
    <!-- navbar -->
    <?php

    // check weather user is present or not
    if (isset($_COOKIE['rowanCarepatient'])) {
        $userIdentifier = $_COOKIE['rowanCarepatient'];
        $userData = getUserData($conn, $userIdentifier, $result["userType"]);
    }

    require_once "components/navbar.php";
    stickyNavbar();
    ?>

    <!-- Banner -->
    <?php
    require_once "components/banner.php";
    banner(title: "Profile Settings", path: "Patient Profile Settings");
    ?>

    <div class="w-[92%] md:w-[85%] mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-9 my-20 gap-4">
            <?php
            require_once "components/dashboard-navigation.php";
            dashboardNavigation($userData, $patientDashboardNav, $color, $result['userType']);
            ?>
            <form method="POST" action="patient-profile-settings.php" class="col-span-7 border-2 rounded-lg p-5">
                <div>1</div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="col-span-1 space-y-3">
                        <div class="flex flex-col gap-2">
                            <label for="htmlFor">First Name</label>
                            <input class="outline-none p-3 rounded-md border-2" type="text" name="firstName"
                                placeholder="Enter your first name" value="<?php
                                echo $userData['firstName'];
                                ?>">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="htmlFor">Date of Birth</label>
                            <input class="outline-none p-3 rounded-md border-2" type="date" name="firstName"
                                placeholder="Enter your date of Birth">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="htmlFor">Email ID</label>
                            <input class="outline-none text-gray-500 p-3 rounded-md border-2" type="text"
                                name="firstName" placeholder="Enter your email Id" value="<?php
                                echo $userData['email'];
                                ?>" disabled>
                        </div>
                    </div>
                    <div class="col-span-1 space-y-3">
                        <div class="flex flex-col gap-2">
                            <label for="htmlFor">Last Name</label>
                            <input class="outline-none p-3 rounded-md border-2" type="text" name="firstName"
                                placeholder="Enter your last Name" value="<?php
                                echo $userData['lastName'];
                                ?>">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="htmlFor">Blood Group</label>
                            <select class="outline-none p-3 rounded-md border-2" name="bloodGroup" id="bloodGroup">
                                <option value="">Select your blood group</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="phoneNumber">Phone Number</label>
                            <input class="outline-none p-3 rounded-md border-2" type="tel" pattern="[0-9]{10}"
                                title="Enter a 10-digit phone number" name="phoneNumber"
                                placeholder="Enter your phone number" value="<?php echo $userData['phoneNumber']; ?>">
                        </div>

                    </div>
                </div>
                <div class="mt-3 mb-3">
                    <div class="flex flex-col gap-2">
                        <label for="htmlFor">Address</label>
                        <input class="outline-none p-3 rounded-md border-2" type="text" name="firstName"
                            placeholder="Enter your address">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="col-span-1 space-y-3">
                        <div class="flex flex-col gap-2">
                            <label for="htmlFor">City</label>
                            <input class="outline-none p-3 rounded-md border-2" type="text" name="firstName"
                                placeholder="Enter your city">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="zipCode">Zip Code</label>
                            <input class="outline-none p-3 rounded-md border-2" type="text" name="zipCode" id="zipCode"
                                pattern="\d{6}" title="Please enter a 6-digit zip code"
                                placeholder="Enter your area zip code" maxlength="6" minlength="6">
                        </div>
                    </div>
                    <div class="col-span-1 space-y-3">
                        <div class="flex flex-col gap-2">
                            <label for="htmlFor">State</label>
                            <input class="outline-none p-3 rounded-md border-2" type="text" name="firstName"
                                placeholder="Enter your state name">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="htmlFor">Country</label>
                            <input class="outline-none p-3 rounded-md border-2" type="text" name="firstName"
                                placeholder="Enter your country name">
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <button
                        class="w-full md:w-fit text-center bg-green-500 hover:bg-green-600 duration-500 text-white px-10 py-3 rounded-md outline-none border-none cursor-pointer flex items-center sm:w-fit justify-center font-medium"
                        type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>