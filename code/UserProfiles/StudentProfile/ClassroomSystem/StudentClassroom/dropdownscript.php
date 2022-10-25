<?php
  foreach($allPost as $i){
    $post_selector=$i['post_id'];
?>
<script>
  function <?php echo $post_selector;?>dropdownbtn() {
    document.getElementById("<?php echo $post_selector;?>myDropdown").classList.toggle("show");
  }
  </script>
  <?php
  }
  ?>

<?php
  foreach($allComments as $i){
    $comment_selector=$i['comment_id'];
?>
<script>
  function <?php echo $comment_selector;?>dropdownbtn() {
    document.getElementById("<?php echo $comment_selector;?>myDropdown").classList.toggle("show");
  }
  </script>
  <?php
  }
  ?>