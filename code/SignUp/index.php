<!DOCTYPE HTML>
<html>
<head>
<title>
    SignUp
</title>
<link rel="icon" href="/EdEz/logo4.jpg" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="css/bootstrap.css" />
<script defer src="script.js"></script>
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
                <form id="form" class="myForm text-center" action="insert.php" method="POST">
                    <header>Create New Account</header>
                    <div id="error" class="form-group" style="color:red">
                        
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
                        <i class="fas fa-user"> </i>
                        <input class="myInput" type="text" placeholder="Username" name="username" id="username" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-envelope"> </i>
                        <input class="myInput" placeholder="Email" name="email" type="text" id="email" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-user"> </i>
                        <input class="myInput" type="text" name="institution" placeholder="Institution" id="institution" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-lock"> </i>
                        <input class="myInput" placeholder="Password" type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-lock"> </i>
                        <input class="myInput" placeholder="Confirm Password" type="password" id="cfpassword" name="cfpassword" required>
                    </div>
                    <div class="form-group">
                            <i class="fas fa-lock"> </i>
                            <select class="myInput" name="gender" id="gender">
                                <option value="select">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="not specified">Not Specified</option>
                                <option value="other">Other</option>
                                </select>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-lock"> </i>
                        <span class="hovertext" data-hover="Enter Date Of Birth">
                            <input class="myInput" type="date" name="dob" id="dob" onclick="
                            var dateString=new Date().toLocaleDateString('en-ca');
                            this.setAttribute('max',dateString);" required>
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
                    <input type="submit" value="Submit" class="butt">             
                </form>
            </div>
        </div>

    </div>
    </div>
</div>
</body>
</html>