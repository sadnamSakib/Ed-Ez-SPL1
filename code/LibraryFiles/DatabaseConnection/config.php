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

    
    function isPasswordValid($password){
        $len=strlen($password);
        $smallCase=false;
        $bigCase=false;
        $charPresent=false;
        $numPresent=false;
        for($i=0;$i<$len;$i++){
            if(ord($password[$i])>=ord('A') && ord($password[$i])<=ord('Z')){
                $bigCase=true;
            }
            else  if(ord($password[$i])>=ord('a') && ord($password[$i])<=ord('z')){
                $smallCase=true;
            }
            else if(ord($password[$i])>=ord('0') && ord($password[$i])<=ord('9')){
                $numPresent=true;
            }
            else if((ord($password[$i])>=ord(' ') && ord($password[$i])<ord('9'))||(ord($password[$i])>ord('9') && ord($password[$i])<ord('A'))||(ord($password[$i])>ord('Z') && ord($password[$i])<ord('a'))|| (ord($password[$i])>ord('z'))){
                $charPresent=true;
            }
            else{
                continue;
            }
        }
        if($charPresent && $numPresent && $bigCase && $smallCase){
            return true;
        }
        return false;
    }
    
    function generateRandomString($length = 10)
    {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    }
    
    // Create connection
    $database=new Database("UserManager","localhost","12345678","user");
    // Check connection
    $database->connect();

    error_reporting(0);

    session_start();
