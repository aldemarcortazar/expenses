<?php

    require_once 'models/usermodel.php';
    class Signup extends sessionController{

        function __construct()
        {
            parent::__construct();
        }

        function render(){
            $this->view->render('login/signup', [], );
        }


        function newUser(){
            if($this->existPOST(['username' , 'password'])){

                $username = $this->getPost('username');
                $password = $this->getPost('password');

                if($username === '' || empty($username) || $password === '' || empty($password)){
                    // si esta vacio mando otro error
                    $this->redirect('signup' , ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY]);
                }else{

                    $user = new UserModel();
                    $user->setUsername($username);
                    $user->setPassword($password);
                    $user->setRole('user');

                    if($user->exists($username)){
                        $this->redirect('signup' , ['error' =>ErrorMessages::ERROR_SIGNUP_NEWUSER_EXIST]);
                    }elseif($user->save()){
                        $this->redirect('' , ['success' => SuccessMessages::SUCCES_SIGNUP_NEWUSER]);
                        // var_dump($user);
                    }else{
                        $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
                    }
                }
            }else{
                $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
            }
        }
    }
?>