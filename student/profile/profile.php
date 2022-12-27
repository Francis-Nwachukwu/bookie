<?php

include("../../utils/db.php");
include("../../utils/functions.php");

$student_data = check_student_login($con);

$appointment_data = getStudentAppointment($con);

?>

<?php include("../../includes/header.php") ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
<link rel="stylesheet" href="./profile.css">
<title><?= $student_data["firstname"] ?> Dashboard</title>
</head>

<body>
    <?php include("../../includes/navbar.php") ?>

    <section class="section container">
        <div class="dashboard-header">
            <p>Profile</p>
            <p><?= $student_data["studentid"] ?></p>
        </div>
        <div class="student-details">
            <div class="details-container">
                <div class="img-container">
                    <?php
                    $img_url = $student_data["studentimage"];
                    ?>
                    <img class="profile-image" src="../../uploads/<?= $img_url ?>" alt="Student profile image">

                </div>
                <div class="details">
                    <h3 class="details-name"><?= $student_data["firstname"] . " " . $student_data["lastname"] ?></h3>
                    <p class="details-email"><?= $student_data["email"] ?></p>
                    <p class="details-dep"><?= $student_data["department"] ?></p>
                    <!-- <p><?= $student_data["supervisor"] ?></p> -->
                </div>
            </div>
            <div class="update-container">
                <form class="" action="../../utils/update.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="student-updating" value="true">
                    <input type="hidden" name="student_id" value="<?= $student_data["studentid"] ?>">
                    <div class="card_form-detail">
                        <input type="text" name="studentFirstname" placeholder="First Name" value="<?= $student_data['firstname'] ?>" required />
                    </div>
                    <div class="card_form-detail">
                        <input type="text" name="studentLastname" placeholder="Last Name" value="<?= $student_data['lastname'] ?>" required />
                    </div>
                    <div class="card_form-detail">
                        <input type="email" name="studentEmail" placeholder="Email" value="<?= $student_data['email'] ?>" required />
                    </div>
                    <div class="card_form-detail">
                        <input type="text" name="studentDepartment" placeholder="Department" value="<?= $student_data['department'] ?>" required />
                    </div>
                    <div class="card_form-detail">
                        <label>
                            Update Profile Picture
                        </label>
                        <input class="file-input" name="studentImage" type="file" />
                    </div>
                    <button class="submit-btn btn btn-secondary" type="submit">Update</button>
                </form>
            </div>
        </div>
        <div class="appointment-details_container">
            <div class="appointment-details">

                <?php
                $student_id = $student_data['studentid'];
                $sql = "SELECT * FROM appointments WHERE studentid = '$student_id'";
                $res = mysqli_query($con, $sql);
                $count = 1;

                if (mysqli_num_rows($res) > 0) { ?>
                    <div class="table-container">
                        <table class="table table-striped">
                            <tr>
                                <th>S/N</th>
                                <th>Appointment ID</th>
                                <th>Message</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Status</th>
                            </tr>
                            <?php while ($result = mysqli_fetch_assoc($res)) {
                                $status = $result['appointmentstatus'];
                                if ($status == "Pending") {
                                    $status = "primary";
                                } elseif ($status == "Approved") {
                                    $status = "success";
                                } else {
                                    $status = "danger";
                                }
                            ?>
                                <tr>
                                    <td><?= $count ?></td>
                                    <td><?= $result['appointmentid'] ?></td>
                                    <td><?= $result['studentmessage'] ?></td>
                                    <td><?= $result['appointmentdate'] ?></td>
                                    <td><?= $result['appointmenttime'] ?></td>
                                    <td><button class="btn btn-<?= $status ?>" type="disabled"><?= $result['appointmentstatus'] ?></button></td>
                                </tr>
                            <?php
                                $count += 1;
                            } ?>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-danger">No Appointments yet. Navigate <a href="../home/home.php">here</a> to book.</div>
                <?php } ?>

            </div>

    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="./profile.js"></script>
</body>

</html>