<?php
$root_path = '../../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
require $root_path . 'LibraryFiles/ValidationPhp/InputValidation.php';
session::profile_not_set($root_path);
$email=new EmailValidator($_SESSION['email']);
$database->fetch_results($verified,"SELECT Verified FROM users WHERE email='".$email->get_email()."'");
if ($verified['Verified'] !== '1') {
  header('Location: ' . $root_path . 'LoginAuth/SignUp/ConfirmEmail/index.php');
}

$error = null;
$errorColor = "red";

if (isset($_REQUEST['profileimg'])) {
  $fileName = basename($_FILES["image"]["name"]);
  $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
  $allowTypes = array('jpg', 'png', 'jpeg');
  if (in_array($fileType, $allowTypes)) {
    $image = $_FILES["image"]["tmp_name"];
    $imgContent = addslashes(file_get_contents($image));
  }
  $updateProfilePicture = "UPDATE users SET profile_picture='$imgContent' WHERE email = '".$email->get_email()."'";
  $database->performQuery($updateProfilePicture);
}

if (isset($_POST['UpdateProfile'])) {
  $validate=new InputValidation();
  $_SESSION['name']=$name = $validate->post_sanitise_regular_input('name');
  $department =$validate->post_sanitise_regular_input('department');
  $semester = $validate->post_sanitise_number('semester');
  $country = $validate->post_sanitise_regular_input('country');
  $studentID = $validate->post_sanitise_digits('studentID');
  $database->fetch_results($row, "SELECT * FROM users WHERE email = '".$email->get_email()."'");
  if ($_REQUEST['mobile'] != '') {
    $mobileNumber = $validate->post_sanitise_digits('mobile');
  } else {
    $mobileNumber = $row['mobileNumber'];
  }
  
  if (password_verify(hash('sha512', $validate->post_sanitise_password('password')), $row['password'])) {
    if ($semester == '') {
      $semester = -1;
    }
    $database->performQuery("UPDATE users SET name='$name',mobileNumber='$mobileNumber',country='$country',department='$department' WHERE email='".$email->get_email()."'");
    $database->performQuery("UPDATE student SET semester='$semester',studentID='$studentID' WHERE email = '".$email->get_email()."'");
  } else {
    $error = "Incorrect Password, Cannot make changes to profile";
    $errorColor = "red";
  }
}

$database->fetch_results($row,"SELECT * FROM users INNER JOIN student ON users.email=student.email WHERE users.email = '".$email->get_email()."'");

$var = $row['profile_picture'];
if ($var != "") {
  $src = "data:image/jpg;charset=utf8;base64," . base64_encode($var);
} else {
  $src = "profile-picture.png";
}
$name = $row['name'];
$mobileNumber = $row['mobileNumber'];
$instituion = $row['institution'];
$department = $row['department'];
$semester = $row['semester'];
$country = $row['country'];
$studentID=$row['studentID'];
if ($semester == -1) {
  $semester = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Profile</title>
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
    require 'navbar.php';
    student_navbar($root_path,true);
    ?>
    <section class="content-section m-auto px-5">
      <div class="container-fluid bg-white rounded mt-5 mb-5"></div>
      <!-- <h2 class="fs-5">Profile</h2> -->
      <div class="row">
        <div class="col-md-3 border-end">
          <div class="d-flex flex-column align-items-center text-center p-3 py-5">
            <img src="<?php echo $src ?>" class="rounded mt-5" width="150px" />
            <span class="font-weight-bold"><?php echo $_SESSION['name'] ?></span>
            <span class="text-black-50"><?php echo $_SESSION['email'] ?></span>
            <form method="POST" action="" enctype="multipart/form-data">
              <div class="input-group w-75 mx-5">
                <input type="file" class="form-control profile" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="image" accept="image/*">

                <!-- <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">Upload Profile</button> -->
              </div>
              <input type="submit" class="btn btn-dark mt-3" id="inputGroupFileAddon04" name="profileimg" value="Update Profile Picture" />
              <!-- <p style="color:red">Make sure the image represents you and doesn't contain anything offensive</p> -->
            </form>
          </div>
        </div>
        <div class="col-md-5 border-end">
          <div class="p-3 py-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h4>Student Profile</h4>
            </div>
            <form id='form' action="" method="POST">
              <div id="errorPass form-label" style="color:<?php echo $errorColor ?>;<?php echo $error===null?'none':'block'; ?>"><?php echo $error ?></div>
              <div class="row mt-3">
                <div class="col-md-12 mb-3">
                  <label class="form-label">Full Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="<?php echo $name ?>" value="<?php echo $name ?>">
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-12 mb-3">
                  <label class="form-label">Mobile Number</label>
                  <input type="text" class="form-control" id="mobile" name="mobile" placeholder="<?php echo $mobileNumber ?>" value="<?php echo $mobileNumber ?>">
                  <div id="error" style="color:red"></div>
                </div>


              </div>
              <div class="col-md-12 mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter Email ID" value="<?php echo $_SESSION['email'] ?>" readonly>
              </div>
              <div class="col-md-12 mb-3">
                <label class="form-label">Institution</label>
                <input type="text" class="form-control" id="institution" placeholder="Enter Instituition" name="institution" value="<?php echo $instituion ?>">
              </div>
              <div class="col-md-12 mb-3">
                <label class="form-label">Department</label>
                <input type="text" class="form-control" id="department" name="department" value="<?php echo $department ?>">
              </div>
              <div class="col-md-12 mb-3">
                <label class="form-label">Semester</label>
                <input type="number" class="form-control" id="semester" name="semester" value="<?php echo $semester ?>" onclick="
                    var value=document.getElementById('semester');
                    this.setAttribute('min',1);
                    this.setAttribute('max',20);
                    ">
              </div>
              <div class="col-md-12 mb-3">
                <label class="form-label">Student ID</label>
                <input type="text" class="form-control" id="studentID" name="studentID" placeholder="Enter Student ID" value="<?php echo $studentID ?>">
              </div>
              <div class="col-md-12 mb-3">
                <label class="form-label">Country</label>
                <input type="text" class="form-control" id="country" name="country" placeholder="Enter country" value="<?php echo $country ?>">
              </div>
          </div>
          <div class="row justify-content-center p-3">
            <button type="button" class="btn btn-dark col-md-auto mb-sm-5 me-sm-5" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat">Update Profile</button>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Enter password to save changes</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <div class="mb-3" id="error" style="display:none">
                      </div>
                      <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Enter Password" name="password" id="password">
                      </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type='submit' name='UpdateProfile' value='Confirm' class="btn btn-primary btn-join">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      </form>

  </div>

  </div>
  </section>
  </div>
  </div>


</body>

</html>