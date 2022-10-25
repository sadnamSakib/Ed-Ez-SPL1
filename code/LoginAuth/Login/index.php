<?php 

$root_path='../../';
include $root_path.'LibraryFiles/DatabaseConnection/config.php';
include $root_path.'LibraryFiles/SessionStore/session.php';
include $root_path.'LibraryFiles/ValidationPhp/InputValidation.php';


session::stay_in_session();
if (isset($_GET['email']) && isset($_GET['code'])){
    $temp=$_GET['email'];
    $code=$_GET['code'];
    $database->fetch_results($record,"SELECT * FROM token_table WHERE email='$temp'");
    if($record['code']===$code){
      $database->performQuery("UPDATE users SET Verified='1' where email='$temp';");
      $database->performQuery("DELETE FROM token_table WHERE email='$temp';");
    }
    unset($_GET['email']);
  }

if(isset($_SESSION['Password_Reset'])){
    $error="Password Has Been Successfully Reset";
    unset($_SESSION['Password_Reset']);
}
else{
    $error='';
}

if (isset($_POST['submit'])) {
    $email=new EmailValidator(filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL));
    $password=new PasswordValidator(filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS));
    $button_radio=$_REQUEST['btnradio'];
    $existence_name = "SELECT * FROM users INNER JOIN $button_radio ON  users.email=$button_radio.email WHERE users.email = '".$email->get_email()."'";
    $result = $database->performQuery($existence_name);
    if(!$email->email_validate($email->get_original_email()) || !$password->constraint_check()){
        $error='Invalid email address/password';
    }
	else if ($result->num_rows > 0) 
    {
        $database->fetch_results($row,$existence_name);
		if(password_verify($password->get_store_password(),$row['password'])){
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $email->get_original_email();
            $_SESSION['tableName']=$button_radio;
            unset($_POST['password']);
            unset($_POST['email']);	
		    session::redirectProfile($button_radio);
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
<link rel="icon" href="<?php echo $root_path; ?>title_icon.jpg" />
<title>
    Login
</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
<script defer src="script.js"></script>
<script src="https://kit.fontawesome.com/d0f239b9af.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
<div class="container col-md-4">
    <div class="myCard">
    <div class="row">
        
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
                        <input class="myInput" placeholder="Email" type="text" id="email" name="email" value="<?php echo $_POST['email']; ?>" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                    <i class="fas fa-lock"> </i>
                        <input class="myInput" placeholder="Password" type="password" name="password" id="password" value="<?php echo $_POST['password']; ?>" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                        <i class="fas fa-eye-slash" id="togglePassword"></i>
                    </div>
                    <div class="form-group">
                        <p>Don't have an account? <a href="../SignUp/index.php">REGISTER NOW!</a></p>  
                    </div>
                    <div>
                    <a href="../ForgotPassword/SendEmail/index.php">FORGOT PASSWORD?</a>
                    </div>
                    <button type="submit" class="butt" name="submit">Login</button>   
                </form>
            </div>
        

    </div>
    </div>
</div>
</body>
</html>