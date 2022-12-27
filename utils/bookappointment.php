<?php

include("./db.php");
include("./functions.php");

$logged_in_student = check_student_login($con);

$error_msg = "";
if (isset($_SERVER["REQUEST_METHOD"]) == "POST") {
    $appointment_DOW = $_POST["appointmentDOW"];
    $appointment_date = $_POST["appointmentDate"];
    $appointment_time = $_POST["appointmentTime"];
    $student_message = $_POST["student-message"];
    $index = $_POST["index"];

    $supervisorID = $_POST["student_supervisor"];
    $student_id = $_POST["student_id"];

    $sql = "SELECT availabilitydetails FROM supervisors WHERE supervisorid = '$supervisorID' limit 1";
    $res = mysqli_query($con, $sql);

    if (mysqli_num_rows($res) > 0) {
        $result = mysqli_fetch_array($res);
        $availabilityDetails = json_decode($result[0]);
    }

    if (!empty($appointment_date) && !empty($appointment_time) && !empty($student_message) && !empty($appointment_DOW)) {
        // save appointment to database
        $availabilityDetails[$index]->availableSlots -= 1;
        $encodedAvailabilityDetails = json_encode($availabilityDetails);

        $appointment_id = random_id();
        $query = "INSERT INTO appointments (appointmentid, studentid, supervisorid, appointmentdate, appointmenttime, studentmessage, appointmentstatus) VALUES ('$appointment_id', '$student_id', '$supervisorID', '$appointment_date','$appointment_time', '$student_message', 'Pending')";

        mysqli_query($con, $query);

        $updateQuery = "UPDATE supervisors SET availabilitydetails = '$encodedAvailabilityDetails' WHERE supervisorid = '$supervisorID'";
        mysqli_query($con, $updateQuery);

        header("Location: ../student/profile/profile.php");
        exit();
    } else {
        $error_msg = "error=wronginput";
        header("Location: ../student/profile/profile.php?$error_msg");
        exit();
    }
}
