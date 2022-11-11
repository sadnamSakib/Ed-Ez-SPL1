<?php
    class FileManagement{
        public $filename;
        public $file_extension;
        private $file_id;
        private $file_tmp_name;
        private $database;

        function __construct($filename,$file_tmp_name, $file_extension,$database,$utility){
            $this->filename = $filename;
            $this->file_extension = $file_extension;
            $this->database = $database;
            $file_id = $utility->generateRandomString(10);
            $existence = $this->database->performQuery("SELECT * FROM files where file_id='$file_id'");
            while ($existence->num_rows > 0) {
              $file_id = $utility->generateRandomString(10);
              $existence = $this->database->performQuery("SELECT * FROM files where file_id='$file_id'");
            }
            $this->file_id=$file_id;
            $this->file_tmp_name= $file_tmp_name;
            $this->addFile();
        }

        private function addFile(){
            $this->database->performQuery("insert into files(file_id,filename,file_ext) values('$this->file_id','$this->filename','$this->file_extension')");
            mkdir(URLPath::getFTPServerRoot().$this->file_id.'/');
            move_uploaded_file($this->file_tmp_name,URLPath::getFTPServerRoot().$this->file_id.'/'.$this->filename);
          }

          public function get_file_url($ftp_server){
            return $ftp_server.$this->file_id.'\\'.$this->filename;
          }

          function get_file_id(){
            return $this->file_id;
          }
    }

?>