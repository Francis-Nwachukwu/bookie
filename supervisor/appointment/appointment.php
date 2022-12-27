<?php
include("../../utils/db.php");
include("../../utils/functions.php");

$supervisor_data = check_supervisor_login($con);
?>

<?php

$appointmentID = $_GET["appointmentID"];
$query = "SELECT * FROM appointments WHERE appointmentid = '$appointmentID'";
$res = mysqli_query($con, $query);
$appointmentResult = mysqli_fetch_assoc($res);

$student_id = $appointmentResult["studentid"];
$stdQuery = "SELECT * from students where studentid = '$student_id'";
$stdRes = mysqli_query($con, $stdQuery);
$stdResult = mysqli_fetch_assoc($stdRes);

?>



<?php include("../../includes/header.php") ?>
<title><?= $stdResult["firstname"] . " " . $stdResult["lastname"] ?> appointment</title>
<link rel="stylesheet" href="./appointment.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
</head>

<body>
    <div class="dashboard">
        <aside class="dashboard-sidebar">
            <div class="sidebar-list_container">
                <div class="profile-img_container">
                    <?php
                    $img_url = $supervisor_data["supervisorimage"];
                    ?>
                    <img src="../../uploads/<?= $img_url ?>" alt="Supervisor profile image">
                </div>
                <ul class="sidebar-list">
                    <li class="sidebar-list_item active">
                        <a href="../dashboard/dashboard.php">
                            <div class="item-link">
                                <i class="bi bi-card-list"></i>Appointments
                            </div>
                        </a>
                    </li>
                    <li class="sidebar-list_item">
                        <a href="../schedule/schedule.php">
                            <div class="item-link">
                                <i class="bi bi-calendar-check"></i>Schedules
                            </div>
                        </a>
                    </li>
                    <li class="sidebar-list_item">
                        <a href="../messages/messages.php">
                            <div class="item-link">
                                <i class="bi bi-envelope-check-fill"></i>Messages
                            </div>
                        </a>
                    </li>
                    <li class="sidebar-list_item">
                        <a href="../../utils/logout.php">
                            <div class="item-link">
                                <i class="bi bi-box-arrow-in-left"></i>Logout
                            </div>
                        </a>
                    </li>
                </ul>

            </div>
        </aside>
        <aside class="mobile_sidebar hidden">
            <div class="sidebar-list_container">
                <div class="profile-img_container">
                    <?php
                    $img_url = $supervisor_data["supervisorimage"];
                    ?>
                    <img src="../../uploads/<?= $img_url ?>" alt="Supervisor profile image">
                </div>
                <ul class="sidebar-list">
                    <li class="sidebar-list_item active">
                        <a href="../dashboard/dashboard.php">
                            <div class="item-link">
                                <i class="bi bi-card-list"></i>Appointments
                            </div>
                        </a>
                    </li>
                    <li class="sidebar-list_item">
                        <a href="../schedule/schedule.php">
                            <div class="item-link">
                                <i class="bi bi-calendar-check"></i>Schedules
                            </div>
                        </a>
                    </li>
                    <li class="sidebar-list_item">
                        <a href="../messages/messages.php">
                            <div class="item-link">
                                <i class="bi bi-envelope-check-fill"></i>Messages
                            </div>
                        </a>
                    </li>
                    <li class="sidebar-list_item">
                        <a href="../../utils/logout.php">
                            <div class="item-link">
                                <i class="bi bi-box-arrow-in-left"></i>Logout
                            </div>
                        </a>
                    </li>
                </ul>

            </div>
        </aside>

        <section class="appointment container">
            <nav class="dashboard-main_nav">
                <i class="bi bi-arrow-bar-right" style="font-size: 2rem;"></i>
                <div class="main-nav_header">
                    <h1 class="page-header"><?= $stdResult["firstname"] . " " . $stdResult["lastname"] ?></h1>
                </div>
                <div class="header-img_container">
                    <?php
                    $img_url = $stdResult["studentimage"];
                    ?>
                    <img src="../../uploads/<?= $img_url ?>" alt="Supervisor profile image">
                </div>
            </nav>
            <div class="appointment-container">
                <div class="appointment-details">
                    <h6>DEPARTMENT:</h6>
                    <p><?= $stdResult['department'] ?></p>
                </div>
                <div class="appointment-details">
                    <h6>STUDENT ID:</h6>
                    <p><?= $stdResult['studentid'] ?></p>
                </div>
                <div class="appointment-details">
                    <h6>APPOINTMENT TIME:</h6>
                    <p><?= $appointmentResult['appointmentdate'] . " " . $appointmentResult['appointmenttime'] ?></p>
                </div>
                <?php
                $status = $appointmentResult['appointmentstatus'];
                if ($status == "Pending") {
                    $status = "primary";
                } elseif ($status == "Approved") {
                    $status = "success";
                } else {
                    $status = "danger";
                }
                ?>
                <div class="appointment-details">
                    <h6>STATUS:</h6>
                    <p><button disabled="disabled" class="btn btn-<?= $status ?>"><?= $appointmentResult['appointmentstatus'] ?></button></p>
                </div>
                <div class="appointment-details">
                    <h6>MESSAGE:</h6>
                    <p><?= $appointmentResult['studentmessage'] ?></p>
                </div>
                <div class="appointment-details">
                    <h6>REPLY:</h6>
                    <form class="supervisor-msg_form" action="../../utils/sendsupervisormsg.php" method="POST">
                        <input type="hidden" name="student_id" value="<?= $stdResult["studentid"] ?>">
                        <textarea class="supervisor-msg" name="supervisor-message" rows="4" cols="40" placeholder="Leave a message for the student..." required></textarea>
                        <button class="btn btn-secondary" type="submit">Send <i class="bi bi-send"></i></button>
                    </form>
                </div>
            </div>
        </section>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="./appointment.js"></script>
</body>

</html>