<?php
$root_path = '../../../';
$profile_path = '';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
require $root_path . 'LibraryFiles/Utility/Utility.php';
require $root_path . 'LibraryFiles/ValidationPhp/InputValidation.php';
session::profile_not_set($root_path);
$validate = new InputValidation();
$classCode = $_SESSION['class_code'];
$email = new EmailValidator($_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Classroom</title>
  <link rel="icon" href="<?php echo $root_path; ?>title_icon.jpg" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css" />
  <script defer src="script.js"></script>
  <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

  <link href="<?php echo $root_path; ?>boxicons-2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>

  <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
  <div class="main-container ">
    <?php
    require $profile_path . 'navbar.php';
    student_navbar($root_path);
    ?>
    <section class="content-section row justify-content-center w-75">
      <div class="col-md-8">
        <canvas id="chartProgress"></canvas>
      </div>
    </section>
    <section class="content-section row justify-content-center">
      <div class="progressbars col-md-4 w-50">
        <label>Attendance</label>
        <div class="progress my-2">
          <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-label="Animated striped example" style="width: 90%" aria-valuenow="66.6" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <label>Quiz</label>
        <div class="progress my-2">
          <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-label="Animated striped example" style="width: 83%" aria-valuenow="66.6" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <label>Assignment</label>
        <div class="progress my-2">
          <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-label="Animated striped example" style="width: 88%" aria-valuenow="66.6" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <label>Mid-Semester</label>
        <div class="progress my-2">
          <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-label="Animated striped example" style="width: 74%" aria-valuenow="66.6" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <label>Semester Final</label>
        <div class=" progress my-2">
          <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-label="Animated striped example"  style="width: 65%" aria-valuenow="66.6" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>

    </section>
  </div>

</body>

</html>