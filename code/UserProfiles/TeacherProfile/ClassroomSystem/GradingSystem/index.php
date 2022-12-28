<?php
$root_path = '../../../../';
$profile_path = '../../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
require $root_path . 'LibraryFiles/Utility/Utility.php';
require $root_path . 'LibraryFiles/ValidationPhp/InputValidation.php';
require 'CSVHandler.php';
session::profile_not_set($root_path);
$tableName = $_SESSION['tableName'];
$email = new EmailValidator($_SESSION['email']);
$validate = new InputValidation();
$classCode = $_SESSION['class_code'];
$classrooms = $database->performQuery("SELECT * FROM classroom,teacher_classroom where classroom.class_code=teacher_classroom.class_code and teacher_classroom.email='" . $email->get_email() . "' and active='1';");
foreach ($classrooms as $classroom) {
  if (isset($_POST[$classroom['class_code']])) {
    $csvHandler = new CSVHandler($classroom['class_code']);
    $classCode = $classroom['class_code'];
    $tasks = $database->performQuery("SELECT * FROM task,task_classroom WHERE task.task_id=task_classroom.task_id AND task_classroom.class_code='$classCode' AND task.active='1' order by task.task_title asc");
    $totalMarks = 0;
    $task_array = ['Name', 'Student ID'];
    foreach ($tasks as $task) {
      array_push($task_array, $task['task_title']);
      $totalMarks+=$task['marks'];
    }
    array_push($task_array, 'Attendance', 'Total Marks', 'Percentage');
    $csvHandler->write($task_array);
    try {
      $users = $database->performQuery("SELECT DISTINCT student.email,student.studentID,users.name from classroom,student_classroom,users,student WHERE classroom.class_code=student_classroom.class_code AND users.email=student_classroom.email AND student.email=users.email");
      foreach ($users as $user) {
        $user_marks = [$user['name'], is_null($user['studentID']) ? 'N/A' : $user['studentID']];
        $total = 0;
        $marks = [];
        foreach ($tasks as $task) {
          $result = null;
          $database->fetch_results($result, "SELECT marks_obtained from student_task_submission WHERE email='" . $user['email'] . "' AND task_id='" . $task['task_id'] . "'");
          is_null($result) ? array_push($user_marks, 0) : array_push($user_marks, $result['marks_obtained']);
          $total += $result['marks_obtained'];
        }
        $database->fetch_results($attendance, "SELECT nvl(count(*),0)StudentAttendance FROM classroom_session,student_classroom_session WHERE classroom_session.session=student_classroom_session.session AND classroom_session.class_code='$classCode' AND student_classroom_session.email='" . $user['email'] . "'");
        $database->fetch_results($totalAttendance, "SELECT nvl(count(*),0)TotalSessions FROM classroom_session WHERE classroom_session.class_code='$classCode'");
        if ($totalAttendance['TotalSessions'] == 0) {
          $attendancePercentage = $classroom['attendance'];
        } else {
          $attendancePercentage = ($attendance['StudentAttendance'] * $classroom['attendance']) / $totalAttendance['TotalSessions'];
        }
        array_push($user_marks,$attendancePercentage);
        array_push($user_marks,$total);
        if($totalMarks!==0){
          $totalMarks = ($total * 90) / $totalMarks;
        }
        else{
          $totalMarks = 0;
        }
        array_push($user_marks, $totalMarks+$attendancePercentage);
        $csvHandler->write($user_marks);
        $csvHandler->download();
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
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
    teacher_navbar($root_path);
    ?>
    <section class="content-section row">
      <div class="card intro-card w-75 text-bg-secondary m-auto">
        <div class="card-header">
          <h3 class="card-title" style="text-align:center">Gradesheet</h3>

        </div>
        <div class="flex-container w-100">
          <div class="scroll w-100">
            <?php
            foreach ($classrooms as $classroom) {
            ?>
              <div class="card card-body mx-1 my-2 me-1 btn btn-resource saved-resources" style="text-align:left" id="scrollspyHeading1">
                <div class="d-flex justify-content-between">
                  <div class="my-auto">
                  <h4 class="my-auto"><?php echo $classroom['course_code'] . ': ' . $classroom['classroom_name'] ?></h4>
                  </div>
                  <div class="buttonsffs" style="display:inline-block">
                  <form action="" method="POST">
                    <button type="submit" class="btn btn-primary btn-gradeDownload my-3" name="<?php echo $classroom['class_code'] ?>">Attendance</button>
                  <button type="submit" class="btn btn-primary btn-gradeDownload my-3" name="<?php echo $classroom['class_code'] ?>">Gradesheet</button>
                </form>

                  </div>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>

</html>