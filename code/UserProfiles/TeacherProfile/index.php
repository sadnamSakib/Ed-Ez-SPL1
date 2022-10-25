<?php

$root_path = '../../';
include $root_path . 'LibraryFiles/DatabaseConnection/config.php';
include $root_path . 'LibraryFiles/URLFinder/URLPath.php';
include $root_path . 'LibraryFiles/SessionStore/session.php';
session::profile_not_set($root_path);
$temp = hash('sha512', $_SESSION['email']);
$verified=mysqli_fetch_assoc($database->performQuery("SELECT * FROM users WHERE email='$temp';"));
if($verified['Verified']!=='1'){
  header('Location: '.$root_path.'LoginAuth/SignUp/ConfirmEmail/index.php');
}


$tableName = $_SESSION['tableName'];
$_SESSION['url'] = URLPath::getURL();

$error = "Enter Password To make Updates to Profile Information";
$errorColor = "red";

if (isset($_REQUEST['profileimg'])) {
  $img = $_REQUEST['image'];
  $fileName = basename($_FILES["image"]["name"]);
  $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
  // Allow certain file formats 
  $allowTypes = array('jpg', 'png', 'jpeg');
  if (in_array($fileType, $allowTypes)) {
    $image = $_FILES['image']['tmp_name'];
    $imgContent = addslashes(file_get_contents($image));
  }
  $updateProfilePicture = "UPDATE users SET profile_picture='$imgContent' WHERE email = '$temp'";
  $database->performQuery($updateProfilePicture);
}

if (isset($_POST['UpdateProfile'])) {
  $name = $_REQUEST['name'];
  $_SESSION['name'] = $name;

  $department = $_REQUEST['department'];
  $designation = $_REQUEST['designation'];
  $country = $_REQUEST['country'];
  $password = $_REQUEST['password'];
  $password = hash('sha512', $password);
  $existanceCheck = "SELECT * FROM users WHERE email = '$temp'";
  $result = $database->performQuery($existanceCheck);
  $row = mysqli_fetch_assoc($result);
  if ($_REQUEST['mobile'] != '') {
    $mobileNumber = $_REQUEST['mobile'];
  } else {
    $mobileNumber = $row['mobileNumber'];
  }

  if (password_verify($password, $row['password'])) {
    $database->performQuery("UPDATE users SET name='$name',mobileNumber='$mobileNumber',country='$country',department='$department' WHERE email='$temp'");
    $database->performQuery("UPDATE teacher SET designation='$designation' WHERE email='$temp';");
  } else {
    $error = "Incorrect Password, Cannot make changes to profile";
    $errorColor = "red";
  }
}


$existanceCheck = "SELECT * FROM users INNER JOIN teacher ON users.email=teacher.email WHERE users.email = '$temp'";
$result = $database->performQuery($existanceCheck);
$row = mysqli_fetch_assoc($result);


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
$designation = $row['designation'];
$country = $row['country'];
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
  <link href="<?php echo $root_path;?>boxicons-2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <script defer src="script.js"></script>
  
</head>

<body>

  <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
  <div class="main-container d-flex">
       <?php 
        include 'navbar.php';
        teacher_navbar($root_path);
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
                <input class="d-none" type="file" name="img" accept="image/*" />
                <div class="input-group w-75 mx-5">
                  <input type="file" class="form-control profile" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="image">

                  <!-- <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">Upload Profile</button> -->
                </div>
                <input type="submit" class="btn btn-dark mt-3" id="inputGroupFileAddon04" name="profileimg" value="Update Profile Picture" />
                <p style="color:red">Make sure the image represents you and doesn't contain anything offensive</p>
              </form>
            </div>
          </div>
          <div class="col-md-5 border-end">
            <div class="p-3 py-5">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Teacher Profile</h4>
              </div>
              <form id='form' action="" method="POST">
                <div id="errorPass form-label" style="color:<?php echo $errorColor ?>"><?php echo $error ?></div>
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
                  <label class="form-label">Password</label>
                  <div class="col-md-12 mb-3 d-flex justify-content-around">

                    <input type="password" class="form-control" placeholder="Enter Password" name="password" id="password">
                    <i class="fas fa-eye-slash my-2 p-1" id="togglePassword"></i>

                  </div>
                  <div class="col-md-12 mb-3">
                    <a href="<?php echo $root_path; ?>UserProfiles/UpdatePassword/index.php"><button type="button" class="btn btn-dark col-xs-5">Change Password</button></a>
                  </div>
                </div>
                <div class="col-md-12 mb-3">
                  <label class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" placeholder="Enter Email ID" value="<?php echo $_SESSION['email'] ?>" readonly>
                </div>
                <div class="col-md-12 mb-3">
                  <label class="form-label">Institution</label>
                  <input type="text" class="form-control" id="institution" placeholder="Enter Instituition" value="<?php echo $instituion ?>">
                </div>
                <div class="col-md-12 mb-3">
                  <label class="form-label">Department</label>
                  <input type="text" class="form-control" id="department" name="department" value="<?php echo $department ?>">
                </div>
                <div class="col-md-12 mb-3">
                  <label class="form-label">Designation</label>
                  <input type="text" class="form-control" id="designation" name="designation" placeholder="Enter Your designation" value="<?php echo $designation ?>">
                </div>
                <div class="col-md-12 mb-3">
                  <label class="form-label">Country</label>
                  <input type="text" class="form-control" id="country" name="country" placeholder="Enter country" value="<?php echo $country ?>">
                </div>
            </div>
            <div class="row justify-content-center">
              <input type="submit" name="UpdateProfile" class="btn btn-dark col-xs-5 mb-5 w-50" value="Update Profile" />
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