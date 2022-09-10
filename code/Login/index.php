<?php 

include '../config.php';

if (isset($_REQUEST['submit'])) {
	$email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $button_radio=$_REQUEST['btnradio'];
    $password=hash('md5',$password);
    if($button_radio==='teacher'){
        //$sql = "INSERT INTO teacher VALUES ('$name', '$email','$password','$dob','$gender','$institutions')";
        $existence_name = "SELECT * FROM teacher WHERE email = '$email' AND password = '$password'";
    }
    else{
        //$sql = "INSERT INTO teacher VALUES ('$name', '$email','$password','$dob','$gender','$institutions')";
        $existence_name = "SELECT * FROM student WHERE email = '$email' AND password = '$password'";
    }
    $result = mysqli_query($conn, $existence_name);
	if ($result->num_rows > 0) {
		$row = mysqli_fetch_assoc($result);
		$_SESSION['username'] = $row['username'];
		header("Location: ../Profile/index.php");
	} else {
        $email='';
        $password='';
        $_REQUEST['password']='';
	}
}
?>

<!DOCTYPE HTML>
<html>
<head>
<link rel="icon" href="/EdEz/logo4.jpg" />
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
                    <div id="error" style="color:red">
        
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
                        <input class="myInput" placeholder="Email" type="text" id="email" name="email" value="<?php echo $email; ?>" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                    <i class="fas fa-lock"> </i>
                        <input class="myInput" placeholder="Password" type="password" name="password" id="password" value="<?php echo $_REQUEST['password']; ?>" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
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