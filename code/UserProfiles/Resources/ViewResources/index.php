<?php
$root_path = '../../../';
$profile_path = '../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
require $root_path . 'LibraryFiles/ValidationPhp/InputValidation.php';
require $root_path . 'LibraryFiles/Utility/Utility.php';
foreach (glob($root_path . 'LibraryFiles/ClassroomManager/*.php') as $filename) {
  require $filename;
}
session::profile_not_set($root_path);
session::profile_not_set($root_path);
$validate = new InputValidation();
$email = new EmailValidator($_SESSION['email']);
$resources = $database->performQuery("SELECT * FROM resources");
$resource_id = null;
foreach($resources as $resource)
{
  if(isset($_POST[$resource['resource_id']])){
    $resource_id=$resource['resource_id'];
  }
}

$database->fetch_results($resource, "SELECT * FROM resources,resource_uploaded WHERE resources.resource_id = '$resource_id' AND resource_uploaded.resource_id = '$resource_id'");
$database->fetch_results($user,"SELECT * FROM users WHERE email='".$resource['email']."'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Resources</title>
  <link rel="icon" href="<?php echo $root_path; ?>title_icon.jpg" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link href="<?php echo $root_path; ?>boxicons-2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <script defer src="script.js"></script>
</head>

<body>
  <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
  <div class="main-container d-flex">
    <?php
    $profile_type = $tableName = $_SESSION['tableName'] === 'student' ? '../../StudentProfile/' : '../../TeacherProfile/';
    require $profile_type . 'navbar.php';
    $profile_type === '../StudentProfile/' ? student_navbar($root_path, false) : teacher_navbar($root_path, false);
    ?>
    <section class="content-section m-auto px-5 py-3">
      <div class="card intro-card w-75 text-bg-secondary m-auto mb-3">
        <div class="card-header">
          <h5 class="card-title" style="text-align:left">Shared By <?php echo $user['name'] ?> <?php echo $resource['post_date_time'] ?></h5>
        </div>
        <div class="card-body text-success">
          <object data="<?php echo FileManagement::get_file_url_static($database,URLPath::getFTPServer(),$resource['file_id']) ?>" type="application/pdf" width="100%" height="500px">
            <p>It appears your Web browser is not configured to display PDF files. No worries, just <a href="<?php echo FileManagement::get_file_url_static($database,URLPath::getFTPServer(),$resource['file_id']) ?>"></p>
          </object>
        </div>
        <div class="card-footer d-flex justify-content-between border-success">
          <div>
            <a title = "UpVote">
            <i class='bx btn bx-sm  bxs-up-arrow me-2'></i>
            </a>
            <label>0</label>
            <a title = "DownVote">
            <i class='bx btn bx-sm  bxs-down-arrow'></i>
            </a>
            <label>0</label>
          </div>
          <div>
            <a title = "Save">
            <i class='bx btn bx-sm bxs-save'></i>
            </a>
          </div>
        </div>
      </div>


    </section>
  </div>

</body>

</html>