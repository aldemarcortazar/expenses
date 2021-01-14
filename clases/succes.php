<?php
class SuccessMessages{
    const PRUEBA = "c74163200ec1e78de1223179774c0318";
    // c74163200ec1e78de12ee17d774c03b8
    const SUCCES_SIGNUP_NEWUSER = 'c74163200ec1e78de12ee17d774c03b8';
    private $succesList = [];
    function __construct()
    {
        $this->succesList = [
            SuccessMessages::PRUEBA => 'esto es un mensaje de prueba',
            SuccessMessages::SUCCES_SIGNUP_NEWUSER => 'nuevo usuario registrado correctamente'
        ];
    }

    public function get($hash){
        return $this->succesList[$hash];
    }

    public function existsKey($key){
        if(array_key_exists($key , $this->succesList)){
            return true;
        }else{
            return false;
        }
    }
}