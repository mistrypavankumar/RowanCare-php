<?php

include '../db_connection.php';
require "../components/functions.php";
require '../components/doctorCard.php';
require "../constants/data.php";


function getDoctorList($conn, $genderList, $specializationList)
{
    $sql = "CALL GetMaleDoctorsOrSpecialization(?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $genderList, $specializationList);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_all();
    return $result;
}

if (!empty($_POST['GENDERS']) || !empty($_POST['SPECIALIZATIONS'])) {
    $genderList = json_decode($_POST['GENDERS']);
    $specializationList = json_decode($_POST['SPECIALIZATIONS']);

    // Convert arrays to strings
    $genderString = $genderList ? "'" . implode("', '", $genderList) . "'" : '';
    $specializationString = $specializationList ? "'" . implode("', '", $specializationList) . "'" : '';

    $doctorList = getDoctorList($conn, $genderString, $specializationString);

    // echo json_encode(getFirstLetter($doctorList[0][1]));


    foreach ($doctorList as $doctor) {
        $profileImage = getProfileImage($conn, $doctor[0], 'doctor');
        $doctorAddress = getAddress($conn, $doctor[0], 'doctor');
        $specializaiton = getDoctorSpecialization($conn, $doctor[0]);

        $doctorData = [
            'doctorId' => $doctor[0],
            'firstName' => $doctor[1],
            'lastName' => $doctor[2]
        ];


        if (!is_null($doctorData) && !empty($doctorAddress["state"]) && !empty($doctorAddress['country'])) {
            json_encode(doctorCard($doctorData, $specializaiton, $profileImage, $doctorAddress, firstLetters: getFirstLetter($doctor[1]), color: $color));
        } else {
            echo json_encode("<p>No Result Found.!<p>");
        }
    }
}
