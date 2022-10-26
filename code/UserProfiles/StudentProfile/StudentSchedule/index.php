<?php
$root_path = '../../../';
$profile_path='../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/URLFinder/URLPath.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
session::profile_not_set($root_path);
$temp = hash('sha512', $_SESSION['email']);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Classroom</title>
  <link rel="icon" href="<?php echo $root_path; ?>title_icon.jpg" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="main.min.css" />
  <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link href="<?php echo $root_path;?>boxicons-2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <script defer src="script.js"></script>

</head>

<body>

  <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
  <script src="main.min.js"></script>
  <div class="main-container d-flex">
  <?php 
      require $profile_path.'navbar.php';
      student_navbar($root_path);
    ?>
      <div class="container">
      <div id='calendar'></div>
      </div>
    </div>
</body>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      
      navLinks: true, // can click day/week names to navigate views
      selectable: false,
      selectMirror: false,
      
      select: function(arg) {
        var title = prompt('Event Title:');
        if (title) {
          calendar.addEvent({
            title: title,
            start: arg.start,
            end: arg.end,
            allDay: arg.allDay
          })
        }
        calendar.unselect()
      },
      
      editable: false,
      dayMaxEvents: true, // allow "more" link when too many events
      events: [
        {
          title: 'SPL progress Presentation',
          start: '2022-10-19'
        }
        
      ]
    });

    calendar.render();
  });

</script>

</html>