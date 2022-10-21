if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }

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