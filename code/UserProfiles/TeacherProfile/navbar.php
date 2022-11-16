<?php 
    require $root_path.'UserProfiles/Navbar/index.php';
    function teacher_navbar($root_path,$profile=false){
        if($profile){
            navbar($root_path.'UserProfiles/TeacherProfile/',$root_path.'UserProfiles/TeacherProfile/index.php',$root_path.'UserProfiles/TeacherProfile/TeacherSchedule/index.php',$root_path.'UserProfiles/TeacherProfile/ClassroomSystem/index.php',$root_path,$root_path.'UserProfiles/UpdatePassword/index.php');
        }
        else{
            navbar($root_path.'UserProfiles/TeacherProfile/',$root_path.'UserProfiles/TeacherProfile/index.php',$root_path.'UserProfiles/TeacherProfile/TeacherSchedule/index.php',$root_path.'UserProfiles/TeacherProfile/ClassroomSystem/index.php',$root_path);
        }
    }
?>