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
                case 'displayBanUser':
                    return $this->displayBanUser();
                case 'banUser':
                    return $this->banUser();
                case 'validateQuestion':
                    return $this->validateQuestion();
                case 'validateResponse':
                    return $this->validateResponse();
            }
        }
    }
    
    public function displayAdmin(){
        $data = Utils::SessionVariables();
        $questions = NULL;
        $condition = "reported = 1";
        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("Question",$questions,$condition);
        $data["questions"] = array();
        foreach ($questions as $question) {
            $responsevalues = get_object_vars($question);
            $subject = new Subject($storage);
            $subject = $question->Subject();
            $responsevalues["subject_id"] = $subject->Id();
            array_push($data["questions"],$responsevalues);
        }

        $responses = NULL;
        $condition = "reported = 1";
        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("Response",$responses,$condition);
        $data["responses"] = array();
        foreach ($responses as $response) {
            $responsevalues = get_object_vars($response);
            $question = new Question($storage);
            $question = $response->Question();
            $subject = new Subject($storage);
            $subject = $question->Subject();
            $responsevalues["question_id"] = $question->Id();
            $responsevalues["subject_id"] = $subject->Id();
            array_push($data["responses"],$responsevalues);
        }
        $info = $_GET["info"];
        if($info === "NULL"){
            $info = "";
        }
        if($info === "SubjectCreated"){
            $info = "Le sujet a bien été créé.";
        }
        if($info === "ErrorCreationSubject"){
            $info = "Erreur création : nom de sujet invalide.";
        }
        if($info === "SubjectDeleted"){
            $info = "Le sujet a bien été supprimé.";
        }
        if($info === "QuestionDeleted"){
            $info = "La question a bien été supprimée.";
        }
        if($info === "ResponseDeleted"){
            $info = "La réponse a bien été supprimée.";
        }
        if($info === "UserBanned"){
            $info = "L'utilisateur a bien été banni.";
        }

        $data["info"] = $info;
        $view = new View("admin",$data);
        $view->setTitle("admin");
        $view->show();
    }

    public function displayCreateSubject(){
        $data = Utils::SessionVariables();
        $view = new View("createSubject",$data);
        $view->setTitle("createSubject");
        $view->show();
    }

    public function createSubject(){
        if(isset($_POST['name'])){
                $name = $_POST['name'];
            if($name !== ""){
                $storage = Engine::Instance()->Persistence("DatabaseStorage");
                $subject = new Subject($storage);
                $subject->SetName($name);
                $storage->persist($subject);
                $storage->flush();
                header('Location: /Admin&info=SubjectCreated');
            }else{
                header('Location: /Admin&info=ErrorCreationSubject');
            }
        }else{
            header('Location: /Admin&info=ErrorCreationSubject');
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
            header('Location: /Admin&info=SubjectDeleted');
        }else{
            header('Location: /Admin&info=NULL');
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
            header('Location: /Admin&info=QuestionDeleted');
        }else{
            header('Location: /Admin&info=NULL');
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
            header('Location: /Admin&info=ResponseDeleted');
        }else{
            header('Location: /Admin&info=NULL');
        }
    }

    public function displayBanUser(){
        $data = Utils::SessionVariables();
        $users = NULL;
        $condition = "isbanned = 0";
        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("User",$users,$condition);
        $data["users"] = array();
        foreach ($users as $user) {
            array_push($data["users"],get_object_vars($user));
        }
        $view = new View("banuser",$data);
        $view->setTitle("banuser");
        $view->show();

    }

    public function banUser(){
        $data = Utils::SessionVariables();
        $user_id = $_GET['userId'];
        $storage = Engine::Instance()->Persistence("DatabaseStorage");
        $user = new User($storage, $user_id);
        $user = $sotrage->find($user);
        $user->setIsbanned(1);
        $storage->persist($user, $state = StorageState::ToUpdate);
        $storage->flush();
        $users = NULL;
        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("User",$users,NULL);
        $data["users"] = array();
        foreach ($users as $user) {
            array_push($data["users"],get_object_vars($user));
        }
        header('Location : /Admin&info=UserBanned');
    }

    public function validateQuestion(){
        $data = Utils::SessionVariables();
        if(isset($_GET['questionId']) && isset($_GET['subjectId'])){
            $subject_id =  $_GET['subjectId'];
            $question_id = $_GET['questionId'];
            $storage = Engine::Instance()->Persistence("DatabaseStorage");
            $question = new Question($storage, $question_id);
            $question = $storage->find($question);
            $question->setReported(2);
            $storage->persist($question, $state = StorageState::ToUpdate);
            $storage->flush();
            header('Location: /Question?action=displayQuestionContent&subjectId='.$subject_id.'&questionId='.$question_id.'&info=QuestionValidated');
        }else{
            header('Location: /Question?action=displayQuestionContent&subjectId='.$subject_id.'&questionId='.$question_id.'&info=NULL');
        }
    }

    public function validateResponse(){
        $data = Utils::SessionVariables();
        if(isset($_GET['responseId']) && isset($_GET['questionId']) && isset($_GET['subjectId'])){
            $subject_id =  $_GET['subjectId'];
            $question_id = $_GET['questionId'];
            $response_id = $_GET['responseId'];
            $storage = Engine::Instance()->Persistence("DatabaseStorage");
            $response = new Response($storage, $response_id);
            $response = $storage->find($response);
            $response->setReported(2);
            $storage->persist($response, $state = StorageState::ToUpdate);
            $storage->flush();
            header('Location: /Question?action=displayQuestionContent&subjectId='.$subject_id.'&questionId='.$question_id.'&info=ResponseValidated');
        }else{
            header('Location: /Question?action=displayQuestionContent&subjectId='.$subject_id.'&questionId='.$question_id.'&info=NULL');
        }
    }
}