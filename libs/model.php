<?php
    require_once 'libs/imodel.php';
    class Model{
        private $resultado;
        private $ok;
        private $db;
        function __construct()
        {
            $this->db = new Database();
        }

        function prepare($query){
            return $this->resultado = mysqli_prepare($this->db->connect() , $query);
        }

        function query_execute($query){
            return $this->ok =  mysqli_stmt_execute($query);
        }

        function close($query){
            return mysqli_stmt_close($query);
        }

        // public function consulta($connecion , $query , $campos)
        // {
        //     $resultado = mysqli_prepare($connecion , $query);
        //     $this->ok = mysqli_stmt_bind_param($resultado , "s" , $campos);
        //     $this->ok = mysqli_stmt_execute($resultado);
        //     if($this->ok === false){
        //         return false ;
        //     }else{
        //         return $resultado;
        //     }
        // }
    }
?>