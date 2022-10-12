<?php

include '../LibraryFiles/DatabaseConnection/config.php';

class session{
    public static function stay_in_session(){
        if (isset($_SESSION['email'])) {
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
}


?>