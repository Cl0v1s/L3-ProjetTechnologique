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
                case 'displayService':
                    $this->displayService();
                    return;
                case 'registerService':
                    $this->registerService();
                    return;    
            }
        }
    }

    public function displayServices(){
     
        $data = Utils::SessionVariables();
        $user_id = $_SESSION['User'];
        $storage = Engine::Instance()->Persistence("DatabaseStorage");
        $condition = "user_id = ".$user_id; 
        $Status = NULL;
        $storage->findAll("UserStatus",$Status,$condition);
        foreach ($Status as $status) {
            $services_id=NULL;
            $status_id=$status->StatusId();
            $condition = "status_id = ".$status_id;
            $storage->findAll("ServiceStatus",$services_id,$condition);
            $data["services"] = array();
            foreach ($services_id as $service_id){

                $service=$service_id->Service();
                $date_e = $service->DateEnd();
                $date_e = $date_e->format('d-m-Y');
                $now = date('d-m-Y');
                $now = new DateTime($now);
                $now = $now->format('d-m-Y');
                if( $now < $date_e ){ 
                    array_push($data["services"],get_object_vars($service));
                }    
                
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

    public function displayService(){

        $data = Utils::SessionVariables();
        $service_id = $_GET['serviceId'];
        $storage = Engine::Instance()->Persistence("DatabaseStorage");
        $service = new Service($storage, $service_id);
        $obj = $storage->find($service);
        
        $user_id = $_SESSION['User'];
        $condition="user_id='".$user_id."' AND service_id='".$service_id."'";
    
        $is_registred = NULL;
        $storage->findAll("UserService",$is_registred,$condition);

        $data["service"]=array();
        $service = get_object_vars($obj);
        if($is_registred==NULL){
          $service["is_registred"]=True;  
        }else{
          $service["is_registred"]=False; 
        }       

        $date_s = $obj->DateStart();
        $date_s = $date_s->format('d-m-Y à H:i');

        $date_e = $obj->DateEnd();
        $date_e = $date_e->format('d-m-Y à H:i');

        $service["date_s"]=$date_s;
        $service["date_e"]=$date_e;

        array_push($data["service"],$service);

        
        if(isset($_SESSION["Admin"])){
            $data["admin"] = true;
        }else{
             $data["admin"] = false;
        }

        $view = new View("service", $data);
        $view->setTitle("service");
        $view->show();

    }

    public function registerService(){

        $data = Utils::SessionVariables();
        $service_id = $_GET['serviceId'];
        $user_id = $_SESSION['User'];
        $storage = Engine::Instance()->Persistence("DatabaseStorage");        
        $user_service = new UserService($storage);
        $user_service->setUserId($service_id);
        $user_service->setServiceId($user_id);
        
        $storage->persist($user_service);
        $storage->flush();


        if(isset($_SESSION["Admin"])){
            $data["admin"] = true;
        }else{
             $data["admin"] = false;
        }

        header('Location: /Service?action=displayService&serviceId='.$service_id);
    }
    
}