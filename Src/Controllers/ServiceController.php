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
                case 'reportService':
                    $this->reportService();
                    return;
                case 'validateService':
                    $this->validateService();
                    return;
            }
        }
    }


    public function validateService(){
        $data = Utils::SessionVariables();
        if(isset($_GET['serviceId']) || $_SESSION["Admin"] != true){
            $id = $_GET["serviceId"];
            $storage = Engine::Instance()->Persistence("DatabaseStorage");
            $service = new Service($storage, $id);
            $service = $storage->find($service);
            $service->setReported(2);
            $storage->persist($service, StorageState::ToUpdate);
            $storage->flush();
            $str = urlencode("Le service a bien été validé.");
            header('Location: /Service?action=displayService&info='.$str.'&serviceId='.$id);
        }else{
            header('Location: /Default');
        }
    }

    public function reportService(){
        $data = Utils::SessionVariables();
        if(isset($_GET['serviceId'])){
            $id = $_GET["serviceId"];
            $storage = Engine::Instance()->Persistence("DatabaseStorage");
            $service = new Service($storage, $id);
            $service = $storage->find($service);
            if($service->Reported()==0){
                $service->setReported(1);
                $storage->persist($service, StorageState::ToUpdate);
                $storage->flush();
            }
            $str = urlencode("Le service a bien été signalé.");
            header('Location: /Service?action=displayService&info='.$str.'&serviceId='.$id);
        }else{
            header('Location: /Default');
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
            $data["services"] = array();
            foreach ($Status as $status) {
                $services_id=NULL;
                $status_id=$status->StatusId();
                $condition = "status_id = ".$status_id;
                $storage->findAll("ServiceStatus",$services_id,$condition);
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
            $view->setTitle("Services concernés");
            $view->show();
        }    
    }

    public function displayService(){

        $info = "";
        if(isset($_GET["info"]))
            $info = $_GET["info"];
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

        $category = new Category($storage, $obj->CategoryId());
        $category = $storage->find($category);
        $service["category"] = $category->Name();

        array_push($data["service"],$service);

        // ajout du fait que l'user qui a cr?? le service a les droits d'administration dessus
        if($obj->UserId() == $_SESSION["User"])
        {
            $data["admin"] = true;
            $data["user"] = false;
        }

        $data["info"] = $info;
        $view = new View("service", $data);
        $view->setTitle("Détails Service");
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
        $view->setTitle("Tout les services");
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

       $info = "";
       if(isset($_GET["info"]))
           $info = $_GET["info"];
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
        $data["info"] = $info;
        $view = new View("updateService",$data);
        $view->setTitle("Modifier un service");
        $view->show();
   }

   public function updateInfoService(){
        if(isset($_GET['serviceId'])){
            if(isset($_POST["name"]) == false || isset($_POST["description"]) == false  || isset($_POST["date_end"]) == false)
            {
                $str = urlencode("Au moins un des champs est vide.");
                header("Location: /Service?action=updateService&serviceId=".$_GET['serviceId']."&info=".$str);
                return;
            }

            $ddend = explode("/", $_POST['date_end']);
            if(count($ddend) != 3 || strlen($ddend[0]) != 2 || strlen($ddend[1]) != 2 || strlen($ddend[2]) != 4)
            {
                $str = urlencode("Le format de la date de fin est incorrect.");
                header("Location: /Service?action=updateService&serviceId=".$_GET['serviceId']."&info=".$str);
                return;
            }

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
            $storage->persist($service, StorageState::ToUpdate);
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
            header('Location: /Default');
        } 
   }

   public function newService(){
        $info = "";
        if(isset($_GET["info"]))
            $info = $_GET["info"];

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
        $data["info"] = $info;
        $view = new View("newService",$data);
        $view->setTitle("Créer un serveur");
        $view->show();
    }

   public function addService(){
       if(isset($_POST["name"]) == false || isset($_POST["description"]) == false || isset($_POST["category"]) == false || isset($_POST["date_start"]) == false || isset($_POST["date_end"]) == false)
       {
           $str = urlencode("Au moins un des champs est vide.");
           header("Location: /Service?action=newService&info=".$str);
           return;
       }
            $name = $_POST["name"];
            $description = $_POST["description"];
            $category = $_POST["category"];
            $date_start_string = $_POST["date_start"];
            $date_end_string = $_POST["date_end"];

       $ddend = explode("/", $date_start_string);
       if(count($ddend) != 3 || strlen($ddend[0]) != 2 || strlen($ddend[1]) != 2 || strlen($ddend[2]) != 4)
       {
           $str = urlencode("Le format de la date de début est incorrect.");
           header("Location: /Service?action=newService&info=".$str);
           return;
       }

        $ddend = explode("/", $date_end_string);
        if(count($ddend) != 3 || strlen($ddend[0]) != 2 || strlen($ddend[1]) != 2 || strlen($ddend[2]) != 4)
        {
            $str = urlencode("Le format de la date de fin est incorrect.");
            header("Location: /Service?action=newService&info=".$str);
            return;
        }



        $date_start = date_create_from_format('d/m/Y', $date_start_string);
        $today = new DateTime();
        if($date_start->getTimestamp() < $today->getTimestamp())
        {
            $str = urlencode("La date de début doit au moins être aujourd'hui.");
            header("Location: /Service?action=newService&info=".$str);
            return;
        }

        $date_end = date_create_from_format('d/m/Y', $date_end_string);

       if($date_end->getTimestamp() < $today->getTimestamp() || $date_end->getTimestamp() < $date_start->getTimestamp())
       {
           $str = urlencode("La date de fin doit au moins être aujourd'hui et être supérieure à la date de début.");
           header("Location: /Service?action=newService&info=".$str);
           return;
       }

        $storage = Engine::Instance()->Persistence("DatabaseStorage");
        $service = new Service($storage);
        $service->setName(Utils::MakeTextSafe($name));
        $service->setDescription(Utils::MakeTextSafe($description));
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
        if($_SESSION["Admin"] == true)
            header('Location: /Service?action=displayAllServices');
        else
            header('Location: /Service?action=displayServices');
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