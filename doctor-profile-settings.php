<?php
include 'db_connection.php';
require "constants/data.php";
require "components/getUserType.php";
require 'components/functions.php';

session_start();
$result = getUserType();

global $doctorData;

// check weather user is present or not
if (isset($_COOKIE['rowanCaredoctor'])) {
    $userIdentifier = $_COOKIE['rowanCaredoctor'];
    $userData = getUserData($conn, $userIdentifier, $result["userType"]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctorData = [
        'dateOfBirth' => $_POST['dateOfBirth'],
        'addressLine1' => $_POST['addressLine1'],
        'addressLine2' => $_POST['addressLine2'],
        'city' => $_POST['city'],
        'state' => $_POST['state'],
        'country' => $_POST['country'],
        'gender' => $_POST['gender'],
        'zipcode' => $_POST['zipcode'],
        'image_path' => '', // Set initially as empty
    ];

    $uploadOk = 1;
    $target_dir = "uploads/";
    if (isset($_FILES['file-upload']) && $_FILES['file-upload']['error'] == 0) {
        $target_file = $target_dir . basename($_FILES["file-upload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // file size 5MB
        if ($_FILES['file-upload']['size'] > 5000000) {
            $uploadOk = 0;
            $_SESSION['message'] = "Sorry, your file is too large.";
        }

        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
            $uploadOk = 0;
            $_SESSION['message'] = "Sorry, only JPG, JPEG, and PNG files are allowed.";
        }

        if ($uploadOk == 0) {
            $_SESSION['message'] = "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["file-upload"]["tmp_name"], $target_file)) {
                $doctorData['image_path'] = $target_file;
            } else {
                $_SESSION['message'] = "Sorry, there was an error uploading your file.";
                header("Location: doctor-profile-settings.php");
                exit();
            }
        }
    }

    $res = updateDoctorProfile($conn, $userData, $doctorData);

    $_SESSION['message'] = $res ? "Updated profile successfully!" : "Failed to update profile. Please try again.";

    header("Location: doctor-profile-settings.php");
    exit();
}


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
            dashboardNavigation($userData, $doctorDashboardNav, $color, $result['userType']);
            ?>
            <form method="POST" action="doctor-profile-settings.php"
                class="col-span-9 md:col-span-7 border-2 rounded-lg px-5 py-5" enctype="multipart/form-data">
                <div class="flex items-center gap-5 mb-5">
                    <div class="w-24 h-24 bg-gray-200">
                        <?php if (!empty($userData['image_path'])): ?>
                            <img class="w-full object-cover" src="<?php echo $userData['image_path']; ?>"
                                alt="Profile Image">
                        <?php else: ?>
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <p class="text-xl font-bold text-gray-500">
                                    <?php
                                    echo getFirstLetter($userData['firstName']) ? getFirstLetter($userData['firstName']) : "DP";
                                    ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div>

                        <div class="p-4">
                            <?php if (!empty($userData['image_path'])): ?>
                                <div
                                    class="bg-green-500 text-white px-4 py-3 rounded-lg cursor-pointer hover:bg-green-600 duration-500">
                                    Edit Profile</div>
                            <?php else: ?>
                                <label for="file-upload"
                                    class="flex items-center justify-center cursor-pointer bg-blue-500 hover:bg-blue-700 duration-500 text-white font-bold py-2 px-4 rounded">
                                    <i class="fa fa-upload mr-2"></i>
                                    <span>Upload Photo</span>
                                    <input id="file-upload" name="file-upload" type="file" class="hidden"
                                        onchange="updateFileName()" />
                                </label>
                                <span id="file-name" class="ml-2 text-sm text-gray-700 mt-2"></span>
                                <p class="text-xs text-gray-500 mt-3">Allowed JPG, PNG and JPEG</p>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
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
                        class="w-full md:w-fit disabled:opacity-50  text-center bg-[<?php echo $color['primary'] ?>]/80 hover:bg-[<?php echo $color['primary'] ?>] duration-500 text-white px-10 py-3 rounded-md outline-none border-none cursor-pointer flex items-center sm:w-fit justify-center font-medium"
                        type="submit">>Save Changes</button>
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
        <script>         const toaster = document.getElementById("toaster"); toaster.style.bottom = "12px";
            setTimeout(() => { toaster.style.bottom = "-100px"; }, 3000);
        </script>

        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>


    <script>
        function updateFileName() {
            var input = document.getElementById('file-upload');
            var fileName = document.getElementById('file-name');
            if (input.files.length > 0) {
                fileName.textContent = input.files[0].name;
            }
        }
    </script>

</body>

</html>