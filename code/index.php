<?php 

include 'LibraryFiles/DatabaseConnection/config.php';
include 'LibraryFiles/SessionStore/session.php';
include 'LibraryFiles/URLFinder/URLPath.php';
session::create_or_resume_session();
session::stay_in_session();
$_SESSION['ROOT']= URLPath::getURL();
?>
<!DOCTYPE HTML>
<html>
<head>
<title> 
    Ed-Ez
</title>
<link rel="icon" href="logo4.jpg" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="css/bootstrap.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>
<script src="js/bootstrap.js"></script>
    <nav class="navbar navbar-default navbar-fixed-top m-auto" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#"
            ><img src="logo4.jpg" height="55px" width="55px"
          /></a>
        </div>
        <div>
        <a href="LoginAuth/Login/index.php">
          <button
            type="button"
            class="btn btn-light btn-lg"
          >
            Login
          </button></a>
          <a href="LoginAuth/SignUp/index.php">
          <button
            type="button"
            class="btn btn-light btn-lg"
          >
            Register
          </button>
          </a>
        </div>
      </div>
    </nav>
    <div id="home">
      <div class="heading row m-0">
        <div class="landing-text col">
          <h1>Ed-Ez</h1>
          <h3>Education Made Easy.</h3>
          <a href="#" class="btn btn-default btn-lg">Get Started</a>
        </div>
        <div class="bgobject col">
          <object data="bgimage.svg" width="500" height="500"></object>
        </div>
      </div>
      <div class="cards flex-container">
        <div class="card w-25 text-bg-primary mb-3 m-1">
          <div class="card-body">
            <h5 class="card-title">For Teachers</h5>
            <p class="card-text">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
              eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
              enim ad minim veniam, quis nostrud exercitation ullamco laboris
              nisi ut aliquip ex ea commodo consequat.
            </p>
            <a
              href="#"
              class="btn btn-light"
              onclick="location.href='SignUp/index.php';"
              >Join</a
            >
          </div>
        </div>
        <div class="card w-25 text-bg-primary mb-3 m-4">
          <div class="card-body">
            <h5 class="card-title">For Students</h5>
            <p class="card-text">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
              eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
              enim ad minim veniam, quis nostrud exercitation ullamco laboris
              nisi ut aliquip ex ea commodo consequat.
            </p>
            <a
              href="#"
              class="btn btn-light"
              onclick="location.href='SignUp/index.php';"
              >Join</a
            >
          </div>
        </div>
      </div>
    </div>
</body>
</html>

