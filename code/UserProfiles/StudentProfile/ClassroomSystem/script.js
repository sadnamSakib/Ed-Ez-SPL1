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

  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }

  function dropdownbtn() {
    document.getElementById("myDropdown").classList.toggle("show");
  }
  // Close the dropdown if the user clicks outside of it
  window.onclick = function(event) {
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
  }