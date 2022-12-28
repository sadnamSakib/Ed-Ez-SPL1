<?php 
class SessionNotification extends NotificationManagement{
  function __construct($email, $classCode, $utility, $database){
    parent::__construct($email, $classCode, $utility, $database);
    $this->message = "A session has been created in the classroom " . $this->classroom['course_code'] . ": " . $this->classroom['classroom_name'] . " by " . $this->users['name'] . "";
    $this->addnotification('session');
  }
}
?>