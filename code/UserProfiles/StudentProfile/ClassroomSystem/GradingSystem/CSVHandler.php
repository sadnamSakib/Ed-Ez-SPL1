<?php
    class CSVHandler{
        private $filename;
        private $directory;
        private $newFile;
        function __construct($directory){
            $this->filename = "GradeSheet";
            $this->directory = $directory;
            $this->init();
        }

        public function init(){
            mkdir(URLPath::getFTPServerRoot().$this->directory.'/',true);
            $this->newFile = fopen(URLPath::getFTPServerRoot().$this->directory.'/'.$this->filename.".csv", "w");
        }

        public function write(...$args){
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
    }
?>