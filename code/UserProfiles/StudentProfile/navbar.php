<?php 
    require $root_path.'UserProfiles/Navbar/index.php';
    function student_navbar($root_path,$profile=false){
        if($profile){
            navbar($root_path.'UserProfiles/StudentProfile/',$root_path.'UserProfiles/StudentProfile/index.php',$root_path.'UserProfiles/StudentProfile/StudentSchedule/index.php',$root_path.'UserProfiles/StudentProfile/ClassroomSystem/index.php',$root_path.'UserProfiles/StudentProfile/',$root_path,$root_path.'UserProfiles/UpdatePassword/');
        }
        else{
            navbar($root_path.'UserProfiles/StudentProfile/',$root_path.'UserProfiles/StudentProfile/index.php',$root_path.'UserProfiles/StudentProfile/StudentSchedule/index.php',$root_path.'UserProfiles/StudentProfile/ClassroomSystem/index.php',$root_path.'UserProfiles/StudentProfile/',$root_path);
        }
    }
?>
