<?php

include 'db_connection.php';
require "constants/data.php";
require "components/getUserType.php";
require "components/functions.php";
require 'components/doctorCard.php';

$specializaitons = getAllSpecializations($conn);
$getAllDoctors = getAllDoctors($conn);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $selectedGenders = $_POST['gender'] ?? "";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Appointment";
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
        banner(title: "Book Appointment", path: "Appointment");
        ?>

        <div class="w-[92%] md:w-[90%] mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-9 my-20 gap-4">
                <div class="border-2 h-fit col-span-9 md:col-span-2 rounded-lg">
                    <p class="text-xl py-3 px-4 font-medium border-b-2">Search Filter</p>
                    <form action="book-appointment.php" method="post" class="px-4 py-3">
                        <div>
                            <h2 class="font-medium mb-2">Gender</h2>
                            <div class="form-checkbox">
                                <input type="checkbox" id="genderMale" name="gender" value="male" class="hidden" />
                                <label for="genderMale" class="text-gray-700 flex items-center cursor-pointer">
                                    <span class="w-4 h-4 inline-block mr-2 rounded border border-gray-400"></span>
                                    Male Doctor
                                </label>
                            </div>
                            <div class="form-checkbox">
                                <input type="checkbox" id="genderFemale" name="gender" value="female" class="hidden" />
                                <label for="genderFemale" class="text-gray-700 flex items-center cursor-pointer">
                                    <span class="w-4 h-4 inline-block mr-2 rounded border border-gray-400"></span>
                                    Female Doctor
                                </label>
                            </div>
                        </div>
                        <div class="my-4">
                            <h2 class="font-medium mb-3">Select Specialist</h2>
                            <div>
                                <?php foreach ($specializaitons as $sp) : ?>
                                    <div class="form-checkbox">
                                        <input type="checkbox" id="<?php echo $sp['name'] ?>" name="specialization" value="<?php echo $sp['name'] ?>" class="hidden" <?php echo $sp['specializationId'] == 1 ? "checked" : "" ?> />
                                        <label for="<?php echo $sp['name']; ?>" class="flex items-center cursor-pointer text-gray-700">
                                            <span class="w-4 h-4 inline-block mr-2 rounded border border-gray-400"></span>
                                            <?php echo $sp['name'] ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="row-span-2 bg-red-50">
                            <button class="text-center bg-[#0D57E3] hover:bg-[#0a43b0] duration-500 text-white w-full py-2 rounded-md outline-none border-none cursor-pointer flex items-center justify-center font-medium" type="submit">Search</button>
                        </div>
                    </form>
                </div>
                <div class="grid col-span-9 md:col-span-7 gap-4">
                    <?php foreach ($getAllDoctors as $doctor) : ?>
                        <?php if (!empty($doctor["state"]) && !empty($doctor['country'])) : ?>
                            <?php echo doctorCard(doctorData: $doctor, firstLetters: getFirstLetter($doctor['firstName']), color: $color) ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
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