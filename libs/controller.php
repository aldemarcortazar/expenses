<?php
    /** esta va a cargar el modelo y la vista que necesitemos */
    class Controller{
        function __construct()
        {
            $this->view = new View();
        }

        function loadModel($model){
            $url = 'models/' . $model . 'model.php';

            if(file_exists($url)){
                require_once $url;

                $modelName = $model.'Model';
                $this->model = new $modelName(); // con esto inicializo el nuevo objecto
            }
        }

        function existPOST($params){
            foreach($params as $param){
                if(!isset($_POST[$param])){
                    error_log('Controller:: exixstPost => no existe el parametro ' . $param);
                    return false;
                }
            }
            return true;
        }
        function existGET($params){
            foreach($params as $param){
                if(!isset($_GET[$param])){
                    error_log('CONTROLLER:: exixstGet => no existe el parametro ' . $param);
                    return false;
                }
            }
            return true;
        }
        function getGet($name){
            return $_GET[$name];
        }

        function getPost($name){
            return $_POST[$name];
        }

        function redirect($route , $messagues){
            $data = [];
            $params = '';

            foreach($messagues as $key => $messague){
                array_push($data , $key . '=' . $messague);
            }
            // esta funcion permite unir los elementos de un arreglo con un simbolo  
            $params = join('&' , $data); 
            //nombre=marcos&apellido=cortazar;
            if($params != ''){
                $params = '?' . $params; 
            }

            header('Location:' . constant('URL') . '/' . $route . $params);
        }
    }
?>