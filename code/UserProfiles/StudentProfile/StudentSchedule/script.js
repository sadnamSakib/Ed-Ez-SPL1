$(".sidebar ul li").on('click', function() {
    $(".sidebar ul li.active").removeClass('active');
    $(this).addClass('active');
  });
  $('.open-btn').on('click', function() {
    $('.sidebar').addClass('active');
  });
  $('.close-btn').on('click', function() {
    $('.sidebar').removeClass('active');
  });


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
        },
        {
            title: 'Mirzar Biye',
            start: '2022-10-20T10:30:00',
            end: '2022-10-20T12:30:00'
          },
        
      ]
    });

    calendar.render();
  });