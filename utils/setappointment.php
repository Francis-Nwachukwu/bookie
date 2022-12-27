<?php

include("./db.php");
include("./functions.php");

$supervisor_data = check_supervisor_login($con);
$supervisor_id = $supervisor_data["supervisorid"];

$error_msg = "";
if (isset($_SERVER["REQUEST_METHOD"]) == "POST") {
    $availableDate = $_POST['availableDate'];
    $availableTime = $_POST['availableTime'];
    $maximumStudents = $_POST['maximum-students'];
    $availableDOW = $_POST['availableDOW'];

    // print_r($_POST);

    // $availabilityDetails = array();

    class scheduleOBJ
    {
        public $availableDate;
        public $availableTime;
        public $maximumStudents;
        public $availableSlots;
        public $availableDOW;

        function __construct($availableDate, $availableTime, $maximumStudents, $availableDOW)
        {
            $this->availableDate = $availableDate;
            $this->availableTime = $availableTime;
            $this->maximumStudents = $maximumStudents;
            $this->availableSlots = $maximumStudents;
            $this->availableDOW = $availableDOW;
        }
    }

    $scheduleInstance = new scheduleOBJ($availableDate, $availableTime, $maximumStudents, $availableDOW);

    $availableDetailsQuery = "SELECT availabilitydetails from supervisors WHERE supervisorid = '$supervisor_id' limit 1";
    $detailsRes = mysqli_query($con, $availableDetailsQuery);
    if ($detailsRes && mysqli_num_rows($detailsRes) > 0) {
        $detailsResult = mysqli_fetch_array($detailsRes);
        $detailsResult = $detailsResult[0];
        $detailsResult = json_decode($detailsResult);
        array_push($detailsResult, $scheduleInstance);
        $scheduleToBeAdded = json_encode($detailsResult);

        // save to database
        $scheduleQuery = "UPDATE supervisors SET availabilitydetails = '$scheduleToBeAdded' WHERE supervisorid = '$supervisor_id'";
        mysqli_query($con, $scheduleQuery);

        header("Location: ../../supervisor/schedule/schedule.php");
        exit();
    } else {
        // $jsonOBJ = new scheduleOBJ("date", "time", 4, 4);
        // $jsonArray = array($jsonOBJ);
        // $newjson = json_encode($jsonArray);
        $detailsResult = array();
        array_push($detailsResult, $scheduleInstance);
        $scheduleToBeAdded = json_encode($detailsResult);

        // save to database
        $scheduleQuery = "UPDATE supervisors SET availabilitydetails = '$scheduleToBeAdded' WHERE supervisorid = '$supervisor_id'";
        mysqli_query($con, $scheduleQuery);

        header("Location: ../../supervisor/schedule/schedule.php");
        exit();
    }
} else {
    $error_msg = "Some error occurred";
    header("Location: ../../supervisor/schedule/schedule.php?error=$error_msg");
    exit();
}
