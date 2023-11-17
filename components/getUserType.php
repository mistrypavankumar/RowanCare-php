<?php


function getUserType()
{
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

    return ["userType" => $userType, "isLoading" => $isLoading];
}

?>