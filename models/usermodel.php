<?php  

    class UserModel extends Model implements IModel{
        /******** estas variables son para campos que vienen de la base de datos 
         * voy acrear objecto para despues llamar los metodos de la interfaz
        */
        private $db;
        private $id;
        private $username;
        private $password;
        private $role;
        private $budget;
        private $photo;
        private $name;
        public function __construct()
        {              
            parent::__construct();
            $this->db = new Database();
            $this->id = 0;
            $this->username = '';
            $this->password = '';
            $this->role = '';
            $this->budget = 0.0;
            $this->photo = '';
            $this->name = '';
        }

        public function save(){
            try {
                $sql = "INSERT into users(id ,username, password, role, budget, photo, name) values(null ,? , ? , ? , ?, ? , ? )";
                $query = $this->prepare($sql);
                $ok = mysqli_stmt_bind_param($query , 'sssdss' , $this->username, $this->password, $this->role, $this->budget, $this->photo, $this->name);
                // error_log($this->db);
                $ok = $this->query_execute($query);
                $this->close($query);
                return true;
            } catch (Throwable $th) {
                error_log("el ERROR ESTA EN :: ->" . $th);
                return false;
            }
        } 
        public function getAll(){
            $items = [];
            try {
                $sql = "SELECT * from users";
                $query = $this->prepare($sql);
                $ok = $this->query_execute($query);

                $ok = mysqli_stmt_bind_result($query, $this->id, $this->username, $this->password , $this->role, $this->budget, $this->photo, $this->name);
                while ($p = mysqli_stmt_fetch($query)) {
                    $item = new UserModel();
                    $item->setId($p['id']);
                    $item->setUsername($p['username']);
                    $item->setPassword($p['password']);
                    $item->setRole($p['role']);
                    $item->set->setBudget($p['budget']);
                    $item->setPhoto($p['photo']);
                    $item->setName($p['name']);

                    array_push($items, $item);
                } 

                return $items;
            } catch (Throwable $th) {
                error_log('USERMODEL::getALL->exception ' . $th);
            }
        }
        
        public function get($id){
            try{
                $sql = "SELECT * from users where id = ?";
                $query = $this->prepare($sql);
                $ok = mysqli_stmt_bind_param($query, 'i' , $id);

                $ok = $this->query_execute($query);
                $ok = mysqli_stmt_bind_result($query, $this->id , $this->username , $this->password , $this->role, $this->budget, $this->photo, $this->name);

                $this->setId($this->id);
                $this->setUsername($this->username);
                $this->setPassword($this->password);
                $this->setRole($this->role);
                $this->setBudget($this->budget);
                $this->setPhoto($this->photo);
                $this->setName($this->name);
                
                return $this;
            }catch(Throwable $th){
                error_log('USERMODEL::getId->exception .' . $th);
            }
        }
        public function delete($id){
            try{
                $sql = "DELETE from users where id = ?";
                $query = $this->prepare($sql);
                $ok = mysqli_stmt_bind_param($this->db , 'i' , $id);
                $ok = $this->query_execute($query);
                if($ok === true){
                    return true ;
                }else{
                    return false;
                }
            }catch(Throwable $th){
                error_log('USERMODEL::delete->exception .' . $th);
                return false;
            }
        }
        public function update(){
            try{
                $sql = "UPDATE SET username = ? , password = ?, budget = ? , photo = ? , name = ? where id = ?";
                $query = $this->prepare($sql);
                $ok = mysqli_stmt_bind_param($this->db, 'ssdssi' , $this->username , $this->password , $this->budget, $this->photo , $this->name, $this->id);

                $ok = $this->query_execute($query);
        
                return true;
            }catch(Throwable $th){
                error_log('USERMODEL::getId->exception .' . $th);
                return false;
            }
        }
        public function from($array){
            $this->id       = $array[0]['id'];
            $this->username = $array[0]['username'];
            $this->password = $array[0]['password'];
            $this->role     = $array[0]['role'];
            $this->budget   = $array[0]['budget'];
            $this->photo    = $array[0]['photo'];
            $this->name     = $array[0]['name'];
        }


        public function exists($username){
            try{
                $sql = 'SELECT username from users where username = ?';
                $query = $this->prepare($sql);
                // var_dump($this->db->connect());
                $ok = mysqli_stmt_bind_param($query, 's' , $username);
                $ok = $this->query_execute($query);
                $ok = mysqli_stmt_fetch($query);

                if($ok){
                    return true;
                }else{
                    return false;
                }
            }catch(Throwable $th){
                error_log('USERMODEL::exists->exception ' . $th);
                return false;
            }
        }

        public function comparePasswords($password , $id){
            try{
                $user = $this->get($id);

                return password_verify($password , $user->getPassword());
            }catch(Throwable $th){
                error_log('USERMODEL::comparePasswords->exception' . $th);
                return false;
            }
        }
        /********* voy a declarar los metodos getters y setters */
        //id
        private function getHashedPassword($password){
            return password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function getId()
        {
            return $this->id;
        }

        //username
        public function setUsername($username)
        {
            $this->username = $username;
        }
        public function getUsername()
        {
            return $this->username;
        }

        //password

        public function setPassword($password)
        {
            $this->password = $this->getHashedPassword($password);
        }
        public function getPassword()
        {
            return $this->password;
        }

        //role
        public function setRole($role)
        {
            $this->role = $role;
        }

        public function getRole()
        {
            return $this->role;
        }
        //budget
        public function setBudget($budget)
        {
            $this->budget = $budget;
        }

        public function getBudget()
        {
            return $this->budget;
        }
        //photo

        public function setPhoto($photo)
        {
            $this->photo = $photo;
        }

        public function getPhoto()
        {
            return $this->photo;
        }
        //name

        public function setName($name) { $this->name = $name; }
        public function getname() { return $this->name;}

    }