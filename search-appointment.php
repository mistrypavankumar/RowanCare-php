<?php

include 'db_connection.php';
require "constants/data.php";
require "components/getUserType.php";
require "components/functions.php";
require 'components/doctorCard.php';

$specializaitons = getAllSpecializations($conn);
$getAllDoctors = getAllDoctors($conn);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Search Appointment";
    require_once "components/header.php";
    ?>

    <style>
        .form-checkbox input:checked+label span {
            background-color: transparent;
            border-color: #4c51bf;
            position: relative;
            display: hidden;
        }

        .form-checkbox input:checked+label span:after {
            content: "✔";
            color: #4c51bf;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <!-- navbar -->
    <?php
    require_once "components/navbar.php";
    stickyNavbar()
    ?>

    <main>
        <!-- Banner -->
        <?php
        require_once "components/banner.php";
        banner(title: "Search Appointment", path: "Search Appointment");
        ?>

        <div class="w-[92%] md:w-[90%] mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-9 my-20 gap-4">
                <div class="border-2 h-fit col-span-9 md:col-span-2 rounded-lg">
                    <p class="text-xl py-3 px-4 font-medium border-b-2">Search Filter</p>
                    <div id="searchForm" method="POST" class="px-4 py-3">

                        <input type="text" id="genders" name="genders" value="">
                        <input type="text" id="specializations" name="specializations" value="">
                        <div>
                            <h2 class="font-medium mb-2">Gender</h2>
                            <div class="form-checkbox">
                                <input type="checkbox" id="genderMale" name="gender" value="male" class="hidden" />
                                <label for="genderMale" class="text-gray-700 flex items-center cursor-pointer">
                                    <span id="maleCheck" class="w-4 h-4 inline-block mr-2 rounded border border-gray-400"></span>
                                    Male Doctor
                                </label>
                            </div>
                            <div class="form-checkbox">
                                <input type="checkbox" id="genderFemale" name="gender" value="female" class="hidden" />
                                <label for="genderFemale" class="text-gray-700 flex items-center cursor-pointer">
                                    <span id="femaleCheck" class="w-4 h-4 inline-block mr-2 rounded border border-gray-400"></span>
                                    Female Doctor
                                </label>
                            </div>
                        </div>
                        <div class="my-4">
                            <h2 class="font-medium mb-3">Select Specialist</h2>
                            <div>
                                <?php foreach ($specializaitons as $sp) : ?>
                                    <div class="form-checkbox">
                                        <input type="checkbox" id="<?php echo $sp['name'] ?>" name="specialization" value="<?php echo $sp['name'] ?>" class="hidden" />
                                        <label for="<?php echo $sp['name']; ?>" class="flex items-center cursor-pointer text-gray-700">
                                            <span class="w-4 h-4 inline-block mr-2 rounded border border-gray-400"></span>
                                            <?php echo $sp['name']; ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="beforeSearchItems" class="grid col-span-9 md:col-span-7 gap-4">
                    <?php foreach ($getAllDoctors as $doctor) {
                        $profileImage = getProfileImage($conn, $doctor['doctorId'], 'doctor');
                        $doctorAddress = getAddress($conn, $doctor['doctorId'], 'doctor');
                        $specializaiton = getDoctorSpecialization($conn, $doctor['doctorId']);

                        if (!empty($doctorAddress["state"]) && !empty($doctorAddress['country'])) {
                            doctorCard($doctor, $specializaiton, $profileImage, $doctorAddress, firstLetters: getFirstLetter($doctor['firstName']), color: $color);
                        }
                    }
                    ?>
                </div>

                <div id="seachedItems" class="grid col-span-9 md:col-span-7 gap-4">
                    <div id="searchDataRow" class="grid gap-4"></div>
                </div>
            </div>
        </div>

    </main>

    <!-- footer -->
    <?php
    require_once "components/footer.php";
    footer();
    ?>

    <script src="js/search.js?v=1"></script>
    <!-- <script>
        var checkedGenders = [];
        var checkedSpecialization = [];

        document.querySelectorAll("#genderMale, #genderFemale").forEach(function(element) {
            element.addEventListener('change', function() {
                var value = this.value;
                if (this.checked) {
                    checkedGenders.push("'" + value + "'");
                } else {
                    var formattedValue = "'" + value + "'";
                    var index = checkedGenders.indexOf(formattedValue);
                    if (index > -1) {
                        checkedGenders.splice(index, 1);
                    }
                }
            });
        });

        document.querySelectorAll("#Cardiology, #Neurology, #Pediatrics, #Orthopedics, #Dentist").forEach(function(element) {
            element.addEventListener('change', function() {
                var value = this.value;
                if (this.checked) {
                    checkedSpecialization.push("'" + value + "'");
                } else {
                    var formattedValue = "'" + value + "'";
                    var index = checkedSpecialization.indexOf(formattedValue);
                    if (index > -1) {
                        checkedSpecialization.splice(index, 1);
                    }
                }
            });
        });

        document.getElementById("searchDoctorsBtn").addEventListener("click", (e) => {
            e.preventDefault();
            const genders = document.getElementById("genders");
            genders.value = checkedGenders


            const specializations = document.getElementById("specializations");
            specializations.value = checkedSpecialization;

            if (checkedGenders.length === 0 && checkedSpecialization.length === 0) {
                alert("Please select at least one gender or specialization.");

            } else {
                document.getElementById("searchForm").submit();
                document.getElementById('beforeSearchItems').style.display = "none";
            }
        });
    </script> -->
</body>

</html>