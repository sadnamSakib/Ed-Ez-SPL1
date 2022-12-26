<?php
$root_path = '../../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
if(isset($_REQUEST["term"])){
    $sql = "SELECT * FROM resources WHERE resource_tag LIKE ?";
    
    if($stmt = $database->prepared_statement($sql)){
        $database->setPreparedStatement($stmt, $param_term);
        $param_term = $_REQUEST["term"] . '%';
        try{
            $database->getPreparedStatementResult($stmt, $result);
            if($result->num_rows > 0){
                ?>
                <form method="post" action="ViewResources/index.php">
                <?php
                foreach ($result as $dummy_resource){
                    ?>
                    <div class="card card-body my-2 mx-1 me-1 btn btn-resource uploaded-resources" style="text-align:left" id="scrollspyHeading1">
                      <button type="submit" name="<?php echo $dummy_resource['resource_id'] ?>" style="all:unset">
                        <div class="private-box mb-1"><?php echo $dummy_resource['resource_visibility']; ?></div>
                        <h5><?php echo $dummy_resource['title']; ?></h5>
                        <p style="font-size: 12px;">Resource Tag: <?php echo $dummy_resource['resource_tag']; ?></p>
                        <p style="font-size: 12px;"><?php echo $dummy_resource['resource_description']; ?></p>
                      </button>
                    </div>
                    <?php
                }
                ?>
                </form>
                <?php
            } else{
                echo "<p>No matches found</p>";
            }
        } catch(Exception $e){
            echo "ERROR: Could not able to execute $sql. " .$e->getMessage();
        }
    }
}
?>