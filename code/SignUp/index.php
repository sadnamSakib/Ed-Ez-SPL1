<?php 

include '../config.php';
$error='';
$name='';


if (isset($_POST['submit'])) {
	$name =  $_POST['username'];
    $email = $_POST['email'];
    $temp=$email;
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $institutions = $_POST['institution'];
    $button_radio=$_POST['btnradio'];
    $confirm= $_POST['cfpassword'];
    $password=hash('sha512',$password);
    $email=hash('sha512',$email);
    $password=password_hash($password,PASSWORD_BCRYPT);
    $error=$_REQUEST['error'];
    $tableName='';
    if($button_radio==='teacher'){
        $tableName='teacher';
    }
    else{
        $tableName='student';
    }
    $sql = "INSERT INTO $tableName VALUES ('$name', '$email','$password','$dob','$gender','$institutions')";
        $existence_name = "SELECT * FROM $tableName WHERE email = '$email'";
    $result = mysqli_query($conn, $existence_name);
    if ($result->num_rows > 0) {
        $email='';
        $password='';
        $_REQUEST['password']='';
        $error="An account already exists with this email";
    }
    else{
        $addToTable=mysqli_query($conn,$sql);
        $row_fetch = mysqli_query($conn, $existence_name);
        $row = mysqli_fetch_assoc($row_fetch);
		$_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $temp;
		header("Location: ../Profile/index.php");
    }   
}
?>

<!DOCTYPE HTML>
<html>
<head>
<title>
    SignUp
</title>
<link rel="icon" href="../logo4.jpg" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="css/bootstrap.css" />
<script defer src="script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsSHA/2.0.2/sha.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://kit.fontawesome.com/d0f239b9af.js" crossorigin="anonymous"></script>
</head>
<body>
<script src="js/bootstrap.js"></script>
<div class="container col-md-4 mb-5 mt-5">
    <div class="myCard">
    <div class="row">
        <div class="col-md">
            <div class="myLeftCtn">
                <form id="form" class="myForm text-center" action="" method="POST">
                    <header>Create New Account</header>
                    <div class="form-group">
                        <div class="btn-group col" role="group" aria-label="Basic radio toggle button group">

                            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked value="<?php $button_radio="teacher";echo $button_radio; ?>">
                            <label class="btn btn-outline-primary" for="btnradio1">As Teacher</label>
                          
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" value="<?php $button_radio="student";echo $button_radio; ?>">
                            <label class="btn btn-outline-primary" for="btnradio2">As Student</label>
                          </div>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-user"> </i>
                        <input class="myInput" type="text" placeholder="Username" name="username" id="username" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group" id="error" style="color:red;display:none">
                            <p><?php echo $error ?></p>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-envelope"> </i>
                        <input class="myInput" placeholder="Email" name="email" type="text" id="email" required value="<?php echo $_REQUEST['email']; ?>">
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                    <i class="fas fa-graduation-cap"></i>
                        <input class="myInput" type="text" name="institution" placeholder="Institution" id="institution" required value="<?php echo $institutions; ?>">
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div id="passwordError" class="form-group" style="color:red;display:none">

                        </div>
                    <div class="form-group">
                        <i class="fas fa-lock"> </i>
                        
                        <input class="myInput" placeholder="Password" type="password" id="password" name="password" required value="<?php echo $_POST['password']; ?>">
                    </div>
                    <div id="confirmPasswordError" class="form-group" style="color:red;display:none">

                        </div>
                    <div class="form-group">
                        <i class="fas fa-lock"> </i>
                        <input class="myInput" placeholder="Confirm Password" type="password" id="cfpassword" name="cfpassword" required value="<?php echo $_POST['cfpassword']; ?>">
                    </div>
                    <div id="genderError" class="form-group" style="color:red;display:none">

                        </div>
                    <div class="form-group">
                        <i class="fas fa-venus"></i>
                            <select class="myInput" name="gender" id="gender" value="<?php echo $gender; ?>">
                                <option value="select">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="not specified">Not Specified</option>
                                <option value="other">Other</option>
                                </select>
                    </div>
                    <div class="form-group">
                    <i class="fas fa-calendar-days"></i>
                        <span class="hovertext" data-hover="Enter Date Of Birth">
                            <input class="myInput" type="date" name="dob" id="dob" onclick="
                            var dateString=new Date().toLocaleDateString('en-ca');
                            this.setAttribute('max',dateString);" required value="<?php echo $dob ?>">
                        </span>
                    </div>
                    
                    
                    <div class="form-group">
                        <label>
                            <input id="check_1" name="check_1" type="checkbox" required>
                            <small>
                                I read and agree to <a href="tc.html" target="_blank">Terms & Conditions<a>
                            </small>
                        <div class="invalid-feedback">You must check the box.</div>
                        </label>
                    </div>
                    <div class="form-group">
                        <p>Already have an account? <a href="../Login/index.php">LOGIN</a></p>  
                    </div>
                    <input type="submit" value="Submit" class="butt" name="submit">             
                </form>
            </div>
        </div>

    </div>
    </div>
</div>
</body>
</html>