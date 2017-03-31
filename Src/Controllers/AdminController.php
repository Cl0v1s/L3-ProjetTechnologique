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
                case 'displayDeleteQuestion':
                    return $this->displayDeleteQuestion();
                case 'deleteQuestion':
                    return $this->deleteQuestion();
                case 'displayDeleteResponse':
                    return $this->displayDeleteResponse();
                case 'deleteResponse':
                    return $this->deleteResponse();

            }
        }
    }
    
    public function displayAdmin(){
        $data = Utils::SessionVariables();
        $view = new View("admin",$data);
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
        $data = Utils::SessionVariables();
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
        if(isset($_GET['subjectId'])){
            $subject_id = $_GET['subjectId'];
            $storage = Engine::Instance()->Persistence("DatabaseStorage");
            $subject = new Subject($storage, $subject_id);
            $subject = $storage->find($subject);
            $storage->remove($subject);
            $storage->flush();
            header('Location: /Admin');
        }else{
            header('Location: /Admin');
        }
    }

    public function displayDeleteQuestion(){
        $data = Utils::SessionVariables();
        $questions = NULL;
        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("Question",$questions);
        $data["questions"] = array();
        foreach ($questions as $question) {
            array_push($data["questions"],get_object_vars($question));
        }
        $view = new View("deleteQuestion",$data);
        $view->setTitle("deleteQuestion");
        $view->show();
    }

    public function deleteQuestion(){
        if(isset($_GET['questionId'])){
            $question_id = $_GET['questionId'];
            $storage = Engine::Instance()->Persistence("DatabaseStorage");
            $question = new Question($storage, $question_id);
            $subject = $storage->find($question);
            $storage->remove($question);
            $storage->flush();
            header('Location: /Admin');
        }else{
            header('Location: /Admin');
        }
    }

    public function displayDeleteResponse(){
        $data = Utils::SessionVariables();
        $subject_id = $_GET['subjectId'];
        $question_id = $_GET['questionId'];
        $response_id = $_GET['responseId'];

        $subjects = NULL;
        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("Subject",$subjects);
        $data["subjects"] = array();
        foreach ($subjects as $subject) {
            array_push($data["subjects"],get_object_vars($subject));
        }

        $questions = NULL;
        $condition = "subject_id = ".$subject_id;
        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("Question",$questions,$condition);
        $data["questions"] = array();
        foreach ($questions as $question) {
            array_push($data["questions"],get_object_vars($question));
        }

        $responses = NULL;
        $condition = "question_id = ".$question_id;
        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("Response",$responses,$condition);
        $data["responses"] = array();
        foreach ($responses as $response) {
            array_push($data["responses"],get_object_vars($response));
        }

        $data["subject_id"] = $subject_id;
        $data["question_id"] = $question_id;
        $data["response_id"] = $response_id;
        $view = new View("deleteResponse",$data);
        $view->setTitle("deleteResponse");
        $view->show();
    }

    public function deleteResponse(){
        if(isset($_GET['responseId'])){
            $response_id = $_GET['responseId'];
            $storage = Engine::Instance()->Persistence("DatabaseStorage");
            $response = new Response($storage, $response_id);
            $question = $storage->find($response);
            $storage->remove($response);
            $storage->flush();
            header('Location: /Admin');
        }else{
            header('Location: /Admin');
        }
    }
}