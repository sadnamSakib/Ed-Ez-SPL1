<?php

$servername = "localhost";
$username = "UserManager";
$password = "12345678";
$dbname = "user";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
error_reporting(0);

session_start();

if (!isset($_SESSION['email'])) {
  header("Location: ../index.php");
}
$temp = hash('sha512', $_SESSION['email']);
$tableName = $_SESSION['tableName'];

$error = "Enter Password To make Updates to Profile Information";
$errorColor = "black";

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
  $sql = "UPDATE $tableName SET ProfilePicture='$imgContent' WHERE email = '$temp'";
  $res = mysqli_query($conn, $sql);
}

if (isset($_POST['UpdateProfile'])) {
  $username = $_REQUEST['username'];
  $_SESSION['username'] = $username;

  $Department = $_REQUEST['department'];
  $Semester = $_REQUEST['semester'];
  $country = $_REQUEST['country'];
  $password = $_REQUEST['password'];
  $password = hash('sha512', $password);
  $existence_name = "SELECT * FROM $tableName WHERE email = '$temp'";
  $result = mysqli_query($conn, $existence_name);
  $row = mysqli_fetch_assoc($result);
  if ($_REQUEST['mobile'] != '') {
    $MobileNumber = $_REQUEST['mobile'];
  } else {
    $MobileNumber = $row['MobileNumber'];
  }

  if (password_verify($password, $row['password'])) {
    if ($Semester == '') {
      $Semester = -1;
    }
    $sql = "UPDATE $tableName SET username='$username',MobileNumber='$MobileNumber',Country='$country',Department='$Department',Semester='$Semester' WHERE email='$temp'";
    $res = mysqli_query($conn, $sql);
  } else {
    $error = "Incorrect Password, Cannot make changes to profile";
    $errorColor = "red";
  }
}


$existence_name = "SELECT * FROM $tableName WHERE email = '$temp'";
$result = mysqli_query($conn, $existence_name);
$row = mysqli_fetch_assoc($result);

$var = $row['ProfilePicture'];
if ($var != "") {
  $src = "data:image/jpg;charset=utf8;base64," . base64_encode($var);
} else {
  $src = "profile-picture.png";
}
$username = $row['username'];
$MobileNumber = $row['MobileNumber'];
$instituion = $row['institution'];
$Department = $row['Department'];
$Semester = $row['Semester'];
$Country = $row['Country'];
if ($Semester == -1) {
  $Semester = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Classroom</title>
  <link rel="icon" href="../logo4.jpg" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="../../css/bootstrap.css" />
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
        <li class=""><a href="../StudentProfile/index.php" class="text-decoration-none px-3 py-2 d-block"><i class='bx bx-user-circle pe-2'></i>Profile</a></li>
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
                  <a href="../logout.php" style="text-decoration: none; color:black">Log Out</a>
                </button>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <section class="content-section m-auto px-1 w-75">
        <div class="container bg-white rounded mt-5 mb-5"></div>
        <div class="px-3 me-3 d-flex flex-row-reverse">
          <button type="button" class="btn btn-outline-primary btn-join d-flex p-4 py-3" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat"><b>Create new classroom</b></button>
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Create classroom</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="mb-3">
                      <input type="text" class="form-control" placeholder="Enter course code" aria-label="Leave a comment">
                    </div>
                    <div class="mb-3">
                      <input type="text" class="form-control" placeholder="Enter course name" aria-label="Leave a comment">
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary btn-join">Join</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container bg-white rounded m-auto justify-content-center mt-5 mb-5"></div>
        <!-- <h2 class="fs-5">Profile</h2> -->
        <div class="row justify-content-start m-auto">
          <!-- <div class="col-md-6 col-sm-6 border" style="max-height:20rem"> -->
          <!-- <div class="row"> -->
          <div class="card-element col-lg-4 col-md-6 p-4 px-2">
            <div class="card card-box-shadow">
              <div class="card-body">
                <h4 class="card-title">CSE 4301</h4>
                <p class="card-text">Md. Jubair Ibna Mostafa</p>

              </div>
              <div class="pb-5 px-5"><a href="../StudentClassroom/index.php" class="btn btn-primary btn-go">Enter Class</a></div>
            </div>
          </div>
          <div class="card-element col-lg-4 col-md-6 p-4 px-2">
            <div class="card card-box-shadow">
              <div class="card-body">
                <h4 class="card-title">CSE 4303: Data Structure</h4>
                <p class="card-text">Mezbaur Rahman</p>

              </div>
              <div class="pb-5 px-5"><a href="../StudentClassroom/index.php" class="btn btn-primary btn-go">Enter Class</a></div>
            </div>
          </div>
          <div class="card-element col-lg-4 col-md-6 p-4 px-2">
            <div class="card card-box-shadow">
              <div class="card-body">
                <h4 class="card-title">CSE 4309: Theory of Computing</h4>
                <p class="card-text">Tanjila Alam Sathi</p>
              </div>
              <div class="pb-5 px-5"><a href="../StudentClassroom/index.php" class="btn btn-primary btn-go">Enter Class</a></div>
            </div>
          </div>
          <div class="card-element col-lg-4 col-md-6 p-4 px-2">
            <div class="card card-box-shadow">
              <div class="card-body">
                <h4 class="card-title">CSE 4307: Database Management System</h4>
                <p class="card-text">Dr. Abu Raihan Mostafa Kamal</p>

              </div>
              <div class="pb-5 px-5"><a href="../StudentClassroom/index.php" class="btn btn-primary btn-go">Enter Class</a></div>
            </div>
          </div>
          <div class="card-element col-lg-4 col-md-6 p-4 px-2">
            <div class="card card-box-shadow">
              <div class="card-body">
                <h4 class="card-title">CSE 4305: Computer Organization and Architecture</h4>
                <p class="card-text">Imtiaj Ahmed Chowdhury</p>

              </div>
              <div class="pb-5 px-5"><a href="../StudentClassroom/index.php" class="btn btn-primary btn-go">Enter Class</a></div>
            </div>
          </div>
          <div class="card-element col-lg-4 col-md-6 p-4 px-2">
            <div class="card card-box-shadow">
              <div class="card-body">
                <h4 class="card-title">Math 4341: Linear Algebra</h4>
                <p class="card-text">Md. Mohsinul Kabir</p>
              </div>
              <div class="pb-5 px-5"><a href="../StudentClassroom/index.php" class="btn btn-primary btn-go">Enter Class</a></div>
            </div>
          </div>
          <!-- </div> -->
        </div>

        <!-- ekhane card dhukabo  -->


        <!-- <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Leave a comment" aria-label="Leave a comment" aria-describedby="button-addon2">
              <button class="btn btn-primary" type="button" id="button-addon2">comment</button>
            </div> -->
    </div>
    </section>
  </div>
  </div>


</body>

</html>