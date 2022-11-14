<?php
$root_path = '../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
require $root_path . 'LibraryFiles/ValidationPhp/InputValidation.php';
session::profile_not_set($root_path);
$email = new EmailValidator($_SESSION['email']);
$database->fetch_results($verified, "SELECT Verified FROM users WHERE email='" . $email->get_email() . "'");
if ($verified['Verified'] !== '1') {
  header('Location: ' . $root_path . 'LoginAuth/SignUp/ConfirmEmail/index.php');
}

$error = null;
$errorColor = "red";

if (isset($_REQUEST['profileimg'])) {
  $fileName = basename($_FILES["image"]["name"]);
  $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
  $allowTypes = array('jpg', 'png', 'jpeg');
  if (in_array($fileType, $allowTypes)) {
    $image = $_FILES["image"]["tmp_name"];
    $imgContent = addslashes(file_get_contents($image));
  }
  $updateProfilePicture = "UPDATE users SET profile_picture='$imgContent' WHERE email = '" . $email->get_email() . "'";
  $database->performQuery($updateProfilePicture);
}

if (isset($_POST['UpdateProfile'])) {
  $validate = new InputValidation();
  $_SESSION['name'] = $name = $validate->post_sanitise_regular_input('name');
  $department = $validate->post_sanitise_regular_input('department');
  $semester = $validate->post_sanitise_number('semester');
  $country = $validate->post_sanitise_regular_input('country');
  $studentID = $validate->post_sanitise_digits('studentID');
  $database->fetch_results($row, "SELECT * FROM users WHERE email = '" . $email->get_email() . "'");
  if ($_REQUEST['mobile'] != '') {
    $mobileNumber = $validate->post_sanitise_digits('mobile');
  } else {
    $mobileNumber = $row['mobileNumber'];
  }

  if (password_verify(hash('sha512', $validate->post_sanitise_password('password')), $row['password'])) {
    if ($semester == '') {
      $semester = -1;
    }
    $database->performQuery("UPDATE users SET name='$name',mobileNumber='$mobileNumber',country='$country',department='$department' WHERE email='" . $email->get_email() . "'");
    $database->performQuery("UPDATE student SET semester='$semester',studentID='$studentID' WHERE email = '" . $email->get_email() . "'");
  } else {
    $error = "Incorrect Password, Cannot make changes to profile";
    $errorColor = "red";
  }
}

$database->fetch_results($row, "SELECT * FROM users INNER JOIN student ON users.email=student.email WHERE users.email = '" . $email->get_email() . "'");

$var = $row['profile_picture'];
if ($var != "") {
  $src = "data:image/jpg;charset=utf8;base64," . base64_encode($var);
} else {
  $src = "profile-picture.png";
}
$name = $row['name'];
$mobileNumber = $row['mobileNumber'];
$instituion = $row['institution'];
$department = $row['department'];
$semester = $row['semester'];
$country = $row['country'];
$studentID = $row['studentID'];
if ($semester == -1) {
  $semester = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Profile</title>
  <link rel="icon" href="<?php echo $root_path; ?>title_icon.jpg" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="main.min.css" />
  <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
  <link href="<?php echo $root_path; ?>boxicons-2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <script defer src="script.js"></script>
</head>

<body>
  <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
  <script src="main.min.js"></script>
  <div class="main-container d-flex">
    <?php
    require 'navbar.php';
    student_navbar($root_path, true);
    ?>
    <section class="content-section row justify-content-center m-5">

      <div class="col-md-6 mx-5">
        <div class="row mb-1">
          <div class="greetingsbox">
            <h2 class="typewrite" data-period="500" data-type='["Welcome back , <?php echo $name ?>" , "How was your day?" , "Have you submitted all your tasks?" ]'>
            </h2>
            <span class="wrap"></span>
          </div>
        </div>
        <div class="row mb-2">
          <h4>My Classrooms</h4>
        </div>
        <div class="row">
          <div class="box classroomcontainer">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Card 1</h5>
                <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>

              </div>
            </div>
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Card 2</h5>
              <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
            </div>
          </div>
          </div>

        </div>
      </div>
      <div class="col-md-4 mx-5">
        <div class="row justify-content-center mb-3">
          <div class="profilebox row col-md-6 w-100 align-self-center justify-content-center">
            <div class="col-md-2">
              <img src="<?php echo $src ?>" style="border-radius:50%; height:4rem ; width:4rem;">
            </div>
            <div class="col-md-6 justify-content-center align-self-center">
              <p class="row m-0" style="font-weight:bold; color:white"><?php echo $name ?></p>
              <p class="row m-0" style=" color:white">Student</p>
            </div>
            <div class="col-md-2 m-0">

              <i class='bx bxs-bell notification'></i>


            </div>
          </div>
        </div>
        <div class="row">

          <canvas id="chartProgress"></canvas>

        </div>
        <div class="row justify-content-center">
          <div class="box w-100 mt-3">
            <div id='calendar'></div>
          </div>
        </div>

      </div>
    </section>

  </div>


</body>

</html>