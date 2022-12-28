<?php 
class ResourceNotification extends NotificationManagement{
  function __construct($email, $classCode, $title, $utility, $database){
    parent::__construct($email, $classCode, $utility, $database);
    $this->message = "A resource has been uploaded: $title in the classroom " . $this->classroom['course_code'] . ": " . $this->classroom['classroom_name'] . " by " . $this->users['name'] . "";
    $this->addnotification('resource');
  }
}
?>