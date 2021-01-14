<?php
class ErrorMessages{
    // ERROR_CONTROLLER_METHOD_ACTION
    const PRUEBA = "c74163200ec1e78de1223179774c0318";
    const ERROR_SIGNUP_NEWUSER = "c741612a00ec1e78de12bc179";
    const ERROR_SIGNUP_NEWUSER_EMPTY = "c74163211ecDe78de12fh3179774c0318";
    const ERROR_SIGNUP_NEWUSER_EXIST = "c741632341bcDe78de12fh3179774c0318";
    const ERROR_LOGIN_AUTHENTICATE_EMTY = 'c74163240ec1e78de122d13977bc0318';
    const ERROR_LOGIN_AUTHENTICATE_DATA = 'c74163200ec1e78de1ss43179774c0318';
    const ERROR_LOGIN_AUTHENTICATE = 'cacb163200ec1e78de1ss43179d7mc0318';
    private $errorList = [];
    public function __construct()
    {
        $this->errorList = [
            ErrorMessages::PRUEBA => 'este es un mensaje de prueba de error',
            ErrorMessages::ERROR_SIGNUP_NEWUSER => 'hubo un error al intentar procesar la solicitud',
            ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY => 'LLena los campos de usuario y password',
            ErrorMessages::ERROR_SIGNUP_NEWUSER_EXIST => 'ya existe ese nombre de usuario escoge otro',
            ErrorMessages::ERROR_LOGIN_AUTHENTICATE_EMTY => 'llenas los campos de usuario y password',
            ErrorMessages::ERROR_LOGIN_AUTHENTICATE_DATA => 'username y/o paswword incorrectos',
            ErrorMessages::ERROR_LOGIN_AUTHENTICATE => 'no  se puede procesar la solicitud ingresa usuario y password'
        ];
    }

    public function get($hash){
        return $this->errorList[$hash];
    }
    
    public function existsKey($key){
        if(array_key_exists($key , $this->errorList)){
            return true;
        }else{
            return false;
        }
    }
}
?>