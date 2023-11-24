<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Page Not Found!";
    require_once "components/header.php";
    ?>
</head>

<body>
    <main class="w-screen h-screen flex items-center justify-center">
        <div class="w-[400px] md:w-[500px] flex flex-col items-center">
            <img src="assets/page-not-found.svg" alt=" page-not-found">
            <p><?php ?></p>
            <a class="text-center bg-[#0D57E3] hover:bg-[#0a43b0] duration-500   text-white px-10 py-3 rounded-md outline-none border-none cursor-pointer flex items-center sm:w-fit justify-center font-medium" href="index.php">Back to Home</a>
        </div>
    </main>
</body>

</html>