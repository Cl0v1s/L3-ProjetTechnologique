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
        $info = $_GET['info'];
        if($info === "ErrorPassword"){
            $info = "Erreur: les mots de passes ne sont pas identiques";
        }
        else if($info === "ErrorContact")
        {
            $info = "Erreur: vous devez communiquer au moins un moyen de vous contacter.";
        }
        else if($info === "ErrorEmpty")
        {
            $info = "Erreur: Au moins un des champs requis est vide.";
        }
        if($info === "NULL"){
            $info = "";
        }
        $data['info'] = $info;
        $allstatus=NULL;
        $storage = Engine::Instance()->Persistence("DatabaseStorage");
        $storage->findAll("Status",$allstatus);
        $data["status"] = array();
        foreach ($allstatus as $status){
            array_push($data["status"],get_object_vars($status));
        }
        $view = new View("register",$data);
        $view->setTitle("register");
        $view->show();
    }
    
    public function newRegister(){
        if(isset($_POST["firstname"]) ==  false || strlen($_POST["firstname"]) <=0 || isset($_POST["lastname"]) ==  false || strlen($_POST["lastname"]) <=0 || isset($_POST["password"]) == false || strlen($_POST["password"]) <=0 || isset($_POST["password_confirm"]) == false || strlen($_POST["password_confirm"]) <=0)
        {
            header('Location: /Register?info=ErrorEmpty');
            return;
        }
        if((isset($_POST["email"]) == false || strlen($_POST["email"]) <= 0 ) && (isset($_POST["phone"]) ==  false || strlen($_POST["phone"]) <= 0))
        {
            header('Location: /Register?info=ErrorContact');
            return;
        }

        if(isset($_POST["firstname"]))
            $firstname = Utils::MakeTextSafe($_POST["firstname"]);
        if(isset($_POST["lastname"]))
            $lastname = Utils::MakeTextSafe($_POST["lastname"]);
        if(isset($_POST["password"]))
            $password = Utils::MakeTextSafe($_POST["password"]);
        if(isset($_POST["password_confirm"]))
            $password_confirm = Utils::MakeTextSafe($_POST["password_confirm"]);

        $email = "N/A";
        if(isset($_POST["email"]))
        {
            $email = Utils::MakeTextSafe($_POST["email"]);
        }

        $phone = "N/A";
        if(isset($_POST["phone"]))
        {
            $phone = Utils::MakeTextSafe($_POST["phone"]);
        }

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
            $user->setEmail($email);
            $user->setPhone($phone);
            $storage->persist($user);
            $storage->flush();
            $_SESSION["User"] = $user->Id();
            $status = null;
            $storage->findAll("Status", $status);
            foreach ($status as $statut)
            {
                if(isset($_POST["Statut_".$statut->Id()]))
                {
                    $link = new UserStatus($storage);
                    $link->setUserId($user->Id());
                    $link->setStatusId($statut->Id());
                    $storage->persist($link);
                }
            }
            header('Location: /Default');
        }else{
            header('Location: /Register?info=ErrorPassword');
        }
    }
}