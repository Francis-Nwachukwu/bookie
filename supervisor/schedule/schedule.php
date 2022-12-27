<?php
include("../../utils/db.php");
include("../../utils/functions.php");

$supervisor_data = check_supervisor_login($con);
$supervisor_id = $supervisor_data["supervisorid"];
?>

<?php include("../../includes/header.php") ?>
<title><?= $supervisor_data["firstname"] ?>'s schedule</title>
<link rel="stylesheet" href="./schedule.css" />
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
                        <a href="./schedule.php">
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
                        <a href="./schedule.php">
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
        <section class="dashboard-main container">
            <nav class="dashboard-main_nav">
                <i class="bi bi-arrow-bar-right" style="font-size: 2rem;"></i>
                <div class="main-nav_header">
                    <h4 class="page-header">Set Appointment Schedule</h4>
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
            <div class="schedule-form_container">
                <form class="schedule-form" action="../../utils/setappointment.php" method="post">
                    <div>
                        <div class="schedule-input">
                            <label>
                                Date
                            </label>
                            <input name="availableDate" type="date" required />
                        </div>
                        <div class="schedule-input">
                            <label>
                                Time
                            </label>
                            <input name="availableTime" type="time" required />
                        </div>
                    </div>
                    <div>
                        <div class="schedule-input">
                            <label>
                                Maximum students per day
                            </label>
                            <input name="maximum-students" type="number" required />
                        </div>
                        <div class="schedule-input">
                            <label>
                                Day of the Week
                            </label>
                            <select required name="availableDOW">
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-secondary" type="submit">Set Appointment</button>

                </form>
            </div>
            <?php
            $sql = "SELECT availabilitydetails FROM supervisors WHERE supervisorid = '$supervisor_id'";
            $res = mysqli_query($con, $sql);
            $result = mysqli_fetch_array($res);
            $availabilityStatus = json_decode($result[0]);


            if ($availabilityStatus) {
                $index = 0; ?>
                <div class="table-container">
                    <table class="table table-striped">
                        <tr>
                            <th>Day Of The Week</th>
                            <th>Date</th>
                            <th>Std/Day</th>
                            <th>Time</th>
                            <th></th>
                        </tr>
                        <?php foreach ($availabilityStatus as $value) {
                        ?>
                            <tr>
                                <td><?= $value->availableDOW ?></td>
                                <td><?= $value->availableDate ?></td>
                                <td><?= $value->maximumStudents ?></td>
                                <td><?= $value->availableTime ?></td>
                                <td>
                                    <form action="../../utils/deleteappointment.php" method="post">
                                        <input type="hidden" name="detailIndex" value="<?= $index ?>">
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                            $index += 1;
                        } ?>
                    </table>
                </div>
            <?php } else { ?>
                <div class="alert alert-danger">Set Appointment to have different schedules.</div>
            <?php } ?>
        </section>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="./schedule.js"></script>
</body>

</html>