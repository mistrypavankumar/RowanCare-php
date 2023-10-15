<?php require "constants/data.php" ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RowanCare</title>

    <!-- Tailwind css -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Roboto Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-family: 'Roboto', sans-serif;
        }
    </style>

</head>

<body>
    <main>

        <!-- navbar -->
        <?php include "components/navbar.php" ?>

        <!-- banner -->
        <div class="h-screen w-full pt-24 md:pt-0 relative overflow-hidden">
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
                    <a class="text-center bg-[#0D57E3] text-white px-10 py-3 rounded-md outline-none border-none cursor-pointer flex items-center sm:w-fit justify-center font-medium"
                        href="pages/appointment.php">Get a
                        Appointment</a>
                </div>
                <div class="flex justify-center items-center">
                    <img class="w-[60%] md:w-[80%]" src="./assets/images/banner-img.png" alt="">
                </div>
            </div>
        </div>

        <!-- specialities -->
        <div class="h-screen w-full">
            <h1>Center</h1>
        </div>

        <!-- Best Doctors -->

        <!-- footer -->


    </main>
</body>

</html>