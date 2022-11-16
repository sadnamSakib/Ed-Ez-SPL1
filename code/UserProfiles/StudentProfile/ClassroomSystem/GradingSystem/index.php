<?php
$root_path = '../../../../';
$profile_path = '../../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
require $root_path . 'LibraryFiles/Utility/Utility.php';
require $root_path . 'LibraryFiles/ValidationPhp/InputValidation.php';
require 'CSVHandler.php';
session::profile_not_set($root_path);
$tableName = $_SESSION['tableName'];
$email = new EmailValidator($_SESSION['email']);
$validate = new InputValidation();
$classCode = $_SESSION['class_code'];
$classrooms = $database->performQuery("SELECT * FROM classroom,student_classroom where classroom.class_code=student_classroom.class_code and student_classroom.email='" . $email->get_email() . "' and active='1';");
if (isset($_POST['DownloadCSV'])) {
  $csvHandler = new CSVHandler($email->get_email());
  $csvHandler->write('SUBJECT','PERCENTAGE');
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
    $csvHandler->write($i['classroom_name'],$percentage);
  }
  $result = ($total * 100) / $total_credit;
  $csvHandler->write('RESULT',$result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Classroom</title>
  <link rel="icon" href="<?php echo $root_path; ?>title_icon.jpg" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css" />
  <script defer src="script.js"></script>
  <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

  <link href="<?php echo $root_path; ?>boxicons-2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>

  <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
  <div class="main-container ">
    <?php
    require $profile_path . 'navbar.php';
    student_navbar($root_path);
    ?>
    <section class="content-section row justify-content-center w-75">
      <div class="col-md-8">
        <canvas id="chartProgress"></canvas>
      </div>
    </section>
    <section class="content-section row justify-content-center">
      <div class="progressbars col-md-4 w-50">
        <?php
        $total = 0;
        $total_credit = 0;
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
        ?>
          <label><?php echo  $i['classroom_name']; ?></label>
          <div class="progress my-2">
            <div class="progress-bar progressBar<?php echo  $i['class_code']; ?> progress-bar-animated bg-success" role="progressbar" style="width:0%" aria-valuenow="66.6" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <script>
            $(".progress-bar.progressBar<?php echo  $i['class_code']; ?>").animate({
              width: "<?php echo $percentage ?>%",
            }, 250);
          </script>
        <?php
        }
        ?>
        <div>
          <form action="" method="POST">
            <input type="submit" class="btn btn-primary" name="DownloadCSV" value="Download Grade Sheet">
          </form>
        </div>
      </div>

    </section>
  </div>
  <script>
    <?php
    $result = ($total * 100) / $total_credit;
    ?>
    var myChartCircle = new Chart('chartProgress', {
      type: 'doughnut',
      data: {
        datasets: [{
          label: 'Total percentage',
          percent: <?php echo $result ?>,
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
            textX = Math.round((width - ctx.measureText(text).width) / 2.2),
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
</body>

</html>