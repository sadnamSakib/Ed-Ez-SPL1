<?php
    class CommentManagement{
        private $system_date;
        private $database;
        private $comment_id;
        private $comment_text;
        private $email;
        private $post_id;
        function __construct($comment_text,$post_id,$email,$utility,$database){
            $this->database = $database;
            $this->comment_id = $utility->generateRandomString(50);
            while (($database->performQuery("SELECT * FROM comments WHERE comment_id = '".$this->comment_id."'"))->num_rows > 0) {
                $this->comment_id = $utility->generateRandomString(50);
            }
            $this->comment_text=$comment_text;
            $this->comment_text = $comment_text;
            $this->email=$email;
            $this->post_id=$post_id;
            $this->get_system_date();
            $this->addcomment();
        }

        private function addcomment(){
            if (!is_null($this->comment_text) && $this->comment_text !== '') {
                $this->database->performQuery("INSERT INTO comment_post(comment_id, post_id) VALUES ('".$this->comment_id."','".$this->post_id."')");
                $this->database->performQuery("INSERT INTO comments(comment_id,email,comment_datetime,comment_message) VALUES('".$this->comment_id."','" . $this->email . "','".$this->system_date['DATE']."','".$this->comment_text."');");
            }
        }

        private function get_system_date(){
            $this->database->fetch_results($this->system_date,"SELECT SYSDATE() AS DATE");
        }
    }
?>