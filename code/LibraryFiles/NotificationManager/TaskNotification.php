<?php 
class TaskNotification extends NotificationManagement{
  function __construct($email, $classCode, $title, $utility, $database){
    parent::__construct($email, $classCode, $utility, $database);
    $this->message = "A task has been posted: $title in the classroom " . $this->classroom['course_code'] . ": " . $this->classroom['classroom_name'] . " by " . $this->users['name'] . "";
    $this->addnotification('task');
  }
}

?>