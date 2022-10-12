<?php 

include '../config.php';

if (isset($_SESSION['email'])) {
    $tableName=$_SESSION['tableName'];
    if($tableName==='teacher'){
        header('Location: '.$uri.'/Ed-Ez-SPL1/code/TeacherProfile/index.php');
    }
    else{
        header('Location: '.$uri.'/Ed-Ez-SPL1/code/StudentProfile/index.php');
    }
}

$error='';

if (isset($_REQUEST['submit'])) {
	$email = $_REQUEST['email'];
    $temp=$email;
    $password = $_REQUEST['password'];
    $button_radio=$_REQUEST['btnradio'];
    $password=hash('sha512',$password);
    $email=hash('sha512',$email);
    $tablename;
    if($button_radio==='teacher'){
        $tablename="teacher";
    }
    else{
        $tablename="student";
    }
    $existence_name = "SELECT * FROM users WHERE email = '$email'";
    $result = $database->performQuery($existence_name);
	if ($result->num_rows > 0) 
    {
        
		$result = $database->performQuery($existence_name);
        $row=mysqli_fetch_assoc($result);
		if(password_verify($password,$row['password'])){
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $temp;
            $_SESSION['tablename']=$tablename;
		    if($tablename=='teacher'){
                header("Location: ../TeacherProfile/index.php");
            }
            else{
                header("Location: ../StudentProfile/index.php");
            }
        }
        else{
            $error='Password is incorrect ';
        }
	} 
    else 
    {
        $error='Login details is incorrect';
        $email='';
        $password='';
        $_REQUEST['password']='';
	}
}
?>

<!DOCTYPE HTML>
<html>
<head>
<link rel="icon" href="../logo4.jpg" />
<title>
    Login
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
                    <header>Have an account? Log in!</header>
                    <div class="form-group" id="error" style="color:red">
                            <p><?php echo $error ?></p>
                    </div>
                    <div class="form-group">
                    <div class="btn-group col" role="group" aria-label="Basic radio toggle button group">

                            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked value="<?php $button_radio="teacher";echo $button_radio; ?>">
                            <label class="btn btn-outline-primary" for="btnradio1">As Teacher</label>
                          
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" value="<?php $button_radio="student";echo $button_radio; ?>">
                            <label class="btn btn-outline-primary" for="btnradio2">As Student</label>
                          </div>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-envelope"> </i>
                        <input class="myInput" placeholder="Email" type="text" id="email" name="email" value="<?php echo $_REQUEST['email']; ?>" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                    <i class="fas fa-lock"> </i>
                        <input class="myInput" placeholder="Password" type="password" name="password" id="password" value="<?php echo $_REQUEST['password']; ?>" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                        <i class="fas fa-eye-slash" id="togglePassword"></i>
                    </div>
                    <div class="form-group">
                        <p>Don't have an account? <a href="../SignUp/index.php">REGISTER NOW!</a></p>  
                    </div>
                    <div class="form-group">
                        <p><a href="../ForgotPassword/reset_pass.php">FORGOT PASSWORD?</a></p>  
                    </div>
                    <button type="submit" class="butt" name="submit">Login</button>   
                </form>
            </div>
        </div>

    </div>
    </div>
</div>
</body>
</html>