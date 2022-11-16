<?php
$root_path = '../../../../';
$profile_path = '../../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
require $root_path . 'LibraryFiles/Utility/Utility.php';
require $root_path . 'LibraryFiles/ValidationPhp/InputValidation.php';
foreach (glob($root_path . 'LibraryFiles/ClassroomManager/*.php') as $filename) {
  require $filename;
}
session::profile_not_set($root_path);
$validate = new InputValidation();
$classCode = $_SESSION['class_code'];
$email = new EmailValidator($_SESSION['email']);
$authentication = $database->performQuery("SELECT * FROM teacher_classroom WHERE email='" . $email->get_email() . "' and class_code='$classCode'");
if ($authentication->num_rows == 0) {
  session::redirectProfile('teacher');
}

if (isset($_POST['taskSubmit'])) {
  $task_id = $utility->generateRandomString(50);
  $existence = $database->performQuery("SELECT * FROM task where task_id='$task_id'");
  while ($existence->num_rows > 0) {
    $task_id = $utility->generateRandomString(50);
    $existence = $database->performQuery("SELECT * FROM task where task_id='$task_id'");
  }
  $task_title = $_REQUEST['TaskTitle'];
  $Deadline = $_REQUEST['Deadline'];
  $marks = $_REQUEST['Marks'];
  $database->fetch_results($row, "select * from classroom where class_code='$classCode'");
  $semester = $row['semester'];
  $instructions = $validate->post_sanitise_regular_input('instruction');
  $database->fetch_results($row, "select * from users where email='" . $email->get_email() . "'");
  $institution = $row['institution'];
  if (isset($_FILES['taskName']['name'])) {
    $eventManagement = new EventManagement(EventManagement::get_system_date($database), $Deadline, $database, $utility);
    $fileManagement = new FileManagement($_FILES['taskName']['name'], $_FILES['taskName']['tmp_name'], 'pdf', $database, $utility);
    $insertquery = "INSERT INTO task(task_id,task_title,event_id,institution,semester,marks,file_id,instructions) VALUES('$task_id','$task_title','" . $eventManagement->get_event_id() . "','$institution','$semester','$marks','" . $fileManagement->get_file_id() . "','$instructions')";
    $database->performQuery($insertquery);
    $database->performQuery("INSERT INTO task_classroom(task_id,class_code) VALUES('$task_id','$classCode')");
    $Deadline = date("d/m/Y h:i:s a", strtotime($Deadline));
    $link = $fileManagement->get_file_url(URLPath::getFTPServer());
    $post_text = "A Task has been assigned: <br> Title: $task_title <br>  Deadline: $Deadline <br> Marks: $marks <br> Question Link: <a href=\"$link\" target=\"__blank\">Link</a>";
    $taskPost = new PostManagement($post_text, $email->get_email(), $classCode, $utility, $database);
  }
}

$session = "No ongoing sessions";
$sessionError = false;
if (isset($_POST['sessionSubmit'])) {
  $session = $utility->generateRandomString(10);
  $existence = $database->performQuery("SELECT * FROM classroom_session WHERE session='$session'");
  while ($existence->num_rows > 0) {
    $session = $utility->generateRandomString(10);
    $existence = $database->performQuery("SELECT * FROM classroom_session WHERE session='$session'");
  }
  $startTime = $_REQUEST['sessionStart'];
  $endTime = $_REQUEST['sessionEnd'];
  $eventManagement = new EventManagement($startTime, $endTime, $database, $utility);
  $deadline=$_REQUEST['attendanceDeadline'];
  $database->performQuery("INSERT INTO classroom_session VALUES('$classCode','$session','" . $eventManagement->get_event_id() . "','$deadline')");
  $post_text = "A Classroom Session Has Been Posted";
  $online = $_REQUEST['online'];
  $offline = $_REQUEST['offline'];
  $sessionLink = null;
  if ($online === "online") {
    $sessionLink = $_REQUEST['SessionLink'];
    if ($sessionLink == null || $sessionLink === "") {
      $sessionError = true;
    }
    $sessionLink = "<a href=\"$sessionLink\" target=\"__blank\">[Click Here]</a>";
    $post_text = $post_text . ", Online Session Link: " . $sessionLink . ". ";
  } else {
    $post_text = $post_text . " Session is an offline session. ";
  }
  $post_text = $post_text . "<br> Start Date and Time: $startTime <br> End Date and Time: $endTime <br>";
  if ($online === "online" && $sessionError == true) {
    $database->performQuery("DELETE FROM classroom_session WHERE session='$session'");
    $session = "No Session Links Provided";
  } else {
    $sessionPost = new PostManagement($post_text, $email->get_email(), $classCode, $utility, $database);
  }
}


$allPost = $database->performQuery("SELECT * FROM post WHERE active='1';");
foreach ($allPost as $j) {
  $i = $j['post_id'];
  if (isset($_REQUEST[$i . 'POST'])) {
    $database->performQuery("UPDATE post SET active='0' WHERE post_id='$i'");
  }
}
$allComments = $database->performQuery("SELECT * FROM comments WHERE active='1';");
foreach ($allComments as $j) {
  $i = $j['comment_id'];
  if (isset($_REQUEST[$i . 'COMMENT'])) {
    $database->performQuery("UPDATE comments SET active='0' WHERE comment_id='$i'");
  }
}

$database->fetch_results($classroom_records, "SELECT * FROM classroom WHERE class_code = '$classCode' and active='1'");
$database->fetch_results($teacher_records, "SELECT * FROM users WHERE email = '" . $email->get_email() . "'");
if (isset($_REQUEST['post_msg'])) {
  $postManagement = new PostManagement($validate->post_sanitise_text('post_value'), $email->get_email(), $classCode, $utility, $database);
}

$posts = $database->performQuery("SELECT * FROM post,post_classroom WHERE post.post_id=post_classroom.post_id and post_classroom.class_code='$classCode' and active='1' order by post_datetime desc;");
foreach ($posts as $i) {
  $post_id = $i['post_id'];
  if (isset($_REQUEST[$post_id . 'comment_msg'])) {
    $commentManager = new CommentManagement($validate->post_sanitise_text($post_id . 'comment_text'), $post_id, $email->get_email(), $utility, $database);
    unset($_REQUEST[$post_id . 'comment_msg']);
  }
}
$allPost = $database->performQuery("SELECT * FROM post WHERE active='1';");
$allComments = $database->performQuery("SELECT * FROM comments,comment_post WHERE comments.comment_id=comment_post.comment_id AND comments.active='1'");
$allTasks = $database->performQuery("SELECT * FROM task,task_classroom,event WHERE task.event_id=event.event_id AND task.task_id=task_classroom.task_id AND task_classroom.class_code='$classCode' order by event.event_end_datetime ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Classroom</title>
  <link rel="icon" href="<?php echo $root_path; ?>title_icon.jpg" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
  <link href="<?php echo $root_path; ?>boxicons-2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <script src="script.js"></script>
  <script src="<?php echo $root_path; ?>js/bootstrap.min.js"></script>
  <?php require 'dropdownstyle.php'; ?>
  <?php require 'dropdownscript.php'; ?>
</head>

<body>
  <div class="main-container d-flex">
    <?php
    require $profile_path . 'navbar.php';
    teacher_navbar($root_path);
    ?>
    <section class="content-section parent px-2 py-2">
      <div class="div2">
        <div class="card-header d-flex flex-row justify-content-between">
          <button type="button" class="btn btn-outline-primary btn-join m-3" data-bs-toggle="modal" data-bs-target="#examplemodal1" data-bs-whatever="@fat">Create Task</button>
          <div class="modal fade" id="examplemodal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Create Task</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div id="error" style="display:none">
                  </div>
                  <form action="" method="POST" name="taskForm" id="taskForm" enctype="multipart/form-data">
                    <div class="mb-3">
                      <label for="TaskTitle">Task Title :</label>
                      <input type="text" class="form-control" id="TaskTitle" name="TaskTitle" placeholder="Enter Task Title" required>
                    </div>
                    <div class="mb-3">
                      <label for="taskDateTime">Deadline :</label>
                      <input type="datetime-local" id="Deadline" name="Deadline" class="form-control" onclick="
                            var dateString=new Date();
                            this.setAttribute('min',dateString);" required>
                    </div>
                    <div class="mb-3">
                      <label for="Marks">Marks :</label>
                      <input type="number" class="form-control" id="taskMarks" name="Marks" placeholder="Enter Marks" onclick="
                        var value=document.getElementById('taskMarks');
                        this.setAttribute('min',1);
                        this.setAttribute('max',4000);
                        " required>
                    </div>
                    <div class="mb-3">
                      <label for="message-text" class="col-form-label">Instruction :</label>
                      <textarea class="form-control" id="message-text" name="instruction" required></textarea>
                    </div>
                    <div class="input-group mb-2">
                      <div class="custom-file">
                        <label class="mb-2" for="taskName">Upload Question Paper :</label>
                        <input type="file" id="taskName" name="taskName" class="custom-file-input" accept=".pdf" required />
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <input type="submit" name="taskSubmit" value="Create Task" class="btn btn-primary btn-join">
                </div>
                </form>
              </div>
            </div>
          </div>
          <div class="d-flex flex-row justify-content-between">
            <button type="button" class="btn btn-outline-primary btn-join m-3" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat">Create Session</button>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Session</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action='' method='POST' id='sessionForm' name='sessionForm'>
                      <div class="mb-3">
                        <label for="online">Online Session</label>
                        <input type="radio" name="online" value="online" id="online" onclick="document.getElementById('sessionURL').style.display='block';document.getElementById('offline').checked=false;">
                      </div>
                      <div class="mb-3">
                        <label for="offline">Offline Session</label>
                        <input type="radio" name="offline" value="offline" id="offline" onclick="document.getElementById('sessionURL').style.display='none';document.getElementById('online').checked=false;">
                      </div>
                      <div class="mb-3" style="display:none" id="sessionURL">
                        <label for="SessionLink">Session Link :</label>
                        <input type="text" class="form-control" id="SessionLink" name="SessionLink" placeholder="Enter Session Link">
                      </div>
                      <div class="mb-3">
                        <label for="startTime">Start Date and Time :</label>
                        <input type="datetime-local" id="sessionStart" name="sessionStart" class="form-control" onclick="
                            var dateString2=new Date();
                            this.setAttribute('min',dateString2);" required>
                      </div>
                      <div class="mb-3">
                        <label for="attendanceDeadline">Attendance Deadline :</label>
                        <input type="datetime-local" id="attendanceDeadline" name="attendanceDeadline" class="form-control" onclick="
                            var startDateTime1=document.getElementById('sessionStart').value;
                            this.setAttribute('min',startDateTime1);" required>
                      </div>
                      <div class="mb-3">
                        <label for="endTime">End Date and Time :</label>
                        <input type="datetime-local" id="sessionEnd" name="sessionEnd" class="form-control" onclick="
                            var startDateTime=document.getElementById('sessionStart').value;
                            this.setAttribute('min',startDateTime);" required>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="sessionSubmit" value="Create Session" class="btn btn-primary btn-join">
                  </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card text-bg-primary mb-3">
          <div class="card-body task-card" style="height:50px">
            <h4 style="text-align:center">Assigned Tasks</h4>
          </div>
          <form id="view" name="viewPage" action="ViewSubmission/index.php" method="POST">
          <div class="card-footer btn bx bxs-chevron-down w-100" type="button" data-bs-toggle="collapse" data-bs-target="#taskcollapse" aria-expanded="false" aria-controls="taskcollapse">
          </div>
            <div class="collapse multi-collapse" id="taskcollapse">
            <?php
            if ($allTasks->num_rows == 0) {
              echo "<div class=\"card-text\" style=\"text-align:center\">No assigned tasks.</div>";
            } else {
              foreach ($allTasks as $i) {
                echo "<div class=\"collapse multi-collapse\" id=\"taskcollapse\"><div class=\"card card-body my-2 btn\" style=\"text-align:center\"><input type='submit' style='border:none;background:none;padding:0' name='".$i['task_id']."submit' value='".$i['task_title']."'></div></div>";

            ?>
            <?php
              }
            }
            ?>
            </form>
        </div>
      </div>
      <div class="card text-bg-primary mb-3">
          <div class="card-body task-card" style="height:50px">
            <h4 style="text-align:center">Session Code</h4>
          </div>
          <div class="card-footer btn bx bxs-chevron-down w-100" type="button" data-bs-toggle="collapse" data-bs-target="#sessionCollapse" aria-expanded="false" aria-controls="sessionCollapse">
          </div>
            <div class="collapse multi-collapse" id="sessionCollapse">
            <div class="card-text" style="text-align:center;color:<?php echo $sessionError===true?'red':'black' ?>"><?php echo $session; ?></div>
        </div>
      </div>
  </div>

  <div class="div1">
    <div class="card intro-card text-bg-secondary mb-3">
      <div class="card-body px-4">
        <h2 class="card-title"><?php echo $classroom_records['classroom_name'] ?></h2>
        <h4 class="card-text"><?php echo 'Course Code: ' . $classroom_records['course_code'] ?></h4>
        <p class="card-text"><?php echo 'Semester: ' . $classroom_records['semester'] ?></p>
        <p class="card-text"><?php echo 'Instructor: ' . $teacher_records['name'] ?></p>
        <p class="card-text"><?php echo 'Class Code: ' . $classroom_records['class_code'] ?></p>
      </div>
    </div>
    <div class="row justify-content-center my-0 post">

      <form id="Post" name="Post" action="#post_section" method="POST">
        <a name="post_section"></a>
        <textarea class="form-control" name="post_value" id="exampleFormControlTextarea1" placeholder="Write a post..." rows="3"></textarea>
        <div class="d-flex flex-column-reverse pt-2">
          <input type="submit" class="btn btn-primary" name="post_msg" value="Post">
        </div>
      </form>

    </div>
  </div>



  <div class="div3">
    <?php
    foreach ($posts as $i) {
      $post_ID = $i['post_id'];
    ?>

      <div class="div4">
        <div class="card text-bg-light mb-3">
          <div class="card-header  postcard">

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
            <button class="btn btn-dark w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample<?php echo $i['post_id']; ?>" aria-expanded="false" aria-controls="collapseExample">
              <?php
              $database->fetch_results($comments, "SELECT count(*)count_comments FROM comments,comment_post WHERE comment_post.post_id='" . $i['post_id'] . "' AND comments.comment_id=comment_post.comment_id AND active='1'");
              echo $comments['count_comments'] . " comments";
              ?>
            </button>
          </div>
          <div class="collapse multi-collapse" id="collapseExample<?php echo $i['post_id']; ?>">
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
                        <form id="<?php echo $comment_id; ?>deleteComment" action="" method="POST">
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