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
$authentication = $database->performQuery("SELECT * FROM student_classroom WHERE email='" . $email->get_email() . "' and class_code='$classCode'");
if ($authentication->num_rows == 0) {
  session::redirectProfile('student');
}

$allPost = $database->performQuery("SELECT * FROM post WHERE active='1';");
foreach ($allPost as $j) {
  $i = $j['post_id'];
  if (isset($_REQUEST[$i . 'POST'])) {
    $database->performQuery("DELETE FROM post WHERE post_id='$i'");
  }
}
$allComments = $database->performQuery("SELECT * FROM comments WHERE active='1';");
foreach ($allComments as $j) {
  $i = $j['comment_id'];
  if (isset($_REQUEST[$i . 'COMMENT'])) {
    $database->performQuery("DELETE FROM comments WHERE comment_id='$i'");
  }
}

$database->fetch_results($classroom_records, "SELECT * FROM classroom WHERE class_code = '$classCode' and active='1'");
$database->fetch_results($teacher_records, "SELECT * FROM users,teacher_classroom,classroom WHERE users.email=teacher_classroom.email and classroom.class_code='$classCode'");
if (isset($_REQUEST['post_msg']) && !is_null($_REQUEST['post_value'])) {
  $post_date = date('Y-m-d H:i:s');
  $post_id = $utility->generateRandomString(50);
  while (($database->performQuery("SELECT * FROM post WHERE post_id = '$post_id'"))->num_rows > 0) {
    $post_id = $utility->generateRandomString(50);
  }

  $post_value = $validate->post_sanitise_text('post_value');
  if (!is_null($post_value) && $post_value !== '') {
    $database->performQuery("INSERT INTO post(post_id,email,post_datetime,post_message) VALUES('$post_id','" . $email->get_email() . "','$post_date','$post_value');");
    $database->performQuery("INSERT INTO post_classroom(post_id,class_code) VALUES('$post_id','$classCode');");
  }
}

$posts = $database->performQuery("SELECT * FROM post,post_classroom WHERE post.post_id=post_classroom.post_id and post_classroom.class_code='$classCode' and active='1' order by post_datetime desc;");
foreach ($posts as $i) {
  $post_id = $i['post_id'];
  if (isset($_REQUEST[$post_id . 'comment_msg'])) {
    $comment_date = date('Y-m-d H:i:s');
    $comment_id = $utility->generateRandomString(50);
    while (($database->performQuery("SELECT * FROM comments WHERE comment_id = '$comment_id'"))->num_rows > 0) {
      $comment_id = $utility->generateRandomString(50);
    }
    $comment_text = $validate->post_sanitise_text($post_id . 'comment_text');
    if (!is_null($comment_text) && $comment_text !== '') {
      $database->performQuery("INSERT INTO comments(comment_id,email,post_id,comment_datetime,comment_message) VALUES('$comment_id','" . $email->get_email() . "','$post_id','$comment_date','$comment_text');");
    }
    unset($_REQUEST[$post_id . 'comment_msg']);
  }
}
$allPost = $database->performQuery("SELECT * FROM post WHERE active='1'");
$allComments = $database->performQuery("SELECT * FROM comments WHERE active='1'");
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
    <section class="content-section row justify-content-center ms-5 my-5 w-75">
      <div class="col-md-8">
        <canvas id="chartProgress"></canvas>
      </div>
      <div class="progressbars col-md-4">
        <label>Attendance</label>
        <div class="progress my-2">
          <div class="progress-bar bg-success" role="progressbar" style="width: 90%" aria-valuenow="66.6" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <label>Quiz</label>
        <div class="progress my-2">
          <div class="progress-bar bg-success" role="progressbar" style="width: 83%" aria-valuenow="66.6" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <label>Assignment</label>
        <div class="progress my-2">
          <div class="progress-bar bg-success" role="progressbar" style="width: 88%" aria-valuenow="66.6" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <label>Mid-Semester</label>
        <div class="progress my-2">
          <div class="progress-bar bg-success" role="progressbar" style="width: 74%" aria-valuenow="66.6" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <label>Semester Final</label>
        <div class="progress my-2">
          <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="66.6" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
      

    </section>
  </div>

</body>

</html>