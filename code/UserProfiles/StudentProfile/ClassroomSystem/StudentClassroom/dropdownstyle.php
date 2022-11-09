<style>
    <?php
    foreach ($allPost as $j) {
        $i = $j['post_id'];
    ?><?php echo '#' . $i ?>myDropdown {
        transition: all 0.3s;
    }

    <?php echo '.' . $i ?>dropdown-content {
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

    <?php echo '.' . $i ?>dropdown-content a {
        color: black;
        text-decoration: none;
        display: block;
    }

    <?php
    }
    ?><?php
    foreach ($allComments as $j) {
        $i = $j['comment_id'];
    ?><?php echo '#' . $i ?>myDropdown {
        transition: all 0.3s;
    }

    <?php echo '.' . $i ?>dropdown-content {
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

    <?php echo '.' . $i ?>dropdown-content a {
        color: black;
        text-decoration: none;
        display: block;
    }

    <?php
    }
    ?>
</style>