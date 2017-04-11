<?php

include_once "Core/Controller.php";

/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 22/01/17
 * Time: 16:15
 */
class RegisterController extends Controller
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
            $this->display();
        }else{
            $action = $_GET["action"];
            switch($action){
                case 'newRegister':
                    $this->newRegister();
                    return;
            }
        }
    }

    public function display(){
        $data = Utils::SessionVariables();
        $view = new View("register",$data);
        $view->setTitle("register");
        $view->show();
    }
    
    public function newRegister(){
        if(isset($_POST["firstname"]))
            $firstname = $_POST["firstname"];
        if(isset($_POST["lastname"]))
            $lastname = $_POST["lastname"];
        if(isset($_POST["password"]))
            $password = $_POST["password"];
        if(isset($_POST["password_confirm"]))
            $password_confirm = $_POST["password_confirm"];
        if($password == $password_confirm)
        {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $storage = Engine::Instance()->Persistence("DatabaseStorage");
            $user = new User($storage);
            $username = $firstname.".".$lastname;
            $user->setFirstName($firstname);
            $user->setLastName($lastname);
            $user->setPassword($password);
            $user->setUserName($username);
            $user->setIsadmin(0);
            $user->setIsbanned(0);
            $storage->persist($user);
            $storage->flush();
            $_SESSION["User"] = $user->Id();
            header('Location: /Default');
        }else{
            header('Location: /Register');
        }
    }
}