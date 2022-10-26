<?php 
    function teacher_navbar($root_path){
        require $root_path.'UserProfiles/NavbarProfile/index.php';
        navbar($root_path.'UserProfiles/UpdatePassword/',$root_path.'UserProfiles/TeacherProfile/',$root_path.'UserProfiles/TeacherProfile/index.php',$root_path.'UserProfiles/TeacherProfile/TeacherSchedule/index.php',$root_path.'UserProfiles/TeacherProfile/ClassroomSystem/index.php',$root_path.'UserProfiles/TeacherProfile/',$root_path);
    }
?>