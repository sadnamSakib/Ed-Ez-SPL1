<?php

include '../../LibraryFiles/DatabaseConnection/config.php';
include '../../LibraryFiles/URLFinder/URLPath.php';
error_reporting(0);
session_start();

if (!isset($_SESSION['email'])) {
  header("Location: ../../index.php");
}
$temp=hash('sha512',$_SESSION['email']);
$tableName=$_SESSION['tableName'];
$_SESSION['url']=URLPath::getURL();

$error="Enter Password To make Updates to Profile Information";
$errorColor="black";

if(isset($_REQUEST['profileimg'])){
  $img=$_REQUEST['image'];
  $fileName = basename($_FILES["image"]["name"]); 
  $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
  // Allow certain file formats 
  $allowTypes = array('jpg','png','jpeg'); 
  if(in_array($fileType, $allowTypes)){ 
      $image = $_FILES['image']['tmp_name']; 
      $imgContent = addslashes(file_get_contents($image)); 
  }
    $updateProfilePicture="UPDATE users SET profile_picture='$imgContent' WHERE email = '$temp'";
    $database->performQuery($updateProfilePicture);
}

if(isset($_POST['UpdateProfile'])){
  $name=$_REQUEST['name'];
  $_SESSION['name']=$name;
  
  $department=$_REQUEST['department'];
  $designation=$_REQUEST['designation'];
  $country=$_REQUEST['country'];
  $password=$_REQUEST['password'];
  $password=hash('sha512',$password);
  $existanceCheck = "SELECT * FROM users WHERE email = '$temp'";
  $result=$database->performQuery($existanceCheck);
  $row = mysqli_fetch_assoc($result);
  if($_REQUEST['mobile']!=''){
    $mobileNumber=$_REQUEST['mobile'];
  }
  else{
    $mobileNumber=$row['mobileNumber'];
  }
  
  if(password_verify($password,$row['password'])){
    $database->performQuery("UPDATE users SET name='$name',mobileNumber='$mobileNumber',country='$country',department='$department' WHERE email='$temp'");
    $database->performQuery("UPDATE teacher SET designation='$designation' WHERE email='$temp';");
  }
  else{
    $error="Incorrect Password, Cannot make changes to profile";
    $errorColor="red";
  }
  
}


$existanceCheck = "SELECT * FROM users INNER JOIN teacher ON users.email=teacher.email WHERE users.email = '$temp'";
$result=$database->performQuery($existanceCheck);
$row = mysqli_fetch_assoc($result);


$var=$row['profile_picture'];
if($var!=""){
  $src="data:image/jpg;charset=utf8;base64,".base64_encode($var);
}
else{
  $src="profile-picture.png";
}
$name=$row['name'];
$mobileNumber=$row['mobileNumber'];
$instituion=$row['institution'];
$department=$row['department'];
$designation=$row['designation'];
$country=$row['country'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Profile</title>
  <link rel="icon" href="../../logo4.jpg" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="../../css/bootstrap.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jsSHA/2.0.2/sha.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/d0f239b9af.js" crossorigin="anonymous"></script>
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
  <script defer src="script.js"></script>
</head>

<body>

  <script src="../../js/bootstrap.js"></script>
  <div class="main-container d-flex">
    <div class="sidebar" id="side_nav">
      <div class="header-box px-2 pt-3 pb-4 d-flex justify-content-between ">
        <h1 class="fs-4"><span class="bg-white text-dark rounded shadow px-4 mx-4 my-5"><span class="text-whte"> Ed-Ez</span></span></h1>
        <button class="btn d-block close-btn text-white"><i class='bx bx-menu'></i></button>
      </div>
      <ul class="list-unstyled px-2">
        <li class=""><a href="#" class="text-decoration-none px-3 py-2 d-block"><i class='bx bxs-dashboard pe-2'></i>Dashboard</a></li>
        <li class=""><a href="index.php" class="text-decoration-none px-3 py-2 d-block"><i class='bx bx-users-circle pe-2'></i>Profile</a></li>
        <li class=""><a href="#" class="text-decoration-none px-3 py-2 d-block"><i class='bx bxs-calendar-plus pe-2'></i>Schedule</a></li>
        <li class=""><a href="#" class="text-decoration-none px-3 py-2 d-block"><i class='bx bx-chalkboard pe-2'></i>Classrooms</a></li>
        <li class=""><a href="#" class="text-decoration-none px-3 py-2 d-block"><i class='bx bxs-bar-chart-alt-2 pe-2'></i>Grades</a></li>


      </ul>
      <hr class="h-color mx-2 my-5">
      <hr class="h-color mx-2 my-5">
      <hr class="h-color mx-2 my-5">
      <hr class="h-color mx-2 my-5">
      <hr class="h-color mx-2 my-5">
      <hr class="h-color mx-2 my-5">
      <hr class="h-color mx-2 my-5">
      <ul class="list-unstyled px-2 ">
        <li class=""><a href="#" class="text-decoration-none px-3 py-2 d-block "><i class='bx bx-wrench pe-2'></i>Settings</a></li>
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
                <a href="../Logout/logout.php" style="text-decoration: none; color:black">Log Out</a>
                </button>
              </li>
            </ul>
          </div>
        </div>
      </nav>
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
                <input class="d-none" type="file" name="img" accept="image/*"/>
                <div class="input-group w-75">
                <input type="file" class="form-control profile" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="image">

                <!-- <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">Upload Profile</button> -->
                </div>
                <input type="submit" class="btn btn-dark mt-3" id="inputGroupFileAddon04" name="profileimg" value="Update Profile Picture"/>
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
                    <label class = "form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="<?php echo $name ?>" value="<?php echo $name ?>">
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-12 mb-3">
                    <label class = "form-label">Mobile Number</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="<?php echo $mobileNumber ?>" value="<?php echo $mobileNumber ?>">
                    <div id="error" style="color:red"></div>
                  </div>
                  <label class = "form-label">Password</label>
                  <div class="col-md-12 mb-3 d-flex justify-content-around">
  
                    <input type="password" class="form-control" placeholder="Enter Password" name="password" id="password" >
                    <i class="fas fa-eye-slash my-2 p-1" id="togglePassword"></i>
                    
                  </div>
                    <div class="col-md-12 mb-3">
                  <a href="../UpdatePassword/index.php"><button type="button" class="btn btn-dark col-3">Change Password</button></a>
                  </div>
                  </div>
                  <div class="col-md-12 mb-3">
                    <label class = "form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter Email ID" value="<?php echo $_SESSION['email']?>" readonly>
                  </div>
                  <div class="col-md-12 mb-3">
                    <label class = "form-label">Institution</label>
                    <input type="text" class="form-control" id="institution" placeholder="Enter Instituition" value="<?php echo $instituion?>">
                  </div>
                  <div class="col-md-12 mb-3">
                    <label class = "form-label">Department</label>
                    <input type="text" class="form-control" id="department" name="department" value="<?php echo $department?>">
                  </div>
                  <div class="col-md-12 mb-3">
                    <label class = "form-label">Designation</label>
                    <input type="text" class="form-control" id="designation" name="designation" placeholder="Enter Your designation" value="<?php echo $designation?>">
                  </div>
                  <div class="col-md-12 mb-3">
                    <label class = "form-label">Country</label>
                    <input type="text" class="form-control" id="country" name="country" placeholder="Enter country" value="<?php echo $country?>">
                  </div>
                </div>
              </div>
              <div class="row justify-content-center">
              <input type="submit" name="UpdateProfile" class="btn btn-dark col-3" value="Update Profile"/>
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


