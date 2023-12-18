<?php

include 'db_connection.php';
require "constants/data.php";
require "components/getUserType.php";
require_once 'components/functions.php';

$result = getUserType();

if (isset($_COOKIE['rowanCarepatient'])) {
    $userIdentifier = $_COOKIE['rowanCarepatient'];
    $userData = getUserData($conn, $userIdentifier, $result['userType']);
    $patientProfile = getProfileImage($conn, $userData['patientId'], "patient");
    $patientInvoices = getInvoicesById($conn, $userData['patientId'], 'patient');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Invoices";
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
        banner(title: "Invoices", path: "Doctor Invoices");
        ?>
        <div class="w-[85%] mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-9 my-20 gap-4">
                <?php
                require_once "components/dashboard-navigation.php";
                dashboardNavigation($conn, $userData, $patientDashboardNav, $color, $result['userType'], profileImage: $patientProfile['imagePath'] ?? "");
                ?>
                <div class="col-span-9 md:col-span-7">
                    <div class="border-2 rounded-lg p-5">
                        <div>
                            <h3 class="text-xl font-bold mb-4">Invoices</h3>

                            <div class="h-[77vh] overflow-y-auto">
                                <table class="w-full py-2">
                                    <thead class="sticky top-0 bg-white">
                                        <tr class="py-2 border-b-2">
                                            <th class="py-3 text-left">Invoice No</th>
                                            <th class="text-left">Doctor</th>
                                            <th class="text-left">Amount</th>
                                            <th class="text-left">Paid On</th>
                                            <th class="text-left">Action</th>
                                        </tr>
                                    </thead>

                                    <?php foreach ($patientInvoices as $invoice) {

                                        $doctorData = getUserDataByUserId($conn, $invoice['doctorId'], 'doctor')[0];
                                        $profileImage = getProfileImage($conn, $invoice['doctorId'], "doctor");
                                        $res = $invoice['paid_on'];
                                        $paidOn = date('d M Y', strtotime($res));
                                    ?>
                                        <tr class="py-2 border-b-2 last:border-b-0 hover:bg-gray-100 duration-500">
                                            <td>
                                                <p>#INV-00<?php echo $invoice['invoiceId'] ?></p>
                                            </td>
                                            <td class="py-3">
                                                <a href="#" class="flex gap-3 items-center">
                                                    <?php if (empty($profileImage['imagePath'])) : ?>
                                                        <div class="w-[40px] h-[40px] rounded-full bg-gray-200 flex items-center justify-center">
                                                            <p class="font-semibold text-gray-500"><?php echo getFirstLetter($doctorData['firstName']) ?></p>
                                                        </div>
                                                    <?php else : ?>
                                                        <img class="w-[40px] h-[40px] rounded-full object-cover" src="<?php echo $profileImage['imagePath'] ?>" alt="profile">
                                                    <?php endif ?>
                                                    <div>
                                                        <p class="text-[15px]"> <?php echo  $doctorData['firstName'] . " " . $doctorData['lastName'] ?>
                                                        </p>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>$<?php echo $invoice['amount'] ?></td>
                                            <td><?php echo $paidOn ?></td>
                                            <td>
                                                <?php if ($invoice['status'] == "Refunded") : ?>
                                                    <button disabled class="w-fit px-2 py-1 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg duration-500">Refunded</button>
                                                <?php else : ?>
                                                    <button disabled class="w-fit px-2 py-1 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg duration-500">Paid</button>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!-- footer -->
    <?php
    require_once "components/footer.php";
    footer();
    ?>


</body>

</html>