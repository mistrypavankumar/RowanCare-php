<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Doctor";
    require_once "components/header.php"
        ?>
</head>

<body>
    <?php require_once "components/navbar.php";
    stickyNavbar()
        ?>


    <main>
        <!-- Banner -->
        <?php
        require_once "components/banner.php";
        banner(title: "Dashboard", path: "Doctor-Dashboard");
        ?>
        <a href="logout.php">Logout</a>
    </main>
</body>

</html>