<?php

include("./db.php");
include("./functions.php");

$supervisor_data = check_supervisor_login($con);
$supervisor_id = $supervisor_data["supervisorid"];

$error_msg = "";
if (isset($_SERVER["REQUEST_METHOD"]) == "POST") {
    $detailIndex = $_POST['detailIndex'];

    $availableDetailsQuery = "SELECT availabilitydetails from supervisors WHERE supervisorid = '$supervisor_id' limit 1";
    $detailsRes = mysqli_query($con, $availableDetailsQuery);
    $detailsResult = mysqli_fetch_array($detailsRes);
    $detailsResult = $detailsResult[0];
    $detailsResult = json_decode($detailsResult);

    unset($detailsResult[$detailIndex]);
    $detailsResult = array_values($detailsResult);

    $detailsResult = json_encode($detailsResult);

    // save to database
    $scheduleQuery = "UPDATE supervisors SET availabilitydetails = '$detailsResult' WHERE supervisorid = '$supervisor_id'";
    mysqli_query($con, $scheduleQuery);

    header("Location: ../../supervisor/schedule/schedule.php");
    exit();
} else {
    $error_msg = "Some error occurred";
    header("Location: ../../supervisor/schedule/schedule.php?error=$error_msg");
    exit();
}
