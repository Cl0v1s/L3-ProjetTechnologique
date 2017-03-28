<?php
include_once "Core/Controller.php";


class AdminController extends Controller
{
    function __construct($params)
    {
       parent::__construct($params);
    }
    public function run($ctx)
    {
        if(!isset($_SESSION["Admin"])){
            header('Location: /Default');
        }
        if(!isset($_GET["action"])){
            $this->displayAdmin();
        }else{
            $action = $_GET["action"];
            switch($action){
                case 'displayCreateSubject':
                    return $this->displayCreateSubject();
                case 'createSubject':
                    return $this->createSubject();
                case 'displayDeleteSubject':
                    return $this->displayDeleteSubject();
                case 'deleteSubject':
                    return $this->deleteSubject();
            }
        }
    }
    
    public function displayAdmin(){
        $view = new View("admin");
        $view->setTitle("admin");
        $view->show();
    }

    public function displayCreateSubject(){
        $view = new View("createSubject");
        $view->setTitle("createSubject");
        $view->show();
    }

    public function createSubject(){
        if(isset($_POST['name'])){
            $name = $_POST['name'];
            $storage = Engine::Instance()->Persistence("DatabaseStorage");
            $subject = new Subject($storage);
            $subject->SetName($name);
            $storage->persist($subject);
            $storage->flush();
            header('Location: /Admin');
        }else{
            header('Location: /Admin');
        }
    }

    public function displayDeleteSubject(){
        $subjects = NULL;
        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("Subject",$subjects);
        $data["subjects"] = array();
        foreach ($subjects as $subject) {
            array_push($data["subjects"],get_object_vars($subject));
        }
        $view = new View("deleteSubject",$data);
        $view->setTitle("deleteSubject");
        $view->show();
    }

    public function deleteSubject(){
        if(isset($_POST['subjectId'])){
            $subject_id = $_POST['subjectId'];
            $subject = new Subject($storage, $subject_id);
            $subject = $storage->find($subject);
            $storage->remove($subject);
            $storage->flush();
            header('Location: /Admin');
        }else{
            header('Location: /Admin');
        }
    }
}