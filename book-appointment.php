<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Appointment";
    require_once "components/header.php"
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
        banner(title: "Book Appointment", path: "Appointment");
        ?>

    </main>

    <!-- footer -->
    <?php
    require_once "components/footer.php";
    footer();
    ?>
</body>

</html>