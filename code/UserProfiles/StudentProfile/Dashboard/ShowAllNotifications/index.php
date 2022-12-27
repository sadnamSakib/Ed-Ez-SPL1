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
$resource_id = null;
$resource_id = $_SESSION['resource_id'];
$resources = $database->performQuery("SELECT * FROM resources");
foreach ($resources as $resource) {
    if (isset($_POST[$resource['resource_id']])) {
        $resource_id = $resource['resource_id'];
    }
}

$database->fetch_results($resource, "SELECT * FROM resources,resource_uploaded WHERE resources.resource_id = '$resource_id' AND resource_uploaded.resource_id = '$resource_id'");
$database->fetch_results($user, "SELECT * FROM users WHERE email='" . $resource['email'] . "'");

if (isset($_POST['upvote']) && $resource['email'] !== $email->get_email()) {
    $rows = $database->performQuery("SELECT * FROM resource_upvote WHERE resource_id='$resource_id' AND  email='" . $email->get_email() . "'");
    if ($rows->num_rows == 0) {
        $database->performQuery("INSERT INTO resource_upvote VALUES('$resource_id','" . $email->get_email() . "')");
    } else {
        $database->performQuery("DELETE FROM resource_upvote WHERE resource_id='$resource_id' AND email='" . $email->get_email() . "'");
    }
}

if (isset($_POST['downvote']) && $resource['email'] !== $email->get_email()) {
    $rows = $database->performQuery("SELECT * FROM resource_downvote WHERE resource_id='$resource_id' AND  email='" . $email->get_email() . "'");
    if ($rows->num_rows == 0) {
        $database->performQuery("INSERT INTO resource_downvote VALUES('$resource_id','" . $email->get_email() . "')");
    } else {
        $database->performQuery("DELETE FROM resource_downvote WHERE resource_id='$resource_id' AND email='" . $email->get_email() . "'");
    }
}

if (isset($_POST['save'])) {
    $rows = $database->performQuery("SELECT * FROM resource_saved WHERE resource_id='$resource_id' AND  email='" . $email->get_email() . "'");
    if ($rows->num_rows == 0) {
        $database->performQuery("INSERT INTO resource_saved VALUES('$resource_id','" . $email->get_email() . "')");
    } else {
        $database->performQuery("DELETE FROM resource_saved WHERE resource_id='$resource_id' AND email='" . $email->get_email() . "'");
    }
}

$_SESSION['resource_id'] = $resource_id;


$database->fetch_results($resource_upvote, "SELECT count(*) AS upvote FROM resource_upvote WHERE resource_id = '$resource_id'");
$database->fetch_results($resource_downvote, "SELECT count(*) AS downvote FROM resource_downvote WHERE resource_id = '$resource_id'");
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
                    <div class="card mb-2">
                        <div class="card-body">
                            <h5 class="card-title">New Task</h5>
                            <p class="card-text">A new task has been assigned as assignment-1 in CSE-4303</p>
                            <a href="#" class="btn btn-primary">View Task</a>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body">
                            <h5 class="card-title">New Resource</h5>
                            <p class="card-text">A new resource has been shared in CSE-4303</p>
                            <a href="#" class="btn btn-primary">View resource</a>
                        </div>
                    </div>
                </div>

        </section>
    </div>

</body>

</html>