<?php
    class PostManagement{
        private $system_date;
        private $database;
        private $post_id;
        private $post_text;
        private $class_code;
        private $email;
        function __construct($post_text,$email,$class_code,$utility,$database){
            $this->database = $database;
            $this->post_id = $utility->generateRandomString(50);
            while (($database->performQuery("SELECT * FROM post WHERE post_id = '".$this->post_id."'"))->num_rows > 0) {
                $this->post_id = $utility->generateRandomString(50);
            }
            $this->post_text=$post_text;
            $this->class_code=$class_code;
            $this->post_text = $post_text;
            $this->email=$email;
            $this->get_system_date();
            $this->addPost();
        }

        private function addPost(){
            if (!is_null($this->post_text) && $this->post_text !== '') {
                $this->database->performQuery("INSERT INTO post(post_id,email,post_datetime,post_message) VALUES('".$this->post_id."','" . $this->email . "','".$this->system_date['DATE']."','".$this->post_text."');");
                $this->database->performQuery("INSERT INTO post_classroom(post_id,class_code) VALUES('".$this->post_id."','".$this->class_code."');");
            }
        }

        private function get_system_date(){
            $this->database->fetch_results($this->system_date,"SELECT SYSDATE() AS DATE");
        }
    }
?>