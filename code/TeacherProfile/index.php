<?php

session_start();

if (!isset($_SESSION['username'])) {
  header("Location: ../index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Welcome</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="../css/bootstrap.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jsSHA/2.0.2/sha.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/d0f239b9af.js" crossorigin="anonymous"></script>
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>

  <script src="../js/bootstrap.js"></script>
  <div class="main-container d-flex">
    <div class="sidebar" id="side_nav">
      <div class="header-box px-2 pt-3 pb-4 d-flex justify-content-between ">
        <h1 class="fs-4"><span class="bg-white text-dark rounded shadow px-4 mx-4 my-5"><span class="text-whte"> Ed-Ez</span></span></h1>
        <button class="btn d-block close-btn text-white"><i class='bx bx-menu'></i></button>
      </div>
      <ul class="list-unstyled px-2">
        <li class=""><a href="#" class="text-decoration-none px-3 py-2 d-block"><i class='bx bxs-dashboard pe-2'></i>Dashboard</a></li>
        <li class=""><a href="#" class="text-decoration-none px-3 py-2 d-block"><i class='bx bx-user-circle pe-2'></i>Profile</a></li>
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
      <section class="content-section m-auto px-5">
        <div class="container-fluid bg-white rounded mt-5 mb-5"></div>
          <!-- <h2 class="fs-5">Profile</h2> -->
          <div class="row">
            <div class="col-md-3 border-end">
              <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img src="profile-picture.PNG" class="rounded mt-5" width="150px" />
                <span class="font-weight-bold"><?php echo $_SESSION['username'] ?></span>
                <span class="text-black-50"><?php echo $_SESSION['email'] ?></span>
                <input class="d-none" type="file" name="profileimg" accept="image/*"/>
                <button class="btn btn-dark mt-3" for="profileimg" type="button" id="inputGroupFileAddon04">Update Profile Picture</button>
                <div class="input-group w-75">
                <input type="file" class="form-control profile" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                <!-- <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">Upload Profile</button> -->
                </div>
              </div>
            </div>
            <div class="col-md-5 border-end">
              <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h4>Profile</h4>
                </div>
                <div class="row mt-3">
                  <div class="col-md-6">
                    <label class = "form-label">Name</label>
                    <input type="text" class="form-control" id="fname" placeholder="First Name" value="First Name">
                  </div>
                  <div class="col-md-6">
                    <label class = "form-label">Surname</label>
                    <input type="text" class="form-control" id="lname" placeholder="Last Name" value="Last Name">
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-12 mb-3">
                    <label class = "form-label">Mobile Number</label>
                    <input type="text" class="form-control" id="mobile" placeholder="Enter Phone Number" value="Phone Number">
                  </div>
                  <div class="col-md-12 mb-3">
                    <label class = "form-label">Password</label>
                    <input type="text" class="form-control" placeholder="Password" readonly value="#">
                  </div>
                  <div class="col-md-12 mb-3">
                    <label class = "form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter Email ID" value="#">
                  </div>
                  <div class="col-md-12 mb-3">
                    <label class = "form-label">Institution</label>
                    <input type="text" class="form-control" id="institution" placeholder="Enter Instituition" value="#">
                  </div>
                  <div class="col-md-12 mb-3">
                    <label class = "form-label">Department</label>
                    <input type="text" class="form-control" id="department" placeholder="Enter department" value="#">
                  </div>
                  <div class="col-md-12 mb-3">
                    <label class = "form-label">Designation</label>
                    <input type="number" class="form-control" id="designation" placeholder="Enter Your Designation" value="#">
                  </div>
                  <div class="col-md-12 mb-3">
                    <label class = "form-label">Country</label>
                    <input type="text" class="form-control" id="country" placeholder="Enter country" value="#">
                  </div>
                </div>
              </div>
              <div class="row justify-content-center">
              <button class="btn btn-dark col-3" for="profileimg">Update Profile</button>
              </div>
            </div>
            
          </div>
          
        </div>
      </section>
    </div>
  </div>

  <script src="script.js"></script>
</body>

</html>