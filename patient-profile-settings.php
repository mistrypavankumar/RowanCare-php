<?php
include 'db_connection.php';
require "constants/data.php";
require "components/getUserType.php";
require "components/functions.php";

session_start();
$result = getUserType();

// check weather user is present or not
if (isset($_COOKIE['rowanCarepatient'])) {
    $userIdentifier = $_COOKIE['rowanCarepatient'];
    $userData = getUserData($conn, $userIdentifier, $result["userType"]);
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $patientData = [
        'dateOfBirth' => $_POST['dateOfBirth'],
        'address' => $_POST['address'],
        'bloodGroup' => $_POST['bloodGroup'],
        'city' => $_POST['city'],
        'state' => $_POST['state'],
        'country' => $_POST['country'],
        'gender' => $_POST['gender'],
        'zipcode' => $_POST['zipcode'],
        'image_path' => '', // Set initially as empty
    ];

    // no new profile is uploaded
    $isNewFileUploaded = false;

    $uploadOk = 1;
    $target_dir = "uploads/patients/";
    if (isset($_FILES['patient-file-upload']) && $_FILES['patient-file-upload']['error'] == 0) {
        $target_file = $target_dir . basename($_FILES["patient-file-upload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Generate a unique file name
        $uniqueFileName = uniqid('doc_', true) . '.' . $imageFileType;
        $target_file = $target_dir . $uniqueFileName;

        // Delete old image if exists
        if (!empty($userData['image_path']) && file_exists($userData['image_path'])) {
            unlink($userData['image_path']);
        }

        // file size 5MB
        if ($_FILES['patient-file-upload']['size'] > 5000000) {
            $uploadOk = 0;
            $_SESSION['error_message'] = "Sorry, your file is too large.";
            header("Location: patient-profile-settings.php");
            return;
        }

        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
            $uploadOk = 0;
            $_SESSION['error_message'] = "Sorry, only JPG, JPEG, and PNG files are allowed.";
            header("Location: patient-profile-settings.php");
            return;
        }

        if ($uploadOk == 0) {
            $_SESSION['error_message'] = "Sorry, your file was not uploaded.";
            header("Location: patient-profile-settings.php");
            return;

        } else {
            if (move_uploaded_file($_FILES["patient-file-upload"]["tmp_name"], $target_file)) {
                $patientData['image_path'] = $target_file;
                $isNewFileUploaded = true;
            } else {
                $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
                header("Location: patient-profile-settings.php");
                exit();
            }
        }
    } else {
        $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
    }

    if (!$isNewFileUploaded && !empty($userData['image_path'])) {
        $patientData['image_path'] = $userData['image_path'];
    }

    $res = updatePatientProfile($conn, $userData, $patientData);

    if ($res) {
        $_SESSION['success_message'] = "All profile details are successfully updated.";
    } else {
        $_SESSION['error_message'] = "Failed to update profile. Please try again";
    }

    header("Location: patient-profile-settings.php");
    exit();

}

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

            <div class="col-span-9 md:col-span-7 border-2 rounded-lg px-5 py-5">

                <form method="POST" action="patient-profile-settings.php" enctype="multipart/form-data">
                    <?php
                    require_once 'components/uploadProfile.php';
                    uploadProfile($userData, name: "patient-file-upload");
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
                                <label for="bloodGroup">Blood Group</label>
                                <select class="outline-none p-3 rounded-md border-2" name="bloodGroup" id="bloodGroup">
                                    <option value="">Select your blood group</option>
                                    <option value="A+" <?php echo $userData['bloodGroup'] == 'A+' ? 'selected' : ''; ?>>A+
                                    </option>
                                    <option value="A-" <?php echo $userData['bloodGroup'] == 'A-' ? 'selected' : ''; ?>>A-
                                    </option>
                                    <option value="B+" <?php echo $userData['bloodGroup'] == 'B+' ? 'selected' : ''; ?>>B+
                                    </option>
                                    <option value="B-" <?php echo $userData['bloodGroup'] == 'B-' ? 'selected' : ''; ?>>B-
                                    </option>
                                    <option value="AB+" <?php echo $userData['bloodGroup'] == 'AB+' ? 'selected' : ''; ?>>
                                        AB+
                                    </option>
                                    <option value="AB-" <?php echo $userData['bloodGroup'] == 'AB-' ? 'selected' : ''; ?>>
                                        AB-
                                    </option>
                                    <option value="O+" <?php echo $userData['bloodGroup'] == 'O+' ? 'selected' : ''; ?>>O+
                                    </option>
                                    <option value="O-" <?php echo $userData['bloodGroup'] == 'O-' ? 'selected' : ''; ?>>O-
                                    </option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="phoneNumber">Phone Number</label>
                                <input class="outline-none p-3 text-gray-500     rounded-md border-2" type="tel"
                                    pattern="[0-9]{10}" title="Enter a 10-digit phone number" name="phoneNumber"
                                    placeholder="Enter your phone number"
                                    value="<?php echo $userData['phoneNumber']; ?>" disabled>
                            </div>

                        </div>
                    </div>
                    <div class="mt-3 mb-3 grid grid-cols-1 md:grid-cols-2 gap-5">
                        <?php
                        textInputField(userData: $userData, label: "Address", textType: "text", value: "address");
                        ?>

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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="col-span-1 space-y-3">
                            <?php
                            textInputField(userData: $userData, label: "City", textType: "text", value: "city");
                            ?>
                            <div class="flex flex-col gap-2">
                                <label for="zipCode">Zip Code</label>
                                <input class="outline-none text-gray-500 p-3 rounded-md border-2" type="text"
                                    name="zipcode" id="zipCode" pattern="\d{6}" title="Please enter a 6-digit zip code"
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
                            type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php if (!empty($_SESSION['success_message']) || !empty($_SESSION['error_message'])): ?>
        <div id="toaster" class="<?php echo !empty($_SESSION['success_message']) ? "bg-green-500" : "bg-red-500"; ?>
 h-auto w-[350px] p-4 text-white rounded-lg fixed bottom-[-100px] right-2 z-[99999] transition-all duration-500">
            <h2 class="text-xl mb-2">
                <?php echo !empty($_SESSION['success_message']) ? "Success!" : "Error!"; ?>
            </h2>
            <p class="text-sm">
                <?php echo !empty($_SESSION['success_message']) ? $_SESSION['success_message'] : $_SESSION['error_message']; ?>
            </p>
        </div>
        <script>
            const toaster = document.getElementById("toaster");
            toaster.style.bottom = "12px";
            setTimeout(() => {
                toaster.style.bottom = "0";
                toaster.style.right = "-100%";
            }, 3000);
        </script>

        <?php unset($_SESSION['success_message']); ?>
        <?php unset($_SESSION['error_message']); ?>

    <?php endif; ?>




    <script>
        function updateFileName() {
            var input = document.getElementById('patient-file-upload');
            var fileName = document.getElementById('file-name');
            if (input.files.length > 0) {
                fileName.textContent = input.files[0].name;
            }
        }
    </script>
</body>

</html>