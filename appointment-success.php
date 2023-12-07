<?php
include 'db_connection.php';

$orderId = $_GET['orderId'];

if (empty($orderId)) {
    header("Location: page-not-found.php");
    return;
} else {
    $apt = getAppointmentByOrderId($conn, $orderId);
    $doctor = getDoctorDetailsById($conn, $apt['doctorId']);

    $apptDate = date('d M Y', strtotime($apt['appointmentDate']));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $pageTitle = "RowanCare | Checkout";
    require_once "components/header.php";
    ?>

    <style>
        #booking__container {
            width: 100%;
            height: auto;
            display: grid;
            place-items: center;
            padding: 5rem 0;
        }

        #booking__success__container {
            border: 2px solid rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            width: 40%;
            min-width: 350px;
            margin: 0 auto;
            padding: 3rem 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        #booking__success__container>h2 {
            font-size: 24px;
            font-weight: 600;
            text-align: center;
        }
    </style>
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

        <div id="booking__container">
            <div id="booking__success__container">
                <i class="fa fa-check-circle text-6xl text-green-500" aria-hidden="true"></i>
                <h2>Appointment booked Successfully!</h2>
                <p>Appointment booked with <b>Dr.<?php echo $doctor['firstName'] . " " . $doctor['lastName'] ?></b></p>
                <p>on <b><?php echo  $apptDate . " " . $apt['appointmentTime'] ?></b></p>
                <a class="mt-7 text-center bg-[#0D57E3] hover:bg-[#0a43b0] duration-500 text-white px-10 py-3 rounded-md outline-none border-none cursor-pointer flex items-center w-fit justify-center font-medium" href="patient-dashboard.php">View Appointments</a>
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