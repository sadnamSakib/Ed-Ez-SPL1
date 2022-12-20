<?php
$root_path = '../../';
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
    $profile_type = $tableName = $_SESSION['tableName'] === 'student' ? '../StudentProfile/' : '../TeacherProfile/';
    require $profile_type . 'navbar.php';
    $profile_type === '../StudentProfile/' ? student_navbar($root_path, false) : teacher_navbar($root_path, false);
    ?>
    <section class="content-section m-auto px-5">
      <div class="container-fluid bg-white rounded mt-5 mb-5"></div>
      <!-- Saved Resources -->
      <div class="row">
        <div class="col-md-6">
          <div class="card intro-card w-75 text-bg-secondary m-auto mb-3">
            <div class="card-header">
              <h3 class="card-title" style="text-align:center">Saved Resources</h3>
              <form class="d-flex" role="search">
                <input class="form-control search me-2" id="searchbar" type="search" onkeyup="search_resources()" placeholder="Search" aria-label="Search">
                <button class="btn btn-primary btn-search mb-2 mt-2 me-2" type="submit">Search</button>
              </form>
            </div>
            <!-- <div class="card-body btn bx bxs-chevron-down w-100" type="button" data-bs-toggle="collapse" data-bs-target="#taskcollapse" aria-expanded="false" aria-controls="taskcollapse">
        </div> -->
            <div class="flex-container w-100">
              <div class="scroll w-100">
                <div class="card card-body my-2 me-1 btn btn-resource saved-resources" style="text-align:left" id="scrollspyHeading1">First Heading</div>
                <div class="card card-body my-2 me-1 btn btn-resource saved-resources" style="text-align:left" id="scrollspyHeading2">Second heading</div>
                <div class="card card-body my-2 me-1 btn btn-resource saved-resources" style="text-align:left" id="scrollspyHeading3">Third heading</div>
              </div>
            </div>
          </div>
        </div>
        <!-- Uploaded Resources -->
        <div class="col-md-6">
          <div class="card intro-card w-75 text-bg-secondary m-auto mb-3">
            <div class="card-header">
              <h3 class="card-title" style="text-align:center">Uploaded Resources</h3>
              <form class="d-flex" role="search">
                <button type="button" class="btn btn-primary btn-upload" data-bs-toggle="modal" data-bs-target="#exampleModal">Upload</button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload File</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="mb-3">
                          <input type="text" id="title" name="title" class="form-control" placeholder="Title of the file" aria-label="Leave a comment">
                        </div>
                        <div class="input-group">
                          <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                        </div>
                      </div>
                      <div class="mx-4">
                        <label style="color: black">Set resource as: </label>
                        <div class="form-check form-check-inline mx-2">
                          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                          <label class="form-check-label" style="color: black" for="inlineRadio1">Public</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                          <label class="form-check-label" style="color: black" for="inlineRadio2">Private</label>
                        </div>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Upload</button>
                      </div>
                    </div>
                  </div>
                </div>
                <input class="form-control search me-2" id="searchbar-uploaded" type="search" onkeyup="search_uploaded_resources()" placeholder="Search" aria-label="Search">
                <button class="btn btn-primary btn-search mb-2 mt-2 me-2" type="submit">Search</button>
              </form>
            </div>
            <!-- <div class="card-body btn bx bxs-chevron-down w-100" type="button" data-bs-toggle="collapse" data-bs-target="#taskcollapse" aria-expanded="false" aria-controls="taskcollapse">
        </div> -->
            <div class="flex-container w-100">
              <div class="scroll w-100">
                <div class="card card-body my-2 me-1 btn btn-resource uploaded-resources" style="text-align:left" id="scrollspyHeading1">First heading</div>
                <div class="card card-body my-2 me-1 btn btn-resource uploaded-resources" style="text-align:left" id="scrollspyHeading2">Second heading</div>
                <div class="card card-body my-2 me-1 btn btn-resource uploaded-resources" style="text-align:left" id="scrollspyHeading3">Third heading</div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>
  </div>

</body>

</html>