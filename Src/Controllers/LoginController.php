<?php

include_once "Core/Controller.php";

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 22/01/17
 * Time: 16:15
 */
class LoginController extends Controller
{

    function __construct($params)
    {
       parent::__construct($params);
    }

    public function run($ctx)
    {
        if(isset($_SESSION["User"])){
            header('Location: /Default');
        }
        if(!isset($_GET["action"])){
            $info = "";
            $this->display($info);
        }else{
            $action = $_GET["action"];
            switch($action){
                case 'login':
                    $this->login();
                    return;
                case 'logout':
                    $this->logout();
                    return;
            }
        }
    }
    
    public function display($info){
        $data = Utils::SessionVariables();
        $data["info"] = $info;
        $view = new View("login", $data);
        $view->setTitle("login");
        $view->show();
    }

    public function login(){
        if(isset($_POST["username"]))
            $username = $_POST["username"];
        if(isset($_POST["password"]))
            $password = $_POST["password"];
        $users = NULL;
        $condition = "username = '".$username."'";
        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("User",$users,$condition);
        if($users == NULL){
            $info="Cet identifiant n'existe pas.";
            $this->display($info);
        }
        foreach ($users as $user) {
            $hash = $user->Password();
            if (password_verify($password, $hash)) {
                // Success!
                if($user->Isbanned() == 0){
                    //User n'est pas banni
                    $_SESSION['User'] = $user->Id();
                    $isadmin = $user->Isadmin();
                    if($isadmin == 1){
                        $_SESSION['Admin'] = true;
                        header('Location: /Admin');
                    }else{
                        header('Location: /Default');
                    }
                }else{//User banni
                    $info="Cet utilisateur est banni !";
                    $this->display($info);
                }   
            } else {
                //mauvais mdp
                $info="Mot de passe incorrect.";
                $this->display($info);
            }
        }
    }

    public static function logout(){
        if(isset($_SESSION['User'])){
            session_unset();
            session_destroy();
        }
        header('Location: /Default');
    }
}