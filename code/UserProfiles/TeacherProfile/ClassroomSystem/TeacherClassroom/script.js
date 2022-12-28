if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}


var now=new Date();
document.getElementById("sessionStart").min=now.toISOString().substring(0, 16);
document.getElementById("attendanceDeadline").min=now.toISOString().substring(0, 16);
document.getElementById("sessionEnd").min=now.toISOString().substring(0, 16);
document.getElementById("Deadline").min=now.toISOString().substring(0, 16);

// Close the dropdown if the user clicks outside of it
window.addEventListener('dblclick', function (event) {
  if (!event.target.matches('.dropbtn')) {
    close_dropdown();
  }
});

function close_dropdown() {
  var dropdowns = document.getElementsByClassName("dropdown-content");
  var i;
  for (i = 0; i < dropdowns.length; i++) {
    var openDropdown = dropdowns[i];
    if (openDropdown.classList.contains('show')) {
      openDropdown.classList.remove('show');
    }
  }
}
//Function
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function (event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
};