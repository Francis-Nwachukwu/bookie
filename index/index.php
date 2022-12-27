<?php
include_once("../includes/header.php");
include_once("../utils/db.php");

?>
<title>Bookie System</title>
<link rel="stylesheet" href="./index.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
</head>

<body>
  <section class="main-section">
    <div class="card-container">
      <div class="card student">
        <div class="card-body">
          <form action="../utils/auth.php" class="studentFormbox studentRegister" method="POST" enctype="multipart/form-data">
            <h5>Sign up with your Student account</h5>
            <div class="card_form-detail">
              <input type="text" name="studentFirstname" placeholder="First Name" required />
            </div>
            <div class="card_form-detail">
              <input type="text" name="studentLastname" placeholder="Last Name" required />
            </div>
            <div class="card_form-detail">
              <label>
                Profile Picture
              </label>
              <input class="file-input" name="studentImage" type="file" />
            </div>
            <div class="card_form-detail">
              <input type="email" name="studentEmail" placeholder="E-mail" required />
            </div>
            <div class="card_form-detail">
              <input type="text" name="studentDepartment" placeholder="Department" required />
            </div>
            <div class="card_form-detail">
              <input type="password" name="studentPassword" placeholder="Password" required />
            </div>
            <div class="card_form-detail">
              <input type="password" name="studentConfirmPassword" placeholder="Repeat password" required />
            </div>

            <?php
            $sql = "SELECT * FROM supervisors";
            $res = mysqli_query($con, $sql);

            if (mysqli_num_rows($res) > 0) { ?>
              <div class="card_form-detail">
                <label>
                  Select Supervisor
                </label>
                <select required name="studentSupervisor" id="studentSupervisor">
                  <?php while ($result = mysqli_fetch_assoc($res)) { ?>
                    <option value="<?= $result["supervisorid"] ?>"><?= $result["firstname"] . " " . $result["lastname"] ?></option>
                  <?php } ?>
                </select>
              </div>
            <?php
            } ?>

            <input type="hidden" name="student-signing-up" value="true">
            <button class="submit-btn btn btn-secondary" type="submit">Register</button>
            <div class="form-msg_container">
              <button type="button" class="toggleBtn" data-target="studentLogin">
                Sign in
              </button>
            </div>

          </form>
        </div>
        <div class="card-body">
          <form class="studentFormbox active studentLogin" action="../utils/auth.php" method="POST">
            <input type="hidden" name="student-signing-in" value="true">
            <h5>Sign in with your student details</h5>
            <div class="card_form-detail">
              <input type="email" name="studentEmail" placeholder="E-mail" required />
            </div>
            <div class="card_form-detail">
              <input type="password" name="studentPassword" placeholder="Password" required />
            </div>

            <button class="submit-btn btn btn-secondary" type="submit">Sign in</button>
            <div class="form-msg_container">
              <button type="button" class="toggleBtn" data-target="studentRegister">
                Register
              </button>
            </div>

          </form>
        </div>
      </div>
      <div class="card supervisor">
        <div class="card-body">
          <form class="supervisorFormbox supervisorRegister" action="../utils/auth.php" method="POST" enctype="multipart/form-data">
            <h5>Sign up with your Supervisor account</h5>
            <div class="card_form-detail">
              <input type="text" name="supervisorFirstname" placeholder="First Name" required />
            </div>
            <div class="card_form-detail">
              <input type="text" name="supervisorLastname" placeholder="Last Name" required />
            </div>
            <div class="card_form-detail">
              <label for="file-upload" class="custom-file-upload">
                Profile Picture
              </label>
              <input class="file-input" id="file-upload" name="supervisorImage" type="file" />
            </div>
            <div class="card_form-detail">
              <input type="email" name="supervisorEmail" placeholder="E-mail" required />
            </div>
            <div class="card_form-detail">
              <input type="password" name="supervisorPassword" placeholder="Password" required />
            </div>
            <div class="card_form-detail">
              <input type="password" name="supervisorConfirmPassword" placeholder="Repeat password" required />
            </div>
            <input type="hidden" name="supervisor-signing-up" value="true">
            <button class="submit-btn btn btn-secondary " type="submit">Register</button>
            <div class="form-msg_container">
              <button type="button" class="toggleBtn" data-target="supervisorLogin">
                Sign in
              </button>
            </div>

          </form>
        </div>
        <div class="card-body">
          <form class="supervisorFormbox active supervisorLogin" action="../utils/auth.php" method="POST">
            <h5>Sign in with your Supervisor details</h5>
            <div class="card_form-detail">
              <input type="email" name="supervisorEmail" placeholder="E-mail" required />
            </div>
            <div class="card_form-detail">
              <input type="password" name="supervisorPassword" placeholder="Password" required />
            </div>
            <input type="hidden" name="supervisor-signing-in" value="true">
            <button class="submit-btn btn btn-secondary " type="submit">Sign in</button>
            <div class="form-msg_container">
              <button type="button" class="toggleBtn" data-target="supervisorRegister">
                Register
              </button>
            </div>

          </form>
        </div>
      </div>
      <?php
      $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

      if (strpos($fullUrl, "passwords=mismatch") == true) {
        echo "<div class='alert'>Passwords do not match</div>";
        exit();
      } elseif (strpos($fullUrl, "email=exists") == true) {
        echo "<div class='alert'>Email Address already exists</div>";
        exit();
      } elseif (strpos($fullUrl, "type=unknown") == true) {
        echo "<div class='alert'>Image type must be JPG, JPEG or PNG</div>";
        exit();
      } elseif (strpos($fullUrl, "imageupload=unknownerror") == true) {
        echo "<div class='alert'>Unknown error occurred with image upload</div>";
        exit();
      } elseif (strpos($fullUrl, "error=wronginput") == true) {
        echo "<div class='alert'>Please input valid details</div>";
        exit();
      } elseif (strpos($fullUrl, "error=incorrect") == true) {
        echo "<div class='alert'>Wrong email or password</div>";
        exit();
      } elseif (strpos($fullUrl, "invalid=email") == true) {
        echo "<div class='alert'>Invalid email format</div>";
        exit();
      }
      ?>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="./index.js"></script>
</body>

</html>