<?php
$root_path='../../../../';
$parent_path='../../';
require $root_path.'LibraryFiles/DatabaseConnection/config.php';
require $root_path.'LibraryFiles/SessionStore/session.php';
require $root_path.'LibraryFiles/ValidationPhp/InputValidation.php';
session::stay_in_session();

if (isset($_POST['submit_password'])) {
    $validate=new InputValidation();
    $password=new PasswordValidator($validate->post_sanitise_password('password'));
    $confirm = $validate->post_sanitise_password('cfpassword');
    if($password->password_match($confirm) && $password->constraint_check()){
        $select = $database->performQuery("update users set password='".$password->get_password()."' where email='".$_SESSION['email']."'");
        $_SESSION['Password_Reset']=true;
        header('Location: '.$root_path.'LoginAuth/Login/index.php');
    }
    else{
        $password->password_match($confirm);
        $password->constraint_check();
    }
    
}

if ($_GET['key'] && $_GET['reset']) {
    $email = $_GET['key'];
    $pass = $_GET['reset'];
    $select = $database->performQuery("select email,password from users where md5(email)='$email' and md5(password)='$pass'");
    if ($select->num_rows == 1) {
        $database->fetch_results($row,"select email,password from users where md5(email)='$email' and md5(password)='$pass'");
        $_SESSION['email']=$row['email'];
        }
    }
    ?>

        <!DOCTYPE HTML>
        <html>

        <head>
            <link rel="icon" href="<?php echo $root_path; ?>title_icon.jpg" />
            <title>
                Reset Password
            </title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="<?php echo $parent_path ?>style.css" />
            <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
            <script src="https://kit.fontawesome.com/d0f239b9af.js" crossorigin="anonymous"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
            <script defer src="script.js"></script>
        </head>

        <body>
            
            <div class="container col-md-4">
                <div class="myCard">
                    <div class="row">
                        <div class="col-md">
                            <div class="myLeftCtn">
                                <form id="form" class="myForm text-center" action="" method="POST">
                                    <header>Reset Password</header>
                                    <div class="form-group" id="error" style="color:red;display:<?php
                                        if(!is_null($password->password_error)){
                                            echo "block";
                                        }
                                        else{
                                            echo "none";
                                        }
                                    ?>">
                                    <?php echo $password->password_error; ?>
                                    </div>
                                    <div class="form-group">
                                        <i class="fas fa-lock"> </i>
                                        <input class="myInput" placeholder="Password" type="password" id="password" name="password" required>
                                        <i class="fas fa-eye-slash" id="togglePassword"></i>
                                    </div>
                                    <div class="form-group" id="errorConfirm" style="color:red;display:<?php
                                        if(!is_null($password->confirm_error)){
                                            echo "block";
                                        }
                                        else{
                                            echo "none";
                                        }
                                    ?>">
                                    <?php echo $password->confirm_error; ?>
                                    </div>
                                    <div class="form-group">
                                        <i class="fas fa-lock"> </i>
                                        <input class="myInput" placeholder="Confirm Password" type="password" id="cfpassword" name="cfpassword" required>
                                        <i class="fas fa-eye-slash" id="togglePassword2"></i>
                                    </div>
                                    <input type="submit" value="Reset Password" class="butt" name="submit_password">
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </body>

        </html>