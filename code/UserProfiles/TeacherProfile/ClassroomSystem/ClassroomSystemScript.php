<?php
foreach ($classrooms as $i) {
  $card = $i['class_code'];
?>
  <script>
    function <?php echo $card; ?>closeModal() {
      document.getElementById('<?php echo $card; ?>myModal').style.display = 'none';
    }

    function <?php echo $card; ?>displayModal() {
      document.getElementById('<?php echo $card; ?>myModal').style.display = 'block';
    }

    function <?php echo $card; ?>dropdownbtn() {
      document.getElementById("<?php echo $card; ?>myDropdown").classList.toggle("show");
    }
  </script>
<?php
}
?>
<script>
  //Close the dropdown if the user clicks outside of it
  window.addEventListener("dblclick", function(event) {
    // When the user clicks anywhere outside of the modal, close it
    <?php
    foreach ($classrooms as $i) {
      $card = $i['class_code'];
    ?>
      if (!event.target.matches('.<?php echo $card; ?>dropbtn')) {
        var dropdowns = document.getElementsByClassName("<?php echo $card; ?>dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
      if (event.target == document.getElementById('<?php echo $card; ?>myModal')) {
        document.getElementById('<?php echo $card; ?>myModal').style.display = "none";
      }
    <?php
    }
    ?>
  })
</script>