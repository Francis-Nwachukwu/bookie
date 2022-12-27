<?php
include("../../utils/db.php");
include("../../utils/functions.php");

$supervisor_data = check_supervisor_login($con);
$supervisor_id = $supervisor_data["supervisorid"];
?>

<?php include("../../includes/header.php") ?>
<title><?= $supervisor_data["firstname"] ?>'s Messages</title>
<link rel="stylesheet" href="./messages.css" />
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
                        <a href="./messages.php">
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
                        <a href="./dashboard.php">
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
                        <a href="#">
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
        <section class="dashboard-main container">
            <nav class="dashboard-main_nav">
                <i class="bi bi-arrow-bar-right" style="font-size: 2rem;"></i>
                <div class="main-nav_header">
                    <h4 class="page-header">Messages</h4>
                </div>
                <div class="main-nav_tools">
                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#availableModal">
                        <i class="bi bi-envelope-check-fill"></i>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="availableModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Messages</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div>
                                    <?php
                                    $sql = "SELECT * FROM appointments WHERE supervisorid = '$supervisor_id'";
                                    $res = mysqli_query($con, $sql);

                                    if (mysqli_num_rows($res) > 0) {
                                        while ($result = mysqli_fetch_assoc($res)) {
                                    ?>
                                            <div class="msg-container">
                                                <p><?= $result["studentmessage"] ?></p>
                                                <div class="msg-footer">
                                                    <p><?= $result["studentid"] ?></p>
                                                    <p><?= $result["appointmentdate"] ?></p>
                                                </div>
                                            </div>

                                        <?php }
                                    } else { ?>
                                        <div class="alert alert-danger">No Messages from any student yet.</div>
                                    <?php } ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <div>
                <?php
                $sql = "SELECT * FROM appointments WHERE supervisorid = '$supervisor_id'";
                $res = mysqli_query($con, $sql);

                if (mysqli_num_rows($res) > 0) {
                    while ($result = mysqli_fetch_assoc($res)) {
                ?>
                        <div class="msg-container">
                            <p><?= $result["studentmessage"] ?></p>
                            <div class="msg-footer">
                                <p><?= $result["studentid"] ?></p>
                                <p><?= $result["appointmentdate"] ?></p>
                            </div>
                        </div>

                    <?php }
                } else { ?>
                    <div class="alert alert-danger">No Messages from any student yet.</div>
                <?php } ?>
            </div>
        </section>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="./messages.js"></script>
</body>

</html>