<?php
require_once 'models/usermodel.php';
    class LoginModel extends Model{
        private $id;
        private $username;
        private $password;
        private $role; 
        private $budget;
        private $photo;
        private $name;
        function __construct()
        {
            parent::__construct();
        }

        function login($username , $password){
            try{
                $items = [];
                $sql = "SELECT * from users where username = ?";
                $query = $this->prepare($sql);
                $ok = mysqli_stmt_bind_param($query , 's' ,$username);
                $ok = $this->query_execute($query);
                $ok = mysqli_stmt_bind_result($query , $this->id, $this->username , $this->password , $this->role , $this->budget, $this->photo , $this->name);
                while(mysqli_stmt_fetch($query)) {
                    array_push($items , ['id' => $this->id , 'username' => $this->username, 'password' => $this->password , 'role' => $this->role, 'budget' => $this->budget, 'photo' => $this->photo , 'name' => $this->name]);
                }
                if(count($items) == 1){
                    $user = new UserModel();
                    $user->from($items);
                    // return $items;
                    if(password_verify($password , $user->getPassword())){
                        error_log('LOGINMODEL:: login->succes');
                        return $user;
                    }else {
                        error_log('LOGINMODEL:: Login -> password no esta igual');
                        return null;
                    }
                }
            }catch(Throwable $th){
                error_log('LOGINMODEL::LoginException -> exception ' . $th);
                return null;
            }
        }
    }
?>