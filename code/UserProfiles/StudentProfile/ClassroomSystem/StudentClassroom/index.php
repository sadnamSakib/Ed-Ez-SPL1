<?php
$root_path = '../../../../';
$profile_path = '../../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
require $root_path . 'LibraryFiles/Utility/Utility.php';
require $root_path . 'LibraryFiles/ValidationPhp/InputValidation.php';
foreach (glob($root_path .'LibraryFiles/ClassroomManager/*.php') as $filename)
{
    require $filename;
}
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
if (isset($_REQUEST['post_msg'])) {
  $postManagement=new PostManagement($validate->post_sanitise_text('post_value'),$email->get_email(),$classCode,$utility,$database);
}

$posts = $database->performQuery("SELECT * FROM post,post_classroom WHERE post.post_id=post_classroom.post_id and post_classroom.class_code='$classCode' and active='1' order by post_datetime desc;");
foreach ($posts as $i) {
  $post_id = $i['post_id'];
  if (isset($_REQUEST[$post_id . 'comment_msg'])) {
    $commentManager=new CommentManagement($validate->post_sanitise_text($post_id . 'comment_text'),$post_id,$email->get_email(),$utility,$database);
    unset($_REQUEST[$post_id . 'comment_msg']);
  }
}
$allTasks = $database->performQuery("SELECT * FROM task,task_classroom,event WHERE task.event_id=event.event_id AND task.task_id=task_classroom.task_id AND task_classroom.class_code='$classCode' order by event.event_end_datetime ASC");
foreach($allTasks as $i){
  if(isset($_POST[$i['task_id'].'submit'])){
    if (isset($_FILES[$i['task_id'].'ans']['name'])) {
      $fileManagement = new FileManagement($_FILES[$i['task_id'].'ans']['name'], $_FILES[$i['task_id'].'ans']['tmp_name'], 'pdf', $database, $utility);
      $database->fetch_results($system_date,"SELECT SYSDATE() AS DATE");
      $database->fetch_results($records,"SELECT * FROM task,event WHERE task.event_id=event.event_id");
      if($records['event_end_datetime']<=$sysdate['DATE']){
        $database->performQuery("INSERT INTO student_task_submission(email,task_id,file_id,submission_status) VALUES('".$email->get_email()."','".$i['task_id']."','".$fileManagement->get_file_id()."','1')");
      }
      else{
        $database->performQuery("INSERT INTO student_task_submission(email,task_id,file_id,submission_status) VALUES('".$email->get_email()."','".$i['task_id']."','".$fileManagement->get_file_id()."','0')");
      }
    }
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
  <link href="<?php echo $root_path; ?>boxicons-2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <script defer src="script.js"></script>
  <?php require 'dropdownscript.php'; ?>
  <?php require 'dropdownstyle.php'; ?>
</head>

<body>

  <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
  <div class="main-container d-flex">
    <?php
    require $profile_path . 'navbar.php';
    student_navbar($root_path);
    ?>
    <section class="content-section parent px-2 py-2">

      <div class="div2">
        <div class="card text-bg-primary  mb-3">
          <div class="card-header task-card" style="height:50px">
            <h4 style="text-align:center">Pending Tasks</h4>
          </div>
          <div class="card-body ">

            <?php 
            $database->fetch_results($record,"SELECT count(*)CountTask FROM task,task_classroom,event WHERE task.event_id=event.event_id AND task.task_id=task_classroom.task_id AND task_classroom.class_code='$classCode' order by event.event_end_datetime ASC");           
            ?>
            <p class="card-text" style="text-align:center"><?php echo $record['CountTask']!=0?$record['CountTask']." Tasks Pending":"No Tasks Pending" ?></p>
          </div>
          <div class="card-footer btn bx bxs-chevron-down w-100" type="button" data-bs-toggle="collapse" data-bs-target="#taskcollapse" aria-expanded="false" aria-controls="taskcollapse">

            <!-- <button class="btn bx bxs-chevron-down w-100" type="button" data-bs-toggle="collapse" data-bs-target="#taskcollapse" aria-expanded="false" aria-controls="taskcollapse"> -->

          </div>
          <div class="collapse multi-collapse" id="taskcollapse">
          <?php 
              foreach($allTasks as $i){
          ?>
            <div class="card card-body my-2 btn" data-bs-toggle="modal" data-bs-target="#<?php echo $i['task_id']."modal" ?>" data-bs-whatever="@fat">
              <div class="modal fade" id="<?php echo $i['task_id']."modal" ?>" tabindex="-1" aria-labelledby="<?php echo $i['task_id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="<?php echo $i['task_id'] ?>"><?php echo $i['task_title'] ?></h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form name="<?php echo $i['task_id'].'form' ?>" action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                          <label for="quizDate">Instructions :</label>
                          <p id="taskInstructions"><?php echo $i['instructions'] ?></p>
                        </div>
                        <div class="mb-3">
                          <?php $rows=$database->performQuery("SELECT * from student_task_submission WHERE task_id='".$i['task_id']."' AND email='".$email->get_email()."'") ?>
                          <p id="status">
                          Current Status: 
                        <?php
                          $status="Due";
                          if($rows->num_rows>0){
                            $database->fetch_results($status,"SELECT * from student_task_submission WHERE task_id='".$i['task_id']."' AND email='".$email->get_email()."'");
                            if($status['submission_status']==='1'){
                              $status="Submitted On Time";
                            }
                            else{
                              $status="Late Submission";
                            }
                          }
                          echo $status;
                        ?>
                        </p>
                        </div>
                        <div class="mb-3">
                          <label for="quizDate">Question paper :</label>
                          <a href="<?php echo FileManagement::get_file_url_static($database,URLPath::getFTPServer(),$i['file_id']) ?>" target="__blank">question</a>
                        </div>

                        <label class="mb-4" for="inputGroupFile02">Upload answer script :</label>
                        <div class="input-group mb-3 justify-content-center mx-5">
                          <div class="custom-file">
                            <input type="file" name="<?php echo $i['task_id'].'ans';?>" class="custom-file-input" id="inputGroupFile02">
                          </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <input type="submit" name="<?php echo $i['task_id'].'submit'?>" value="Submit" class="btn btn-primary btn-join">
                    </div>
                    </form>
                  </div>
                </div>
              </div>
              <?php echo $i['task_title'] ?>
            </div>
            <?php
                }
            ?>          
          </div>
        </div>
      </div>
      <div class="div1">
        <div class="card  intro-card text-bg-secondary mb-3">
          <div class="card-body px-4">
            <h3 class="card-title"><?php echo $classroom_records['classroom_name'] ?></h3>
            <h4 class="card-text"><?php echo 'Course Code: ' . $classroom_records['course_code'] ?></h4>
            <p class="card-text"><?php echo 'Semester: ' . $classroom_records['semester'] ?></p>
            <p class="card-text"><?php echo 'Instructor: ' . $teacher_records['name'] ?></p>
            <p class="card-text"><?php echo 'Class Code: ' . $classroom_records['class_code'] ?></p>
          </div>

        </div>


        <form id="Post" name="Post" action="#post_section" method="POST">
          <a name="post_section"></a>
          <textarea class="form-control" name="post_value" id="exampleFormControlTextarea1" placeholder="Write a post..." rows="3"></textarea>
          <div class="d-flex flex-column-reverse pt-2">
            <input type="submit" class="btn btn-primary" name="post_msg" value="Post">
          </div>
        </form>
      </div>


      <div class="div3">
        <?php
        foreach ($posts as $i) {
          $post_ID = $i['post_id'];
        ?>
          <div class="div4">
            <div class="card text-bg-light mb-3">
              <div class="card-header">

                <div class="row">
                  <a name="<?php echo $post_id; ?>post"></a>
                  Posted by <?php
                            $database->fetch_results($user_post, "SELECT * FROM users WHERE email='" . $i['email'] . "'");
                            echo $user_post['name'];
                            ?>
                  at <?php echo date("d/m/Y h:i:s a", strtotime($i['post_datetime'])); ?>
                  <div class="dropdown col-lg-auto col-sm-6 col-md-3">
                    <?php
                    if ($email->get_email() === $user_post['email']) {
                      echo "<i onclick=\"" . $post_ID . "dropdownbtn()\" class=\"dropbtn bx bx-dots-horizontal-rounded\"></i>";
                    }
                    ?>
                    <div id="<?php echo $post_ID; ?>myDropdown" class="dropdown-content dropdown-menu">
                      <form id="<?php echo $post_ID; ?>deletePost" action="" method="POST">
                        <button type="button" class="btn btn-light dropdown-item d-flex" onclick='<?php echo $post_ID; ?>displayModal()' id='<?php echo $post_ID; ?>deletebtn'>Delete</button>
                        <div id="<?php echo $post_ID; ?>myModal" class="modal">
                          <!-- Modal content -->
                          <div class="modal-content w-50">
                            <div class="modal-header">
                              <h3>Are you sure you want to delete the post?</h3>
                            </div>
                            <div class="modal-body d-flex flex-row-reverse">
                              <button type="button" class="btn btn-secondary Close d-flex m-2" onclick='<?php echo $post_ID; ?>closeModal()' id='<?php echo $post_ID; ?>closebtn'>Close</button>
                              <input type="submit" value="Delete" name="<?php echo $post_ID . 'POST'; ?>" class="btn btn-outline-primary btn-join d-flex m-2">
                            </div>
                          </div>
                        </div>
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
                  $database->fetch_results($comments, "SELECT count(*)count_comments FROM comments,comment_post WHERE comment_post.post_id='" . $i['post_id'] . "' AND comments.comment_id=comment_post.comment_id AND active='1'");
                  echo $comments['count_comments'] . " comments";

                  ?>
                </button>
              </div>
              <div class="collapse multi-collapse" id="collapseExample<?php echo $i['post_id'] ?>">
                <?php
                $post_id = $i['post_id'];
                $sql = $database->performQuery("SELECT * FROM comments,comment_post WHERE comments.comment_id=comment_post.comment_id AND comment_post.post_id='" . $post_id . "' and comments.active='1' order by comments.comment_datetime desc");
                foreach ($sql as $j) {
                  $comment_id = $j['comment_id'];
                  $users_email = $j['email'];
                  $database->fetch_results($user_comment, "SELECT * FROM users WHERE email='$users_email'");
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
                        if ($email->get_email() === $users_email) {
                          echo "<i onclick=\"" . $comment_id . "dropdownbtn()\" class=\"dropbtn bx bx-dots-horizontal-rounded\"></i>";
                        }
                        ?>
                        <div id="<?php echo $comment_id; ?>myDropdown" class="dropdown-content dropdown-menu">
                          <form id="<?php echo $comment_ID; ?>deleteComment" action="" method="POST">
                            <button type="button" class="btn btn-light dropdown-item d-flex" onclick='<?php echo $comment_id; ?>displayModal()' id='<?php echo $comment_id; ?>deletebtn'>Delete</button>
                            <div id="<?php echo $comment_id; ?>myModal" class="modal">
                              <!-- Modal content -->
                              <div class="modal-content w-50">
                                <div class="modal-header">
                                  <h3>Are you sure you want to delete this comment?</h3>
                                </div>
                                <div class="modal-body d-flex flex-row-reverse">
                                  <button type="button" class="btn btn-secondary Close d-flex m-2" onclick='<?php echo $comment_id; ?>closeModal()' id='<?php echo $comment_id; ?>closebtn'>Close</button>
                                  <input type="submit" value="Delete" name="<?php echo $comment_id . 'COMMENT'; ?>" class="btn btn-outline-primary btn-join d-flex m-2">
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
          <?php $post_id = $i['post_id']; ?>
          <div class="div5">
            <form id="comment" name="<?php echo $post_id . 'Comment'; ?>" method="POST" action="#<?php echo $post_id; ?>post">
              <div class="input-group mb-3 pb-3">
                <input type="text" class="form-control" placeholder="Leave a comment" aria-label="Leave a comment" aria-describedby="button-addon2" name="<?php echo $post_id . 'comment_text'; ?>">
                <input type="submit" class="btn btn-primary" id="button-addon2" value="comment" name="<?php echo $post_id . 'comment_msg'; ?>">
              </div>
            </form>
          </div>

        <?php
        }
        ?>
      </div>
    </section>
  </div>



</body>

</html>