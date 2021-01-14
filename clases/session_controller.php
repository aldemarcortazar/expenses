<?php

require_once 'clases/sesion.php';
require_once 'models/usermodel.php';
class sessionController extends Controller{
    private $userSesssion;
    private $username;
    private $userid;
    private $session;
    private $sites;
    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->init();
    }

    function init(){
        $this->session = new Session();

        $json = $this->getJSONFIleConfig();

        $this->sites = $json['sites'];
        $this->defaultSites = $json['default-sites'];

        $this->validateSession();
    }

    private function getJSONFileConfig(){
        $string = file_get_contents("config/access.json");
        $json = json_decode($string , true);
        return $json;
    }


    public function validateSession(){
        error_log('SESSIONCONTROLLER::validateSession');

        if($this->existsSession()){
            // si existe sesion
            $role = $this->getUserSessionData()->getRole();
            // vvalidar sin la pagina a entrar es publica

            if($this->isPublic()){
                $this->redirectDefaultSiteByRole($role);
            }else{
                if($this->isAuthorized($role)){
                    //lo dejo pasar
                }else{
                    $this->redirectDefaultSiteByRole($role);
                }
            }
        }else{
            // no existe sesion
            if($this->isPublic()){
                // no hago nada lo dejo pasar
            }else{
                header('location: ' . constant('URL') . '');
            }
        }
    }

    function existsSession(){
        if(!$this->session->exists()) return false;
        if($this->session->getCurrentUser() == null) return false;

        $userid = $this->session->getCurrentUser();
        if($userid) return true;

        return false;
    }

    function getUserSessionData(){
        $id = $this->session->getCurrentUser();
        $this->user = new UserModel();
        $this->user->get($id);
        error_log('SESSIONCOntroller::getUserSessionData ->' .$this->user->getUsername());
        return $this->user;
    }

    function isPublic(){
        $currentURL = $this->getCurrentPage();
        $currentURL = preg_replace("/\?.*/" , "" , $currentURL);


        for($i = 0 ; $i < sizeof($this->sites); $i++){
            if($currentURL == $this->sites[$i]['site'] && $this->sites[$i]['access'] == 'public'){
                return true;
            }
        }
        return false;
    }

    function getCurrentPage(){
        $actualLink = trim("$_SERVER[REQUEST_URI]");
        $url = explode('/' , $actualLink);
        error_log('SESSIONCONTROLLER::getcurrentPage -> ' . $url[2]);
        return $url[2];
    }

    private function redirectDefaultSiteByRole($role){
        $url = '';
        for($i = 0 ; $i < sizeof($this->sites); $i++){
            // donde voy a redirigirsegun el rol

            if($this->sites[$i]['role'] == $role){
                $url = '/expenses/' . $this->sites[$i]['site'];
                error_log('estoy en redirectDefaultByRole y esto da ' . $url);
            break;
            }
        }
        header('location:' . constant('URL') . $url);
    }
    private function isAuthorized($role){
     $currentURL = $this->getCurrentPage();
     $currentURL = preg_replace("/\?.*/" , "" , $currentURL);
     
     for($i = 0; $i <sizeof($this->sites); $i++){
         if($currentURL == $this->sites[$i]['site'] && $this->sites[$i]['role'] == $role){
            return true;
         }
     }
     return false;
    }

    function initialize($user){
        $this->session->setCurrentUser($user->getId());
        $this->authorizedAcces($user->getRole());
    }
    function authorizedAcces($role){
        switch($role){
            case 'user':
                $this->redirect($this->defaultSites['user'] , []);
            break;
            case 'admin':
                $this->redirect($this->defaultSites['admin'], []);
        }
    }

    function logout(){
        $this->session->closeSession();
    }
}
?>