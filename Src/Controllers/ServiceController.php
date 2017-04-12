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
            $this->displayservices();
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
                case 'displayAllServices':
                    $this->displayAllServices();
                    return;
                case 'deleteUserService':
                    $this->deleteUserService();
                    return;
                case 'updateService':      
                    $this->updateService();
                    return;
                case 'updateInfoService':
                    $this->updateInfoService();
                    return;    
                case 'deleteService':
                    $this->deleteService();
                    return; 
                case 'newService':
                    $this->newService();
                    return;
                case 'addService':
                    $this->addService();
                    return; 
                case 'displayUsers':
                    $this->displayUsers();
                    return;                 
            }
        }
    }

    public function displayServices(){

        if(!isset($_SESSION['User'])){
            header('Location: /Login');
        }else{    
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
                    $now = new DateTime();
                    if( $now->getTimestamp() < $date_e->getTimestamp() ){
                        array_push($data["services"],get_object_vars($service));
                    }    
                    
                }

            }

            $view = new View("services", $data);
            $view->setTitle("services");
            $view->show();
        }    
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
          $service["not_registred"]=False;  
        }else{
          $service["is_registred"]=False;
          $service["not_registred"]=True; 
        }       

        $date_s = $obj->DateStart();
        $date_s = $date_s->format("d/m/Y");

        $date_e = $obj->DateEnd();
        $date_e = $date_e->format("d/m/Y");

        $service["date_s"]=$date_s;
        $service["date_e"]=$date_e;

        array_push($data["service"],$service);

        // ajout du fait que l'user qui a créé le service a les droits d'administration dessus
        if($obj->UserId() == $_SESSION["User"])
        {
            $data["admin"] = true;
            $data["user"] = false;
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
        $user_service->setUserId($user_id);
        $user_service->setServiceId($service_id);
        
        $storage->persist($user_service);
        $storage->flush();


        header('Location: /Service?action=displayService&serviceId='.$service_id);
    }

    public function DeleteUserService(){

        $data = Utils::SessionVariables();
        $service_id = $_GET['serviceId'];
        $user_id = $_SESSION['User'];
        $storage = Engine::Instance()->Persistence("DatabaseStorage");
        $user_services = null;
        $storage->findAll("UserService", $user_services, "user_id = '".$user_id."' AND service_id='".$service_id."'");
        foreach ($user_services as $us)
        {
            $storage->remove($us);
        }
        $storage->flush();
        header('Location: /Service?action=displayService&serviceId='.$service_id);
    }    

    public function displayAllServices(){
        $services = NULL;
        $data = Utils::SessionVariables();
        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("Service",$services);

        $data["services"] = array();
        foreach ($services as $service) {

            $date_e = $service->DateEnd();
            $now = new DateTime();
            if( $now->getTimestamp() < $date_e->getTimestamp() ){
                array_push($data["services"],get_object_vars($service));
            }  
        }

        $view = new View("services", $data);
        $view->setTitle("services");
        $view->show();
    }

   public function deleteService(){
        if(isset($_GET['serviceId'])){
            $service_id = $_GET['serviceId'];
            $storage = Engine::Instance()->Persistence("DatabaseStorage");
            $service = new Service($storage, $service_id);
            $storage->remove($service);
            $storage->flush();
            header('Location: /Service?action=displayAllServices');
        }else{
            header('Location: /Service?action=displayAllServices');
        }
   }
   public function updateService(){

        $service_id = $_GET['serviceId'];
        $servicestatus=NULL;
        $storage = Engine::Instance()->Persistence("DatabaseStorage");
        $service = new Service($storage, $service_id);
        $service = $storage->find($service);
        $condition = "service_id = ".$service_id;
        $storage->findAll("ServiceStatus",$servicestatus,$condition);
        $data=array();
        $data = Utils::SessionVariables();
        $data["status"] = array();
        $status=NULL;
        $storage->findAll("Status",$status);

        foreach($status as $statut)
        {
            $vars = get_object_vars($statut);
            $vars["checked"] = "";
            $vars["disabled"] = "";
            foreach ($servicestatus as $servicestatut)
            {
                if($statut->Id() == $servicestatut->StatusId())
                {
                    $vars["checked"] = "checked";
                    $vars["disabled"] = "disabled readonly";
                }
            }
            array_push($data["status"], $vars);
        }


        $data["service_name"] = $service->Name();
        $data["service_id"] = $service->Id();
        $data["service_description"] = $service->Description();
        $data["service_date_start"] = $service->DateStart()->format('d/m/Y');;

        $category = new Category($storage, $service->CategoryId());
        $category = $storage->find($category);
        $data["service_category_id"] = $category->Name();

        $data["service_date_end"] = $service->DateEnd()->format('d/m/Y');;
        $view = new View("updateService",$data);
        $view->setTitle("updateService");
        $view->show();
   }

   public function updateInfoService(){
        if(isset($_GET['serviceId'])){
            $service_id = $_GET['serviceId'];
            $storage = Engine::Instance()->Persistence("DatabaseStorage");
            $service = new Service($storage, $service_id);
            $service= $storage->find($service);
            $name=$_POST['name'];
            $description=$_POST['description'];
            $date_end_string=$_POST['date_end'];
            $date_end = date_create_from_format('d/m/Y', $date_end_string);
            $service->setName($name);
            $service->setDescription($description);
            $service->setDateEnd($date_end);
            $storage->persist($service, $state= StorageState::ToUpdate);
            $status = null;
            $storage->findAll("Status", $status);
            foreach ($status as $statut)
            {
                if(isset($_POST["Statut_".$statut->Id()]))
                {
                    $link = new ServiceStatus($storage);
                    $link->setServiceId($service->Id());
                    $link->setStatusId($statut->Id());
                    $storage->persist($link);
                }
            }
            $storage->flush();
            header('Location: /Service?action=displayService&serviceId='.$service_id);
        }else{
            header('Location: /Service?action=displayService&serviceId='.$service_id);
        } 
   }

   public function newService(){
    
        $categorys = NULL;
        $statuss = NULL;
        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("Category",$categorys);
        $data = array();
        $data = Utils::SessionVariables();
        $data["categorys"] = array();
        foreach ($categorys as $entry) {
            array_push($data["categorys"],get_object_vars($entry));
        }
        $storage=Engine::Instance()->Persistence("DatabaseStorage")->findAll("Status",$statuss);
        $data["statuss"] = array();
        foreach ($statuss as $entry) {
            array_push($data["statuss"],get_object_vars($entry));
        }
        $view = new View("newService",$data);
        $view->setTitle("newService");
        $view->show();
    }

   public function addService(){
        if(isset($_POST["name"]))
            $name = $_POST["name"];
        if(isset($_POST["description"]))
            $description = $_POST["description"];
        if(isset($_POST["category"]))
            $category = $_POST["category"];
        if(isset($_POST["date_start"]))
            $date_start_string = $_POST["date_start"];
        if(isset($_POST["date_end"]))
            $date_end_string = $_POST["date_end"];

        $date_start = new DateTime();
        $date_start = date_create_from_format('Y-m-d', $date_start_string);
        $date_end = new DateTime();
        $date_end = date_create_from_format('Y-m-d', $date_end_string);

        $storage = Engine::Instance()->Persistence("DatabaseStorage");
        $service = new Service($storage);
        $service->setName($name);
        $service->setDescription($description);
        $service->setCategoryId($category);
        $service->setDateStart($date_start);
        $service->setDateEnd($date_end);
        $service->setUserId($_SESSION["User"]);
        $storage->persist($service);
        $storage->flush();

        $status = null;
        $storage->findAll("Status", $status);
        foreach ($status as $statut)
        {
            if(isset($_POST["Statut_".$statut->Id()]))
            {
                $link = new ServiceStatus($storage);
                $link->setServiceId($service->Id());
                $link->setStatusId($statut->Id());
                $storage->persist($link);
            }
        }
        $storage->flush();

        header('Location: /Service?action=displayAllServices');
   }  

   public function displayUsers(){

        $service_id = $_GET['serviceId'];
        $users_id = NULL;
        $service=NULL;
        $storage = Engine::Instance()->Persistence("DatabaseStorage");
        $condition = "service_id = ".$service_id;
        $storage->findAll("UserService",$users_id,$condition);
        $service = new Service($storage,$service_id);
        $storage->find($service);
        $name=$service->Name();
        $data=array();
        $data = Utils::SessionVariables();
        $data["id"] = $service_id;
        $data["name"] = $name;
        $data["users"] = array();
        foreach ($users_id as $user_id) {
            $user=NULL;
            $user=$user_id->User();
            array_push($data["users"],get_object_vars($user));     
        }
        $view = new View("userService",$data);
        $view->setTitle("userService");
        $view->show();

   }   

}