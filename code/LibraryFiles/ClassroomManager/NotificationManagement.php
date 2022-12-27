<?php
    class NotificationManagement{
        private $system_date;
        private $database;
        private $notification_id;
        private $message;
        private $notification_type;
        private $email;
        private $classroom;
        private $users;

        private $classCode;

        function __construct($email,$notification_type,$classCode,$title,$utility,$database,$submission_status=NULL){
            $this->database = $database;
            $this->notification_id = $utility->generateRandomString(50);
            while (($database->performQuery("SELECT * FROM notifications WHERE notification_id = '".$this->notification_id."'"))->num_rows > 0) {
                $this->notification_id = $utility->generateRandomString(50);
            }
            $this->classCode = $classCode;
            $this->notification_type=$notification_type;
            $this->email=$email;
            $this->database->fetch_results($this->users, "SELECT * FROM users WHERE email='".$this->email."'");
            $this->database->fetch_results($this->classroom, "SELECT * FROM classroom WHERE class_code='$classCode'");
            if($this->notification_type==='resource'){
              $this->message = "A resource has been uploaded: $title in the classroom ".$this->classroom['course_code'].": ".$this->classroom['classroom_name']." by ".$this->users['name']."" ;
            }
            else if($this->notification_type==='session'){
              $this->message = "A session has been created in the classroom ".$this->classroom['course_code'].": ".$this->classroom['classroom_name']." by ".$this->users['name']."" ;
            }
            else if($this->notification_type==='submit'){
                $this->message = "A task has been submitted: $title in the classroom ".$this->classroom['course_code'].": ".$this->classroom['classroom_name']." by ".$this->users['name']." ";
                if($submission_status==0){
                $this->message = $this->message ." late";
                }
                else{
                    $this->message = $this->message ." on time";
                }
            }
            else{
              $this->message = "A task has been posted: $title in the classroom ".$this->classroom['course_code'].": ".$this->classroom['classroom_name']." by ".$this->users['name']."" ;
            }
            $this->get_system_date();
            $this->addnotification();
        }

        private function addnotification(){
            if (!is_null($this->message) && $this->message !== '') {
                $this->database->performQuery("INSERT INTO notifications(message,notification_id,notification_datetime,notification_type,class_code) VALUES('".$this->message."','" . $this->notification_id . "','".$this->system_date['DATE']."','".$this->notification_type."','".$this->classCode."');");
            }
        }

        private function get_system_date(){
            $this->database->fetch_results($this->system_date,"SELECT SYSDATE() AS DATE");
        }
    }
