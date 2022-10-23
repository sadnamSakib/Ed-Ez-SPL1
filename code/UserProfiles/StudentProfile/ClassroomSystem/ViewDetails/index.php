<?php
$root_path = '../../../../';
$profile_path = '../../';
include $root_path . 'LibraryFiles/DatabaseConnection/config.php';
include $root_path . 'LibraryFiles/URLFinder/URLPath.php';
include $root_path . 'LibraryFiles/SessionStore/session.php';
$classCode = $_SESSION['class_code'];
$classCode = $_SESSION['class_code'];
session::create_or_resume_session();
session::profile_not_set($root_path);
// $tableName=$_SESSION['table_name'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>View Details</title>
  <link rel="icon" href="<?php echo $root_path; ?>title_icon.jpg" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
  <script defer src="script.js"></script>
</head>

<body>

  <script src="<?php echo $root_path; ?>js/bootstrap.min.js"></script>
  <div class="main-container d-flex">
    <?php
    include $profile_path . 'navbar.php';
    student_navbar($root_path);
    ?>
    <section class="content-section m-auto px-5">
      <div class="container-fluid bg-white rounded mt-5 mb-5"></div>
      <!-- <h2 class="fs-5">Profile</h2> -->
      <div class="card intro-card w-50 text-bg-secondary m-auto mb-3">
        <div class="card-header">
          <h5 class="card-title">Instructor(s)</h5>
        </div>
        <?php
        $sql = $database->performQuery("SELECT * FROM users,teacher_classroom WHERE users.email=teacher_classroom.email AND class_code='$classCode'");
        foreach ($sql as $i) {
        ?>
          <div class="card-body px-4">

            <h5 class="card-text"><?php echo $i['name']; ?></h5>

          </div>
        <?php
        }
        ?>

      </div>
      <div class="card  w-50 text-bg-secondary m-auto mb-1">
        <div class="card-header">
          <h5 class="card-title"><?php
                                  $sql = $database->performQuery("SELECT * FROM users, student_classroom WHERE users.email=student_classroom.email AND class_code='$classCode'");
                                  $record = mysqli_fetch_assoc($database->performQuery("SELECT count(*)count_student FROM users, student_classroom WHERE users.email=student_classroom.email AND class_code='$classCode'"));
                                  echo $record['count_student'] . ' Student(s)';
                                  ?></h5>
        </div>

        <ul class="list-group list-group-flush">
          <?php
          $sql = $database->performQuery("SELECT * FROM users, student_classroom WHERE users.email=student_classroom.email AND class_code='$classCode'");
          foreach ($sql as $i) {
          ?>
            <li class="list-group-item">
              <p class="card-text"><?php echo $i['name']; ?></p>
            </li>
          <?php
          }

          ?>

        </ul>



      </div>

  </div>
  </section>
  </div>
  </div>


</body>

</html>