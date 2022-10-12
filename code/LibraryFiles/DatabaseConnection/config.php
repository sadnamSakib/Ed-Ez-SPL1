<?php

    class Database{
        private $username;
        private $servername;
        private $password;
        private $database;
        private $connection;
        function __construct($username, $servername, $password,$database){
            $this->username = $username;
            $this->servername = $servername;
            $this->password = $password;
            $this->database = $database;
        }

        function connect(){
            $this->connection=new mysqli($this->servername, $this->username, $this->password, $this->database);
            if ($this->connection->connect_error) {
                die("Connection failed: " . $this->connection->connect_error);
            }

        }

        function get_connection(){
            return $this->connection;
        }

        function set_connection($username, $servername, $password,$database){
            $this->username = $username;
            $this->servername = $servername;
            $this->password = $password;
            $this->database = $database;
            $this->connect();
        }

        function performQuery($sql){
            if(is_null($this->connection)){
                die("Connection with database failed");
            }
            return mysqli_query($this->connection,$sql);
        }
        

        
    }

    

    
    
    // Create connection
    $database=new Database("UserManager","localhost","12345678","user");
    // Check connection
    $database->connect();

    error_reporting(0);

    session_start();


?>
