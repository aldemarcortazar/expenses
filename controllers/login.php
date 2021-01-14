<?php
    class Login extends sessionController{
        function __construct()
        {
            parent::__construct();
            error_log('Login::construct -> inicio de login');
            // echo "hola desde login";
        }

        function render(){
            $this->view->render('login/index');
            // $this->view->render('dashboard/index');
        }

        function authenticate(){
            if($this->existPOST(['username' , 'password'])){
                $username = $this->getPost('username');
                $password = $this->getPost('password');

                if($username === '' || empty($username) || $password === '' || empty($password)){
                    $this->redirect('', ['error' => ErrorMessages::ERROR_LOGIN_AUTHENTICATE_EMTY]);
                }else{

                    $user = $this->model->login($username , $password);

                    if($user != null){
                        $this->initialize($user);
                    }else{
                        $this->redirect('' , ['error' => ErrorMessages::ERROR_LOGIN_AUTHENTICATE_DATA]);
                    }
                }
            }else{
                $this->redirect("" , ["error" , ErrorMessages::ERROR_LOGIN_AUTHENTICATE]);
            }
        }
    }

?>