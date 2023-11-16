<?php
include 'db_connection.php';


$errorMessage = "";
$email = "";

//  Handling login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (!empty($email) && !empty($password)) {
        $isLoginSuccess = loginUser($conn, $email, $password);

        if ($isLoginSuccess) {
            $successMessage = "Successfully Logged In";
        } else {
            $errorMessage = "Invalid email or password.";
        }
    } else {
        $errorMessage = "X Please fill all the fields X";
    }
}


require_once "components/navbar.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Login";
    require_once "components/header.php"
        ?>
</head>

<body>
    <!-- navbar -->
    <?php
    stickyNavbar()
        ?>




    <div class="h-screen flex items-center w-[92%] md:w-[85%] mx-auto mt-5">
        <div class="hidden md:block w-[70%]">
            <img src="./assets/images/loginImg.png" alt="reg-img">
        </div>
        <div class="bg-white w-full md:w-1/2 px-5 md:px-7 pt-5 pb-7 border-2 rounded-md">

            <?php
            if (!empty($errorMessage)) {
                ?>

                <p class="bg-red-500/20 p-2 rounded-md text-center text-red-500 font-semibold">
                    <?php echo $errorMessage; ?>
                </p>
            <?php }
            ?>

            <?php
            if (!empty($successMessage)) {
                ?>

                <p class="bg-green-500/20 p-2 rounded-md text-center text-green-500 font-semibold">
                    <?php echo $successMessage; ?>
                </p>
            <?php }
            ?>

            <div class="flex w-full justify-between py-5">
                <p class="font-semibold text-xl">Login RowanCare</p>
            </div>

            <?php $inputStyle = "border-2 p-3 rounded-md outline-none" ?>

            <form method="POST" action="login.php" class="flex flex-col gap-3 mt-5">
                <input class="<?php echo $inputStyle ?>" type="email" placeholder="Email" name="email"
                    value="<?php echo $email; ?>">
                <input class="<?php echo $inputStyle ?>" type="password" placeholder="Password" name="password">

                <a class="w-full flex justify-end font-semibold text-[#0D57E3]" href="forgot-password.php">Forgot
                    Password?</a>
                <button
                    class="font-semibold mt-3 bg-[#0D57E3] hover:bg-[#0a43b0] duration-500 text-white p-3 rounded-md">Login</button>

                <p class="mt-3 text-center font-semibold">Don't have an account? <a class=" text-[#0D57E3]"
                        href="register.php">Register</a></p>
            </form>

            <a href="logout.php">Logout</a>
        </div>
    </div>

    <!-- footer -->
    <?php
    require_once "components/footer.php";
    footer();
    ?>

</body>

</html>