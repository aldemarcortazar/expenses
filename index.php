<?php
    error_reporting(E_ALL);       
    ini_set('ignore_repeated_errors' , TRUE);
    ini_set('display_errors' , FALSE);
    ini_set('log_errors', TRUE);

    ini_set("error_log" , "php-error.log");
    error_log("inicio de aplicacion web!");  

    // requiero la app

    require_once 'libs/app.php';
    require_once 'libs/database.php';
    require_once 'config/config.php';
    require_once 'libs/model.php';
    require_once 'libs/view.php';
    require_once 'libs/controller.php';
    require_once 'controllers/errores.php';
    require_once 'clases/error_messague.php';
    require_once 'clases/succes.php';
    require_once 'clases/session_controller.php';
    $app = new App();

    // $login = new LoginModel();
    // error_log('login::->aja' . var_dump($login->login('papa' , '12345')));
    
?>