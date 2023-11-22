<?php
include 'db_connection.php';
require "constants/data.php";
require "components/getUserType.php";
require 'components/functions.php';

session_start();
$result = getUserType();
$allSpecialization = getAllSpecializations($conn);

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
        'specialization' => $_POST['specialization'],
        'image_path' => $userData['image_path'] ?? "", // Set initially as empty
    ];

    $feeRanges = [
        'min' => $_POST['minFee'],
        'max' => $_POST['maxFee'],
    ];

    $newFileUploaded = false;
    $target_dir = "uploads/doctors/";

    if (isset($_FILES['doctor-file-upload']) && $_FILES['doctor-file-upload']['error'] == 0) {
        if ($_FILES['doctor-file-upload']['error'] != 0) {
            $_SESSION['error_message'] = "File upload error: " . $_FILES['doctor-file-upload']['error'];
            header("Location: doctor-profile-settings.php");
            exit();
        }

        $imageFileType = strtolower(pathinfo($_FILES["doctor-file-upload"]["name"], PATHINFO_EXTENSION));
        $uniqueFileName = uniqid('doctor_', true) . '.' . $imageFileType;
        $target_file = $target_dir . $uniqueFileName;

        if ($_FILES['doctor-file-upload']['size'] > 5000000) {
            $_SESSION['error_message'] = "Sorry, your file is too large.";
        } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
            $_SESSION['error_message'] = "Sorry, only JPG, JPEG, and PNG files are allowed.";
        } elseif (move_uploaded_file($_FILES["doctor-file-upload"]["tmp_name"], $target_file)) {
            // Delete old image if exists
            if (!empty($userData['image_path']) && file_exists($userData['image_path'])) {
                unlink($userData['image_path']);
            }
            $doctorData['image_path'] = $target_file;
            $newFileUploaded = true;
        } else {
            $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
        }
    }

    if (!$newFileUploaded && !empty($userData['image_path'])) {
        $doctorData['image_path'] = $userData['image_path'];
    }

    if (empty($_SESSION['error_message'])) {
        $res = updateDoctorProfile($conn, $userData, $doctorData);
        $fee = insertOrUpdateFeeRange(conn: $conn, doctorId: $userData['doctorId'], minFee: $feeRanges['min'], maxFee: $feeRanges['max']);

        if ($res) {
            $_SESSION['success_message'] = "All profile details are successfully updated.";
        } else {
            $_SESSION['error_message'] = $conn->error;
        }
    }

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
            <div class="col-span-9 md:col-span-7">
                <form method="POST" action="doctor-profile-settings.php" class="grid gap-4" enctype="multipart/form-data">
                    <div class="border-2 rounded-lg px-5 py-5">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold mb-7">Profile Information</h1>
                        </div>

                        <?php
                        require_once 'components/uploadProfile.php';
                        uploadProfile($userData, name: "doctor-file-upload");
                        ?>


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
                                    <input class="outline-none p-3 text-gray-500     rounded-md border-2" type="tel" pattern="[0-9]{10}" title="Enter a 10-digit phone number" name="phoneNumber" placeholder="Enter your phone number" value="<?php echo $userData['phoneNumber']; ?>" disabled>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <label for="htmlFor">Gender</label>
                                    <select class="outline-none p-3 rounded-md border-2 text-gray-500" name="gender" id="gender">
                                        <option value="">Select your Gender</option>
                                        <option value="Male" <?php echo $userData['gender'] == "Male" ? "selected" : "" ?>>
                                            Male
                                        </option>
                                        <option value="Female" <?php echo $userData["gender"] == "Female" ? "selected" : "" ?>>
                                            Female
                                        </option>
                                        <option value="Other" <?php echo $userData["gender"] == "Other" ? "selected" : "" ?>>
                                            Other
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
                                    <input class="outline-none text-gray-500 p-3 rounded-md border-2" type="text" name="zipcode" id="zipCode" pattern="\d{6}" title="Please enter a 6-digit zip code" placeholder="Enter your area zip code" maxlength="6" minlength="6" value="<?php echo $userData['zipcode'] ?>">
                                </div>
                            </div>
                            <div class="col-span-1 space-y-3">
                                <?php
                                textInputField(userData: $userData, label: "State", textType: "text", value: "state");
                                textInputField(userData: $userData, label: "Country", textType: "text", value: "country");
                                ?>
                            </div>
                        </div>

                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 border-2 rounded-lg px-5 py-5 w-full">
                        <div class="col-span-2 mb-5">
                            <h1 class="text-2xl md:text-3xl font-bold">Specialization Information</h1>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <div class="flex flex-col gap-2">
                                <label for="specialization" class="text-xl">Specialization</label>
                                <select class="outline-none p-3 rounded-md border-2 text-gray-500" name="specialization" id="specialization">
                                    <option value="">Select your specialization</option>
                                    <?php foreach ($allSpecialization as $spec) : ?>
                                        <option value="<?php echo htmlspecialchars($spec['name']); ?>" <?php echo $userData['specialization'] == $spec["name"] ? "selected" : ""; ?>>
                                            <?php echo htmlspecialchars($spec['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <div class="flex flex-col gap-2">
                                <label for="feerange" class="text-xl">Fee Range</label>

                                <div class="flex justify-between gap-4">
                                    <input value="<?php
                                                    $res = getFeeRange($conn, $userData['doctorId']);
                                                    echo $res['minFee'];
                                                    ?>" class="outline-none text-gray-500 p-2.5 rounded-md border-2 w-full" min="100" max="200" type="number" name="minFee" id="minFee" placeholder="Minimum Fee (eg., 100)*" required>
                                    <input value="<?php
                                                    $res = getFeeRange($conn, $userData['doctorId']);
                                                    echo $res['maxFee'];
                                                    ?>" class="outline-none text-gray-500 p-2.5 rounded-md border-2 w-full" type="number" min="200" max="400" name="maxFee" id="maxFee" placeholder="Maximum Fee (eg., 500)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" mt-5">
                        <button class="w-full md:w-fit disabled:opacity-50  text-center bg-[<?php echo $color['primary'] ?>]/80 hover:bg-[<?php echo $color['primary'] ?>] duration-500 text-white px-10 py-3 rounded-md outline-none border-none cursor-pointer flex items-center sm:w-fit justify-center font-medium" type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <?php
    require_once 'components/toaster.php';
    ?>


    <script>
        function updateFileName() {
            var input = document.getElementById('doctor-file-upload');
            var fileName = document.getElementById('file-name');
            if (input.files.length > 0) {
                fileName.textContent = input.files[0].name;
            }
        }
    </script>

</body>

</html>