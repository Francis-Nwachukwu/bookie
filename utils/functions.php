<?php

session_start();



function check_student_login($con)
{
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $queryStudent = "SELECT * FROM students WHERE studentid = '$id' limit 1";

        $studentResult = mysqli_query($con, $queryStudent);
        if ($studentResult && mysqli_num_rows($studentResult) > 0) {
            $student_data = mysqli_fetch_assoc($studentResult);
            return $student_data;
        }
    }
    // redirect to login page
    header("Location: ../index/index.php");
    die;
}
function check_supervisor_login($con)
{
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $querySupervisor = "SELECT * FROM supervisors WHERE supervisorid = '$id' limit 1";

        $supervisorResult = mysqli_query($con, $querySupervisor);
        if ($supervisorResult && mysqli_num_rows($supervisorResult) > 0) {
            $supervisor_data = mysqli_fetch_assoc($supervisorResult);
            return $supervisor_data;
        }
    }
    // redirect to login page
    header("Location: ../index/index.php");
    die;
}
function getSupervisor($con, $id)
{
    $querySupervisor = "SELECT * FROM supervisors WHERE supervisorid = '$id' limit 1";

    $supervisorResult = mysqli_query($con, $querySupervisor);
    if ($supervisorResult && mysqli_num_rows($supervisorResult) > 0) {
        $supervisor_data = mysqli_fetch_assoc($supervisorResult);
        return $supervisor_data;
    }
}
// function getAllSupervisor($con)
// {
//     $queryAllSupervisor = "SELECT * FROM supervisors";

//     $AllSupervisorResult = mysqli_query($con, $queryAllSupervisor);
//     if ($supervisorResult && mysqli_num_rows($supervisorResult) > 0) {
//         $supervisor_data = mysqli_fetch_assoc($supervisorResult);
//         return $supervisor_data;
//     }
// }
function getStudent($con, $id)
{
    $queryStudent = "SELECT * FROM Students WHERE studentid = '$id' limit 1";

    $studentResult = mysqli_query($con, $queryStudent);
    if ($studentResult && mysqli_num_rows($studentResult) > 0) {
        $studentData = mysqli_fetch_assoc($studentResult);
        return $studentData;
    }
}

function getStudentAppointment($con)
{
    $student_data = check_student_login($con);
    $student_id = $student_data['studentid'];

    $appointmentQuery = "SELECT * FROM appointments where studentid = '$student_id' limit 1";

    $appointmentResult = mysqli_query($con, $appointmentQuery);
    if ($appointmentResult && mysqli_num_rows($appointmentResult) > 0) {
        $appointment_data = mysqli_fetch_assoc($appointmentResult);
        return $appointment_data;
    }
}
function getAllAppointment($con)
{
    $allAppointmentQuery = "SELECT * FROM appointments";

    $allResult = mysqli_query($con, $allAppointmentQuery);
    if ($allResult && mysqli_num_rows($allResult) > 0) {
        $allAppointment_data = mysqli_fetch_assoc($allResult);
        return $allAppointment_data;
    }
}
function getAllAppointmentNum($con)
{
    $allAppointmentQuery = "SELECT * FROM appointments";

    $allResult = mysqli_query($con, $allAppointmentQuery);
    $count = mysqli_num_rows($allResult);
    return $count;
}
function getPendingAppointment($con)
{
    $pendingAppointmentQuery = "SELECT * FROM appointments where appointmentstatus = 'Pending'";

    $pendingResult = mysqli_query($con, $pendingAppointmentQuery);
    if ($pendingResult && mysqli_num_rows($pendingResult) > 0) {
        $pendingAppointment_data = mysqli_fetch_assoc($pendingResult);
        return $pendingAppointment_data;
    }
}
function getPendingAppointmentNum($con)
{
    $pendingAppointmentQuery = "SELECT * FROM appointments where appointmentstatus = 'Pending'";

    $pendingResult = mysqli_query($con, $pendingAppointmentQuery);
    $count = mysqli_num_rows($pendingResult);
    return $count;
}
function getApprovedAppointment($con)
{

    $appointmentQuery = "SELECT * FROM appointments where appointmentstatus = 'Approved'";

    $appointmentResult = mysqli_query($con, $appointmentQuery);
    if ($appointmentResult && mysqli_num_rows($appointmentResult) > 0) {
        $appointment_data = mysqli_fetch_assoc($appointmentResult);
        return $appointment_data;
    }
}
function getApprovedAppointmentNum($con)
{
    $pendingAppointmentQuery = "SELECT * FROM appointments where appointmentstatus = 'Approved'";

    $pendingResult = mysqli_query($con, $pendingAppointmentQuery);
    $count = mysqli_num_rows($pendingResult);
    return $count;
}
function getCancelledAppointment($con)
{

    $appointmentQuery = "SELECT * FROM appointments where appointmentstatus = 'Cancelled'";

    $appointmentResult = mysqli_query($con, $appointmentQuery);
    if ($appointmentResult && mysqli_num_rows($appointmentResult) > 0) {
        $appointment_data = mysqli_fetch_assoc($appointmentResult);
        return $appointment_data;
    }
}
function getCancelledAppointmentNum($con)
{
    $pendingAppointmentQuery = "SELECT * FROM appointments where appointmentstatus = 'Cancelled'";

    $pendingResult = mysqli_query($con, $pendingAppointmentQuery);
    $count = mysqli_num_rows($pendingResult);
    return $count;
}

function random_id()
{
    $text = "";

    for ($i = 0; $i < 10; $i++) {
        $text .= rand(0, 9);
    }
    return $text;
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
