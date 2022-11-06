<?php
foreach ($allPost as $i) {
    $post_selector = $i['post_id'];
?>
    <script>
        function <?php echo $post_selector; ?>dropdownbtn() {
            document.getElementById("<?php echo $post_selector; ?>myDropdown").classList.toggle("show");
        }
        function <?php echo $post_selector; ?>closeModal() {
                document.getElementById('<?php echo $post_selector; ?>myModal').style.display = 'none';
                document.getElementById("<?php echo $post_selector; ?>myDropdown").classList.toggle("show");
              }
          
              function <?php echo $post_selector; ?>displayModal() {
                document.getElementById('<?php echo $post_selector; ?>myModal').style.display = 'block';
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