<?php

class session{
    public static function stay_in_session(){
        if (isset($_SESSION['email']) && !isset($_SESSION['code'])) {
            $url=$_SESSION['url'];
            header('Location: '.$url.'');
        }
    }

    public static function redirectProfile($tableName){
        if($tableName=='teacher'){
            header("Location: ../../UserProfiles/TeacherProfile/index.php");
        }
        else{
            header("Location: ../../UserProfiles/StudentProfile/index.php");
        }
    }

    public static function create_or_resume_session(){
        session_start();
        error_reporting(0);
    }

    public static function profile_not_set($root_path){
        if (!isset($_SESSION['email'])) {
            header("Location: " . $root_path . "index.php");
          }
    }
}


?>