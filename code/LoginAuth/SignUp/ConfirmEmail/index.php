<?php 

$root_path='../../../';
include $root_path.'LibraryFiles/DatabaseConnection/config.php';
include $root_path.'LibraryFiles/URLFinder/URLPath.php';
include $root_path.'LibraryFiles/SessionStore/session.php';
include $root_path.'LibraryFiles/MailServer/smtp.php';
session::create_or_resume_session();
$email=$_SESSION['email'];
$temp_email=hash('sha512',$email);
$code=generateRandomString(12);
if($database->performQuery("SELECT * FROM token_table WHERE email = '$temp_email'")->num_rows>0){
    $database->performQuery("DELETE FROM token_table WHERE email = '$temp_email'");
}
$database->performQuery("INSERT INTO token_table(email,code) VALUES('$temp_email','$code');");
$link= URLPath::getRoot() .'LoginAuth/Login/index.php?email='.$temp_email.'&code='.$code.'';
$mail=new email($email,'<a href="'.$link.'">Click on this link</a> to verify your profile and then login with your credentials ','email Verification for EdEz');

try{
    $smtp=new smtp($mail);
    if(!$smtp->send($_SESSION['error'])){
        $database->performQuery("DELETE FROM users WHERE email='$temp_email';");
        $database->performQuery("DELETE FROM token_table WHERE email='$temp_email';");
        header('Location: ../index.php');
    }
}
catch(Exception $e){
    $_SESSION['error']='MailServer Failure could not validate email address';
    $database->performQuery("DELETE FROM users WHERE email='$temp_email';");
    $database->performQuery("DELETE FROM token_table WHERE email='$temp_email';");
    header('Location: ../index.php');
}







?>

<!DOCTYPE HTML>
<html>
<head>
<link rel="icon" href="<?php echo $root_path; ?>logo4.jpg" />
<title>
    Confirm email
</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="css/bootstrap.css" />
<script defer src="script.js"></script>
<script src="https://kit.fontawesome.com/d0f239b9af.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsSHA/2.0.2/sha.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body style="margin: 0 !important; padding: 0 !important;">
<script src="js/bootstrap.js"></script>

    <!-- HIDDEN PREHEADER TEXT -->
    <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: 'Lato', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;"> We're thrilled to have you here! Get ready to dive into your new account.
    </div>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <!-- LOGO -->
        <tr>
            <td bgcolor="#4596be" align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#4596be" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                            <h1 style="font-size: 48px; font-weight: 400; margin: 2;">Welcome!</h1> <img src="<?php echo $root_path; ?>logo2Confirmemail.jpg" width="300" height="250" style="display: block; border: 0px;" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">We're excited to have you get started. First, you need to confirm your account. <b>An email has been sent to your account</b>, if you did not receive it click the button below.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" style="border-radius: 3px;" bgcolor="#4596be"><a href="index.php"  style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #4596be; display: inline-block;">Confirm Account</a></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">Cheers,<br>EdEz Team</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

