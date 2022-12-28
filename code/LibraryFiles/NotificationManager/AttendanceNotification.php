<?php 
class AttendanceNotification extends NotificationManagement{
  function __construct($email, $classCode, $utility, $database,$attendance_status){
    parent::__construct($email, $classCode, $utility, $database);
    $this->message = "Attendance given by ". $this->users['name'] ." in the classroom " . $this->classroom['course_code'] . ": " . $this->classroom['classroom_name']."";
    if($attendance_status===0){
      $this->message = "Late " . $this->message;
    }
    $this->addnotification('attendance');
  }
  protected function addnotification($notification_type)
  {
    $this->database->performQuery("INSERT INTO notifications(message,notification_id,notification_datetime,notification_type,class_code) VALUES('" . $this->message . "','" . $this->notification_id . "','" . $this->system_date['DATE'] . "','" . $notification_type . "','" . $this->classCode . "');");
    $userInsert = $this->database->performQuery("SELECT * FROM classroom,teacher_classroom,teacher WHERE classroom.class_code=teacher_classroom.class_code AND teacher.email=teacher_classroom.email AND classroom.class_code='" . $this->classCode . "' AND teacher.email!='" . $this->email . "'");
    foreach ($userInsert as $insert) {
      $this->database->performQuery("INSERT INTO notification_user VALUES('" . $this->notification_id . "','" . $insert['email'] . "')");
    }
  }
}
?>