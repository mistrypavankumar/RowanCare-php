<?php
function stickyNavbar()
{
    ?>

    <?php
    $page = basename($_SERVER['REQUEST_URI']);
    ?>
    <div class="py-4 w-full fixed top-0 z-50">
        <div class="flex items-center w-[92%] md:w-[85%] mx-auto py-2 justify-between">
            <a href="index.php" class="w-[180px] cursor-pointer">
                <img class="w-full" src="./assets/logo/Rowancare-logo.png" alt="">
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

                <!-- Register and Login Buttons -->
                <a href="register.php"
                    class="px-7 text-black/80 bg-white hover:scale-105 duration-300 py-2 rounded-md font-medium border-[1.5px] border-black/20 cursor-pointer">
                    Register
                </a>

                <a href="login.php"
                    class="px-7 bg-[#0D57E3]/90 hover:bg-[#0D57E3] hover:scale-105 duration-300 text-white py-2 rounded-md font-medium cursor-pointer">
                    Login
                </a>
            </div>


            <!-- Mobile view navbar -->
            <div class="hidden border-r-2 bg-white absolute top-0 left-0 w-[75%] h-screen p-5 flex flex-col md:hidden">
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

                    <div class="flex flex-col gap-5">
                        <a class="px-7 bg-transparent text-center border-2 border-[#0D57E3]/50 duration-300 text-[#0D57E3] py-2 rounded-md font-medium cursor-pointer"
                            href="contactus.php">Register</a>

                        <a class="px-7 bg-[#0D57E3]/90 text-center hover:bg-[#0D57E3] duration-300 text-white py-2 rounded-md font-medium cursor-pointer"
                            href="contactus.php">Login</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php
}
?>