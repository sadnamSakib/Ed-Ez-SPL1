<?php

 class EventManagement{
    private $event_id;
    private $startDateTime;
    private $endDateTime;
    private $database;
    function __construct($startDateTime,$endDateTime,$database,$utility)
    {
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
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
        $this->database->performQuery("insert into event(event_id,event_start_datetime,event_end_datetime) values('$this->event_id','$this->startDateTime','$this->endDateTime')");
    }

    public function get_event_id(){
        return $this->event_id;
      }
 }
?>