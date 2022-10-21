<?php
  foreach ($classrooms as $i) {
    $card = $i['class_code'];
  ?>
    <style>
    <?php echo "." . $card; ?>dropbtn {
        background-color: transparent;
        color: black;
        padding: 3px;
        font-size: 16px;
        border: 10px;
        border-color: #000;
        border-radius: 5px;
        cursor: pointer;
      }


      <?php "#" . $card ?>myDropdown {
        transition: all 0.3s;
      }

      <?php echo "." . $card?>dropbtn:hover,<?php echo $card;?>dropbtn:focus{
        background-color: #2f6d8b;
      }

      <?php echo "." . $card;?>dropdown{
        position: relative;
        display: inline-block;
      }

      <?php echo "." . $card; ?>dropdown-content{
        display: none;
        position: absolute;
        background-color: white;
        min-width: 160px;
        border-radius: 1.5px;
        overflow: auto;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        transition: all 0.3s;
      }

      <?php echo "." . $card; ?>dropdown-content a{
        color: black;
        text-decoration: none;
        display: block;
      }

      <?php echo "." . $card;?>dropdown-toggle {
        background-color: #2980B9;
        color: white;
      }

      <?php echo "." . $card; ?>dropdown a:hover {
        background-color: #ddd;
      }
    </style>
  <?php
  };
  ?>