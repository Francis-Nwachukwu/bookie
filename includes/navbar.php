<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .logout {
            text-decoration: none;
            color: red;
            padding: 0 5px;
        }

        .logout:hover {
            color: red;
            font-weight: bold;
        }

        .container-fluid {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-weight: bolder;
            letter-spacing: 2px;
            font-size: 1.5rem;
            text-transform: uppercase;
            border-left: 2px solid black;
        }

        .navbar-brand-2 {
            text-decoration: underline;
        }

        .userInfo {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .userInfo_icon {
            margin-right: 5px;
            font-size: 1.7em;
        }

        .nav-image {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 10px;
        }

        .nav-link {
            text-decoration: none;
            color: black;
            padding: 0 5px;
        }

        .nav-link:hover {
            color: black;
            font-weight: bold;
        }

        .nav-link_container {
            display: flex;
            justify-content: center;
        }

        @media screen and (max-width: 600px) {
            .userInfo h4 {
                display: none;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar bg-light">
        <div class="container-fluid">
            <a href="../index/index.php" class="navbar-brand"><span class="navbar-brand-2">Book</span>ie</a>
            <div class="nav-userInfo">
                <div class="userInfo">
                    <?php
                    $img_url = $student_data["studentimage"];
                    ?>
                    <img class="nav-image" src="../../uploads/<?= $img_url ?>" alt="Student profile image">
                </div>
            </div>
            <div class="nav-link_container">
                <a class="nav-link" href="/student/home/home.php">Home</a>
                <a class="nav-link" href="/student/profile/profile.php">Profile</a>
                <a class="logout" href="../../utils/logout.php">Logout</a>
            </div>
        </div>
    </nav>
</body>

</html>