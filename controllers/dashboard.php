<?php
    class Dashboard extends sessionController{
        function __construct()
        {
            parent::__construct();
            error_log('Dashboard::construct -> inicio de login');
            // echo "hola desde login";
        }

        function render(){
            error_log('DASHBOARD::render estoy aqui');
            $this->view->render('dashboard/index');
        }

    }

?>