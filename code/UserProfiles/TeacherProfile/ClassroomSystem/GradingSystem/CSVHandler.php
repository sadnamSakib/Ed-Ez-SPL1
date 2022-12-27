<?php
    class CSVHandler{
        private $filename;
        private $directory;
        private $newFile;
        private $location;
        function __construct($directory){
            $this->filename = "GradeSheet";
            $this->directory = $directory;
            $this->init();
        }

        public function init(){
            mkdir(URLPath::getFTPServerRoot().$this->directory.'/',true);
            $this->newFile = fopen(URLPath::getFTPServerRoot().$this->directory.'/'.$this->filename.".csv", "w");
            $this->location=URLPath::getFTPServer().$this->directory.'/'.$this->filename.'.csv';
        }

        public function write(&$args){
            $found=false;
            foreach($args as $i){
                if($found==false){
                    fwrite($this->newFile,$i);
                    $found=true;
                }
                else{
                    fwrite($this->newFile,','.$i);
                }
            }
            fwrite($this->newFile,"\n");
        }

        public function download(){
            header('Location:'.$this->location.'');
        }
    }
?>