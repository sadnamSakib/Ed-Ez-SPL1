<?php
$root_path = '../../';
require $root_path . 'LibraryFiles/DatabaseConnection/config.php';
require $root_path . 'LibraryFiles/ValidationPhp/InputValidation.php';
require $root_path . 'LibraryFiles/SessionStore/session.php';
$email = new EmailValidator($_SESSION['email']);

if(isset($_REQUEST["term"])){

    if($_SESSION['tableName']==='student')
    {
        $sql = "SELECT DISTINCT resources.resource_id,resources.resource_visibility,resources.resource_tag,resources.resource_description,resources.title FROM resources,resources_classroom,student_classroom WHERE 
    ((resources_classroom.class_code=student_classroom.class_code AND student_classroom.email='".$email->get_email()."'
    AND resources.resource_id=resources_classroom.resource_id) OR resources.resource_visibility='public')
     AND resource_tag LIKE ?";
    }
    else{
        $sql = "SELECT DISTINCT resources.resource_id,resources.resource_visibility,resources.resource_tag,resources.resource_description,resources.title FROM resources,resources_classroom,teacher_classroom WHERE 
    ((resources_classroom.class_code=teacher_classroom.class_code AND teacher_classroom.email='".$email->get_email()."'
    AND resources.resource_id=resources_classroom.resource_id) OR resources.resource_visibility='public')
     AND resource_tag LIKE ?";
    }
    
    
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