<?php 
    class DB{
        private $sqlid;
        private $sqlip;
        private $sqlname;
        private $sqlport;
        private $sqlpass;
        public  $con;
        public function __construct(){
            $this->sqlid= $GLOBALS['config']['mysqli']['sqlid'];
            $this->sqlpass= $GLOBALS['config']['mysqli']['sqlpassword'];
            $this->sqlname= $GLOBALS['config']['mysqli']['sqlname'];
            $this->sqlip= $GLOBALS['config']['mysqli']['sqlip'];
            $this->sqlport= $GLOBALS['config']['mysqli']['sqlport'];
            @$this->con = new mysqli($this->ip,$this->sqlid,$this->sqlpass, $this->sqlname, $this->sqlport);
            if(mysqli_connect_error()){
                $error_mysqli_connect = array(
                    'aim'=>'mysqli_connect',
                    'statu'=>'false',
                    'reson'=>mysqli_connect_errno()
                );
                die(json_encode($error_mysqli_connect));
            }
        }
        public function mQuery($sql){
            $result_query = mysqli_query($this->con, $sql);
            if(!$result_query){
                return false;
            }else{
                return $result_query;
            }
        }
    }