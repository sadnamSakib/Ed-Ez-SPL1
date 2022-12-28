<?php
class NotificationManagement
{
    protected $system_date;
    protected $database;
    protected $notification_id;
    protected $message;
    protected $email;
    protected $classroom;
    protected $users;

    protected $classCode;

    function __construct($email, $classCode, $utility, $database)
    {
        $this->database = $database;
        $this->notification_id = $utility->generateRandomString(50);
        while (($database->performQuery("SELECT * FROM notifications WHERE notification_id = '" . $this->notification_id . "'"))->num_rows > 0) {
            $this->notification_id = $utility->generateRandomString(50);
        }
        $this->classCode = $classCode;
        $this->email = $email;
        $this->database->fetch_results($this->users, "SELECT * FROM users WHERE email='" . $this->email . "'");
        $this->database->fetch_results($this->classroom, "SELECT * FROM classroom WHERE class_code='$classCode'");
        $this->get_system_date();
    }

    protected function addnotification($notification_type)
    {
        $this->database->performQuery("INSERT INTO notifications(message,notification_id,notification_datetime,notification_type,class_code) VALUES('" . $this->message . "','" . $this->notification_id . "','" . $this->system_date['DATE'] . "','" . $notification_type . "','" . $this->classCode . "');");
        $userInsert = $this->database->performQuery("SELECT * FROM classroom,teacher_classroom,teacher WHERE classroom.class_code=teacher_classroom.class_code AND teacher.email=teacher_classroom.email AND classroom.class_code='" . $this->classCode . "'  AND teacher.email!='".$this->email."'");
        foreach ($userInsert as $insert) {
            $this->database->performQuery("INSERT INTO notification_user VALUES('" . $this->notification_id . "','" . $insert['email'] . "')");
        }
        $userInsert = $this->database->performQuery("SELECT * FROM classroom,student_classroom,student WHERE classroom.class_code=student_classroom.class_code AND student.email=student_classroom.email AND classroom.class_code='" . $this->classCode . "'  AND student.email!='".$this->email."'");
        foreach ($userInsert as $insert) {
            $this->database->performQuery("INSERT INTO notification_user VALUES('" . $this->notification_id . "','" . $insert['email'] . "')");
        }
    }

    protected function get_system_date()
    {
        $this->database->fetch_results($this->system_date, "SELECT SYSDATE() AS DATE");
    }
}
