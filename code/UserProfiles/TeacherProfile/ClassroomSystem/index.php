<?php
$root_path = '../../../';
$profile_path = '../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
require $root_path . 'LibraryFiles/Utility/Utility.php';
require $root_path . 'LibraryFiles/ValidationPhp/InputValidation.php';
session::profile_not_set($root_path);
$validate = new InputValidation();
$email = new EmailValidator($_SESSION['email']);
$tableName = $_SESSION['tableName'];
$error = null;
$database->fetch_results($row, "SELECT * FROM users WHERE email='" . $email->get_email() . "'");
$classrooms = $database->performQuery("SELECT * FROM classroom,teacher_classroom where classroom.class_code=teacher_classroom.class_code and teacher_classroom.email='" . $email->get_email() . "';");
foreach ($classrooms as $dummy_classroom) {
  if (isset($_REQUEST['delete' . $dummy_classroom['class_code']])) {
    $database->performQuery("DELETE FROM teacher_classroom WHERE class_code='" . $dummy_classroom['class_code'] . "';");
    $database->performQuery("UPDATE classroom  SET active='0' WHERE class_code='" . $dummy_classroom['class_code'] . "';");
  }
}

if (isset($_POST['Join'])) {
  $classCode = $validate->post_sanitise_regular_input('classCode');
  $existenceCheck = $database->performQuery("SELECT * FROM teacher_classroom WHERE class_code='$classCode' and email='" . $email->get_email() . "'");
  if ($database->performQuery("SELECT * FROM classroom WHERE class_code='$classCode' and active='1'")->num_rows == 0) {
    $error = "classroom doesn't exist";
  } else if ($existenceCheck->num_rows == 0) {
    $database->performQuery("INSERT INTO teacher_classroom(email,class_code) VALUES('" . $email->get_email() . "','$classCode')");
  } else {
    $error = "You are already enrolled in this classroom";
  }
  unset($_REQUEST['classCode']);
}



if (isset($_POST['Create'])) {
  $classCode = $utility->generateRandomString(10);
  $existence = $database->performQuery("SELECT * FROM classroom where class_code='$classCode'");
  while ($existence->num_rows > 0) {
    $classCode = $utility->generateRandomString(10);
    $existence = $database->performQuery("SELECT * FROM classroom where class_code='$classCode'");
  }
  $className = $validate->post_sanitise_regular_input('courseName');
  $courseCode = $validate->post_sanitise_regular_input('courseCode');
  $attendancePercentage = $validate->post_sanitise_regular_input('attendancePercentage');
  $courseCredit=$validate->post_sanitise_regular_input('courseCredit');
  $semester = $validate->post_sanitise_number('semester');
  if ($className !== null && $courseCode !== null && $semester !== null && $attendancePercentage !== null && $courseCredit !== null) {
    $date = date('Y-m-d H:i:s');
    $database->performQuery("INSERT INTO classroom(class_code,classroom_name,course_code,semester,course_credit,attendance) VALUES('$classCode','$className','$courseCode','$semester','$courseCredit','$attendancePercentage')");
    $database->performQuery("INSERT INTO teacher_classroom(email,class_code) VALUES('" . $email->get_email() . "','$classCode')");
    $database->performQuery("INSERT INTO classroom_creator(email,class_code,creation_date) VALUES('" . $email->get_email() . "','$classCode','$date')");
  } else {
    $error = "All the fields are required";
  }
}

$classrooms = $database->performQuery("SELECT * FROM classroom,teacher_classroom where classroom.class_code=teacher_classroom.class_code and teacher_classroom.email='" . $email->get_email() . "' and classroom.active='1';");
foreach ($classrooms as $dummy_classroom) {
  if (isset($_POST[$dummy_classroom['class_code']])) {
    $_SESSION['class_code'] = $dummy_classroom['class_code'];
    header('Location: TeacherClassroom/index.php');
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
  <?php
      require 'ClassroomSystemScript.php';
      require 'ClassroomSystemStyle.php'; 
  ?>
</head>

<body>
  <script defer src="script.js"></script>
  <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
  <div class="main-container d-flex">
    <?php
    require $profile_path . 'navbar.php';
    teacher_navbar($root_path);
    ?>
    <section class="content-section m-auto px-1 w-75">
      <div class="container justify-content-evenly">
        <div class="container bg-white rounded mt-5 mb-5"></div>
        <div class="px-3 me-3 d-flex flex-row-reverse">
          <button type="button" class="btn btn-outline-primary btn-join d-flex p-4 py-3" data-bs-toggle="modal" data-bs-target="#examplemodal1" data-bs-whatever="@fat"><b>Join new classroom</b></button>
          <div class="modal fade" id="examplemodal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                      <div class="mb-3" id="error" style="display:<?php echo $error === null ? "none" : "block" ?>">
                        <?php echo $error; ?>
                      </div>
                      <div class="mb-3">
                        <input type="text" id="courseName" name="courseName" class="form-control" placeholder="Enter Course Name" aria-label="Leave a comment">
                      </div>
                      <div class="mb-3">
                        <input type="text" id="courseCode" name="courseCode" class="form-control" placeholder="Enter Course Code" aria-label="Leave a comment">
                      </div>
                      <div class="mb-3">
                        <select class="form-select" aria-label="selectSemester" name="semester" id="semester">
                          <option selected value="0">Select Semester</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                          <option value="6">6</option>
                          <option value="7">7</option>
                          <option value="8">8</option>
                          <option value="9">9</option>
                          <option value="10">10</option>
                          <option value="11">11</option>
                          <option value="12">12</option>
                          <option value="13">13</option>
                          <option value="14">14</option>
                          <option value="15">15</option>
                          <option value="16">16</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <input type="number" id="courseCredit" name="courseCredit" class="form-control" step="0.01" placeholder="Enter Course Credit" aria-label="Leave a comment" onclick="
                    var value=document.getElementById('courseCredit');
                    this.setAttribute('min',0);
                    this.setAttribute('max',5);
                    ">
                      </div>
                      <div class="mb-3">
                        <input type="number" id="attendancePercentage" name="attendancePercentage" step="0.01" class="form-control" placeholder="Enter Attendance Percentage" aria-label="Leave a comment" onclick="
                    var value=document.getElementById('courseCredit');
                    this.setAttribute('min',0);
                    this.setAttribute('max',100);
                    ">
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
        </div>
      </div>
      <div class="container bg-white rounded m-auto justify-content-center mt-5 mb-5"></div>
      <div class="row justify-content-start m-auto">
        <div id="error" style="color:red">
          <?php echo $error; ?>
        </div>
        <?php
        foreach ($classrooms as $i) {
        ?>
          <div class="card-element col-lg-4 col-md-6 p-4 px-2">
            <div class="card card-box-shadow">
              <div class="card-header  task-card justify-content-around" style="height:100px">
                <div class="row">
                  <h4 class="card-title col py-1"> <?php echo $i['course_code'] . ": " . $i['classroom_name']; ?></h4>
                  <?php $card = $i['class_code']; ?>
                  <div class="dropdown col-lg-auto col-sm-1 py-3">
                    <i onclick="<?php echo $card; ?>dropdownbtn()" class="<?php echo $card; ?>dropbtn bx bx-dots-horizontal-rounded"></i>
                    <div id="<?php echo $card; ?>myDropdown" class="<?php echo $card; ?>dropdown-content dropdown-menu">
                      <form name='view_delete<?php echo $card; ?>' action='' method='POST'>
                        <input type="submit" value="View Details" name='view<?php echo $card; ?>' class="btn btn-light dropdown-item">
                        <button type="button" class="btn btn-light dropdown-item d-flex" onclick='<?php echo $card; ?>displayModal()' id='<?php echo $card; ?>deletebtn'>Delete classroom</button>
                        <div id="<?php echo $card; ?>myModal" class="modal">
                          <!-- Modal content -->
                          <div class="modal-content w-50">
                            <div class="modal-header">
                              <h3>Are you sure you want to delete the classroom, <?php echo $i['course_code'].': '.$i['classroom_name']; ?>?</h3>
                            </div>
                            <div class="modal-body d-flex flex-row-reverse">
                              <button type="button" class="btn btn-secondary Close d-flex m-2" onclick='<?php echo $card;?>closeModal()' id='<?php echo $card; ?>closebtn'>Close</button>
                              <input type="submit" value="Delete" name='delete<?php echo $card; ?>' class="btn btn-outline-primary btn-join d-flex m-2">
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <p class="card-text"><?php
                                      $class_code = $i['class_code'];
                                      $database->fetch_results($row, "SELECT * FROM classroom_creator,users WHERE classroom_creator.email=users.email AND class_code='$class_code'");
                                      ?></p>
                <p class="card-text"><?php echo "Created By: " . $row['name']; ?></p>
                <p class="card-text"><?php echo "Class Code: " . $i['class_code']; ?></p>
                <div class="pb-3 px-5">
                  <form id="EnterClassroom" name="EnterClassroom" action="" method="POST">
                    <input type="submit" name="<?php echo  $i['class_code']; ?>" value="Enter Class" class="btn btn-primary btn-go">
                  </form>
                </div>
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
</body>
</html>