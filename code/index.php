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
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#"
            ><img src="logo2.jpg" class="img-fluid logo" alt="bootstrap" height="50" width="250"
          /></a>
        </div>
        <div class="d-flex">
         <a href="LoginAuth/Login/index.php">
          <button type="button" class="btn btn-light btn-lg mx-sm-2 mx-xs-2"> Login</button></a>
          <a href="LoginAuth/SignUp/index.php">
          <button type="button" class="btn btn-light btn-lg mx-sm-2 mx-xs-2">Register </button>
          </a>
        </div>
      </div>
    </nav>
    <div id="home">
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="4000" >
      <img src="slideHome.jpg" class="d-block w-75 img-fluid m-auto" alt="bootstrap" height="600">
    </div>
    <div class="carousel-item" data-bs-interval="2000" >
      <img src="slide1.jpg" class="d-block w-75 img-fluid m-auto" alt="bootstrap" height="600">
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img src="slide2.jpg" class="d-block w-75 img-fluid m-auto" alt="bootstrap" height="600">
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img src="slide3.jpg" class="d-block w-75 img-fluid m-auto" alt="bootstrap" height="600">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
    </div>
</body>
</html>
