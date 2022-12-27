<?php
$root_path = '../../../';
$profile_path = '../';
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

$classrooms = $database->performQuery("SELECT * FROM classroom,student_classroom where classroom.class_code=student_classroom.class_code and student_classroom.email='" . $email->get_email() . "' and active='1';");



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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="main.min.css" />
  <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
  <link href="<?php echo $root_path; ?>boxicons-2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <script defer src="script.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'listWeek',
    themeSystem: 'bootstrap5',
    header: {
      left: '',
      center: '',
      right: ''
    },

    events: [
        <?php 
            $recordsTask=$database->performQuery("select * from event,task,student_classroom,task_classroom where event.event_id=task.event_id and task_classroom.task_id=task.task_id and student_classroom.email='".$email->get_email()."' and student_classroom.class_code=task_classroom.class_code;");
            $first=false;
            foreach($recordsTask as $i){
              if(!$first){
                $first=true;
              }
              else{
                echo ',';
              }
          ?>
        {
          
          title: '<?php echo $i['task_title']; ?>',
          start: '<?php echo $i['event_start_datetime'];?>'
          
        }
        <?php
            }
          ?>
      ]
  });
  calendar.render();
});
  </script>
</head>

<body>
  <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
  <script src="main.min.js"></script>
  <div class="main-container d-flex">
    <?php
    require $profile_path . 'navbar.php';
    student_navbar($root_path);
    ?>
    <section class="content-section row justify-content-center my-5 mx-5">

      <div class="col-md-6 mx-5">
        <div class="row mb-1">
          <div class="greetingsbox">
            <h2 class="typewrite" data-period="500" data-type='["Welcome back , <?php echo $name ?>" , "How was your day?" , "Have you submitted all your tasks?" ]'>
            </h2>
            <span class="wrap"></span>

          </div>
        </div>
        <div class=" small-profile row justify-content-center mb-3 ">
          <div class="profilebox col-md-4 w-100">
            <div class="row my-auto">
              <div class="col my-auto">
                <img src="<?php echo $src ?>" style="border-radius:75%; height:3rem ; width:3rem;">
              </div>
              <div class="col-5 my-auto">
                <p class="my-auto align-self-start" style=" font-weight:bold; color:white;font-size:15px"><?php echo $name ?></p>
                <p class="my-auto align-self-start" style=" color:white">Student</p>
              </div>
              <div class="col my-auto">
                <i class="bx bxs-bell notification align-self-end ms-5"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-2">
          <h4>My Classrooms</h4>
        </div>
        <div class="row">
          <div class="box classroomcontainer">
            <?php
            foreach ($classrooms as $i) {
              $classCode = $i['class_code'];
              $classTitle = $i['classroom_name'];
              $database->fetch_results($teacher_records, "SELECT * FROM users,teacher_classroom,classroom WHERE users.email=teacher_classroom.email and classroom.class_code='$classCode'");
            ?>
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $classTitle ?></h5>
                  <h6 class="card-subtitle mb-2 text-muted"><?php echo $teacher_records['name'] ?></h6>
                </div>
              </div>
            <?php } ?>


          </div>
        </div>

        <div class="row mb-2 mt-5">
          <h4>My Resources</h4>
        </div>
        <div class="row">
          <div class="box classroomcontainer">



            <?php
            $resource = $database->performQuery("SELECT * FROM resources,resource_saved WHERE resources.resource_id=resource_saved.resource_id;");
           
            foreach ($resource as $dummy_resource) {
            ?>
              <div class="card">
                <div class="card-body">
                <?php $visibility = $dummy_resource['resource_visibility']; ?>
                <div class="<?php echo $visibility ?>-box mb-1"><?php echo $visibility ?></div>
                  <h5 class="card-title"><?php echo $dummy_resource['title']; ?></h5>
                  <h6 class="card-subtitle mb-2 text-muted"><?php echo $dummy_resource['resource_description']; ?></h6>
                </div>
              </div>
              
            <?php
            }
            ?>

          </div>
        </div>
      </div>

      <div class="col-md-4 mx-5">

        <div class="big-profile row justify-content-center mb-3">
          <div class="profilebox col-md-4 w-100">
            <div class="row my-auto">
              <div class="col my-auto mx-2">
                <img src="<?php echo $src ?>" style="border-radius:75%; height:3rem ; width:3rem;">
              </div>
              <div class="col-6 my-auto">
                <p class="my-auto align-self-start" style=" font-weight:bold; color:white;font-size:20px"><?php echo $name ?></p>
                <p class="my-auto align-self-start" style=" color:white">Student</p>
              </div>
              <div class="col-2 my-auto">

                <!-- <div class="dropdown-center">
                  <button class="btn btn-xs dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true">
                  <i class="bx bxs-bell notification"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Action two</a></li>
                    <li><a class="dropdown-item" href="#">Action three</a></li>
                  </ul>
                </div> -->
                <div class="dropdown">
                  <i class="bx bxs-bell notification dropbtn position-relative" onclick="myFunction()">
                    <span class="position-absolute top-0 start-100 translate-middle badge badge-sm rounded-pill bg-danger ">
                      99+
                      <span class="visually-hidden">unread messages</span>
                    </span></i>
                  <div id="myDropdown" class="dropdown-content w-50">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                    <a href="#" class="amarMonChaise">Show all notifications</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row gradebox mt-5 my-2">
          <div class="row mt-3"><canvas id="chartProgress"></canvas></div>
          <div class="row justify-content-center  mt-4" style="text-align:center; ">
            <h5>Grade percentage</h5>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="box w-100 mt-3">
            <div id="calendar"></div>
          </div>
        </div>

      </div>
    </section>

  </div>


</body>

</html>