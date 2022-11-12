<?php
$root_path = '../../../../../';
$profile_path = '../../../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
$classCode = $_SESSION['class_code'];
session::create_or_resume_session();
session::profile_not_set($root_path);
// $tableName=$_SESSION['table_name'];

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
                <div class="card card-body btn my-2 w-50 me-2" style="text-align:left">Zaara Zabeen Arpa</div>
                <div class="marks w-25 my-2 me-2">
                    <form class="py-2">
                    <input type="number" id="marks" name="marks" class="form-control" placeholder="Enter Marks" aria-label="Leave a comment" onclick="
                    var value=document.getElementById('marks');
                    this.setAttribute('min',0);
                    this.setAttribute('max',300);
                    ">
                    </form>
                </div>
                <button type="button" class="btn btn-primary btn-xs btn-join me-2 m-auto"><b>Submit</b></button>
                </div>
               
                <div class="collapse multi-collapse" id="taskcollapse">
                <div class="flex-container">
                <div class="card card-body btn my-2 w-50 me-2" style="text-align:left">Zaara Zabeen Arpa</div>
                <div class="marks w-25 my-2 me-2">
                    <form class="py-2">
                    <input type="number" id="marks" name="marks" class="form-control" placeholder="Enter Marks" aria-label="Leave a comment" onclick="
                    var value=document.getElementById('marks');
                    this.setAttribute('min',0);
                    this.setAttribute('max',300);
                    ">
                    </form>
                </div>
                <button type="button" class="btn btn-primary btn-xs btn-join me-2 m-auto"><b>Submit</b></button>
                </div>
        </div>

    </section>
  </div>
</body>

</html>