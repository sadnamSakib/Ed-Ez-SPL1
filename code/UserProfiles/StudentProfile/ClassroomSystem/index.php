<?php
$root_path = '../../../';
$profile_path = '../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
require $root_path . 'LibraryFiles/ValidationPhp/InputValidation.php';
session::profile_not_set($root_path);

$tableName = $_SESSION['tableName'];
$email = new EmailValidator($_SESSION['email']);
$validate = new InputValidation();
$database->fetch_results($row, "SELECT * FROM users WHERE email='" . $email->get_email() . "'");

$classrooms = $database->performQuery("SELECT * FROM classroom,student_classroom where classroom.class_code=student_classroom.class_code and student_classroom.email='" . $email->get_email() . "';");
foreach ($classrooms as $dummy_classroom) {
  if (isset($_REQUEST['leave' . $dummy_classroom['class_code']])) {
    $database->performQuery("DELETE FROM student_classroom WHERE class_code='" . $dummy_classroom['class_code'] . "';");
  }
}

$error = "";
$name = $row['name'];
if (isset($_POST['Join'])) {
  $classCode = $validate->post_sanitise_regular_input('classCode');
  $existenceCheck = $database->performQuery("SELECT * FROM student_classroom WHERE class_code='$classCode' and email='" . $email->get_email() . "';");
  if ($database->performQuery("SELECT * FROM classroom WHERE class_code='$classCode' and active='1'")->num_rows == 0) {
    $error = "classroom doesn't exist";
  } else if ($existenceCheck->num_rows == 0) {
    $database->fetch_results($classroomRecords,"SELECT * FROM classroom WHERE class_code='$classCode'");
    $database->fetch_results($userRecords,"SELECT * FROM users,student WHERE student.email='".$email->get_email()."' AND users.email='".$email->get_email()."'");
    if($classroomRecords['semester']===$userRecords['semester']) {
      $database->performQuery("INSERT INTO student_classroom(email,class_code) VALUES('" . $email->get_email() . "','$classCode');");
    }
    else{
      $error="Student is not elligible for this classroom";
    }
    
  } else {
    $error = "You are already enrolled in this classroom";
  }
  unset($_REQUEST['classCode']);
}

$classrooms = $database->performQuery("SELECT * FROM classroom,student_classroom where classroom.class_code=student_classroom.class_code and student_classroom.email='" . $email->get_email() . "' and active='1';");
foreach ($classrooms as $dummy_classroom) {
  if (isset($_POST[$dummy_classroom['class_code']])) {
    $_SESSION['class_code'] = $dummy_classroom['class_code'];
    header('Location: StudentClassroom/index.php');
  }
}

foreach ($classrooms as $dummy_classroom) {
  if (isset($_POST["view" . $dummy_classroom['class_code']])) {
    $_SESSION['class_code'] = $dummy_classroom['class_code'];
    header('Location: ViewDetails/index.php');
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Classroom</title>
  <link rel="icon" href="<?php echo $root_path; ?>title_icon.jpg" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link href="<?php echo $root_path; ?>boxicons-2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <script defer src="script.js"></script>
  <?php require 'ClassroomSystemStyle.php'; ?>
  <?php require 'ClassroomSystemScript.php'; ?>
</head>

<body>

  <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
  <div class="main-container d-flex">
    <?php
    require $profile_path . 'navbar.php';
    student_navbar($root_path);
    ?>
    <section class="content-section m-auto px-1 w-75">
      <div class="container bg-white rounded mt-5 mb-5"></div>
      <div class="px-3 me-3 d-flex flex-row-reverse">
        <button type="button" class="btn btn-outline-primary btn-join d-flex p-4 py-3" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat"><b>Join new classroom</b></button>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Join classroom</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="" method="POST">
                  <div class="mb-3">
                    <input type="text" name="classCode" class="form-control" placeholder="Enter classroom code" aria-label="Leave a comment">
                  </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="Join" value="Join" class="btn btn-primary btn-join">
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div id="error" style="color:red">
        <?php echo $error; ?>
      </div>
      <div class="container bg-white rounded m-auto justify-content-center mt-5 mb-5"></div>
      <!-- <h2 class="fs-5">Profile</h2> -->
      <div class="row justify-content-start m-auto">
        <?php
        foreach ($classrooms as $i) {
          $classCode = $i['class_code'];
          $database->fetch_results($instructor_name, "select name from users where email in (select teacher.email from teacher,teacher_classroom where teacher.email=teacher_classroom.email and class_code='$classCode')");
        ?>
          <div class="card-element col-lg-4 col-md-6 p-4 px-2">
            <div class="card card-box-shadow">
              <div class="card-header  task-card justify-content-around" style="height:100px">
                <div class="row">
                  <h4 class="card-title col py-2"><?php echo $i['course_code'] . ": " . $i['classroom_name']; ?></h4>
                  <?php $card = $i['class_code']; ?>
                  <div class="dropdown col-lg-auto col-sm-6 col-md-3 py-3">
                    <i onclick="<?php echo $card; ?>dropdownbtn()" class="<?php echo $card; ?>dropbtn bx bx-dots-horizontal-rounded"></i>
                    <form name='view_leave<?php echo $card; ?>' action='' method='POST'>
                      <div id="<?php echo $card; ?>myDropdown" class="<?php echo $card; ?>dropdown-content dropdown-menu">
                        <input type="submit" value="View Details" name='view<?php echo $card; ?>' class="dropdown-item">
                        <!-- <input type="submit" value="Leave Classroom" name='leave<?php echo $card; ?>' class="dropdown-item"> -->
                        <button type="button" class="btn btn-light dropdown-item d-flex" onclick='<?php echo $card; ?>displayModal()' id='<?php echo $card; ?>leavebtn'>Leave Classroom</button>
                        <div id="<?php echo $card; ?>myModal" class="modal">
                          <!-- Modal content -->
                          <div class="modal-content w-50">
                            <div class="modal-header">
                              <h3>Are you sure you want to leave this classroom, <?php echo $i['course_code'].': '.$i['classroom_name'] ?>?</h3>
                            </div>
                            <div class="modal-body d-flex flex-row-reverse">
                            <button type="button" class="btn btn-secondary Close d-flex m-2" onclick='<?php echo $card;?>closeModal()' id='<?php echo $card; ?>closebtn'>Close</button>
                              <input type="submit" value="Leave" name='leave<?php echo $card; ?>' class="btn btn-outline-primary btn-join d-flex m-2">
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <p class="card-text"><?php
                                      $class_code = $i['class_code'];
                                      $database->fetch_results($row, "SELECT * FROM classroom_creator,users WHERE classroom_creator.email=users.email AND class_code='$class_code'");
                                      ?></p>
                <p class="card-text"><?php echo "Created By: " . $row['name']; ?></p>
              </div>
              <form action="" method="POST">
                <div class="pb-5 px-5"><input type="submit" name="<?php echo $i['class_code'] ?>" value="Enter Class" class="btn btn-primary btn-go" /></div>
              </form>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
    </section>
  </div>
  </div>
</body>

</html>