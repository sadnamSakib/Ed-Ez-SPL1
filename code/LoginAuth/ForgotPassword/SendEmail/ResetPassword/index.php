<?php
$root_path='../../../../';
$parent_path='../../';
include $root_path.'LibraryFiles/DatabaseConnection/config.php';
include $root_path.'LibraryFiles/SessionStore/session.php';
session::create_or_resume_session();
session::stay_in_session();

if (isset($_POST['submit_password'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $pass = hash('sha512', $pass);
    $pass = password_hash($pass, PASSWORD_BCRYPT);
    $select = $database->performQuery("update users set password='$pass' where email='$email'");
    $_SESSION['Password_Reset']=true;
    header('Location: '.$root_path.'LoginAuth/Login/index.php');
}
else if ($_GET['key'] && $_GET['reset']) {
    $email = $_GET['key'];
    $pass = $_GET['reset'];
    $select = $database->performQuery("select email,password from users where md5(email)='$email' and md5(password)='$pass'");
    if ($select->num_rows == 1) {
        $row = mysqli_fetch_assoc($select);
        $email = $row['email'];
?>

        <!DOCTYPE HTML>
        <html>

        <head>
            <link rel="icon" href="<?php echo $root_path; ?>logo4.jpg" />
            <title>
                Reset Password
            </title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="<?php echo $parent_path ?>style.css" />
            <link rel="stylesheet" href="<?php echo $parent_path ?>css/bootstrap.css" />
            <script src="https://kit.fontawesome.com/d0f239b9af.js" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jsSHA/2.0.2/sha.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="../js/bootstrap.js"></script>
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
                                    <div class="form-group" id="error" style="color:red">
                                    </div>
                                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                                    <input type="hidden" name="type" value="<?php echo $type; ?>">
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
                                    <input type="submit" value="Reset Password" class="butt" name="submit_password">
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </body>

        </html>
    <?php
    }
}
    else{
        echo "error 404";
    }
    ?>