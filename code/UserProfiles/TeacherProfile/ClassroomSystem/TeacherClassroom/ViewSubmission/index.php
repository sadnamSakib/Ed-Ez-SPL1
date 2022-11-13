<?php
$root_path = '../../../../../';
$profile_path = '../../../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
require $root_path . 'LibraryFiles/Utility/Utility.php';
require $root_path . 'LibraryFiles/ValidationPhp/InputValidation.php';
foreach (glob($root_path . 'LibraryFiles/ClassroomManager/*.php') as $filename) {
  require $filename;
}
$classCode = $_SESSION['class_code'];
session::create_or_resume_session();
session::profile_not_set($root_path);
$allTasks=$database->performQuery("SELECT * from task");
$searchTaskResult=$_SESSION['searchTask'];
foreach($allTasks as $i){
  if(isset($_POST[$i['task_id'].'submit'])){
    $searchTaskResult=$i['task_id'];
    break;
  }
}
if($searchTaskResult==null){
  header("Location: ../index.php");
}
else{
  $_SESSION['searchTask']=$searchTaskResult;
}

$allTaskSubmissions=$database->performQuery("SELECT student_task_submission.submission_status as submission_status, users.name as name,task.marks as marks,student_task_submission.marks_obtained as marks_obtained,users.email as email,student_task_submission.file_id as file_id,student_task_submission.task_id as task_id from student_task_submission,users,task WHERE task.task_id=student_task_submission.task_id AND student_task_submission.task_id='$searchTaskResult' AND users.email=student_task_submission.email");
foreach($allTaskSubmissions as $i){
  if(isset($_REQUEST[$i['file_id'].'submissionView'])){
    $email=$_POST[$i['file_id'].'email'];
    $file_id=$_POST[$i['file_id'].'file_id'];
    $marksObtained=$_POST[$i['file_id'].'marksObtained'];
    $task_id=$i['task_id'];
    $database->performQuery("UPDATE student_task_submission SET marks_obtained='$marksObtained' WHERE task_id='$task_id' AND email='$email' AND file_id='$file_id'");
  }
}
$allTaskSubmissions=$database->performQuery("SELECT student_task_submission.submission_status as submission_status, users.name as name,task.marks as marks,student_task_submission.marks_obtained as marks_obtained,users.email as email,student_task_submission.file_id as file_id,student_task_submission.task_id as task_id from student_task_submission,users,task WHERE task.task_id=student_task_submission.task_id AND student_task_submission.task_id='$searchTaskResult' AND users.email=student_task_submission.email");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>View Submissions</title>
  <link rel="icon" href="<?php echo $root_path; ?>title_icon.jpg" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link href="<?php echo $root_path;?>boxicons-2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <script defer src="script.js"></script>
</head>

<body>

  <script src="<?php echo $root_path; ?>js/bootstrap.min.js"></script>
  <div class="main-container d-flex">
    <?php
    require $profile_path . 'navbar.php';
    teacher_navbar($root_path);
    ?>
    <section class="content-section m-auto px-5">
      <div class="container-fluid bg-white rounded mt-5 mb-5"></div>
      <!-- <h2 class="fs-5">Profile</h2> -->
      <div class="card intro-card w-75 text-bg-secondary m-auto mb-3">
        <div class="card-header">
          <h5 class="card-title" style="text-align:center">Submissions</h5>
        </div>
        <div class="card-body btn bx bxs-chevron-down w-100" type="button" data-bs-toggle="collapse" data-bs-target="#taskcollapse" aria-expanded="false" aria-controls="taskcollapse">
          </div>
            <div class="collapse multi-collapse" id="taskcollapse">
                <div class="flex-container">
                <?php
                  foreach($allTaskSubmissions as $i)
                  {
                ?>
                
                <div class="card card-body btn my-2 w-50 me-2">
                  <span style="text-align:left"><a href="<?php echo FileManagement::get_file_url_static($database,URLPath::getFTPServer(),$i['file_id'])?>" target="_blank" style="all:unset"><?php echo $i['name'] ?></a></span>
                  <span style="text-align:left;color:<?php echo $i['submission_status']==='1'?'green':'red'?>"><?php echo $i['submission_status']==='1'?'Submitted In Time':'Late Submission' ?></span>
                </div>
                <div class="marks w-25 my-2 me-2">
                <form action="" method="POST" name="<?php echo $i['file_id']?>form" class="py-2">
                    <input type="hidden" name="<?php echo $i['file_id'] ?>email" value="<?php echo $i['email']?>">
                    <input type="hidden" name="<?php echo $i['file_id'] ?>file_id" value="<?php echo $i['file_id']?>">
                    <input type="number" id="marksObtained" name="<?php echo $i['file_id'] ?>marksObtained" class="form-control" onclick="
                    var value=document.getElementById('marksObtained');
                    this.setAttribute('min',0);
                    this.setAttribute('max',<?php echo $i['marks'] ?>);
                    " required placeholder="<?php echo $i['marks_obtained']===null?'Enter Marks':$i['marks_obtained'] ?>">
                  </div>
                  <div>
                <input type="submit" name="<?php echo $i['file_id'] ?>submissionView" class="btn btn-primary btn-xs btn-join me-2 m-auto" value="Submit">
                </div>
                  </form>
                <?php
                  }
                ?>
        </div>

    </section>
  </div>
</body>

</html>