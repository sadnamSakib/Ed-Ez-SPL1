<?php 
    function student_navbar($root_path){
        require $root_path.'UserProfiles/NavbarProfile/index.php';
        navbar($root_path.'UserProfiles/UpdatePassword/',$root_path.'UserProfiles/StudentProfile/',$root_path.'UserProfiles/StudentProfile/index.php',$root_path.'UserProfiles/StudentProfile/StudentSchedule/index.php',$root_path.'UserProfiles/StudentProfile/ClassroomSystem/index.php',$root_path.'UserProfiles/StudentProfile/',$root_path);
    }
?>