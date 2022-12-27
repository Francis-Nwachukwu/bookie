<?php
// session_start();

include("./db.php");
include("./functions.php");


$error_msg = "";
if (isset($_POST["student-updating"])) {

    // =========== sign up ====================

    $firstname = test_input($_POST["studentFirstname"]);
    $lastname = test_input($_POST["studentLastname"]);
    $email = test_input($_POST["studentEmail"]);
    $department = test_input($_POST["studentDepartment"]);
    $student_id = test_input($_POST["student_id"]);

    $img_name = $_FILES["studentImage"]["name"];
    $img_size = $_FILES["studentImage"]["size"];
    $tmp_name = $_FILES["studentImage"]["tmp_name"];
    $error = $_FILES["studentImage"]["error"];

    if ($error === 0) {
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);

        $allowed_exs = array("jpg", "jpeg", "png");
        if (in_array($img_ex_lc, $allowed_exs)) {
            $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
            $img_upload_path = "../uploads/" . $new_img_name;
            move_uploaded_file($tmp_name, $img_upload_path);
            // exit();
        } else {
            $error_msg = "type=unknown";
            header("Location: ../student/home/home.php?$error_msg");
            exit();
        }
    } else {
        $error_msg = "imageupload=unknownerror";
        header("Location: ../student/home/home.php?$error_msg");
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "invalid=email";
        header("Location: ../student/home/home.php?$error_msg");
        exit();
    }

    if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($department)) {
        $password = password_hash($password, PASSWORD_BCRYPT);
        // save to database
        $query = "UPDATE students SET firstname = '$firstname', lastname = '$lastname', email = '$email', department = '$department', studentimage = '$new_img_name' WHERE studentid = '$student_id'";

        mysqli_query($con, $query);
        $_SESSION['user_id'] = $student_id;
        header("Location: ../student/home/home.php");
        // die;

    } else {
        $error_msg = "error=wronginput";
        header("Location: ../student/home/home.php?$error_msg");
        exit();
    }
}
