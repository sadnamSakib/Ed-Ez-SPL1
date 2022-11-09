if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

// Close the dropdown if the user clicks outside of it
window.addEventListener('dblclick',function(event) {
  if (!event.target.matches('.dropbtn')) {
    close_dropdown();
  }
});

function close_dropdown(){
  var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
}