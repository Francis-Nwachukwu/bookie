<!DOCTYPE html>
<html lang="en">

<head>
    <style>

    </style>
</head>

<body>
    <aside class="mobile_sidebar hidden">

        <div class="mobile-sidebar-list_container">
            <div class="student-profile">
                <div class="profile-header_container">
                    <h1 class="profile-header">Profile</h1>
                    <i class="fas fa-times close_btn"></i>
                </div>
                <div class="profile-img_container">
                    <?php
                    $img_url = $student_data["studentimage"];
                    ?>
                    <img src="../../uploads/<?= $img_url ?>" alt="Student profile image">
                </div>
                <div class="student-details">
                    <div class="student-id">
                        <span class="id-label">Student ID</span> <?php echo $student_data["studentid"]; ?>
                    </div>
                    <div class="student-name">
                        <span class="name-label">Student Name</span>
                        <?php
                        $name = $student_data["firstname"] . " " . $student_data["lastname"];
                        echo $name;
                        ?>
                    </div>
                    <div class="student-email">
                        <span class="email-label">Student Email</span> <?php echo $student_data["email"]; ?>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <script></script>
</body>

</html>