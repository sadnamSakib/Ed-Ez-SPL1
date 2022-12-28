<?php
$root_path = '../../../';
$profile_path = '../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
require $root_path . 'LibraryFiles/ValidationPhp/InputValidation.php';
session::profile_not_set($root_path);
$email = new EmailValidator($_SESSION['email']);
$database->fetch_results($verified, "SELECT Verified FROM users WHERE email='" . $email->get_email() . "'");
if ($verified['Verified'] !== '1') {
  header('Location: ' . $root_path . 'LoginAuth/SignUp/ConfirmEmail/index.php');
}

$error = null;
$errorColor = "red";

$classCode = $_SESSION['class_code'];
$classrooms = $database->performQuery("SELECT * FROM classroom,student_classroom where classroom.class_code=student_classroom.class_code and student_classroom.email='" . $email->get_email() . "' and active='1';");

foreach ($classrooms as $i) {
  $total_credit += (is_null($i['course_credit']) ? 0 : $i['course_credit']);
  $classCode = $i['class_code'];
  $database->fetch_results($attendance, "SELECT nvl(count(*),0)StudentAttendance FROM classroom_session,student_classroom_session WHERE classroom_session.session=student_classroom_session.session AND classroom_session.class_code='$classCode' AND student_classroom_session.email='" . $email->get_email() . "'");
  $database->fetch_results($totalAttendance, "SELECT nvl(count(*),0)TotalSessions FROM classroom_session WHERE classroom_session.class_code='$classCode'");
  $database->fetch_results($taskInfo, "SELECT (sum(nvl(marks_obtained,0))/sum(nvl(marks,1)))*90 AS percentage FROM task,task_classroom,student_task_submission WHERE task.task_id=task_classroom.task_id AND task_classroom.class_code='" . $classCode . "' AND student_task_submission.task_id=task.task_id AND task.active='1'");
  if (is_null($taskInfo)) {
    $percentage = 0;
  } else {
    $percentage = $taskInfo['percentage'];
  }
  if ($totalAttendance['TotalSessions'] == 0) {
    $percentage = $taskInfo['percentage'] + 10;
  } else {
    $percentage = $taskInfo['percentage'] + ($attendance['StudentAttendance'] * 10) / $totalAttendance['TotalSessions'];
  }
  $total += (($percentage * $i['course_credit']) / 100);
}
$result = ($total * 100) / $total_credit;



$database->fetch_results($row, "SELECT * FROM users INNER JOIN student ON users.email=student.email WHERE users.email = '" . $email->get_email() . "'");

$var = $row['profile_picture'];
if ($var != "") {
  $src = "data:image/jpg;charset=utf8;base64," . base64_encode($var);
} else {
  $src = "profile-picture.png";
}
$name = $row['name'];
$mobileNumber = $row['mobileNumber'];
$instituion = $row['institution'];
$department = $row['department'];
$semester = $row['semester'];
$country = $row['country'];
$studentID = $row['studentID'];
if ($semester == -1) {
  $semester = '';
}
$notifications = $database->performQuery("SELECT * FROM notifications,classroom,student_classroom,notification_user WHERE notifications.notification_id=notification_user.notification_id AND notification_user.email='".$email->get_email()."'  AND notifications.class_code=classroom.class_code AND classroom.class_code=student_classroom.class_code AND student_classroom.email='".$email->get_email()."' AND notifications.notification_type!='submit' order by notification_datetime desc LIMIT 3");
foreach($notifications as $notification){
  if(isset($_POST['notification'.$notification['notification_id']])){
    $_SESSION['class_code']=$notification['class_code'];
    $_SESSION['email']=$email->get_original_email();
    header('Location: ../ClassroomSystem/StudentClassroom/index.php');
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="icon" href="<?php echo $root_path; ?>title_icon.jpg" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="main.min.css" />
  <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
  <link href="<?php echo $root_path; ?>boxicons-2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <script defer src="script.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'listWeek',
        themeSystem: 'bootstrap5',
        header: {
          left: '',
          center: '',
          right: ''
        },

        events: [
          <?php
          $recordsTask = $database->performQuery("select * from event,task,student_classroom,task_classroom where event.event_id=task.event_id and task_classroom.task_id=task.task_id and student_classroom.email='" . $email->get_email() . "' and student_classroom.class_code=task_classroom.class_code;");
          $first = false;
          foreach ($recordsTask as $i) {
            if (!$first) {
              $first = true;
            } else {
              echo ',';
            }
          ?> {

              title: '<?php echo $i['task_title']; ?>',
              start: '<?php echo $i['event_start_datetime']; ?>'

            }
          <?php
          }
          ?>
        ]
      });
      calendar.render();
    });
  </script>
</head>

<body>
  <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
  <script src="main.min.js"></script>
  <div class="main-container d-flex">
    <?php
    require $profile_path . 'navbar.php';
    student_navbar($root_path);
    ?>
    <section class="content-section row justify-content-center my-5 mx-5">

      <div class="col-md-6 mx-5">
        <div class="row mb-1">
          <div class="greetingsbox">
            <h2 class="typewrite" data-period="500" data-type='["Welcome back , <?php echo $name ?>" , "How was your day?" , "Have you submitted all your tasks?" ]'>
            </h2>
            <span class="wrap"></span>

          </div>
        </div>
        <div class=" small-profile row justify-content-center mb-3 ">
          <div class="profilebox col-md-4 w-100">
            <div class="row my-auto">
              <div class="col my-auto">
                <img src="<?php echo $src ?>" style="border-radius:75%; height:3rem ; width:3rem;">
              </div>
              <div class="col-5 my-auto">
                <p class="my-auto align-self-start" style=" font-weight:bold; color:white;font-size:15px"><?php echo $name ?></p>
                <p class="my-auto align-self-start" style=" color:white">Student</p>
              </div>
              <div class="col my-auto">
                <i class="bx bxs-bell notification align-self-end ms-5"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-2">
          <h4>My Classrooms</h4>
        </div>
        <div class="row">
          <div class="box classroomcontainer">
            <?php
            foreach ($classrooms as $i) {
              $classCode = $i['class_code'];
              $classTitle = $i['classroom_name'];
              $database->fetch_results($student_records, "SELECT * FROM users,student_classroom,classroom WHERE users.email=student_classroom.email and classroom.class_code='$classCode'");
            ?>
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $classTitle ?></h5>
                  <h6 class="card-subtitle mb-2 text-muted"><?php echo $student_records['name'] ?></h6>
                </div>
              </div>
            <?php } ?>


          </div>
        </div>

        <div class="row mb-2 mt-5">
          <h4>My Resources</h4>
        </div>
        <div class="row">
          <div class="box classroomcontainer">



            <?php
            $resource = $database->performQuery("SELECT * FROM resources,resource_saved WHERE resources.resource_id=resource_saved.resource_id;");

            foreach ($resource as $dummy_resource) {
            ?>
              <div class="card">
                <div class="card-body">
                  <?php $visibility = $dummy_resource['resource_visibility']; ?>
                  <div class="<?php echo $visibility ?>-box mb-1"><?php echo $visibility ?></div>
                  <h5 class="card-title"><?php echo $dummy_resource['title']; ?></h5>
                  <h6 class="card-subtitle mb-2 text-muted"><?php echo $dummy_resource['resource_description']; ?></h6>
                </div>
              </div>

            <?php
            }
            ?>

          </div>
        </div>
      </div>

      <div class="col-md-4 mx-5">

        <div class="big-profile row justify-content-center mb-3">
          <div class="profilebox col-md-4 w-100">
            <div class="row my-auto">
              <div class="col my-auto mx-2">
                <img src="<?php echo $src ?>" style="border-radius:75%; height:3rem ; width:3rem;">
              </div>
              <div class="col-6 my-auto">
                <p class="my-auto align-self-start" style=" font-weight:bold; color:white;font-size:20px"><?php echo $name ?></p>
                <p class="my-auto align-self-start" style=" color:white">Student</p>
              </div>
              <div class="col-2 my-auto">

                <!-- <div class="dropdown-center">
                  <button class="btn btn-xs dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true">
                  <i class="bx bxs-bell notification"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Action two</a></li>
                    <li><a class="dropdown-item" href="#">Action three</a></li>
                  </ul>
                </div> -->
                <div class="dropdown">
                  <i class="bx bxs-bell notification dropbtn position-relative" onclick="myFunction()">
                    <span class="position-absolute top-0 start-100 translate-middle badge badge-sm rounded-pill bg-danger ">
                      <?php
                      $database->fetch_results($result, "SELECT count(*) AS notification_count FROM notifications,classroom,student_classroom,notification_user WHERE notifications.notification_id=notification_user.notification_id AND notification_user.email='".$email->get_email()."'  AND notifications.class_code=classroom.class_code AND classroom.class_code=student_classroom.class_code AND student_classroom.email='".$email->get_email()."' AND notifications.notification_type!='submit' order by notification_datetime desc");
                      if ($result['notification_count'] > 3) {
                        echo "3+";
                      } else {
                        echo $result['notification_count'];
                      }
                      ?>
                      <span class="visually-hidden">unread messages</span>
                    </span></i>
                  <div id="myDropdown" class="dropdown-content">
                    <form action="" method="POST">
                    <?php
                    foreach ($notifications as $notification) {
                    ?>
                      <a><button type="submit" name="notification<?php echo $notification['notification_id'] ?>" style="all:unset"><?php echo $notification['message']; ?></button></a>
                    <?php
                    }
                    ?>
                    </form>
                    <a title="Notification" class="amarMonChaise">
                      <div class="d-flex justify-content-around">
                        <button type="button" class="btn btn-primary btn-notification" onclick="window.location.href='ShowAllNotifications/index.php'">Show All Notification</button>
                        <button type="button" class="btn btn-primary btn-notification">Clear</button>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row gradebox mt-5 my-2">
          <div class="row mt-3"><canvas id="chartProgress"></canvas></div>
          <div class="row justify-content-center  mt-4" style="text-align:center; ">
            <h5>Grade percentage</h5>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="box w-100 mt-3">
            <div id="calendar"></div>
          </div>
        </div>

      </div>
    </section>

  </div>


</body>
<script>
  <?php
    $result = ($total * 100) / $total_credit;
    ?>
  var myChartCircle = new Chart('chartProgress', {
  type: 'doughnut',
  data: {
    datasets: [{
      label: 'Total percentage',
      percent:<?php echo $result ?>,
      backgroundColor: ['#2f6d8b']
    }]
  },
  plugins: [{
      beforeInit: (chart) => {
        const dataset = chart.data.datasets[0];
        chart.data.labels = [dataset.label];
        dataset.data = [dataset.percent, 100 - dataset.percent];
      }
    },
    {
      beforeDraw: (chart) => {
        var width = chart.chart.width,
          height = chart.chart.height,
          ctx = chart.chart.ctx;
        ctx.restore();
        var fontSize = (height / 90).toFixed(2);
        ctx.font = fontSize + "em sans-serif";
        ctx.fillStyle = "#9b9b9b";
        ctx.textBaseline = "middle";



        var text = chart.data.datasets[0].percent.toFixed(2);
        textX = Math.round((width - ctx.measureText(text).width) / 2.1),
          textY = height / 2;
        ctx.fillText(text + "%", textX, textY);
        ctx.save();
      }
    }
  ],
  options: {
    maintainAspectRatio: false,
    aspectRatio: 1,
    cutoutPercentage: 80,
    rotation: Math.PI / 2,
    legend: {
      display: false,
    },
    tooltips: {
      filter: tooltipItem => tooltipItem.index == 0
    }
  }
});
</script>

</html>