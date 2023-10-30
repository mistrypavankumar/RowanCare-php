<?php require "constants/data.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "components/header.php" ?>

</head>

<body>
    <main>

        <!-- navbar -->
        <?php
        require_once "components/navbar.php";
        stickyNavbar()
            ?>

        <!-- banner -->
        <div class="h-screen bg-[#F5F8FE] w-full pt-24 md:pt-0 relative overflow-hidden">
            <img class="w-full absolute" src="./assets/images/bg-design.png" alt="banner-bg-img">
            <div
                class="w-[92%] md:w-[85%] mx-auto flex flex-col md:flex-row justify-center items-center h-full gap-10 relative z-10">
                <div class="flex-col items-center">
                    <h1
                        class="text-3xl text-center sm:text-left sm:text-5xl w-full md:w-[75%] font-semibold pb-5 md:pb-7">
                        Consult
                        <span class="text-[#0D57E3]">Best
                            Doctors</span>
                        Your Nearby Location.
                    </h1>
                    <p class="pb-7 text-center sm:text-left text-[16px] text-black/70">Lorem ipsum dolor sit amet
                        consectetur adipisicing elit.
                    </p>

                    <!-- Appointment button -->
                    <a class="text-center bg-[#0D57E3] hover:bg-[#0a43b0] duration-500   text-white px-10 py-3 rounded-md outline-none border-none cursor-pointer flex items-center sm:w-fit justify-center font-medium"
                        href="appointment.php">Get a
                        Appointment</a>
                </div>
                <div class="flex justify-center items-center">
                    <img class="w-[60%] md:w-[80%]" src="./assets/images/banner-img.png" alt="">
                </div>
            </div>
        </div>

        <!-- specialities -->
        <div class="h-auto md:h-screen w-full bg-white">
            <div class="w-[92%] md:w-[85%] mx-auto py-14">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl md:text-4xl font-bold">Specialities</h1>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 py-10">
                    <?php
                    include 'components/specialitiesCard.php';

                    foreach ($specialities as $speciality) {
                        specialitiesCard($speciality['dark'], $speciality['light'], $speciality['name']);
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Best Doctors -->
        <div id="mobileNavbar" class="bg-[#F5F8FE] h-auto w-full relative overflow-hidden">
            <img class="w-full h-auto absolute z-10" src="./assets/images/banner-img1.png" alt="banner-bg-img">

            <div class="w-[92%] md:w-[85%] mx-auto py-14">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl md:text-4xl font-bold">Best Doctors</h1>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 py-10 gap-5 relative z-20">
                    <?php
                    include "components/bestDoctorCard.php";

                    bestDoctorCard();
                    bestDoctorCard();
                    bestDoctorCard();
                    bestDoctorCard();

                    ?>
                </div>
            </div>
        </div>

        <!-- footer -->
        <?php
        require_once "components/footer.php";
        footer();
        ?>
    </main>
</body>

</html>