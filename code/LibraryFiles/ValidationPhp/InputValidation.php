<?php
    class InputValidation{
        public $error;
        function __construct(){
            $this->error=null;
        }

        function presence_check(...$args){
            foreach($args as $i){
                if(is_null($i)){
                    $this->error="All Fields are required";
                    return false;
                }
            }
            return true;
        }

        function Date_Validation($date){
            if(strtotime($date)>=strtotime(date("Y-m-d"))){
                return "Date is Invalid";
            }
            else{
                return null;
            }
        }


    }
    
    class EmailValidator{
        private $email;
        public $error;
        private $regex_pattern;

        function __construct($email){
            $this->email = $email;
            $this->error=null;
            $this->set_regular_expression();
        }

        public function SQLInjectionCheck(){
            $len=strlen($this->email);
            foreach($this->email as $i){
                if(ord($i)===ord('(')||ord($i)===ord(')')||ord($i)===ord('_')||ord($i)===ord('\'')||ord($i)===ord('\"')||ord($i)===ord('=')||ord($i)===ord('-')||ord($i)===ord('\\')||ord($i)===ord(';')){
                    return false;
                }
            }
            return true;
        }

        private function set_regular_expression(){//RFC 2822 Standard
            $user   = '[a-zA-Z0-9_\-\.\+\^!#\$%&*+\/\=\?\`\|\{\}~\']+';
            $domain = '(?:(?:[a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.?)+';
            $ipv4   = '[0-9]{1,3}(\.[0-9]{1,3}){3}';
            $ipv6   = '[0-9a-fA-F]{1,4}(\:[0-9a-fA-F]{1,4}){7}';
            $this->regex_pattern="/^$user@($domain|(\[($ipv4|$ipv6)\]))$/";
        }

        public function PatternCheck(){
	        return preg_match($this->regex_pattern,$this->email);
        }

        public function email_validate(){
            if(!$this->SQLInjectionCheck()){
                $this->error="Please Do not use \\, \', \", ;, = in the email";
                return false;
            }
            else if(!$this->PatternCheck()){
                $this->error="Email is Invalid";
                return false;
            }
            else if(is_null($this->email)){
                $this->error="Email is Invalid";
                return false;
            }
            else{
                $this->error=null;
                return true;
            }
        }

        public function get_email(){
            return hash('sha512',$this->email);
        }

        public function get_original_email(){
            return $this->email;
        }

    }

    class PasswordValidator{
        private $password;
        public $password_error;
        public $confirm_error;
        function __construct($password){
            $this->password=$password;
            $this->password_error=null;
            $this->confirm_error=null;
        }

        function password_match($confirm_password){
            if($this->password===$confirm_password){
                return true;
            }
            $this->confirm_error="Password does not match with confirm password";
            return false;
        }

        private function length_check(){
            return strlen($this->password);
        }

        function get_password(){
            $this->password=hash('sha512',$this->password);
            return password_hash($this->password,PASSWORD_BCRYPT);
        }

        function get_store_password(){
            return hash('sha512',$this->password);
        }

        private function attribute_constraint_check($attribute){
            $smallCase=false;
            $bigCase=false;
            $charPresent=false;
            $numPresent=false;
            $dangerousCharacters=false;
            foreach($attribute as $i){
                if(ord($i)>=ord('A') && ord($i)<=ord('Z')){
                    $bigCase=true;
                }
                else  if(ord($i)>=ord('a') && ord($i)<=ord('z')){
                    $smallCase=true;
                }
                else if(ord($i)>=ord('0') && ord($i)<=ord('9')){
                    $numPresent=true;
                }
                else if((ord($i)>=ord(' ') && ord($i)<ord('9'))||(ord($i)>ord('9') && ord($i)<ord('A'))||(ord($i)>ord('Z') && ord($i)<ord('a'))|| (ord($i)>ord('z'))){
                    $charPresent=true;
                }
                else if(ord($i)===ord('(')||ord($i)===ord(')')||ord($i)===ord('_')||ord($i)===ord('\'')||ord($i)===ord('\"')||ord($i)===ord('=')||ord($i)===ord('-')||ord($i)===ord('\\')||ord($i)===ord(';')){
                    $dangerousCharacters=true;
                }
                else{
                    continue;
                }
            }
            if($smallCase && $bigCase && $charPresent && $numPresent && !$dangerousCharacters){
                return true;
            }
            return false;
        }

        function constraint_check(){
            if(!$this->attribute_constraint_check($this->password) && $this->length_check()<8){
                $this->password_error="Password must be at least 8 characters, with alphabets, numbers, symbols and no dangerous characters";
                return false;
            }
            else if(is_null($this->password)){
                $this->password_error="Password must be at least 8 characters, with alphabets, numbers, symbols and no dangerous characters";
                return false;
            }
            return true;
        }

    }
?>