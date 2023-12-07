<?php
function stickyNavbar($isLoggedIn = false, $logoPath = "./assets/logo/Rowancare-logo.png")
{
?>

    <?php
    $page = basename($_SERVER['REQUEST_URI']);

    $uesrType = "";

    // Check if the login cookie exists
    if (isset($_COOKIE['rowanCarepatient'])) {
        $uesrType = "patient";
        $isLoggedIn = true;
    } else if (isset($_COOKIE['rowanCaredoctor'])) {
        $isLoggedIn = true;
        $uesrType = "doctor";
    }

    ?>
    <div id="headerNavbar" class="py-4 w-full fixed top-0 z-[9999]">
        <div class="flex items-center w-[92%] md:w-[85%] mx-auto py-2 justify-between">
            <a href="index.php" class="w-[180px] cursor-pointer">
                <img class="w-full" src="<?php echo $logoPath ?>" alt="">
            </a>
            <div class="hidden md:flex items-center gap-10">
                <a class="
                        <?php
                        echo "text-[17px] duration-300 font-medium hover:text-[#0D57E3]";
                        echo $page == "index.php" ? " text-[#0D57E3]" : "";
                        ?>
                    " href="index.php">Home</a>

                <a class="<?php
                            echo "text-[17px] duration-300 font-medium hover:text-[#0D57E3]";
                            echo $page == "pharmacy.php" ? " text-[#0D57E3]" : "";
                            ?>" href="pharmacy.php">Pharmacy</a>

                <a class="<?php
                            echo "text-[17px] duration-300 font-medium hover:text-[#0D57E3]";
                            echo $page == "aboutus.php" ? " text-[#0D57E3]" : "";
                            ?>" href="aboutus.php">About Us</a>
                <a class="<?php
                            echo "text-[17px] duration-300 font-medium hover:text-[#0D57E3]";
                            echo $page == "contactus.php" ? " text-[#0D57E3]" : "";
                            ?>" href="contactus.php">Contact Us</a>

            </div>
            <div class="hidden md:flex gap-5">

                <?php
                if ($isLoggedIn) {
                    echo '
                    <a href="' . $uesrType . '-dashboard.php"
                        class="px-7 bg-[#0D57E3]/90 hover:bg-[#0D57E3] hover:scale-105 duration-300 text-white py-2 rounded-md font-medium cursor-pointer">
                        Dashboard
                    </a>';
                } else {
                    // Register and Login Buttons
                    echo '
                    <a href="register.php"
                        class="px-7 text-black/80 bg-white hover:scale-105 duration-300 py-2 rounded-md font-medium border-[1.5px] border-black/20 cursor-pointer">
                        Register
                    </a>
                    <a href="login.php"
                        class="px-7 bg-[#0D57E3]/90 hover:bg-[#0D57E3] hover:scale-105 duration-300 text-white py-2 rounded-md font-medium cursor-pointer">
                        Login
                    </a>';
                }

                ?>
            </div>
            <div id="idMenuBar" class="block md:hidden w-fit">
                <i class="fa fa-bars text-2xl text-[#0a43b0] hover:text-[#0D57E3] duration-300 cursor-pointer"></i>
            </div>

            <!-- Mobile view navbar -->
            <div id="mobileNavbar" class="md:hidden border-r-2 bg-white absolute translate-x-[-100%] top-0 left-0 w-[75%] h-screen p-5 flex flex-col">
                <a href="index.php" class="w-[180px] pt-4 pb-10  cursor-pointer">
                    <img class="w-full" src="./assets/logo/Rowancare-logo.png" alt="">
                </a>

                <div class="flex flex-col justify-between h-full">
                    <div class="flex flex-col">

                        <a class="
                        <?php
                        echo "hover:bg-[#0D57E3]/10 py-3 px-2 text-[17px] rounded-md duration-300 font-medium hover:text-[#0D57E3]";
                        echo $page == "index.php" ? " text-[#0D57E3]" : "";
                        ?>
                        " href="index.php">Home</a>

                        <a class="<?php
                                    echo "hover:bg-[#0D57E3]/10 py-3 px-2 text-[17px] rounded-md text-[17px] duration-300 font-medium hover:text-[#0D57E3]";
                                    echo $page == "pharmacy.php" ? " text-[#0D57E3]" : "";
                                    ?>" href="pharmacy.php">Pharmacy</a>

                        <a class="<?php
                                    echo "hover:bg-[#0D57E3]/10 py-3 px-2 text-[17px] rounded-md text-[17px] duration-300 font-medium hover:text-[#0D57E3]";
                                    echo $page == "aboutus.php" ? " text-[#0D57E3]" : "";
                                    ?>" href="aboutus.php">About Us</a>
                        <a class="<?php
                                    echo "hover:bg-[#0D57E3]/10 py-3 px-2 text-[17px] rounded-md text-[17px] duration-300 font-medium hover:text-[#0D57E3]";
                                    echo $page == "contactus.php" ? " text-[#0D57E3]" : "";
                                    ?>" href="contactus.php">Contact Us</a>
                    </div>

                    <?php
                    if ($isLoggedIn) {
                        echo '
                        <a href="login.php"
                            class="px-7 bg-[#0D57E3]/90 hover:bg-[#0D57E3] hover:scale-105 duration-300 text-white py-2 rounded-md text-center font-medium cursor-pointer">
                            Dashboard
                        </a>';
                    } else {
                        echo '
                            <div class="flex flex-col gap-5">
                            <a class="px-7 bg-transparent text-center border-2 border-[#0D57E3]/50 duration-300 text-[#0D57E3] py-2 rounded-md font-medium cursor-pointer"
                                href="register.php">Register</a>
                            <a class="px-7 bg-[#0D57E3]/90 text-center hover:bg-[#0D57E3] duration-300 text-white py-2 rounded-md font-medium cursor-pointer"
                                href="login.php">Login</a>
                        </div>
                            ';
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
<?php
}
?>