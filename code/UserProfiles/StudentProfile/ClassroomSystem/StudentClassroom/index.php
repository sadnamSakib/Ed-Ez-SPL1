<?php
$root_path = '../../../../';
$profile_path='../../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
require $root_path . 'LibraryFiles/Utility/Utility.php';
require $root_path . 'LibraryFiles/ValidationPhp/InputValidation.php';
$database->fetch_results($sysdate,"SELECT SYSDATE() AS DATE");
session::profile_not_set($root_path);
$validate=new InputValidation();
$classCode = $_SESSION['class_code'];
$email=new EmailValidator($_SESSION['email']);
$authentication = $database->performQuery("SELECT * FROM student_classroom WHERE email='".$email->get_email()."' and class_code='$classCode'");
if ($authentication->num_rows == 0) {
  session::redirectProfile('student');
}

$allPost = $database->performQuery("SELECT * FROM post WHERE active='1';");
foreach($allPost as $j){
  $i=$j['post_id'];
  if(isset($_REQUEST[$i.'POST'])){
    $database->performQuery("DELETE FROM post WHERE post_id='$i'");
  }
}
$allComments = $database->performQuery("SELECT * FROM comments WHERE active='1';");
foreach($allComments as $j){
  $i=$j['comment_id'];
  if(isset($_REQUEST[$i.'COMMENT'])){
    $database->performQuery("DELETE FROM comments WHERE comment_id='$i'");
  }
}

$database->fetch_results($classroom_records,"SELECT * FROM classroom WHERE class_code = '$classCode' and active='1'");
$database->fetch_results($teacher_records,"SELECT * FROM users,teacher_classroom,classroom WHERE users.email=teacher_classroom.email and classroom.class_code='$classCode'");
if (isset($_REQUEST['post_msg']) && !is_null($_REQUEST['post_value'])) {
  $post_date = $sysdate['DATE'];
  $post_id = $utility->generateRandomString(50);
  while (($database->performQuery("SELECT * FROM post WHERE post_id = '$post_id'"))->num_rows > 0) {
    $post_id = $utility->generateRandomString(50);
  }

  $post_value = $validate->post_sanitise_text('post_value');
  if (!is_null($post_value) && $post_value !== '') {
    $database->performQuery("INSERT INTO post(post_id,email,post_datetime,post_message) VALUES('$post_id','".$email->get_email()."','$post_date','$post_value');");
    $database->performQuery("INSERT INTO post_classroom(post_id,class_code) VALUES('$post_id','$classCode');");
  }
}

$posts = $database->performQuery("SELECT * FROM post,post_classroom WHERE post.post_id=post_classroom.post_id and post_classroom.class_code='$classCode' and active='1' order by post_datetime desc;");
foreach ($posts as $i) {
  $post_id = $i['post_id'];
  if (isset($_REQUEST[$post_id . 'comment_msg'])) {
    $comment_date = $sysdate['DATE'];
    $comment_id = $utility->generateRandomString(50);
    while (($database->performQuery("SELECT * FROM comments WHERE comment_id = '$comment_id'"))->num_rows > 0) {
      $comment_id = $utility->generateRandomString(50);
    }
    $comment_text = $validate->post_sanitise_text($post_id . 'comment_text');
    if (!is_null($comment_text) && $comment_text !== '') {
      $database->performQuery("INSERT INTO comments(comment_id,email,post_id,comment_datetime,comment_message) VALUES('$comment_id','".$email->get_email()."','$post_id','$comment_date','$comment_text');");
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
  <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link href="<?php echo $root_path;?>boxicons-2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <script defer src="script.js"></script>
  <?php require 'dropdownscript.php';?>
  <?php require 'dropdownstyle.php'; ?>
</head>

<body>

  <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
  <div class="main-container d-flex">
  <?php 
      require $profile_path.'navbar.php';
      student_navbar($root_path);
    ?>
      <section class="content-section px-2 py-2">
      <div class="container-fluid bg-white rounded mt-5 mb-5"></div>
      <div class="row justify-content-center">
        <div class="col-md-6 col-sm-6">
          <div class="card intro-card text-bg-secondary mb-3">
            <div class="card-body px-4">
              <h3 class="card-title"><?php echo $classroom_records['classroom_name'] ?></h3>
              <h4 class="card-text"><?php echo 'Course Code: ' . $classroom_records['course_code'] ?></h4>
              <p class="card-text"><?php echo 'Semester: ' . $classroom_records['semester'] ?></p>
              <p class="card-text"><?php echo 'Instructor: ' . $teacher_records['name'] ?></p>
              <p class="card-text"><?php echo 'Class Code: ' . $classroom_records['class_code'] ?></p>
            </div>
          </div>
        </div>
          <div class="col-md-3 col-sm-6 border-end">
            <div class="card text-bg-primary  mb-3">
              <div class="card-header task-card" style="height:50px">
                <h4 style="text-align:center">Pending Tasks</h4>
              </div>
              <div class="card-body ">
                <p class="card-text" style="text-align:center">No pending tasks.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row justify-content-center my-3 post">
          <div class="col-md-6 col-sm-6 border-end">
            <form id="Post" name="Post" action="#post_section" method="POST">
              <a name="post_section"></a>
              <textarea class="form-control" name="post_value" id="exampleFormControlTextarea1" placeholder="Write a post..." rows="3"></textarea>
              <div class="d-flex flex-column-reverse pt-2">
                <input type="submit" class="btn btn-primary" name="post_msg" value="Post">
              </div>
            </form>
          </div>
          <div class="col-md-3 col-sm-6 border-end">
          </div>
        </div>
        <?php

        foreach ($posts as $i) {
          $post_ID=$i['post_id'];
        ?>
          <div class="row justify-content-center">
            <div class="col-md-6 col-sm-6 border-end">
              <div class="card  text-bg-light mb-3">
              <div class="card-header">
                  
              <div class="row">
              <a name="<?php echo $post_id; ?>post"></a>
                  Posted by <?php
                              $database->fetch_results($user_post,"SELECT * FROM users WHERE email='" . $i['email'] . "'");
                              echo $user_post['name'];
                              ?>
                               at <?php echo date("d/m/Y h:i:s a", strtotime($i['post_datetime'])); ?> 
                            <div class="dropdown col-lg-auto col-sm-6 col-md-3">
                              <?php
                                  if($email->get_email()===$user_post['email']){
                                    echo "<i onclick=\"".$post_ID."dropdownbtn()\" class=\"dropbtn bx bx-dots-horizontal-rounded\"></i>";
                                  }
                              ?>
                              <div id="<?php echo $post_ID;?>myDropdown" class="dropdown-content dropdown-menu">
                                <form id="<?php echo $post_ID; ?>deletePost" action="" method="POST">
                                  <input type="submit" value="Delete" class="dropdown-item" name="<?php echo $post_ID.'POST';?>">
                                </form>
                              </div>
                            </div>
                          </div>
                </div>
                <div class="card-body">
                  <p class="card-text"><?php echo $i['post_message']; ?></p>
                </div>
                <div>
                  <button class="btn btn-dark w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample<?php echo $i['post_id'] ?>" aria-expanded="false" aria-controls="collapseExample">
                    <?php
                    $database->fetch_results($comments,"SELECT count(*)count_comments FROM comments WHERE post_id='" . $i['post_id'] . "' and active='1'");
                    echo $comments['count_comments'] . " comments";

                    ?>
                  </button>
                </div>
                <div class="collapse multi-collapse" id="collapseExample<?php echo $i['post_id'] ?>">
                  <?php
                  $post_id = $i['post_id'];
                  $sql = $database->performQuery("SELECT * FROM comments WHERE post_id='" . $post_id . "' and active='1' order by comment_datetime desc;");
                  foreach ($sql as $j) {
                    $comment_id=$j['comment_id'];
                    $users_email = $j['email'];
                     $database->fetch_results($user_comment,"SELECT * FROM users WHERE email='$users_email'");
                  ?>
                    <div class="card p-1">
                      <div class="card-header">
                        Commented by <?php echo $user_comment['name']; ?>
                        at <?php echo date("d/m/Y h:i:s a", strtotime($j['comment_datetime'])); ?> 
                    
                    </div>
                      <div class="card card-body">
                        <div class="row">
                          <p class="col py-2"><?php echo $j['comment_message']; ?> </p>
                          <div class="dropdown col-lg-auto col-sm-6 col-md-3">
                          <?php  
                                  if($email->get_email()===$users_email){
                                    echo "<i onclick=\"".$comment_id."dropdownbtn()\" class=\"dropbtn bx bx-dots-horizontal-rounded\"></i>";
                                  }
                              ?>
                            <div id="<?php echo $comment_id; ?>myDropdown" class="dropdown-content dropdown-menu">
                                <form id="<?php echo $comment_ID; ?>deleteComment" action="" method="POST">
                                  <input type="submit" value="Delete" class="dropdown-item" name="<?php echo $comment_id.'COMMENT';?>">
                                </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php
                  }
                  ?>
                  <!--END-->
                </div>
              </div>
              <?php $post_id = $i['post_id']; ?>
              <form id="comment" name="<?php echo $post_id . 'Comment'; ?>" method="POST" action="#<?php echo $post_id; ?>post">
                <div class="input-group mb-3 pb-3">
                  <input type="text" class="form-control" placeholder="Leave a comment" aria-label="Leave a comment" aria-describedby="button-addon2" name="<?php echo $post_id . 'comment_text'; ?>">
                  <input type="submit" class="btn btn-primary" id="button-addon2" value="comment" name="<?php echo $post_id . 'comment_msg'; ?>">
                </div>
              </form>
            </div>
            <div class="col-md-3 col-sm-6 border-end">
            </div>
          </div>
        <?php
        }
        ?>


      </section>
    </div>
  </div>


</body>
</html>