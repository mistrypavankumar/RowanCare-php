<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Checkout";
    require_once "components/header.php";
    ?>
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
        banner(title: "Booking", path: "Appointment Success");
        ?>

        <div>

        </div>
    </main>
</body>

</html>