<?php
$root_path = '../../../../';
include $root_path . 'LibraryFiles/DatabaseConnection/config.php';
include $root_path . 'LibraryFiles/URLFinder/URLPath.php';
include $root_path . 'LibraryFiles/SessionStore/session.php';
$classCode= $_SESSION['class_code'];
$classCode=$_SESSION['class_code'];
session::create_or_resume_session();
session::profile_not_set($root_path);
// $tableName=$_SESSION['table_name'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>View Details</title>
  <link rel="icon" href="<?php echo $root_path; ?>logo4.jpg" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jsSHA/2.0.2/sha.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/d0f239b9af.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jsSHA/2.0.2/sha.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/d0f239b9af.js" crossorigin="anonymous"></script>
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
  <script defer src="script.js"></script>
</head>

<body>

  <script src="<?php echo $root_path; ?>js/bootstrap.min.js"></script>
  <div class="main-container d-flex">
    <div class="sidebar" id="side_nav">
      <div class="header-box px-2 pt-3 pb-4 d-flex justify-content-between ">
        <h1 class="fs-4"><span class="bg-white text-dark rounded shadow px-4 mx-4 my-5"><span class="text-whte"> Ed-Ez</span></span></h1>
        <button class="btn d-block close-btn text-white"><i class='bx bx-menu'></i></button>
      </div>
      <ul class="list-unstyled px-2">
        <li class=""><a href="#" class="text-decoration-none px-3 py-2 d-block"><i class='bx bxs-dashboard pe-2'></i>Dashboard</a></li>
        <li class=""><a href="<?php echo $root_path;?>UserProfiles/StudentProfile/index.php" class="text-decoration-none px-3 py-2 d-block"><i class='bx bx-user-circle pe-2'></i>Profile</a></li>
        <li class=""><a href="<?php echo $root_path ?>UserProfiles/StudentProfile/StudentSchedule/index.php" class="text-decoration-none px-3 py-2 d-block"><i class='bx bxs-calendar-plus pe-2'></i>Schedule</a></li>
        <li class=""><a href="<?php echo $root_path;?>UserProfiles/StudentProfile/ClassroomSystem/index.php" class="text-decoration-none px-3 py-2 d-block"><i class='bx bx-chalkboard pe-2'></i>Classrooms</a></li>
        <li class=""><a href="#" class="text-decoration-none px-3 py-2 d-block"><i class='bx bxs-bar-chart-alt-2 pe-2'></i>Grades</a></li>
      </ul>
      <!-- <hr class="h-color mx-2 my-5">
      <hr class="h-color mx-2 my-5">
      <hr class="h-color mx-2 my-5">
      <hr class="h-color mx-2 my-5">
      <hr class="h-color mx-2 my-5">
      <hr class="h-color mx-2 my-5">
      <hr class="h-color mx-2 my-5">
      <ul class="list-unstyled px-2 ">
        <li class=""><a href="#" class="text-decoration-none px-3 py-2 d-block "><i class='bx bx-wrench pe-2'></i>Settings</a></li>
      </ul> -->
    </div>
    <div class="content">
      <nav class="navbar navbar-expand p-3" style="background-color: #4596be;">
        <div class="container-fluid mx-5 px-4">
          <div class="d-flex justify-content-between d-block">
            <button class="btn btn-primary open-btn me-2"><i class='bx bx-menu'></i></i></button>
            <a href="#" class="navbar-brand fs-5 px-3 mx-4" href="#"><img src="<?php echo $root_path; ?>logo2.jpg" class="img-fluid" height="40" width="200" /></a>
          </div>
          <!-- <button class="navbar-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fal fa-bars"></i>
          </button> -->
          <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
              <li class="nav-item">
              <button type="button" onclick="window.location.href='<?php echo $root_path; ?>UserProfiles/Logout/logout.php'" class="btn btn-primary me-2 d-flex">
                      Log Out
                </button>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <section class="content-section m-auto px-5">
        <div class="container-fluid bg-white rounded mt-5 mb-5"></div>
        <!-- <h2 class="fs-5">Profile</h2> -->
        <div class="card intro-card w-50 text-bg-secondary m-auto mb-3">
          <div class="card-header">
            <h5 class="card-title">Instructor(s)</h5>
          </div>
          <?php
                $sql=$database->performQuery("SELECT * FROM users,teacher_classroom WHERE users.email=teacher_classroom.email AND class_code='$classCode'");
                foreach($sql as $i){
          ?>
          <div class="card-body px-4">

            <h5 class="card-text"><?php echo $i['name'];?></h5>

          </div>
          <?php
                }
          ?>

        </div>
        <div class="card  w-50 text-bg-secondary m-auto mb-1">
          <div class="card-header">
            <h5 class="card-title"><?php 
                $sql=$database->performQuery("SELECT * FROM users, student_classroom WHERE users.email=student_classroom.email AND class_code='$classCode'");
                $record=mysqli_fetch_assoc($database->performQuery("SELECT count(*)count_student FROM users, student_classroom WHERE users.email=student_classroom.email AND class_code='$classCode'"));
                echo $record['count_student'].' Student(s)';
            ?></h5>
          </div>
          
            <ul class="list-group list-group-flush">
                <?php
                    $sql=$database->performQuery("SELECT * FROM users, student_classroom WHERE users.email=student_classroom.email AND class_code='$classCode'");
                    foreach($sql as $i){
                ?>
              <li class="list-group-item">
                <p class="card-text"><?php echo $i['name'];?></p>
              </li>
              <?php
                    }
 
              ?>
              
            </ul>

          

        </div>

    </div>
    </section>
  </div>
  </div>


</body>

</html>