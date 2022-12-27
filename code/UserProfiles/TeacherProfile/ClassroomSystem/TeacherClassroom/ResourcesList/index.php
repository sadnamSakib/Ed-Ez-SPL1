<?php
$root_path = '../../../../../';
$profile_path = '../../../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
require $root_path . 'LibraryFiles/ValidationPhp/InputValidation.php';
require $root_path . 'LibraryFiles/Utility/Utility.php';
foreach (glob($root_path . 'LibraryFiles/ClassroomManager/*.php') as $filename) {
    require $filename;
}
session::profile_not_set($root_path);
$email = new EmailValidator($_SESSION['email']);
$classCode = $_SESSION['class_code'];
$database->fetch_results($record, "SELECT * FROM classroom WHERE class_code='$classCode'");
$resources = $database->performQuery("SELECT * FROM resources,resources_classroom WHERE resources.resource_id=resources_classroom.resource_id AND resources_classroom.class_code='$classCode'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Resources</title>
    <link rel="icon" href="<?php echo $root_path; ?>title_icon.jpg" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="<?php echo $root_path; ?>boxicons-2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
    <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
    <div class="main-container d-flex">
        <?php
        $profile_type = '../../../';
        require $profile_type . 'navbar.php';
        teacher_navbar($root_path, false);
        ?>
        <section class="content-section m-auto px-5">
            <div class="container-fluid bg-white rounded mt-5 mb-5">
                <div class="card intro-card w-75 text-bg-secondary m-auto mb-3">
                    <div class="card-header">
                        <h3 class="card-title" style="text-align:center"><?php echo $record['course_code'] . ': ' . $record['classroom_name'] ?></h3>
                        <form class="d-flex" role="search">
                            <input class="form-control search me-2" id="searchbar" type="search" onkeyup="search_resources()" placeholder="Search" aria-label="Search">
                            <button class="btn btn-primary btn-search mb-2 mt-2 me-2" type="submit">Search</button>
                        </form>
                    </div>
                    <div class="flex-container w-100">
                        <div class="scroll w-100">
                            <form name="resource_form" id="resource_form" action="<?php echo $root_path ?>/UserProfiles/Resources/ViewResources/index.php" method="POST">
                                <?php
                                foreach ($resources as $dummy_resource) {
                                ?>
                                    <div class="card card-body my-2 me-2 ms-2 btn btn-resource saved" style="text-align:left" id="scrollspyHeading1">
                                        <button type="submit" name="<?php echo $dummy_resource['resource_id'] ?>" style="all:unset">
                                            <div class="<?php echo $dummy_resource['resource_visibility']; ?>-box mb-1"><?php echo $dummy_resource['resource_visibility']; ?></div>
                                            <h5 class="saved-resources"><?php echo $dummy_resource['title']; ?></h5>
                                            <p style="font-size: 12px;">Resource Tag: <?php echo $dummy_resource['resource_tag']; ?></p>
                                            <p style="font-size: 12px;"><?php echo $dummy_resource['resource_description']; ?></p>
                                        </button>
                                    </div>
                                <?php
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    </div>
    <!-- Saved Resources -->

    </section>
    </div>

</body>
<script defer src="script.js"></script>

</html>