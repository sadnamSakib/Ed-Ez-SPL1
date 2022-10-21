<?php 
    function student_navbar($root_path){
        include $root_path.'UserProfiles/Navbar/index.php';
        navbar($root_path.'UserProfiles/StudentProfile/',$root_path.'UserProfiles/StudentProfile/index.php',$root_path.'UserProfiles/StudentProfile/StudentSchedule/index.php',$root_path.'UserProfiles/StudentProfile/ClassroomSystem/index.php',$root_path.'UserProfiles/StudentProfile/',$root_path);
    }
?>