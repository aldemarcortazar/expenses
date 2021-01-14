<?php
    class App{
        function __construct()
        {
           $url = isset($_GET['url']) ? $_GET['url'] : null;
           /**dividir nuestra url por diagonales  */
           $url = rtrim($url , '/');// con esto voy a borrar cualquier diagonalque se encuentre al final de la url
           $url = explode('/' , $url);
           /** con explode voy a separar la url por una diagonal y la vouy a almacenar en un arreglo */
           if(empty($url[0])){
               error_log('APP::construct-> No hay controlador especificado');
               $archivoController = 'controllers/login.php';
               require_once $archivoController;
               $controller = new Login();
               $controller->loadModel('login');
               $controller->render();
               return false;
           }
           $archivoController = 'controllers/' . $url[0] . '.php';

           if(file_exists($archivoController)){
                /**si existe cargamos el controlador */
                require_once $archivoController;
                $controller = new $url[0];
                $controller->loadModel($url[0]);

                if(isset($url[1])){
                    // voy a validar si el metodo esta dentro de la clase que quiero cargar
                    if(method_exists($controller, $url[1])){
                        // si dentro de la url hay mas parametros
                        if(isset($url[2])){
                            // no de parametros
                            $nparam = count($url) - 2;
                            $params = [];

                            for($i = 0 ; $i < $nparam; $i++){
                                array_push($params , $url[$i] + 2);
                            }

                            $controller->{$url[1]}($params);
                        }else{
                            // no tiene parametros llamo al metodo tal cual
                            $controller->{$url[1]}(); 
                        }
                    }else{
                        // error no existe metodo
                        $controller = new Errores();
                        $controller->render();
                    }
                }else{
                    // no hay metodo se carga uno por default
                    $controller->render();
                }
           }else{
                /** si no existe llamo a una pagina de 404 */
                $controller = new Errores();
                $controller->render();
           }
        }
    }
?>