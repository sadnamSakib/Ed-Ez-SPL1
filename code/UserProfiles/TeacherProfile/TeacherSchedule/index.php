<?php
$root_path = '../../../';
$profile_path='../';
include $root_path . 'LibraryFiles/DatabaseConnection/config.php';
include $root_path . 'LibraryFiles/URLFinder/URLPath.php';
include $root_path . 'LibraryFiles/SessionStore/session.php';

session::create_or_resume_session();
session::profile_not_set($root_path);
$temp = hash('sha512', $_SESSION['email']);
$tableName = $_SESSION['tableName'];
$row = mysqli_fetch_assoc($database->performQuery("SELECT * FROM users WHERE email='$temp';"));
$name = $row['name'];



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Classroom</title>
  <link rel="icon" href="<?php echo $root_path; ?>logo4.jpg" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="main.min.css" />
  <link rel="stylesheet" href="<?php echo $root_path; ?>css/bootstrap.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jsSHA/2.0.2/sha.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/d0f239b9af.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jsSHA/2.0.2/sha.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/d0f239b9af.js" crossorigin="anonymous"></script>
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
  <script defer src="script.js"></script>
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>

</head>

<body>

  <script src="<?php echo $root_path; ?>js/bootstrap.js"></script>
  <script src="main.min.js"></script>
  <div class="main-container d-flex">
      <?php 
        include $profile_path.'navbar.php';
        teacher_navbar($root_path);
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
      selectable: true,
      selectMirror: true,
      
      select: function(arg) {
        var title = prompt('Event Title:');
        if (title) {
          // calendar.addEvent({
          //   title: title,
          //   start: arg.start,
          //   end: arg.end,
          //   allDay: arg.allDay
          // })
          $.ajax({
            type : "POST",  //type of method
            url  : window.location.pathname,  //your page
            data : { 
            title: title,
            start: arg.start,
            type: 'holiday' 
          },// passing the values
            success: function(data){  
                        location.reload();
                    }
        });
        }
        calendar.unselect()
      },
      eventClick: function(arg) {
        if (confirm('Are you sure you want to delete this event?')) {
          arg.event.remove()
        }
      },
      editable: true,
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