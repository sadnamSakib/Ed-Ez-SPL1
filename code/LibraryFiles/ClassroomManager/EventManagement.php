<?php

 class EventManagement{
    private $event_id;
    private $deadline;
    private $database;
    private $startTime;
    function __construct($startTime,$deadline,$database,$utility)
    {
        $this->startTime=$startTime;
        $this->deadline = $deadline;
        $this->database = $database;
        $this->utility = $utility;
        $event_id = $utility->generateRandomString(10);
        $existence = $database->performQuery("SELECT * FROM event where event_id='$event_id'");
        while ($existence->num_rows > 0) {
          $event_id = $utility->generateRandomString(10);
          $existence = $database->performQuery("SELECT * FROM event where event_id='$event_id'");
        }
        $this->event_id= $event_id;
        $this->addEvent();

    }

    private function addEvent()
    {
        $this->database->performQuery("insert into event(event_id,event_start_datetime,event_end_datetime) values('$this->event_id','$this->startTime','$this->deadline')");
    }

    public function get_event_id(){
        return $this->event_id;
      }

      public static function get_system_date($database){
        $system_date=null;
        $database->fetch_results($system_date,"SELECT SYSDATE() AS DATE");
        return $system_date['DATE'];
    }
 }
?>