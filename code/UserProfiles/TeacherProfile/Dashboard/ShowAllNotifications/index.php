<?php
$root_path = '../../../../';
$profile_path = '../../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
require $root_path . 'LibraryFiles/ValidationPhp/InputValidation.php';
require $root_path . 'LibraryFiles/Utility/Utility.php';
foreach (glob($root_path . 'LibraryFiles/ClassroomManager/*.php') as $filename) {
    require $filename;
}
session::profile_not_set($root_path);
session::profile_not_set($root_path);
$validate = new InputValidation();
$email = new EmailValidator($_SESSION['email']);
$notifications = $database->performQuery("SELECT * FROM notifications,classroom,teacher_classroom,notification_user WHERE notifications.notification_id=notification_user.notification_id AND notification_user.email='".$email->get_email()."'  AND notifications.class_code=classroom.class_code  AND teacher_classroom.email='".$email->get_email()."' AND classroom.class_code=teacher_classroom.class_code order by notification_datetime desc");
foreach($notifications as $notification){
    if(isset($_POST['notification'.$notification['notification_id']])){
      $_SESSION['class_code']=$notification['class_code'];
      $_SESSION['email']=$email->get_original_email();
      header('Location: ../../ClassroomSystem/TeacherClassroom/index.php');
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Notifications</title>
    <link rel="icon" href="<?php echo $root_path; ?>title_icon.jpg" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="<?php echo $root_path; ?>boxicons-2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <script defer src="script.js"></script>
</head>

<body>
    <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
    <div class="main-container d-flex">
        <?php
        require $profile_path . 'navbar.php';
        teacher_navbar($root_path);
        ?>
        <section class="content-section m-auto px-5 py-3">
            <div class="card intro-card w-75 text-bg-secondary m-auto mb-3">
                <div class="card-header">
                    <h5 class="card-title" style="text-align:center">All Notifications</h5>
                </div>
                <div class="card-body text-success">
                <form action="" method="POST">
                <?php 
                    foreach ($notifications as $notification) {
                    ?>
                    <div class="card mb-2">
                        <div class="card-body d-flex justify-content-around">
                            <div class="me-4">
                            <h5 class="card-title" style="color:black;">New <?php echo $notification['notification_type'] ?></h5>
                            <p class="card-text" style="color:black;"><?php echo $notification['message'] ?></p>
                            <p class="card-text" style="color:black;">Date: <?php echo $notification['notification_datetime']?></p>
                            <i class='bx bx-sm bx-x '></i>
                            <button type="submit" class="btn btn-primary" name="notification<?php echo $notification['notification_id'] ?>">View <?php echo $notification['notification_type']?></button>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    </form>
                </div>

        </section>
    </div>

</body>

</html>