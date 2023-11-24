<?php
function footer()
{
?>

    <div class="h-auto bg-[#F5F8FE] border-t-2 py-5">
        <div class="w-[92%] md:w-[85%] mx-auto flex flex-col md:flex-row py-7">
            <div class="w-full md:w-[30%]">
                <div class="w-[250px] pb-3">
                    <a href="index.php" class="w-[180px] cursor-pointer">
                        <img class="w-full" src="./assets/logo/Rowancare-logo.png" alt="">
                    </a>
                </div>
                <p class="text-gray-500 pr-7 mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus, culpa
                    voluptate.</p>
            </div>


            <div class="flex-col md:flex-row flex gap-7">

                <!-- style variables -->
                <?php
                $footerLinkStyle = "text-gray-500 mb-2 hover:text-[#0D57E3] duration-300 w-fit hover:translate-x-3 text-[15px]";
                $mainDivStyle = "flex flex-col w-1/2";
                $titleStyle = "text-xl font-semibold mb-2";

                $patientLinks = [
                    "Search for Doctors" => "search-appointment.php",
                    "Login" => "login.php",
                    "Register" => "register.php"
                ];

                $doctorLinks = [
                    "Appointments" => "#appointments",
                    "Chats" => "#chats",
                    "Login" => "login.php"
                ];

                require_once "components/functions.php";

                listOfFooterLinks("For Patients", $patientLinks, $mainDivStyle, $titleStyle, $footerLinkStyle);
                listOfFooterLinks("For Doctors", $doctorLinks, $mainDivStyle, $titleStyle, $footerLinkStyle);

                ?>

                <div class="flex flex-col pr-10">
                    <h2 class="text-xl font-semibold mb-2">Contact Us</h2>
                    <p class="text-gray-500 mb-2">
                        <i class="fa fa-map-marker"></i>
                        201 Mullica Hill Rd, Glassboro, NJ 08028
                    </p>
                    <p class="text-gray-500 mb-2">
                        <i class="fa fa-phone"></i>
                        +1 (856) 256-4000
                    </p>
                    <p class="text-gray-500 mb-2 flex items-center gap-2">
                        <i class="fa fa-envelope"></i>
                        rowancare@support.com
                    </p>
                </div>
            </div>
            <div>
                <div class="flex flex-col mt-5 md:mt-0">
                    <h2 class="text-xl font-semibold mb-2">Join Our Newsletter</h2>
                    <div class="flex items-center w-full mt-2">
                        <input class="outline-none py-3 px-2 w-full rounded-tl-md rounded-bl-md" type="email" placeholder="Enter Email">
                        <button class="bg-[#0D57E3] text-white py-3 px-2 rounded-tr-md rounded-br-md hover:bg-[#0a43b0] duration-300">Submit</button>
                    </div>
                    <div class="flex items-center gap-5 mt-5">
                        <a href="#">
                            <i class="fa fa-instagram text-gray-500 hover:text-[#0D57E3] cursor-pointer text-xl duration-300" aria-hidden="true"></i>
                        </a>
                        <a href="#">
                            <i class="fa fa-facebook text-gray-500 hover:text-[#0D57E3] cursor-pointer text-xl duration-300" aria-hidden="true"></i>
                        </a>
                        <a href="#">
                            <i class="fa fa-envelope text-gray-500 hover:text-[#0D57E3] cursor-pointer text-xl duration-300" aria-hidden="true"></i>
                        </a>
                        <a href="#">
                            <i class="fa fa-twitter text-gray-500 hover:text-[#0D57E3] cursor-pointer text-xl duration-300" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-t-2 w-[92%] md:w-[85%] mx-auto pt-7 pb-3 flex flex-col text-center gap-3 md:flex-row justify-between">
            <p class="text-gray-500 text-sm">Copyright © 2023 <span class="font-semibold text-black">Mistry Pavan
                    Kumar</span>. All
                Rights
                Reserved</p>
            <p class="text-gray-500 text-sm">Privacy | PolicyTerms and Conditions</p>
        </div>
    </div>

<?php } ?>