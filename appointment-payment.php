<?php


if (empty($_GET['appointmentDate']) && empty($_GET['appointmentTime'] && empty($_GET['doctorId']))) {
    header("Location: page-not-found.php");
    return;
} else {
    $appointmentDate = $_GET['appointmentDate'];
    $appointmentTime = $_GET['appointmentTime'];
    $doctorId = $_GET['doctorId'];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>