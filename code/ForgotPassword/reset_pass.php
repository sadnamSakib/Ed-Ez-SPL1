<?php

include '../config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if(isset($_POST['submit_password']) && $_POST['type'])
{
  $email=$_POST['email'];
  $pass=$_POST['password'];
  $pass=hash('sha512',$pass);
  $pass=password_hash($pass,PASSWORD_BCRYPT);
  $type=$_POST['type'];
  $select=mysqli_query($conn,"update $type set password='$pass' where email='$email'");
        if($type==='teacher'){
            header('Location: ../TeacherProfile/index.php');
        }
        else{
            header('Location: ../StudentProfile/index.php');
        }
  
}

if($_GET['key'] && $_GET['reset'] && $_GET['type'])
{
  $email=$_GET['key'];
  $pass=$_GET['reset'];
  $type=$_GET['type'];
  $select=mysqli_query($conn,"select email,password from $type where md5(email)='$email' and md5(password)='$pass'");
  if($select->num_rows==1)
  {
    $row=mysqli_fetch_assoc($select);
    $email=$row['email'];
    ?>

<!DOCTYPE HTML>
<html>
<head>
<link rel="icon" href="../logo4.jpg" />
<title>
    Reset Password
</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="css/bootstrap.css" />
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
                    <header>Reset Password</header>
                    <div class="form-group" id="error" style="color:red">
                    </div>
                    <input type="hidden" name="email" value="<?php echo $email;?>">
                    <input type="hidden" name="type" value="<?php echo $type;?>">
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
                    <script>
                        const togglePassword = document
            .querySelector('#togglePassword');
  
        togglePassword.addEventListener('click', () => {
  
            // Toggle the type attribute using
            // getAttribure() method
            const type = password
                .getAttribute('type') === 'password' ?
                'text' : 'password';
                  
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
  });

  const togglePassword2 = document
            .querySelector('#togglePassword2');
  
        togglePassword2.addEventListener('click', () => {
  
            // Toggle the type attribute using
            // getAttribure() method
            const type = cfpassword
                .getAttribute('type') === 'password' ?
                'text' : 'password';
                  
            cfpassword.setAttribute('type', type);
            this.classList.toggle('fa-eye');
  });
                        const form=document.getElementById('form')
                        form.addEventListener('submit', (e) => {
                            const errorElement=document.getElementById('error')
                            let messages = []
                            var password=document.getElementById('password')
                            var cfpassword=document.getElementById('cfpassword')
                            if(password.value!==cfpassword.value) {
                                messages.push('Passwords do not match')
                            }
                            else if(password.value.length>=8){
                                let charPresentSmall=false
                                let charPresentBig=false
                                let numPresent=false
                                let symbolPresent=false
                                for(let i=0;i<password.value.length;i++){
                                    if(password.value.charAt(i)>='A' && password.value.charAt(i)<='Z'){
                                        charPresentBig=true
                                    }
                                    else if(password.value.charAt(i)>='a' && password.value.charAt(i)<='z'){
                                        charPresentSmall=true
                                    }
                                    else if(password.value.charAt(i)>='0' && password.value.charAt(i)<='9'){
                                        numPresent=true
                                    }
                                    else if((password.value.charAt(i)>=' ' && password.value.charAt(i)<'9') || (password.value.charAt(i)>'9' && password.value.charAt(i)<'A') || (password.value.charAt(i)>'Z' && password.value.charAt(i)<'a') || (password.value.charAt(i)>'z' && password.value.charAt(i)<='~')){
                                        symbolPresent=true
                                    }
                                    else{
                                        continue
                                    }
                                }
                                if(charPresentSmall===false || charPresentBig===false || numPresent===false || symbolPresent===false){
                                    messages.push("Password must contain numbers, letters of both cases and symbols")
                                }

                            }
                            else{
                                messages.push('Password must be greater than 8 characters long')
                            }
                            if(messages.length>0){
                                e.preventDefault()
                                errorElement.innerText=messages.join(', ')
                            }
                        })
                    </script>
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
    $error='';
    if(isset($_POST['email'])){
            $error="An Email Has Been Sent, Check Your Registered Email Address. If you didn't receive the email within 5 minutes, Try Again";
            $email=$_POST['email'];
            $temp=$email;
            $email=hash('sha512',$email);
            $button_radio=$_POST['btnradio'];
            if($button_radio==="teacher"){
                $button_radio="teacher";
            }
            else{
                $button_radio="student";
            }
            $select=mysqli_query($conn,"select email,password from $button_radio where email='$email'");
            if($select->num_rows==1)
            {
                $row = mysqli_fetch_array($select);
                $email=md5($row['email']);
                $pass=md5($row['password']);
                $link="<a href='http://localhost/SPL-1-Ed-Ez/code/ForgotPassword/reset_pass.php?key=".$email."&reset=".$pass."&type=".$button_radio."'>Click To Reset password</a>";
                $mail = new PHPMailer(true);
                try {                                    
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp-relay.sendinblue.com;';                    
                    $mail->SMTPAuth   = true;                             
                    $mail->Username   = '-------------';                 
                    $mail->Password   = '-------------';                      
                    $mail->SMTPSecure = 'tls';                              
                    $mail->Port       = 587;  
                
                    $mail->setFrom('edez23931@gmail.com', 'EdEz');           
                    $mail->addAddress(''.$temp.'');
                    $mail->isHTML(true);                                  
                    $mail->Subject = 'Reset Password';
                    $mail->Body    = 'Please click here to reset your password '.$link.' ';
                    $mail->AltBody = 'Please click here to reset your password '.$link.' ';
                    $mail->send();
                    $error="An Email Has Been Sent Check Your Email Address. If you didn't receive the email within 5 minutes, Try Again";
                    
                } catch (Exception $e) {
                    $error="Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                
            }
        else 
        {
            $error='Email is not a valid/registered email address';
        }
    }
    ?>
    <!DOCTYPE HTML>
<html>
<head>
<link rel="icon" href="../logo4.jpg" />
<title>
    ForgotPassword
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
                    <script>
                        //this script is disfunctional and can be removed later I guess...
                        const form=document.getElementById('form1')
                        form.addEventListener('submit', (e) => {
                            const errorElement=document.getElementById('error')
                            let messages = []
                            var email=document.getElementById('email');
                            if(!ValidateEmail(email.value)){
                                messages.push("Email is not in a valid format");
                            }
                            if(messages.length>0){
                                e.preventDefault()
                                errorElement.innerText=messages.join(', ')
                            }
                        })

                        function ValidateEmail(inputText)
                        {
                        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                        if(inputText.value.match(mailformat))
                        {
                        return true;
                        }
                        else
                        {
                        return false;
                        }
                        }
                    </script>
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
?>

