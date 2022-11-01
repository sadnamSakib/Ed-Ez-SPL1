<?php 
$root_path='../../';
require $root_path.'LibraryFiles/DatabaseConnection/config.php';
require $root_path.'LibraryFiles/SessionStore/session.php';
require $root_path.'LibraryFiles/ValidationPhp/InputValidation.php';

session::stay_in_session();

$error=$_SESSION['error'];


if (isset($_POST['submit'])) {
    $validate=new InputValidation();
	$name = $validate->post_sanitise_regular_input('name');
    $email=new EmailValidator($validate->post_sanitise_email('email'));
    $password=new PasswordValidator($validate->post_sanitise_password('password'));
    $dob=$_REQUEST['dob'];
    $institutions = $validate->post_sanitise_regular_input('institution');
    $button_radio=$validate->post_sanitise_regular_input('btnradio');
    $confirm= $validate->post_sanitise_password('cfpassword');
    $error=$_REQUEST['error'];
    $exists = "SELECT * FROM users WHERE email = '".$email->get_email()."'";
    $result=$database->performQuery($exists);
    if ($result->num_rows > 0) {
        $email='';
        $password='';
        $_REQUEST['password']='';
        $error="An account already exists with this email";
        
    }
    else if(!$email->email_validate() || !$password->password_match($confirm) || !$password->constraint_check() || !is_null($validate->Date_Validation($dob))){
        $email->email_validate();
        $password->constraint_check();
        $password->password_match($confirm);
    }
    else{
        $insertusers = "INSERT INTO users(email,name,password,institution,dob) VALUES ('".$email->get_email()."', '$name','".$password->get_password()."','$institutions','$dob')";
        $insertTable="INSERT INTO $button_radio(email) VALUES('".$email->get_email()."')";
        $_SESSION['email']=$email->get_original_email();
        unset($_POST['password']);
        unset($_POST['email']);	
        unset($_POST['cfpassword']);
        unset($institutions);
        unset($button_radio);
        unset($confirm);
        unset($name);
        unset($dob);
        unset($email);
        unset($password);
        unset($validate);
        $database->performQuery($insertusers);
        $database->performQuery($insertTable);
        $database->fetch_results($row,$exists);
        $_SESSION['name'] = $row['name'];
        unset($_SESSION['error']);
        header('Location: ConfirmEmail/index.php');
		
    }   
}
?>

<!DOCTYPE HTML>
<html>
<head>
<title>
    SignUp
</title>
<link rel="icon" href="<?php echo $root_path; ?>title_icon.jpg" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
<script defer src="script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://kit.fontawesome.com/d0f239b9af.js" crossorigin="anonymous"></script>
</head>
<body>
<script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
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
                    <div class="form-group" id="error" style="color:red;display:<?php
                        if(is_null($error)){
                            echo "none";
                        }
                        else{
                            echo "block";
                        }
                    ?>">
                            <?php echo $error;unset($error)?>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-user"> </i>
                        <input class="myInput" type="text" placeholder="Full Name" name="name" id="name" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group" id="error" style="color:red;display:<?php
                        if(is_null($email->error)){
                            echo "none";
                        }
                        else{
                            echo "block";
                        }
                    ?>">
                            <?php echo $email->error;?>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-envelope"> </i>
                        <input class="myInput" placeholder="Email" name="email" type="text" id="email" required value="<?php echo $_REQUEST['email']; ?>">
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                    <i class="fas fa-graduation-cap"></i>
                    <select id="institution" name="institution" class="myInput" placeholder="Select University" required value="<?php echo $institutions; ?>">
                                    <option value="">Select University...</option>
                                    <option value="Ahsanullah University of Science and Technology">Ahsanullah University of Science and Technology, Dhaka</option>
                                    <option value="American International University-Bangladesh">American International University-Bangladesh, Dhaka</option>
                                    <option value="Anwer Khan Modern University">Anwer Khan Modern University, Dhaka</option>
                                    <option value="ASA University Bangladesh">ASA University Bangladesh, Dhaka</option>
                                    <option value="Asian University for Women">Asian University for Women, Chittagong</option>
                                    <option value="Asian University of Bangladesh">Asian University of Bangladesh, Dhaka</option>
                                    <option value="Atish Dipankar University of Science and Technology">Atish Dipankar University of Science and Technology, Uttara</option>
                                    <option value="Bandarban University">Bandarban University, Bandarban</option>
                                    <option value="Bangabandhu Sheikh Mujib Medical University">Bangabandhu Sheikh Mujib Medical University, Dhaka</option>
                                    <option value="Bangabandhu Sheikh Mujibur Rahman Agricultural University">Bangabandhu Sheikh Mujibur Rahman Agricultural University, Gazipur</option>
                                    <option value="Bangabandhu Sheikh Mujibur Rahman Digital University">Bangabandhu Sheikh Mujibur Rahman Digital University, Gazipur</option>
                                    <option value="Bangabandhu Sheikh Mujibur Rahman Maritime University">Bangabandhu Sheikh Mujibur Rahman Maritime University, Dhaka</option>
                                    <option value="Bangabandhu Sheikh Mujibur Rahman Science and Technology University">Bangabandhu Sheikh Mujibur Rahman Science and Technology University, Gopalganj</option>
                                    <option value="Bangamata Sheikh Fojilatunnesa Mujib Science & Technology University">Bangamata Sheikh Fojilatunnesa Mujib Science & Technology University, Jamalpur</option>
                                    <option value="Bangladesh Agricultural University">Bangladesh Agricultural University, Mymensingh</option>
                                    <option value="Bangladesh Army International University of Science and Technology">Bangladesh Army International University of Science and Technology, Cumilla</option>
                                    <option value="Bangladesh Islami University">Bangladesh Islami University, Dhaka</option>
                                    <option value="Bangladesh Medical College">Bangladesh Medical College, Dhaka</option>
                                    <option value="Bangladesh Open University">Bangladesh Open University, Dhaka Division</option>
                                    <option value="Bangladesh University">Bangladesh University, Dhaka</option>
                                    <option value="Bangladesh University of Business and Technology">Bangladesh University of Business and Technology, Dhaka</option>
                                    <option value="Bangladesh University of Engineering and Technology">Bangladesh University of Engineering and Technology, Dhaka</option>
                                    <option value="Bangladesh University of Health Sciences">Bangladesh University of Health Sciences, Dhaka</option>
                                    <option value="Bangladesh University of Professionals">Bangladesh University of Professionals, Dhaka</option>
                                    <option value="Bangladesh University of Textiles">Bangladesh University of Textiles, Dhaka</option>
                                    <option value="Barisal University">Barisal University, Barishal</option>
                                    <option value="Begum Rokeya University">Begum Rokeya University, Rangpur</option>
                                    <option value="BGC Trust University Bangladesh">BGC Trust University Bangladesh, Chittagong</option>
                                    <option value="BGMEA University of Fashion & Technology">BGMEA University of Fashion & Technology, Dhaka</option>
                                    <option value="BRAC University">BRAC University, Dhaka</option>
                                    <option value="Britannia University">Britannia University, Comilla</option>
                                    <option value="Canadian University of Bangladesh">Canadian University of Bangladesh, Dhaka</option>
                                    <option value="CCN University of Science & Technology">CCN University of Science & Technology, Comilla</option>
                                    <option value="Central University of Science and Technology">Central University of Science and Technology, Dhaka</option>
                                    <option value="Central Women's University">Central Women's University, Dhaka</option>
                                    <option value="Chittagong Independent University ">Chittagong Independent University , Chittagong</option>
                                    <option value="Chittagong Medical College">Chittagong Medical College, Chittagong</option>
                                    <option value="Chittagong Medical University">Chittagong Medical University, Chittagong</option>
                                    <option value="Chittagong University of Engineering and Technology">Chittagong University of Engineering and Technology, Chittagong</option>
                                    <option value="Chittagong Veterinary and Animal Sciences University">Chittagong Veterinary and Animal Sciences University, Chittagong</option>
                                    <option value="City University">City University, Dhaka</option>
                                    <option value="Comilla University">Comilla University, Comilla</option>
                                    <option value="Cox's Bazar International University">Cox's Bazar International University, Cox's Bazar</option>
                                    <option value="Daffodil International University">Daffodil International University, Dhaka</option>
                                    <option value="Darul Ihsan University">Darul Ihsan University, Dhaka</option>
                                    <option value="Dhaka City College">Dhaka City College, Dhaka</option>
                                    <option value="Dhaka International University">Dhaka International University, Dhaka</option>
                                    <option value="Dhaka Medical College">Dhaka Medical College, Dhaka</option>
                                    <option value="Dhaka National Medical College">Dhaka National Medical College, Dhaka</option>
                                    <option value="Dhaka University of Engineering & Technology">Dhaka University of Engineering & Technology, Gazipur, Gazipur</option>
                                    <option value="East Delta University">East Delta University, Chittagong</option>
                                    <option value="East West University">East West University, Dhaka</option>
                                    <option value="Eastern University">Eastern University, Dhaka</option>
                                    <option value="European University of Bangladesh">European University of Bangladesh, Dhaka</option>
                                    <option value="Exim Bank Agricultural University Bangladesh">Exim Bank Agricultural University Bangladesh, Chapainawabganj</option>
                                    <option value="Fareast International University">Fareast International University, Dhaka</option>
                                    <option value="Feni University">Feni University, Feni</option>
                                    <option value="First Capital University of Bangladesh">First Capital University of Bangladesh, Chuadanga</option>
                                    <option value="German University Bangladesh">German University Bangladesh, Gazipur</option>
                                    <option value="Global University Bangladesh">Global University Bangladesh, Barisal</option>
                                    <option value="Gono University">Gono University, Savar</option>
                                    <option value="Green University of Bangladesh">Green University of Bangladesh, Dhaka</option>
                                    <option value="Habiganj Agricultural University">Habiganj Agricultural University, Habiganj</option>
                                    <option value="Hajee Mohammad Danesh Science & Technology University">Hajee Mohammad Danesh Science & Technology University, Dinajpur</option>
                                    <option value="Hamdard University Bangladesh">Hamdard University Bangladesh, Munshigonj</option>
                                    <option value="IBAIS University">IBAIS University, Dhaka</option>
                                    <option value="Ibrahim Medical College">Ibrahim Medical College, Dhaka</option>
                                    <option value="Independent University Bangladesh">Independent University Bangladesh, Dhaka</option>
                                    <option value="International Islamic University Chittagong">International Islamic University Chittagong, Chittagong</option>
                                    <option value="International Standard University">International Standard University, Dhaka</option>
                                    <option value="International University of Business Agriculture and Technology">International University of Business Agriculture and Technology, Dhaka</option>
                                    <option value="Ishakha International University">Ishakha International University, Kishoreganj</option>
                                    <option value="Islamic Arabic University">Islamic Arabic University, Dhaka</option>
                                    <option value="Islamic University">Islamic University, Kushtia</option>
                                    <option value="Islamic University of Technology">Islamic University of Technology, Gazipur</option>
                                    <option value="Jagannath University">Jagannath University, Dhaka</option>
                                    <option value="Jahangirnagar University">Jahangirnagar University, Savar</option>
                                    <option value="Jahurul Islam Medical College">Jahurul Islam Medical College, Kishoregonj</option>
                                    <option value="Jatiya Kabi Kazi Nazrul Islam University">Jatiya Kabi Kazi Nazrul Islam University, Mymensingh</option>
                                    <option value="Jessore University of Science and Technology">Jessore University of Science and Technology, Jessore</option>
                                    <option value="Kabi Nazrul Government College">Kabi Nazrul Government College, Dhaka</option>
                                    <option value="Khulna Agricultural University">Khulna Agricultural University, Khulna</option>
                                    <option value="Khulna City Medical College">Khulna City Medical College, Khulna</option>
                                    <option value="Khulna Medical College">Khulna Medical College, Khulna</option>
                                    <option value="Khulna University">Khulna University, Khulna</option>
                                    <option value="Khulna University of Engineering and Technology">Khulna University of Engineering and Technology, Khulna</option>
                                    <option value="Khwaja Yunus Ali University">Khwaja Yunus Ali University, Rajshahi</option>
                                    <option value="Kumudini Women's Medical College">Kumudini Women's Medical College, Tangail</option>
                                    <option value="Leading University">Leading University, Sylhet</option>
                                    <option value="Manarat International University">Manarat International University, Dhaka</option>
                                    <option value="Mawlana Bhashani Science and Technology University">Mawlana Bhashani Science and Technology University, Tangail</option>
                                    <option value="Metropolitan University">Metropolitan University, Sylhet</option>
                                    <option value="Military Institute of Science & Technology">Military Institute of Science & Technology, Dhaka</option>
                                    <option value="Millennium University">Millennium University, Dhaka</option>
                                    <option value="Mymensingh Medical College">Mymensingh Medical College, Mymensingh</option>
                                    <option value="National University">National University, Gazipur</option>
                                    <option value="Noakhali Science and Technology University">Noakhali Science and Technology University, Noakhali</option>
                                    <option value="North Bengal International University">North Bengal International University, Rajshahi</option>
                                    <option value="North East Medical College">North East Medical College, Sylhet</option>
                                    <option value="North East University Bangladesh">North East University Bangladesh, Sylhet</option>
                                    <option value="North South University">North South University, Dhaka</option>
                                    <option value="North Western University">North Western University, Khulna</option>
                                    <option value="Northern University Bangladesh">Northern University Bangladesh, Dhaka</option>
                                    <option value="Notre Dame University Bangladesh">Notre Dame University Bangladesh, Dhaka</option>
                                    <option value="NPI University of Bangladesh">NPI University of Bangladesh, Manikganj</option>
                                    <option value="Pabna Textile Engineering College">Pabna Textile Engineering College, Pabna</option>
                                    <option value="Pabna University of Science and Technology">Pabna University of Science and Technology, Pabna</option>
                                    <option value="Patuakhali University of Science and Technology">Patuakhali University of Science and Technology, Patuakhali</option>
                                    <option value="Port City International University">Port City International University, Chittagong</option>
                                    <option value="Premier University">Premier University, Chittagong</option>
                                    <option value="Presidency University">Presidency University, Dhaka</option>
                                    <option value="Prime University">Prime University, Dhaka</option>
                                    <option value="Primeasia University">Primeasia University, Dhaka</option>
                                    <option value="Pundra University of Science and Technology">Pundra University of Science and Technology, Bogra</option>
                                    <option value="Queens University">Queens University, Dhaka</option>
                                    <option value="Rabindra Maitree University">Rabindra Maitree University, Kushtia</option>
                                    <option value="Rabindra University">Rabindra University, Sirajganj</option>
                                    <option value="Rajshahi Medical University">Rajshahi Medical University, Rajshahi</option>
                                    <option value="Rajshahi Science & Technology University">Rajshahi Science & Technology University, Natore</option>
                                    <option value="Rajshahi University">Rajshahi University, Rajshahi</option>
                                    <option value="Rajshahi University of Engineering & Technology">Rajshahi University of Engineering & Technology, Rajshahi</option>
                                    <option value="Ranada Prasad Shaha University">Ranada Prasad Shaha University, Naryanganj</option>
                                    <option value="Rangamati Science and Technology University">Rangamati Science and Technology University, Rangamati</option>
                                    <option value="Rangpur Medical College">Rangpur Medical College, Rangpur</option>
                                    <option value="Royal University of Dhaka">Royal University of Dhaka, Dhaka</option>
                                    <option value="Shah Makhdum College">Shah Makhdum College, Rajshahi</option>
                                    <option value="Shaheed Suhrawardy Medical College">Shaheed Suhrawardy Medical College, Dhaka</option>
                                    <option value="Shaheed Ziaur Rahman Medical College">Shaheed Ziaur Rahman Medical College, Bogra</option>
                                    <option value="Shahjalal University of Science and Technology">Shahjalal University of Science and Technology, Sylhet</option>
                                    <option value="Shanto Mariam University of Creative Technology">Shanto Mariam University of Creative Technology, Dhaka</option>
                                    <option value="Sheikh Fazilatunnesa Mujib University">Sheikh Fazilatunnesa Mujib University, Jamalpur</option>
                                    <option value="Sheikh Hasina University">Sheikh Hasina University, Netrokona</option>
                                    <option value="Sher-e-Bangla Agricultural University">Sher-e-Bangla Agricultural University, Dhaka</option>
                                    <option value="Sir Salimullah Medical College">Sir Salimullah Medical College, Dhaka</option>
                                    <option value="Sonargaon University">Sonargaon University, Dhaka</option>
                                    <option value="Southeast University">Southeast University, Dhaka</option>
                                    <option value="Southern University of Bangladesh">Southern University of Bangladesh, Chittagong</option>
                                    <option value="Stamford University Bangladesh">Stamford University Bangladesh, Dhaka</option>
                                    <option value="State University of Bangladesh">State University of Bangladesh, Dhaka</option>
                                    <option value="Sylhet Agricultural University">Sylhet Agricultural University, Sylhet</option>
                                    <option value="Sylhet Engineering College">Sylhet Engineering College, Sylhet</option>
                                    <option value="Sylhet International University">Sylhet International University, Sylhet</option>
                                    <option value="Sylhet MAG Osmani Medical College">Sylhet MAG Osmani Medical College, Sylhet</option>
                                    <option value="Tagore University of Creative Arts">Tagore University of Creative Arts, Dhaka</option>
                                    <option value="The International University of Scholars">The International University of Scholars, Dhaka</option>
                                    <option value="The People's University of Bangladesh">The People's University of Bangladesh, Dhaka</option>
                                    <option value="The University of Asia Pacific">The University of Asia Pacific, Dhaka</option>
                                    <option value="Times University">Times University, Faridpur</option>
                                    <option value="TMSS Medical College">TMSS Medical College, Bogura</option>
                                    <option value="United International University">United International University, Dhaka</option>
                                    <option value="University of Chittagong">University of Chittagong, Chittagong</option>
                                    <option value="University of Development Alternative">University of Development Alternative, Dhaka</option>
                                    <option value="University of Dhaka">University of Dhaka, Dhaka</option>
                                    <option value="University of Information Technology & Sciences">University of Information Technology & Sciences, Dhaka</option>
                                    <option value="University of Liberal Arts Bangladesh">University of Liberal Arts Bangladesh, Dhaka</option>
                                    <option value="University of Science & Technology Chittagong">University of Science & Technology Chittagong, Chittagong</option>
                                    <option value="University of South Asia">University of South Asia, Dhaka</option>
                                    <option value="Uttara University">Uttara University, Dhaka</option>
                                    <option value="Varendra University">Varendra University, Rajshahi</option>
                                    <option value="Victoria University of Bangladesh">Victoria University of Bangladesh, Dhaka</option>
                                    <option value="World University of Bangladesh">World University of Bangladesh, Dhaka</option>
                                    <option value="Z H Sikder University of Science & Technology">Z H Sikder University of Science & Technology, Shariatpur</option>
                                </select>
                                <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div id="passwordError" class="form-group" style="color:red;display:<?php
                        if(is_null($password->password_error)){
                            echo "none";
                        }
                        else{
                            echo "block";
                        }
                    ?>">
                            <?php echo $password->password_error;?>

                        </div>
                    <div class="form-group">
                        <i class="fas fa-lock"> </i>
                        
                        <input class="myInput" placeholder="Password" type="password" id="password" name="password" required value="<?php echo $_POST['password']; ?>">
                        <i class="fas fa-eye-slash" id="togglePassword"></i>
                    </div>
                    <div id="confirmPasswordError" class="form-group" style="color:red;display:<?php
                        if(is_null($password->confirm_error)){
                            echo "none";
                        }
                        else{
                            echo "block";
                        }
                    ?>">
                            <?php echo $password->confirm_error;?>

                        </div>
                    <div class="form-group">
                        <i class="fas fa-lock"> </i>
                        <input class="myInput" placeholder="Confirm Password" type="password" id="cfpassword" name="cfpassword" required value="<?php echo $_POST['cfpassword']; ?>">
                        <i class="fas fa-eye-slash" id="togglePassword2"></i>
                    </div>
                    <div id="dateError" class="form-group" style="color:red;display:<?php
                        if(isset($validate) && is_null($validate->Date_Validation($dob))){
                            echo "none";
                        }
                        else if(isset($validate)){
                            echo "block";
                        }
                        else{
                            echo "none";
                        }
                    ?>">
                            <?php 
                            if(isset($validate)){
                                echo $validate->Date_Validation($dob);
                            }
                            ?>

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
                                I read and agree to <a href="TermsAndConditions.html" target="_blank">Terms & Conditions<a>
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
