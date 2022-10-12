<?php

include '../../../LibraryFiles/DatabaseConnection/config.php';
include '../../../LibraryFiles/MailServer/smtp.php';
include '../../../LibraryFiles/URLFinder/URLPath.php';

    $error = '';
    if (isset($_POST['email'])) {
        $error = "An Email Has Been Sent, Check Your Registered Email Address. If you didn't receive the email within 5 minutes, Try Again";
        $email = $_POST['email'];
        $temp = $email;
        $email = hash('sha512', $email);
        $select =$database->performQuery("select email,password from users where email='$email'");
        if ($select->num_rows == 1) {
            $row = mysqli_fetch_assoc($select);
            $email = md5($row['email']);
            $pass = md5($row['password']);
            $link = "<a href='".URLPath::getDirectoryURL()."/ResetPassword/index.php?key=" . $email . "&reset=" . $pass . "'>Click To Reset password</a>";
            $emailContent = new Email($temp,'Please click here to reset your password ' . $link . ' ', 'Reset Password');
            $smtp = new SMTP($emailContent);
            
            $error = $smtp->sendMail();
            
        } else {
            $error = 'Email is not a valid/registered email address';
        }
    }
    ?>
    <!DOCTYPE HTML>
    <html>

    <head>
        <link rel="icon" href="../../../logo4.jpg" />
        <title>
            ForgotPassword
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../style.css" />
        <link rel="stylesheet" href="../css/bootstrap.css" />
        <script defer src="script.js"></script>
        <script src="https://kit.fontawesome.com/d0f239b9af.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jsSHA/2.0.2/sha.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="../js/bootstrap.js"></script>
    </head>

    <body>
        
        <div class="container col-md-4">
            <div class="myCard">
                <div class="row">
                    <div class="col-md">
                        <div class="myLeftCtn">
                            <form id="form1" class="myForm text-center" action="" method="POST">
                                <header>Have an account? Log in!</header>
                                <div class="form-group" id="error2" style="color:red">
                                    <p><?php echo $error ?></p>
                                </div>
                                <div class="form-group">
                                    <div class="btn-group col" role="group" aria-label="Basic radio toggle button group">

                                        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked value="teacher">
                                        <label class="btn btn-outline-primary" for="btnradio1">As Teacher</label>

                                        <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" value="student">
                                        <label class="btn btn-outline-primary" for="btnradio2">As Student</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <i class="fas fa-envelope"> </i>
                                    <input class="myInput" placeholder="Email" type="text" id="email" name="email" required>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                                <div class="form-group">
                                    <p>Retry Login? <a href="../Login/index.php">Login</a></p>
                                </div>
                                <div class="form-group">
                                    <p>Don't have an account? <a href="../SignUp/index.php">REGISTER NOW!</a></p>
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