<?php
    
    require 'script.php';
    require 'style.php';
    function navbar($Dashboard,$Profile,$Schedule,$Resources,$ClassroomSystem,$root_path,$updatePassword=NULL,$Grades){
        ?>
    <?php echo navstyle(); ?>
    <div class="sidebar" id="side_nav">
      <div class="header-box px-2 pt-3 pb-4 d-flex justify-content-between ">
        <h1 class="fs-4"><span class="bg-white text-dark rounded shadow px-4 mx-4 my-5"><span class="text-whte"> Ed-Ez</span></span></h1>
        <button class="btn d-block close-btn text-white"><i class='bx bx-menu'></i></button>
      </div>
      <ul class="list-unstyled px-2">
        <li class=""><a href="<?php echo $Dashboard?>" class="text-decoration-none px-3 py-2 d-block"><i class='bx bxs-dashboard pe-2'></i>Dashboard</a></li>
        <li class=""><a href="<?php echo $Profile?>" class="text-decoration-none px-3 py-2 d-block"><i class='bx bx-user-circle pe-2'></i>Profile</a></li>
        <?php 
          if(!is_null($updatePassword)){
        ?>
          <ul class="list-unstyled ps-4 pe-2">
        <li class=""><a href="<?php echo $updatePassword?>" class="text-decoration-none px-3 py-2 d-block" style="font-size:14px;"><i class='bx bxs-key pe-2'></i>Change password</a></li>
        </ul>
        <?php
          }
        ?>
        <li class=""><a href="<?php echo $Schedule?>" class="text-decoration-none px-3 py-2 d-block"><i class='bx bxs-calendar-plus pe-2'></i>Schedule</a></li>
        <li class=""><a href="<?php echo $Resources?>" class="text-decoration-none px-3 py-2 d-block"><i class='bx bxs-folder-plus pe-2'></i>Resources</a></li>
        <li class=""><a href="<?php echo $ClassroomSystem?>" class="text-decoration-none px-3 py-2 d-block"><i class='bx bx-chalkboard pe-2'></i>Classrooms</a></li>
        <li class=""><a href="<?php echo $Grades?>" class="text-decoration-none px-3 py-2 d-block"><i class='bx bxs-bar-chart-alt-2 pe-2'></i>Grades</a></li>
          <?php
          ?>
      </ul>
    </div>
    <div class="content">
      <nav class="navbar navbar-expand p-3" style="background-color: #4596be;">
        <div class="container-fluid mx-5 px-4">
          <div class="d-flex justify-content-between d-block">
            <button class="btn btn-primary open-btn me-2"><i class='bx bx-menu'></i></i></button>
            <a href="#" class="navbar-brand fs-5 px-3 mx-4" href="#"><img src="<?php echo $root_path; ?>title_icon.jpg" class="img-fluid" height="40" width= "200"/></a>
          </div>
          <!-- <button class="navbar-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fal fa-bars"></i>
          </button> -->
          <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
              <li class="nav-item">
              <button type="button" onclick="window.location.href='<?php echo $root_path; ?>UserProfiles/Logout/logout.php'" class="btn btn-primary me-2 d-flex">
                      Log Out
                </button>
              </li>
            </ul>
          </div>
        </div>
        </nav>
        <?php echo navscript(); ?>
        <?php
    }
?>