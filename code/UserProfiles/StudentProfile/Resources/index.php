<?php
$root_path = '../../../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
require $root_path . 'LibraryFiles/ValidationPhp/InputValidation.php';
session::profile_not_set($root_path);
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
  <script defer src="script.js"></script>
</head>

<body>
  <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
  <div class="main-container d-flex">
    <?php
    require '../navbar.php';
    student_navbar($root_path, false);
    ?>
    <section class="content-section m-auto px-5">
      <div class="container-fluid bg-white rounded mt-5 mb-5"></div>
      <!-- Saved Resources -->
      <div class="row">
        <div class="col-md-6">
          <div class="card intro-card w-75 text-bg-secondary m-auto mb-3">
            <div class="card-header">
              <h3 class="card-title" style="text-align:center">Saved Recources</h3>
              <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-primary btn-search mb-2 mt-2 me-2" type="submit">Search</button>
              </form>
            </div>
            <!-- <div class="card-body btn bx bxs-chevron-down w-100" type="button" data-bs-toggle="collapse" data-bs-target="#taskcollapse" aria-expanded="false" aria-controls="taskcollapse">
        </div> -->
            <div class="flex-container w-100">
              <div class="scroll w-100">
                <div class="card card-body my-2 me-1 btn btn-resource" style="text-align:left" id="scrollspyHeading1">First heading</div>
                <div class="card card-body my-2 me-1 btn btn-resource" style="text-align:left" id="scrollspyHeading2">Second heading</div>
                <div class="card card-body my-2 me-1 btn btn-resource" style="text-align:left" id="scrollspyHeading3">Third heading</div>
              </div>
            </div>
          </div>
        </div>
        <!-- Uploaded Resources -->
        <div class="col-md-6">
          <div class="card intro-card w-75 text-bg-secondary m-auto mb-3">
            <div class="card-header">
              <h3 class="card-title" style="text-align:center">Uploaded Recources</h3>
              <form class="d-flex" role="search">
                <button class="btn btn-primary btn-upload" for="inputGroupFile02">Upload</button>
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-primary btn-search mb-2 mt-2 me-2" type="submit">Search</button>
              </form>
            </div>
            <!-- <div class="card-body btn bx bxs-chevron-down w-100" type="button" data-bs-toggle="collapse" data-bs-target="#taskcollapse" aria-expanded="false" aria-controls="taskcollapse">
        </div> -->
            <div class="flex-container w-100">
              <div class="scroll w-100">
                <div class="card card-body my-2 me-1 btn btn-resource" style="text-align:left" id="scrollspyHeading1">First heading</div>
                <div class="card card-body my-2 me-1 btn btn-resource" style="text-align:left" id="scrollspyHeading2">Second heading</div>
                <div class="card card-body my-2 me-1 btn btn-resource" style="text-align:left" id="scrollspyHeading3">Third heading</div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>
  </div>

</body>

</html>