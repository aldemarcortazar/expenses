<?php
    class Database{
        private $host;
        private $user;
        private $password;
        public $db;
        private $connectar;
        public function __construct()
        {
            $this->host = constant('HOST');
            $this->user = constant('USER');
            $this->password = constant('PASSWORD');
            $this->db = constant('DB');
        }
        public function connect(){
            try {
                $this->connectar = new mysqli($this->host, $this->user, $this->password, $this->db);
                if($this->connectar ->connect_errno){
                    die("fallo la conexion a la base de datos");
                }// }else{
                //     echo "se connecto a la base de datos" . $this->db;
                // }
                return $this->connectar;
            } catch (Throwable $th) {
                //throw $th;
                echo "el error esta en" . $th;
            }
        }
    }
?>