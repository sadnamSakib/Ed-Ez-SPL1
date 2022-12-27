<?php 
    require $root_path.'UserProfiles/Navbar/index.php';
    function student_navbar($root_path,$profile=false){
        if($profile){
            navbar($root_path.'UserProfiles/StudentProfile/Dashboard/index.php',$root_path.'UserProfiles/StudentProfile/index.php',$root_path.'UserProfiles/StudentProfile/StudentSchedule/index.php',$root_path.'UserProfiles/Resources/index.php',$root_path.'UserProfiles/StudentProfile/ClassroomSystem/index.php',$root_path,$root_path.'UserProfiles/StudentProfile/ClassroomSystem/GradingSystem/index.php',$root_path.'UserProfiles/UpdatePassword/index.php');
        }
        else{
            navbar($root_path.'UserProfiles/StudentProfile/Dashboard/index.php',$root_path.'UserProfiles/StudentProfile/index.php',$root_path.'UserProfiles/StudentProfile/StudentSchedule/index.php',$root_path.'UserProfiles/Resources/index.php',$root_path.'UserProfiles/StudentProfile/ClassroomSystem/index.php',$root_path,$root_path.'UserProfiles/StudentProfile/ClassroomSystem/GradingSystem/index.php',NULL);
        }
    }
?>
