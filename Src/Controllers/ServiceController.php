<?php
include_once "Core/Controller.php";
/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 22/01/17
 * Time: 16:15
 */
class ServiceController extends Controller
{
    function __construct($params)
    {
       parent::__construct($params);
    }
    public function run($ctx)
    {
        if(!isset($_GET["action"])){
            $this->displayQuestions();
        }else{
            $action = $_GET["action"];
            switch($action){
                case 'displayServices':
                    $this->displayServices();
                    return;
            }
        }
    }

    public function displayServices(){
        $services = NULL;
        $data = Utils::SessionVariables();
        $user_id = $_SESSION['User'];
        $storage = Engine::Instance()->Persistence("DatabaseStorage");
        $user = new User($storage, $user_id);
        $user = $storage->find($user);
        $statuss=$user->Status();
        $data["services"] = array();
        foreach ($statuss as $status) {
            $servicesstatus = NULL;
            $status_id=$status->Id();
            $condition = "id = ".$status_id;
            $storage->findAll("ServiceStatus",$servicesstatus,$condition);
            foreach ($servicesstatus as $servicestatus) {
                $service_id=$servicestatus->ServiceId();
                $service=NULL;
                $condition = "id = ".$service_id;
                $storage->findAll("Service",$service,$condition);
                array_push($data["services"],$service);
            }      
        }

        if(isset($_SESSION["Admin"])){
            $data["admin"] = true;
        }else{
             $data["admin"] = false;
        }

        $view = new View("services", $data);
        $view->setTitle("services");
        $view->show();
    }
    
}