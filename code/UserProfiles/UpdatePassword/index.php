<?php

$root_path = '../../';
include $root_path . 'LibraryFiles/DatabaseConnection/config.php';
include $root_path . 'LibraryFiles/URLFinder/URLPath.php';
include $root_path . 'LibraryFiles/SessionStore/session.php';
include $root_path.'LibraryFiles/ValidationPhp/InputValidation.php';
session::profile_not_set($root_path);

$temp=hash('sha512',$_SESSION['email']);
$tableName=$_SESSION['tableName'];
$error=null;
if(isset($_REQUEST['updatePassword'])){
    $oldPassword=$_REQUEST['opassword'];
    $oldPassword=hash('sha512',$oldPassword);
    $database->fetch_results($row,"SELECT * FROM users WHERE email = '$temp'");
    $password=new PasswordValidator(filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS));
    if(!$password->constraint_check() || !$password->password_match($_POST['cfpassword'])){
        $password->constraint_check();
        $password->password_match($_POST['cfpassword']);
    }
    else if(password_verify($oldPassword,$row['password'])){
        $sql="UPDATE users SET password='".$password->get_password()."' WHERE email='$temp'";
        $res=$database->performQuery($sql);
        session::redirectProfile($tableName);
    }
    else{
        $error="Old password field should contain the current password or existing password, old password incorrect";
    }
}

?>

<!DOCTYPE HTML>
<html>
<head>
<link rel="icon" href="<?php echo $root_path; ?>title_icon.jpg" />
<title>
    Change Password
</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
<script defer src="script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/d0f239b9af.js" crossorigin="anonymous"></script>
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
</head>
<body>


<script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
<div class="container col-md-4">
    <div class="myCard">
    <div class="row">
        <div class="col-md">
            <div class="myLeftCtn">
                <form id="form" class="myForm text-center" action="" method="POST">
                    <header>Change Account Password</header>
                    <div class="form-group" id="error" style="color:red;display:<?php 
                        if(!is_null($error)){
                            echo "block";
                        }
                        else{
                            echo "none";
                        }
                    ?>">
                            <p><?php echo $error; ?></p>
                    </div>
                    <div class="form-group">
                    <i class="fas fa-lock"> </i>
                        <input class="myInput" placeholder="Old Password" type="password" name="opassword" id="opassword"  required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                        <i class="fas fa-eye-slash" id="togglePassword3"></i>
                    </div>
                    <div class="form-group" id="password_error" style="color:red;display:<?php 
                        if(!is_null($password->password_error)){
                            echo "block";
                        }
                        else{
                            echo "none";
                        }
                    ?>">
                            <p><?php echo $password->password_error; ?></p>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-lock"> </i>
                        <input class="myInput" placeholder="Password" type="password" id="password" name="password" required>
                        <i class="fas fa-eye-slash" id="togglePassword"></i>
                    </div>
                    <div class="form-group" id="confirm_error" style="color:red;display:<?php 
                        if(!is_null($password->confirm_error)){
                            echo "block";
                        }
                        else{
                            echo "none";
                        }
                    ?>">
                            <p><?php echo $password->confirm_error; ?></p>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-lock"> </i>
                        <input class="myInput" placeholder="Confirm Password" type="password" id="cfpassword" name="cfpassword" required>
                        <i class="fas fa-eye-slash" id="togglePassword2"></i>
                    </div>
                    <div class="form-group">
                        <?php
                            if($tableName==='teacher'){
                                $src='TeacherProfile/';
                            }
                            else{
                                $src='StudentProfile/';
                            }
                        ?>
                        <p>Return to Profile <a href="../<?php echo $src; ?>index.php">Profile</a></p>  
                    </div>
                    <input type="submit" class="butt" name="updatePassword" value="Update Password"/>
                </form>
            </div>
        </div>

    </div>
    </div>
</div>
</body>
</html>