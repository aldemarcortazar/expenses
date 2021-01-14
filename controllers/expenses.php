<?php
    class Expenses extends sessionController{
        function __construct()
        {
            parent::__construct();
            error_log('EXPENSES::construct -> inicio de login');
            // echo "hola desde login";
        }

        function render(){
            error_log('EXPENSES::render estoy aqui');
            $this->view->render('expenses/index');
        }

    }

?>