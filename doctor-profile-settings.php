<?php
include 'db_connection.php';
require "constants/data.php";
require "components/getUserType.php";
require 'components/functions.php';

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

    <div class="w-[92%] md:w-[85%] mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-9 my-20 gap-4">
            <?php
            require_once "components/dashboard-navigation.php";
            dashboardNavigation($userData, $patientDashboardNav, $color, $result['userType']);
            ?>
            <form method="POST" action="patient-profile-settings.php"
                class="col-span-9 md:col-span-7 border-2 rounded-lg px-5 py-5">
                <div>1</div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="col-span-1 space-y-3">

                        <?php
                        textInputField(userData: $userData, label: "First Name", textType: "text", value: "firstName", disabled: "disabled");
                        textInputField(userData: $userData, label: "Date of Birth", textType: "date", value: "dateOfBirth");
                        textInputField(userData: $userData, label: "Email ID", textType: "email", value: "email", disabled: "disabled");
                        ?>

                    </div>
                    <div class="col-span-1 space-y-3">
                        <?php
                        textInputField(userData: $userData, label: "Last Name", textType: "text", value: "lastName", disabled: "disabled");
                        ?>

                        <div class="flex flex-col gap-2">
                            <label for="phoneNumber">Phone Number</label>
                            <input class="outline-none p-3 text-gray-500     rounded-md border-2" type="tel"
                                pattern="[0-9]{10}" title="Enter a 10-digit phone number" name="phoneNumber"
                                placeholder="Enter your phone number" value="<?php echo $userData['phoneNumber']; ?>"
                                disabled>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="htmlFor">Gender</label>
                            <select class="outline-none p-3 rounded-md border-2 text-gray-500" name="gender"
                                id="gender">
                                <option value="">Select your Gender</option>
                                <option value="Male" <?php echo $userData['gender'] == "Male" ? "selected" : "" ?>>Male
                                </option>
                                <option value="Female" <?php echo $userData["gender"] == "Female" ? "selected" : "" ?>>
                                    Female
                                </option>
                                <option value="Other" <?php echo $userData["gender"] == "Other" ? "selected" : "" ?>>Other
                                </option>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="mt-3 mb-3 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <?php
                    textInputField(userData: $userData, label: "Address Line1", textType: "text", value: "addressLine1");
                    ?>
                    <?php
                    textInputField(userData: $userData, label: "Address Line2", textType: "text", value: "addressLine2");
                    ?>


                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="col-span-1 space-y-3">
                        <?php
                        textInputField(userData: $userData, label: "City", textType: "text", value: "city");
                        ?>
                        <div class="flex flex-col gap-2">
                            <label for="zipCode">Zip Code</label>
                            <input class="outline-none text-gray-500 p-3 rounded-md border-2" type="text" name="zipcode"
                                id="zipCode" pattern="\d{6}" title="Please enter a 6-digit zip code"
                                placeholder="Enter your area zip code" maxlength="6" minlength="6"
                                value="<?php echo $userData['zipcode'] ?>">
                        </div>
                    </div>
                    <div class="col-span-1 space-y-3">
                        <?php
                        textInputField(userData: $userData, label: "State", textType: "text", value: "state");
                        textInputField(userData: $userData, label: "Country", textType: "text", value: "country");
                        ?>
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



    <?php if (!empty($_SESSION['message'])): ?>
        <div id="toaster"
            class="h-12 w-[350px] text-center bg-[<?php echo $color['primary'] ?>] text-white py-3 rounded-lg fixed bottom-[-100px] right-1/2 left-1/2 -translate-x-1/2 z-[99999] transition-all duration-500">
            <p>
                <?php echo $_SESSION['message']; ?>
            </p>
        </div>
        <script>
            const toaster = document.getElementById("toaster");
            toaster.style.bottom = "12px";

            setTimeout(() => {
                toaster.style.bottom = "-100px";
            }, 2000);
        </script>

        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>


</body>

</html>