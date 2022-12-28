<?php
$root_path = '../../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
require $root_path . 'LibraryFiles/ValidationPhp/InputValidation.php';
require $root_path . 'LibraryFiles/Utility/Utility.php';
foreach (glob($root_path . 'LibraryFiles/ClassroomManager/*.php') as $filename) {
  require $filename;
}
foreach (glob($root_path . 'LibraryFiles/NotificationManager/*.php') as $filename) {
  require $filename;
}

$error = null;
session::profile_not_set($root_path);
$validate = new InputValidation();
$email = new EmailValidator($_SESSION['email']);
if (isset($_POST['uploadSubmit'])) {
  $resource_id = $utility->generateRandomString(50);
  $existence = $database->performQuery("SELECT * FROM resources WHERE resource_id='$resource_id'");
  while ($existence->num_rows > 0) {
    $resource_id = $utility->generateRandomString(50);
    $existence = $database->performQuery("SELECT * FROM resources WHERE resource_id='$resource_id'");
  }
  $title = $validate->post_sanitise_text('title');
  $briefDescription = $validate->post_sanitise_text('briefDescription');
  $tag = $validate->post_sanitise_text('tag');
  $classCode=$validate->post_sanitise_text('classroom');
  $public = $_REQUEST['publicResource'];
  $private = $_REQUEST['privateResource'];
  if ($public === 'public') {
    $visibility = 'public';
  } else {
    $visibility = 'private';
  }
  $database->fetch_results($system_date, "SELECT SYSDATE() AS DATE");
  if (isset($_FILES['uploadResource']['name']) && $validate->presence_check($title,$briefDescription,$tag,$visibility)) {
    if($visibility==='private' && !$validate->presence_check($classCode)){
      $error = $validate->error;
    }
    else{
      $fileManagement = new FileManagement($_FILES['uploadResource']['name'], $_FILES['uploadResource']['tmp_name'], $database, $utility);
      $database->performQuery("INSERT INTO resources VALUES('$resource_id','$title','$tag','" . $system_date['DATE'] . "','" . $fileManagement->get_file_id() . "','$visibility','$briefDescription')");
      $database->performQuery("INSERT INTO resource_uploaded VALUES('$resource_id','" . $email->get_email() . "')");
      if($visibility==="private"){
        $database->performQuery("INSERT INTO resources_classroom VALUES('$resource_id','$classCode')");
        $link = $fileManagement->get_file_url(URLPath::getFTPServer());
        $post_text = "A Resource has been posted: <br> Title: $title <br>  Posted at:". $system_date['DATE']." <br> Brief Description: $briefDescription <br> Resource Link: <a href=\"$link\" target=\"__blank\">Link</a>";
        $notification = new ResourceNotification($email->get_email(), $classCode, $sessionLink, $utility, $database);
        $postManagement = new PostManagement($post_text,$email->get_email(),$classCode,$utility,$database);
      }
    } 
  }
  else{
    $error = "No fields can be left empty";
  }
}

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
</head>
<body>
  <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
  <div class="main-container d-flex">
    <?php
    $profile_type = $_SESSION['tableName'] === 'student' ? '../StudentProfile/' : '../TeacherProfile/';
    require $profile_type . 'navbar.php';
    $_SESSION['tableName'] === 'student'  ? student_navbar($root_path, false) : teacher_navbar($root_path, false);
    ?>
    <section class="content-section mx-auto px-5">
      <div class="container-fluid bg-white rounded mt-5 mb-5 search-box">
        <input class="form-control search search-global" id="searchbar2" type="search" placeholder="Search by Resource Tag..." autocomplete="off" aria-label="Search">
        <div class="mx-auto w-75 result"></div>
      </div>
      <!-- Saved Resources -->
      <div class="row" id="uploadsave">
        <div class="col-md-6">
          <div class="card intro-card w-75 text-bg-secondary m-auto mb-3">
            <div class="card-header">
              <h3 class="card-title" style="text-align:center"><i class='bx bx-cloud-download'></i> Saved Resources</h3>
              <form class="d-flex" role="search">
                <input class="form-control search me-2" id="searchbar" type="search" onkeyup="search_resources()" placeholder="Search by Title" aria-label="Search">
                <button class="btn btn-primary btn-search mb-2 mt-2 me-2" type="submit">Search</button>
              </form>
            </div>
            <!-- <div class="card-body btn bx bxs-chevron-down w-100" type="button" data-bs-toggle="collapse" data-bs-target="#taskcollapse" aria-expanded="false" aria-controls="taskcollapse">
        </div> -->
            <div class="flex-container w-100">
              <div class="scroll w-100">
              <form name="resource_form" id="resource_form" action="ViewResources/index.php" method="POST">
              <?php
                $resource = $database->performQuery("SELECT * FROM resources,resource_saved WHERE resources.resource_id=resource_saved.resource_id;");
                foreach ($resource as $dummy_resource) {
                ?>
                <div class="card card-body mx-1 my-2 me-1 btn btn-resource saved" style="text-align:left" id="scrollspyHeading1">
                <button type="submit" name="<?php echo $dummy_resource['resource_id'] ?>" style="all:unset">
                  <div class="<?php echo $dummy_resource['resource_visibility']; ?>-box mb-1"><?php echo $dummy_resource['resource_visibility']; ?></div>
                  <h5 class="saved-resources"><?php echo $dummy_resource['title']; ?></h5>
                  <p style="font-size: 12px;">Resource Tag: <?php echo $dummy_resource['resource_tag']; ?></p>
                  <p style="font-size: 12px;"><?php echo $dummy_resource['resource_description']; ?></p>
                  </button>
                </div>
                <?php
                }
                ?>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Uploaded Resources -->
        <div class="col-md-6">
          <div class="card intro-card w-75 text-bg-secondary m-auto mb-3">
            <div class="card-header">
              <h3 class="card-title" style="text-align:center"><i class='bx bx-cloud-upload'></i> Uploaded Resources</h3>
              <form class="d-flex" action="" method="POST" role="search" name="uploadForm" enctype="multipart/form-data">
                <button type="button" class="btn btn-primary btn-upload" data-bs-toggle="modal" data-bs-target="#exampleModal">Upload</button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload File</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                      <div class="mb-3" id="error" style="display:<?php echo is_null($error)?'none':'block' ?>">
                          <p style="color:red" id="display_error"><?php echo $error; ?></p>
                        </div>
                        <div class="mb-3">
                          <input type="text" id="title" name="title" class="form-control resource_form_class" placeholder="Title of the file" aria-label="Leave a comment" required>
                        </div>
                        <div class="mb-3">
                          <input type="text" id="briefDescription" name="briefDescription" class="form-control resource_form_class" placeholder="Brief description" aria-label="Leave a comment"  required>
                        </div>
                        <div class="mb-3">
                          <input type="text" id="tag" name="tag" class="form-control resource_form_class" placeholder="Enter a tag to identify resource" aria-label="Leave a comment"  required>
                        </div>
                        <div class="input-group">
                          <input type="file" class="form-control resource_form_class" name="uploadResource" id="uploadResource" aria-describedby="inputGroupFileAddon04" aria-label="Upload"  required>
                        </div>
                      </div>
                      <div class="mx-4">
                        <label style="color: black">Set resource as: </label>
                        <div class="form-check form-check-inline mx-2">
                          <input class="form-check-input" type="radio" name="publicResource" id="publicResource" value="public" checked>
                          <label class="form-check-label" style="color: black" for="publicResource">public</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="privateResource" id="privateResource" value="private">
                          <label class="form-check-label" style="color: black" for="privateResource">private</label>
                        </div>
                      </div>
                      <div class="mb-3 mx-4 classSelector">
                        <select class="form-select" style="display:none;" aria-label="selectClassroom" name="classroom" id="classroom">
                          <?php
                          $classroom_user=$_SESSION['tableName']==='student'?'student_classroom':'teacher_classroom';
                          $classroom_user_email = $classroom_user . '.email';
                          $classroom_user_classcode = $classroom_user . '.class_code';
                          $record = $database->performQuery("select * from classroom,$classroom_user WHERE $classroom_user_email = '".$email->get_email()."' AND $classroom_user_classcode = classroom.class_code");
                          ?>
                          <option selected value="$">Select Classroom</option>
                          <?php
                          foreach ($record as $i) {
                          ?>
                            <option value="<?php echo $i['class_code']; ?>"><?php echo $i['classroom_name']; ?></option>
                          <?php
                          }
                          ?>

                        </select>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" value="Upload" name="uploadSubmit" class="btn btn-primary">
                      </div>
                    </div>
                  </div>
                </div>
                <input class="form-control search me-2" id="searchbar-uploaded" type="search" onkeyup="search_uploaded_resources()" placeholder="Search by Title" aria-label="Search">
                <button class="btn btn-primary btn-search mb-2 mt-2 me-2" type="submit">Search</button>
              </form>
            </div>
            <!-- <div class="card-body btn bx bxs-chevron-down w-100" type="button" data-bs-toggle="collapse" data-bs-target="#taskcollapse" aria-expanded="false" aria-controls="taskcollapse">
        </div> -->
            <div class="flex-container w-100">
              <div class="scroll w-100">
              <form name="resource_form" id="resource_form" action="ViewResources/index.php" method="POST">
                <?php
                $resource = $database->performQuery("SELECT * FROM resources,resource_uploaded WHERE resources.resource_id=resource_uploaded.resource_id;");
                foreach ($resource as $dummy_resource) {
                ?>
                    <div class="card card-body my-2 mx-1 me-1 btn btn-resource uploaded" style="text-align:left" id="scrollspyHeading1">
                      <button type="submit" name="<?php echo $dummy_resource['resource_id'] ?>" style="all:unset">
                      <div class="d-flex justify-content-between">
                      <div class="<?php echo $dummy_resource['resource_visibility']; ?>-box mb-1"><?php echo $dummy_resource['resource_visibility']; ?></div>
                      
                      <div class="deleteResource"><i class='bx bx-md bx-x'></i></div>
                      
                      </div>
                        <h5 class="uploaded-resources"><?php echo $dummy_resource['title']; ?></h5>
                        <p style="font-size: 12px;">Resource Tag: <?php echo $dummy_resource['resource_tag']; ?></p>
                        <p style="font-size: 12px;"><?php echo $dummy_resource['resource_description']; ?></p>
                      </button>
                    </div>
                <?php
                }
                ?>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>
  </div>

</body>
<script defer src="script.js"></script>
</html>