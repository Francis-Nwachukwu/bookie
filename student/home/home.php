<?php

include("../../utils/db.php");
include("../../utils/functions.php");

$student_data = check_student_login($con);

$appointment_data = getStudentAppointment($con);

?>
<?php include("../../includes/header.php") ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
<link rel="stylesheet" href="./home.css">
<title><?= $student_data["firstname"] ?>'s Dashboard</title>
</head>

<body>
    <?php include("../../includes/navbar.php") ?>

    <section class="container">
        <div class="welcome-banner">
            <div class="welcome-text">
                <h1>Welcome <?= $student_data["firstname"] . " " . $student_data["lastname"] ?></h1>
                <p>Book an Appointment for Supervision Today!</p>
            </div>
            <div class="welcome-img">
                <div class="img-container">
                    An image
                </div>
            </div>
        </div>
        <div class="book-appointment">
            <?php
            $currentSupervisor = $student_data["supervisor"];
            $sql = "SELECT availabilitydetails FROM supervisors WHERE supervisorid = '$currentSupervisor'";
            $res = mysqli_query($con, $sql);
            $resData = mysqli_fetch_assoc($res);

            if (mysqli_num_rows($res) > 0) { ?>
                <div class="book-form">
                    <form class="book-appointment" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="get">
                        <?php
                        $currentSupervisor = $student_data["supervisor"];
                        $sql = "SELECT availabilitydetails FROM supervisors WHERE supervisorid = '$currentSupervisor' limit 1";
                        $res = mysqli_query($con, $sql);

                        if (mysqli_num_rows($res) > 0) { ?>
                            <select name="selectedDate">
                                <?php while ($result = mysqli_fetch_array($res)) {
                                    $availabilityDetails = json_decode($result[0]);
                                    $index = 0;
                                    foreach ($availabilityDetails as $value) {
                                ?>
                                        <option value=<?= $index ?>>
                                            <div>
                                                <?= $value->availableDOW ?>
                                                <h1><?= $value->availableDate ?></h1>
                                                <h1><?= substr($value->availableTime, 0, 5) ?></h1>
                                            </div>
                                        </option>
                                <?php
                                        $index += 1;
                                    }
                                } ?>

                            </select>
                            <button class="btn btn-secondary" type="submit">Pick Date</button>
                        <?php } else { ?>
                            <div class="alert alert-danger">Supervisor has not scheduled an available date yet.</div>
                        <?php } ?>
                    </form>


                </div>
                <?php if (isset($_GET["selectedDate"])) { ?>

                    <?php if ($availabilityDetails[$_GET["selectedDate"]]->availableSlots >= 1) { ?>
                        <div class="booked-details">
                            <div class="slot-details">
                                <h1>
                                    <?= $availabilityDetails[$_GET["selectedDate"]]->availableSlots ?>
                                </h1>
                                Slot left
                            </div>
                            <p><?= $availabilityDetails[$_GET["selectedDate"]]->availableDOW ?>, <?= $availabilityDetails[$_GET["selectedDate"]]->availableDate ?> <?= substr($availabilityDetails[$_GET["selectedDate"]]->availableTime, 0, 5) ?></p>
                            <form class="book-appointment" action="../../utils/bookappointment.php" method="post">
                                <input type="hidden" name="student_id" value="<?= $student_data["studentid"] ?>">
                                <input type="hidden" name="student_supervisor" value="<?= $student_data["supervisor"] ?>">
                                <input type="hidden" name="index" value="<?= $_GET["selectedDate"] ?>">
                                <input type="hidden" name="appointmentDOW" value="<?= $availabilityDetails[$_GET["selectedDate"]]->availableDOW ?>">
                                <input type="hidden" name="appointmentDate" value="<?= $availabilityDetails[$_GET["selectedDate"]]->availableDate ?>">
                                <input type="hidden" name="appointmentTime" value="<?= $availabilityDetails[$_GET["selectedDate"]]->availableTime ?>">
                                <input type="hidden" name="availableSlots" value="<?= $availabilityDetails[$_GET["selectedDate"]]->availableSlots ?>">

                                <textarea name="student-message" rows="4" cols="40" rows="10" placeholder="Leave a message for your supervisor..." required></textarea>
                                <button class="btn btn-secondary" type="submit">Book</button>


                            </form>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-danger">No available slots for <?= $availabilityDetails[$_GET["selectedDate"]]->availableDOW ?>, <?= $availabilityDetails[$_GET["selectedDate"]]->availableDate ?></div>
                    <?php } ?>

                <?php } ?>
            <?php } else { ?>
                <div class="alert alert-danger">Supervisor has not scheduled an available date yet.</div>
            <?php } ?>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>