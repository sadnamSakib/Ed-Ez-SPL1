<?php
$root_path = '../../../';
include $root_path . 'LibraryFiles/DatabaseConnection/config.php';
include $root_path . 'LibraryFiles/URLFinder/URLPath.php';
include $root_path . 'LibraryFiles/SessionStore/session.php';

session::create_or_resume_session();
session::profile_not_set($root_path);
$temp = hash('sha512', $_SESSION['email']);
$tableName = $_SESSION['tableName'];
$row = mysqli_fetch_assoc($database->performQuery("SELECT * FROM users WHERE email='$temp';"));
$name = $row['name'];
$className = 'Math 4341 Linear Algebra';
$classrooms = $database->performQuery("SELECT * FROM classroom,teacher_classroom where classroom.class_code=teacher_classroom.class_code and teacher_classroom.email='$temp';");
foreach ($classrooms as $dummy_classroom) {
  if (isset($_REQUEST['delete'.$dummy_classroom['class_code']])) {
    $database->performQuery("DELETE FROM classroom WHERE class_code='".$dummy_classroom['class_code']."';");
  }
}


if (isset($_POST['Create'])) {
  $classCode = generateRandomString(10);
  $existence = $database->performQuery("SELECT * FROM classroom where class_code='$classCode'");
  while ($existence->num_rows > 0) {
    $classCode = generateRandomString(10);
    $existence = $database->performQuery("SELECT * FROM classroom where class_code='$classCode'");
  }
  $className = $_POST['courseName'];
  $courseCode = $_POST['courseCode'];
  $semester = $_POST['semester'];
  $database->performQuery("INSERT INTO classroom(class_code,classroom_name,course_code,semester) VALUES('$classCode','$className','$courseCode','$semester');");
  $database->performQuery("INSERT INTO teacher_classroom(email,class_code) VALUES('$temp','$classCode');");
}

$classrooms = $database->performQuery("SELECT * FROM classroom,teacher_classroom where classroom.class_code=teacher_classroom.class_code and teacher_classroom.email='$temp';");
foreach ($classrooms as $dummy_classroom) {
  if (isset($_POST[$dummy_classroom['class_code']])) {
    $_SESSION['class_code'] = $dummy_classroom['class_code'];
    header('Location: TeacherClassroom/index.php');
  }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Classroom</title>
  <link rel="icon" href="<?php echo $root_path; ?>logo4.jpg" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jsSHA/2.0.2/sha.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/d0f239b9af.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jsSHA/2.0.2/sha.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/d0f239b9af.js" crossorigin="anonymous"></script>
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
  <script defer src="script.js"></script>
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
  <?php
  foreach ($classrooms as $i) {
    $card = $i['class_code'];
  ?>
    <style>
      <?php echo "." . $card . "dropbtn"; ?> {
        background-color: transparent;
        color: black;
        padding: 3px;
        font-size: 16px;
        border: 10px;
        border-color: #000;
        border-radius: 5px;
        cursor: pointer;
      }


      <?php "#" . $card . "myDropdown" ?> {
        transition: all 0.3s;
      }

      <?php echo "." . $card . "dropbtn:hover, ." . $card . "dropbtn:focus"; ?> {
        background-color: #2f6d8b;
      }

      <?php echo "." . $card . "dropdown"; ?> {
        position: relative;
        display: inline-block;
      }

      <?php echo "." . $card . "dropdown-content"; ?> {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 160px;
        border-radius: 1.5px;
        overflow: auto;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        transition: all 0.3s;
      }

      <?php echo "." . $card . "dropdown-content a"; ?> {
        color: black;
        text-decoration: none;
        display: block;
      }

      <?php echo "." . $card . "dropdown-toggle"; ?> {
        background-color: #2980B9;
        color: white;
      }

      <?php echo "." . $card . "dropdown a:hover"; ?> {
        background-color: #ddd;
      }
    </style>
  <?php
  };
  ?>

</head>

<body>
  <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
  <div class="main-container d-flex">
    <div class="sidebar" id="side_nav">
      <div class="header-box px-2 pt-3 pb-4 d-flex justify-content-between ">
        <h1 class="fs-4"><span class="bg-white text-dark rounded shadow px-4 mx-4 my-5"><span class="text-whte"> Ed-Ez</span></span></h1>
        <button class="btn d-block close-btn text-white"><i class='bx bx-menu'></i></button>
      </div>
      <ul class="list-unstyled px-2">
        <li class=""><a href="#" class="text-decoration-none px-3 py-2 d-block"><i class='bx bxs-dashboard pe-2'></i>Dashboard</a></li>
        <li class=""><a href="<?php echo $root_path ?>UserProfiles/TeacherProfile/index.php" class="text-decoration-none px-3 py-2 d-block"><i class='bx bx-user-circle pe-2'></i>Profile</a></li>
        <li class=""><a href="<?php echo $root_path ?>UserProfiles/TeacherProfile/TeacherSchedule/index.php" class="text-decoration-none px-3 py-2 d-block"><i class='bx bxs-calendar-plus pe-2'></i>Schedule</a></li>
        <li class=""><a href="<?php echo $root_path ?>UserProfiles/TeacherProfile/ClassroomSystem/index.php" class="text-decoration-none px-3 py-2 d-block"><i class='bx bx-chalkboard pe-2'></i>Classrooms</a></li>
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
            <a href="#" class="navbar-brand fs-5 px-3 mx-4" href="#"><img src="../../../logo2.jpg" class="img-fluid" height="40" width= "200"/></a>
          </div>
          <!-- <button class="navbar-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fal fa-bars"></i>
          </button> -->
          <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
              <li class="nav-item">
                <button type="button" class="btn btn-primary me-2 d-flex">
                  <a href="<?php echo $root_path; ?>UserProfiles/Logout/logout.php" style="text-decoration: none; color:black">Log Out</a>
                </button>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <section class="content-section m-auto px-1 w-75">
        <div class="container bg-white rounded mt-5 mb-5"></div>
        <div class="px-3 me-3 d-flex flex-row-reverse">
          <button type="button" class="btn btn-outline-primary btn-join d-flex p-4 py-3" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat"><b>Create new classroom</b></button>
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Create classroom</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action='' id='addCourse' method='POST'>
                    <div class="mb-3" id="error" style="display:none">
                    </div>
                    <div class="mb-3">
                      <input type="text" id="courseName" name="courseName" class="form-control" placeholder="Enter Course Name" aria-label="Leave a comment">
                    </div>
                    <div class="mb-3">
                      <input type="text" id="courseCode" name="courseCode" class="form-control" placeholder="Enter Course Code" aria-label="Leave a comment">
                    </div>
                    <div class="mb-3">
                      <input type="text" id="semester" name="semester" class="form-control" placeholder="Enter Semester" aria-label="Leave a comment">
                    </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <input type='submit' name='Create' value='Create' class="btn btn-primary btn-join">
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container bg-white rounded m-auto justify-content-center mt-5 mb-5"></div>
        <div class="row justify-content-start m-auto">
          <!-- <h2 class="fs-5">Profile</h2> -->
          <?php
          foreach ($classrooms as $i) {
          ?>
            <div class="card-element col-lg-4 col-md-6 p-4 px-2">
              <div class="card card-box-shadow">
                <div class="card-header  task-card justify-content-around" style="height:100px">
                  <div class="row">
                    <h4 class="card-title col py-2"><?php echo $i['course_code'] . ": " . $i['classroom_name']; ?></h4>
                    <?php $card = $i['class_code']; ?>
                    <div class="dropdown col-lg-auto col-sm-6 col-md-3 py-3">
                      <i onclick="<?php echo $card; ?>dropdownbtn()" class="<?php echo $card; ?>dropbtn bx bx-dots-horizontal-rounded"></i>
                      <div id="<?php echo $card; ?>myDropdown" class="<?php echo $card; ?>dropdown-content dropdown-menu">
                        <form name='view_delete<?php echo $card;?>' action='' method='POST'>
                        <input type="submit" value="View Details" name='view<?php echo $card; ?>' class="dropdown-item">
                        <input type="submit" value="Delete Classroom" name='delete<?php echo $card; ?>' class="dropdown-item">
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <p class="card-text"><?php echo "Course Instructor: " . $name; ?></p>
                  <p class="card-text"><?php echo $i['class_code']; ?></p>
                </div>
                <div class="pb-5 px-5">
                  <form id="EnterClassroom" name="EnterClassroom" action="" method="POST">
                    <input type="submit" name="<?php echo  $i['class_code']; ?>" value="Enter Class" class="btn btn-primary btn-go">
                  </form>
                </div>
              </div>
            </div>
          <?php
          }
          ?>
        </div>
      </section>
    </div>
  </div>
  <?php
  foreach ($classrooms as $i) {
    $card = $i['class_code'];
  ?>
    <script>
      function <?php echo $card; ?>dropdownbtn() {
        document.getElementById("<?php echo $card; ?>myDropdown").classList.toggle("show");
      }
    </script>
  <?php
  }
  ?>
  <script>
    //Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
      <?php
      foreach ($classrooms as $i) {
        $card = $i['class_code'];
      ?>
        if (!event.target.matches('.<?php echo $card; ?>dropbtn')) {
          var dropdowns = document.getElementsByClassName("<?php echo $card; ?>dropdown-content");
          var i;
          for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
              openDropdown.classList.remove('show');
            }
          }
        }
      <?php
      }
      ?>
    }
  </script>


</body>

</html>