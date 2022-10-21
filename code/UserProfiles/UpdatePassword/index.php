<?php

$root_path = '../../';
include $root_path . 'LibraryFiles/DatabaseConnection/config.php';
include $root_path . 'LibraryFiles/URLFinder/URLPath.php';
include $root_path . 'LibraryFiles/SessionStore/session.php';
session::create_or_resume_session();
session::profile_not_set($root_path);

$temp=hash('sha512',$_SESSION['email']);
$tableName=$_SESSION['tableName'];
$error="";
if(isset($_REQUEST['updatePassword'])){
    $oldPassword=$_REQUEST['opassword'];
    $oldPassword=hash('sha512',$oldPassword);
    $existence_name = "SELECT * FROM users WHERE email = '$temp'";
    $result = $database->performQuery($existence_name);
    $row = mysqli_fetch_assoc($result);
    $password=hash('sha512',$_REQUEST['password']);
    $password=password_hash($password,PASSWORD_BCRYPT);
    if(password_verify($oldPassword,$row['password'])){
        $sql="UPDATE users SET password='$password' WHERE email='$temp'";
        $res=$database->performQuery($sql);
        session::redirectProfile($tableName);
    }
    else{
        $error="Old password field should contain the current password, old password incorrect";
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
<link rel="stylesheet" href="css/bootstrap.css" />
<script defer src="script.js"></script>
<script src="https://kit.fontawesome.com/d0f239b9af.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsSHA/2.0.2/sha.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>


<script src="js/bootstrap.js"></script>
<div class="container col-md-4">
    <div class="myCard">
    <div class="row">
        <div class="col-md">
            <div class="myLeftCtn">
                <form id="form" class="myForm text-center" action="" method="POST">
                    <header>Change Account Password</header>
                    <div class="form-group" id="error" style="color:red">
                            <p><?php echo $error ?></p>
                    </div>
                    <div class="form-group">
                    <i class="fas fa-lock"> </i>
                        <input class="myInput" placeholder="Old Password" type="password" name="opassword" id="opassword"  required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                        <i class="fas fa-eye-slash" id="togglePassword3"></i>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-lock"> </i>
                        <input class="myInput" placeholder="Password" type="password" id="password" name="password" required>
                        <i class="fas fa-eye-slash" id="togglePassword"></i>
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