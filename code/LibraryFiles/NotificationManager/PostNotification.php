<?php 
class PostNotification extends NotificationManagement{
  function __construct($email, $classCode, $utility, $database){
    parent::__construct($email, $classCode, $utility, $database);
    $this->message = $this->users['name'] . " posted in " . $this->classroom['course_code'] . ": " . $this->classroom['classroom_name'] . "";
    $this->addnotification('post');
  }
}
?>