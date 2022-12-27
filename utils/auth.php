<?php
// session_start();

include("./db.php");
include("./functions.php");


$error_msg = "";
if (isset($_POST["student-signing-up"])) {

  // =========== sign up ====================

  $firstname = test_input($_POST["studentFirstname"]);
  $lastname = test_input($_POST["studentLastname"]);
  $email = test_input($_POST["studentEmail"]);
  $department = test_input($_POST["studentDepartment"]);
  $password = test_input($_POST["studentPassword"]);
  $confirmpassword = test_input($_POST["studentConfirmPassword"]);
  $studentSupervisor = $_POST["studentSupervisor"];

  $img_name = $_FILES["studentImage"]["name"];
  $img_size = $_FILES["studentImage"]["size"];
  $tmp_name = $_FILES["studentImage"]["tmp_name"];
  $error = $_FILES["studentImage"]["error"];

  if ($password !== $confirmpassword) {
    $error_msg = "passwords=mismatch";
    header("Location: ../index/index.php?$error_msg");
    exit();
  }

  $checkExistingEmail = "SELECT * FROM students where email = '$email' limit 1";
  $queryResult = mysqli_query($con, $checkExistingEmail);
  if ($queryResult && mysqli_num_rows($queryResult) > 0) {
    $error_msg = "email=exists";
    header("Location: ../index/index.php?$error_msg");

    exit();
  }

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
      header("Location: ../index/index.php?$error_msg");
      exit();
    }
  } else {
    $error_msg = "imageupload=unknownerror";
    header("Location: ../index/index.php?$error_msg");
    exit();
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error_msg = "invalid=email";
    header("Location: ../index/index.php?$error_msg");
    exit();
  }

  if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password) && !empty($confirmpassword)) {
    $password = password_hash($password, PASSWORD_BCRYPT);
    // save to database
    $student_id = random_id();
    $query = "INSERT INTO students (studentid, firstname, lastname, email, department, password, studentimage, supervisor) VALUES ('$student_id', '$firstname','$lastname', '$email', '$department', '$password', '$new_img_name', '$studentSupervisor')";

    mysqli_query($con, $query);
    $_SESSION['user_id'] = $student_id;
    header("Location: ../student/home/home.php");
    // die;

  } else {
    $error_msg = "error=wronginput";
    header("Location: ../index/index.php?$error_msg");
    exit();
  }
} else if (isset($_POST["student-signing-in"])) {
  // ========== student login ==============

  $email = $_POST["studentEmail"];
  $password = $_POST["studentPassword"];

  if (!empty($email) && !empty($password)) {
    // read from database
    $query = "SELECT * FROM students where email='$email' limit 1";

    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      $user_data = mysqli_fetch_assoc($result);

      if (password_verify($password, $user_data["password"])) {
        $_SESSION['user_id'] = $user_data['studentid'];
        header("Location: ../student/profile/profile.php");
        // die;
      } else {
        $error_msg = "error=incorrect";
        header("Location: ../index/index.php?$error_msg");
        exit();
      }
    } else {
      $error_msg = "error=incorrect";
      header("Location: ../index/index.php?$error_msg");
      exit();
    }
  }
} else if (isset($_POST["supervisor-signing-up"])) {
  // ========== supervisor signup =================

  $firstname = test_input($_POST["supervisorFirstname"]);
  $lastname = test_input($_POST["supervisorLastname"]);
  $email = test_input($_POST["supervisorEmail"]);
  $password = test_input($_POST["supervisorPassword"]);
  $confirmpassword = test_input($_POST["supervisorConfirmPassword"]);
  $img_name = $_FILES["supervisorImage"]["name"];
  $img_size = $_FILES["supervisorImage"]["size"];
  $tmp_name = $_FILES["supervisorImage"]["tmp_name"];
  $error = $_FILES["supervisorImage"]["error"];

  print_r($error);

  if ($password !== $confirmpassword) {
    $error_msg = "passwords=mismatch";
    header("Location: ../index/index.php?$error_msg");
    exit();
  }

  $checkExistingEmail = "SELECT * FROM supervisors where email = '$email' limit 1";
  $queryResult = mysqli_query($con, $checkExistingEmail);
  if ($queryResult && mysqli_num_rows($queryResult) > 0) {
    $error_msg = "email=exists";
    header("Location: ../index/index.php?$error_msg");
    exit();
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error_msg = "invalid=email";
    header("Location: ../index/index.php?$error_msg");
    exit();
  }
  if ($error === 0) {
    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_ex_lc = strtolower($img_ex);

    $allowed_exs = array("jpg", "jpeg", "png");
    if (in_array($img_ex_lc, $allowed_exs)) {
      $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
      $img_upload_path = "../uploads/" . $new_img_name;
      move_uploaded_file($tmp_name, $img_upload_path);
    } else {
      $error_msg = "type=unknown";
      header("Location: ../index/index.php?$error_msg");
      exit();
    }
  } else {
    $error_msg = "imageupload=unknownerror";
    header("Location: ../index/index.php?$error_msg");
    exit();
  }


  if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password) && !empty($confirmpassword)) {
    $password = password_hash($password, PASSWORD_BCRYPT);
    // save to database
    $supervisor_id = random_id();
    $query = "INSERT INTO supervisors (supervisorid, firstname, lastname, email, password, supervisorimage) VALUES ('$supervisor_id', '$firstname','$lastname', '$email','$password', '$new_img_name')";

    mysqli_query($con, $query);
    $_SESSION['user_id'] = $supervisor_id;
    header("Location: ../supervisor/dashboard/dashboard.php");
    // die;

  } else {
    $error_msg = "error=wronginput";
    header("Location: ../index/index.php?$error_msg");
    exit();
  }
} else if (isset($_POST["supervisor-signing-in"])) {
  // ============== supervisor login ===============

  $email = $_POST["supervisorEmail"];
  $password = $_POST["supervisorPassword"];

  if (!empty($email) && !empty($password)) {
    // read from database
    $query = "SELECT * FROM Supervisors where email='$email' limit 1";

    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      $user_data = mysqli_fetch_assoc($result);

      if (password_verify($password, $user_data["password"])) {
        $_SESSION['user_id'] = $user_data['supervisorid'];
        header("Location: ../supervisor/dashboard/dashboard.php");
        exit();
        // die;
      } else {
        $error_msg = "error=incorrect";
        header("Location: ../index/index.php?$error_msg");
        exit();
      }
    } else {
      $error_msg = "error=incorrect";
      header("Location: ../index/index.php?$error_msg");
      exit();
    }
  }
}
