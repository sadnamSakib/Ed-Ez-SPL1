<?php
foreach ($allPost as $i) {
    $post_selector = $i['post_id'];
?>
    <script>
        function <?php echo $post_selector; ?>dropdownbtn() {
            document.getElementById("<?php echo $post_selector; ?>myDropdown").classList.toggle("show");
        }
    </script>
<?php
}
?>

<?php
foreach ($allComments as $i) {
    $comment_selector = $i['comment_id'];
?>
    <script>
        function <?php echo $comment_selector; ?>dropdownbtn() {
            document.getElementById("<?php echo $comment_selector; ?>myDropdown").classList.toggle("show");
        }
    </script>
<?php
}
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