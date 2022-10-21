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