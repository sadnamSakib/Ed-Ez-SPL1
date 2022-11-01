<?php
$root_path = '../../../';
require $root_path.'LibraryFiles/DatabaseConnection/config.php';
require $root_path.'LibraryFiles/MailServer/smtp.php';
require $root_path.'LibraryFiles/SessionStore/session.php';
require $root_path.'LibraryFiles/ValidationPhp/InputValidation.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
session::stay_in_session();
$errorMessage = $_SESSION['error'];
unset($_SESSION['error']);
if (isset($_POST['email'])) {
    $validate=new InputValidation();
    $errorMessage = "An Email Has Been Sent, Check Your Registered Email Address. If you didn't receive the email within 5 minutes, Try Again";
    $email=new EmailValidator($validate->post_sanitise_email('email'));
    $select = $database->performQuery("select email,password from users where email='".$email->get_email()."'");
    if(!$email->email_validate()){
        $errorMessage="Email is not a valid/registered email address";
    }
    else if ($select->num_rows == 1) {
        $database->fetch_results($row,"select email,password from users where email='".$email->get_email()."'");
        $link = "<a href='" . URLPath::getDirectoryURL() . "/ResetPassword/index.php?key=" . md5($email->get_email()) . "&reset=" . md5($row['password']) . "'>Click To Reset password</a>";
        $emailContent = new Email($email->get_original_email(), 'Please Click On The Link to reset your password ' . $link . ' ', 'Reset Password');
        try{
            $smtp = new SMTPLaunch($emailContent);
            if(!$smtp->send($_SESSION['error'])){
                header('Location: index.php');
            }
        }
        catch(Exception $e){
            $_SESSION['error']='MailServer Failure could not validate email address';
            header('Location: index.php');
        }
        
        $errorMessage = $smtp->sendMail();
    } else {
        $errorMessage = 'Email is not a valid/registered email address';
    }
    unset($_SESSION['error']);
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <link rel="icon" href="<?php echo $root_path; ?>title_icon.jpg" />
    <title>
        ForgotPassword
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
    <script defer src="script.js"></script>
    <script src="https://kit.fontawesome.com/d0f239b9af.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
</head>

<body>

    <div class="container col-md-4">
        <div class="myCard">
            <div class="row">
                <div class="col-md">
                    <div class="myLeftCtn">
                        <form id="form1" class="myForm text-center" action="" method="POST">
                            <header>Have an account? Log in!</header>
                            <div class="form-group" id="errorMessage2" style="color:red">
                                <p><?php echo $errorMessage ?></p>
                            </div>
                            <div class="form-group">
                                <i class="fas fa-envelope"> </i>
                                <input class="myInput" placeholder="Email" type="text" id="email" name="email" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="form-group">
                                <p>Retry Login? <a href="<?php echo $root_path; ?>LoginAuth/Login/index.php">Login</a></p>
                            </div>
                            <div class="form-group">
                                <p>Don't have an account? <a href="<?php echo $root_path; ?>LoginAuth/SignUp/index.php">REGISTER NOW!</a></p>
                            </div>
                            <input type="submit" value="Send Reset Mail" class="butt" name="submit_email_reset">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>