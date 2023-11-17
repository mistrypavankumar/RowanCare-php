<?php

include 'db_connection.php';
require "constants/data.php";

// get current url path
$urlPath = $_SERVER['REQUEST_URI'];

// split the path into parts
$pathParts = explode("/", $urlPath);

// find the part of the path that contains "doctor" or "patient"
$desiredPath = "";
foreach ($pathParts as $part) {
    if (strpos($part, 'doctor') !== false || strpos($part, 'patient') !== false) {
        $desiredPath = $part;
        break;
    }
}

// extract the relevant role from the string
$userType = "";
$isLoading = true;

if ($desiredPath !== "") {
    $userType = explode("-", $desiredPath)[0];
    $isLoading = false;
} else {
    $isLoading = true; // role not found
}


?>


<?php
function dashboardNavLink($color, $label, $icon, $path)
{
    echo '
    <a class="py-3 px-4 cursor-pointer border-t-2 text-gray-500 hover:text-[' . $color['primary'] . ']
     " href="' . $path . '"> <i class="fa ' . $icon . ' mr-1" aria-hidden="true"></i>
    ' . $label . '</a>
    ';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Patient";
    require_once "components/header.php"
        ?>
</head>

<body>

    <?php
    if ($isLoading === false && $userType !== "") {

        // check weather user is present or not
        if (isset($_COOKIE['rowanCarepatient'])) {
            $userIdentifier = $_COOKIE['rowanCarepatient'];
            $userData = getUserData($conn, $userIdentifier, $userType);
        }

        ?>

        <?php require_once "components/navbar.php";
        stickyNavbar()
            ?>


        <main>
            <!-- Banner -->
            <?php
            require_once "components/banner.php";
            banner(title: "Dashboard", path: "Patient-Dashboard");
            ?>

            <div class="w-[85%] mx-auto">
                <div class="grid grid-cols-1  md:grid-cols-9 my-20">
                    <div class="col-span-2 bg-white border-2 rounded-lg">
                        <div class="flex w-full items-center justify-center py-10 flex-col space-y-2">
                            <div class="bg-gray-100 w-[150px] h-[150px] rounded-full p-2 flex items-center">
                                <div class="rounded-full bg-red-500 overflow-hidden flex items-center">
                                    <img class="w-full h-full object-cover" src="<?php echo $bestDoctors[3]["image"] ?>"
                                        alt="profile-image">
                                </div>
                            </div>
                            <h2 class="font-semibold">
                                <?php echo $userData['firstName'] . " " . $userData['lastName'] ?>
                            </h2>
                            <p class="text-xs text-gray-500">BDS, MDS - Oral & Maxillofacial Surgery</p>
                        </div>
                        <div class="flex flex-col">
                            <?php
                            foreach ($patientDashboardNav as $menu) {
                                dashboardNavLink(color: $color, label: $menu['label'], icon: $menu['icon'], path: $menu['path']);
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-span-7 bg-red-500 border-white border-2">

                    </div>
                </div>
            </div>

        </main>

        <?php
    } else {
        echo "loading..." . $userType . $userIdentifier;

    }
    ?>
</body>

</html>