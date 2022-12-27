<?php

include("./db.php");
include("./functions.php");

$supervisor_id = check_supervisor_login($con);

$error_msg = "";
if (isset($_SERVER["REQUEST_METHOD"]) == "POST") {
    $student_id = $_POST['student_id'];
    $supervisor_message = $_POST['supervisor-message'];

    $student = getStudent($con, $student_id);

    $sendMessageQuery = "UPDATE students SET supervisormessage = '$supervisor_message' WHERE studentid = '$student_id'";
    mysqli_query($con, $sendMessageQuery);

    header("Location: ../supervisor/dashboard/dashboard.php");
    exit();
} else {
    $error_msg = "Some error occurred";
    header("Location: ../supervisor/dashboard/dashboard.php?error=error");
    exit();
}
