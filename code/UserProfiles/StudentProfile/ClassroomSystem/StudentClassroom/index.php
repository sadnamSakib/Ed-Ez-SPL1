<?php
$root_path = '../../../../';
include $root_path . 'LibraryFiles/DatabaseConnection/config.php';
include $root_path . 'LibraryFiles/URLFinder/URLPath.php';
include $root_path . 'LibraryFiles/SessionStore/session.php';
session::create_or_resume_session();
session::profile_not_set($root_path);
$classCode = $_SESSION['class_code'];
$email = $_SESSION['email'];
$dummy_email = hash('sha512', $email);
$authentication = $database->performQuery("SELECT * FROM student_classroom WHERE email='$dummy_email' and class_code='$classCode'");
if ($authentication->num_rows == 0) {
  session::redirectProfile('student');
}

$allPost = $database->performQuery("SELECT * FROM post;");
foreach($allPost as $j){
  $i=$j['post_id'];
  if(isset($_REQUEST[$i.'POST'])){
    $database->performQuery("DELETE FROM post WHERE post_id='$i'");
  }
}
$allComments = $database->performQuery("SELECT * FROM comments;");
foreach($allComments as $j){
  $i=$j['comment_id'];
  if(isset($_REQUEST[$i.'COMMENT'])){
    $database->performQuery("DELETE FROM comments WHERE comment_id='$i'");
  }
}

$classroom_records = mysqli_fetch_assoc($database->performQuery("SELECT * FROM classroom WHERE class_code = '$classCode'"));
$teacher_records = mysqli_fetch_assoc($database->performQuery("SELECT * FROM users,teacher_classroom,classroom WHERE users.email=teacher_classroom.email and classroom.class_code='$classCode';"));
if (isset($_REQUEST['post_msg']) && !is_null($_REQUEST['post_value'])) {
  $post_date = date('Y-m-d H:i:s');
  $post_id = generateRandomString(50);
  while (($database->performQuery("SELECT * FROM post WHERE post_id = '$post_id'"))->num_rows > 0) {
    $post_id = generateRandomString(50);
  }

  $post_value = $_REQUEST['post_value'];
  if (!is_null($post_value) && $post_value !== '') {
    $database->performQuery("INSERT INTO post(post_id,email,post_datetime,post_message) VALUES('$post_id','$dummy_email','$post_date','$post_value');");
    $database->performQuery("INSERT INTO post_classroom(post_id,class_code) VALUES('$post_id','$classCode');");
  }
}

$posts = $database->performQuery("SELECT * FROM post,post_classroom WHERE post.post_id=post_classroom.post_id and post_classroom.class_code='$classCode' order by post_datetime desc;");
foreach ($posts as $i) {
  $post_id = $i['post_id'];
  if (isset($_REQUEST[$post_id . 'comment_msg'])) {
    $comment_date = date('Y-m-d H:i:s');
    $comment_id = generateRandomString(50);
    while (($database->performQuery("SELECT * FROM comments WHERE comment_id = '$comment_id'"))->num_rows > 0) {
      $comment_id = generateRandomString(50);
    }
    $comment_text = $_REQUEST[$post_id . 'comment_text'];
    if (!is_null($comment_text) && $comment_text !== '') {
      $database->performQuery("INSERT INTO comments(comment_id,email,post_id,comment_datetime,comment_message) VALUES('$comment_id','$dummy_email','$post_id','$comment_date','$comment_text');");
    }

    unset($_REQUEST[$post_id . 'comment_msg']);
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
  <style>

<?php
  foreach($allPost as $j){
    $i=$j['post_id'];
?>
<?php echo '#'.$i ?>myDropdown{
  transition: all 0.3s;
}

<?php echo '.'.$i ?>dropdown-content {
  display: none;
  position: absolute;
  background-color: white;
  min-width: 160px;
  border-radius: 1.5px;
  overflow: auto;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  transition: all 0.3s;
}

<?php echo '.'.$i ?>dropdown-content a {
  color: black;
  text-decoration: none;
  display: block;
}
<?php
  }
?>
<?php
  foreach($allComments as $j){
    $i=$j['comment_id'];
?>
<?php echo '#'.$i ?>myDropdown{
  transition: all 0.3s;
}

<?php echo '.'.$i ?>dropdown-content {
  display: none;
  position: absolute;
  background-color: white;
  min-width: 160px;
  border-radius: 1.5px;
  overflow: auto;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  transition: all 0.3s;
}

<?php echo '.'.$i ?>dropdown-content a {
  color: black;
  text-decoration: none;
  display: block;
}
<?php
  }
?>
</style>
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
        <li class=""><a href="<?php echo $root_path ?>UserProfiles/StudentProfile/index.php" class="text-decoration-none px-3 py-2 d-block"><i class='bx bx-user-circle pe-2'></i>Profile</a></li>
        <li class=""><a href="<?php echo $root_path ?>UserProfiles/StudentProfile/StudentSchedule/index.php" class="text-decoration-none px-3 py-2 d-block"><i class='bx bxs-calendar-plus pe-2'></i>Schedule</a></li>
        <li class=""><a href="<?php echo $root_path ?>UserProfiles/StudentProfile/ClassroomSystem/index.php" class="text-decoration-none px-3 py-2 d-block"><i class='bx bx-chalkboard pe-2'></i>Classrooms</a></li>
        <li class=""><a href="#" class="text-decoration-none px-3 py-2 d-block"><i class='bx bxs-bar-chart-alt-2 pe-2'></i>Grades</a></li>


      </ul>
    </div>
    <div class="content">
      <nav class="navbar navbar-expand p-3" style="background-color: #4596be;">
        <div class="container-fluid mx-5 px-4">
          <div class="d-flex justify-content-between d-block">
            <button class="btn btn-primary open-btn me-2"><i class='bx bx-menu'></i></i></button>
            <a href="#" class="navbar-brand fs-5 px-3 mx-4" href="#"><span class="bg-dark rounded px-2 py-0 text-white">Ed-Ez</span></a>
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
      <section class="content-section m-auto px-2 py-2">
        <div class="container-fluid bg-white rounded mt-5 mb-5"></div>
        <!-- <h2 class="fs-5">Profile</h2> -->
        <div class="row justify-content-center">
          <div class="col-md-6 col-sm-6">
            <div class="card intro-card text-bg-secondary mb-3">
              <div class="card-body px-4">
                <h1 class="card-title"><?php echo $classroom_records['classroom_name'] ?></h1>
                <h4 class="card-text"><?php echo 'Course Code: ' . $classroom_records['course_code'] ?></h4>
                <p class="card-text"><?php echo 'Semester: ' . $classroom_records['semester'] ?></p>
                <p class="card-text"><?php echo 'Instructor: ' . $teacher_records['name'] ?></p>
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
                  Posted by <?php
                              $user_record = mysqli_fetch_assoc($database->performQuery("SELECT * FROM users WHERE email='" . $i['email'] . "';"));
                              echo $user_record['name'];
                              ?>
                            <div class="dropdown col-lg-auto col-sm-6 col-md-3">
                              <?php
                                  if($dummy_email===$user_record['email']){
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
                    $comments = mysqli_fetch_assoc($database->performQuery("SELECT count(*)count_comments FROM comments WHERE post_id='" . $i['post_id'] . "'"));
                    echo $comments['count_comments'] . " comments";

                    ?>
                  </button>
                </div>
                <div class="collapse multi-collapse" id="collapseExample<?php echo $i['post_id'] ?>">
                  <?php
                  $post_id = $i['post_id'];
                  $sql = $database->performQuery("SELECT * FROM comments WHERE post_id='" . $post_id . "' order by comment_datetime desc;");
                  foreach ($sql as $j) {
                    $comment_id=$j['comment_id'];
                    $users_email = $j['email'];
                    $users_records = mysqli_fetch_assoc($database->performQuery("SELECT * FROM users WHERE email='$users_email'"));
                  ?>
                    <div class="card p-1">
                      <div class="card-header">Commented by <?php echo $users_records['name']; ?></div>
                      <div class="card card-body">
                        <div class="row">
                          <p class="col py-2"><?php echo $j['comment_message']; ?> </p>
                          <div class="dropdown col-lg-auto col-sm-6 col-md-3">
                          <?php  
                                  if($dummy_email===$users_email){
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
              <form id="comment" name="<?php echo $post_id . 'Comment'; ?>" method="POST" action="#<?php echo $post_id; ?>comment_section">
                <div class="input-group mb-3 pb-3">
                  <a name="<?php echo $post_id; ?>comment_section"></a>
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
<?php
  foreach($allPost as $i){
    $post_selector=$i['post_id'];
?>
<script>
  function <?php echo $post_selector;?>dropdownbtn() {
    document.getElementById("<?php echo $post_selector;?>myDropdown").classList.toggle("show");
  }
  </script>
  <?php
  }
  ?>

<?php
  foreach($allComments as $i){
    $comment_selector=$i['comment_id'];
?>
<script>
  function <?php echo $comment_selector;?>dropdownbtn() {
    document.getElementById("<?php echo $comment_selector;?>myDropdown").classList.toggle("show");
  }
  </script>
  <?php
  }
  ?>

<script>
  function dropdownbtnNew() {
    document.getElementById("myDropdown2").classList.toggle("show");
  }
  // Close the dropdown if the user clicks outside of it
  window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
  }
</script>
</html>