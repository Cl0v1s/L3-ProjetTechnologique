<?php
include_once "Core/Controller.php";
/**
 * Created by PhpStorm.
 * User: clovis
 * Date: 22/01/17
 * Time: 16:15
 */
class QuestionController extends Controller
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
                case 'displayCreateQuestion':
                    $this->displayCreateQuestion();
                    return;
                case 'createQuestion':
                    $this->createQuestion();
                    return;
                case 'displayQuestions':
                    $this->displayQuestions();
                    return;
                case 'displayQuestionContent':
                    $this->displayQuestionContent();
                    return;
                case 'createResponse':
                    $this->createResponse();
                    return;
                case 'reportQuestion':
                    $this->reportQuestion();
                    return;
                case 'reportResponse':
                    $this->reportResponse();
                    return;
            }
        }
    }

    public function displayQuestions(){
        $questions = NULL;
        $data = Utils::SessionVariables();
        $info = $_GET['info'];
        $subject_id = $_GET['subjectId'];
        $question_id = $_GET['questionId'];
        $condition = "subject_id = ".$subject_id;
        $storage = Engine::Instance()->Persistence("DatabaseStorage");
        $storage->findAll("Question",$questions,$condition);

        $data["subject_name"] = "(sélectionnez un sujet...)";
        if($subject_id != "NULL")
        {
            $subj = new Subject($storage,$subject_id);
            $subj = $storage->find($subj);
            if($subj != null)
            {
                $data["subject_name"] = $subj->Name();
            }
        }

        $data["questions"] = array();
        foreach ($questions as $question) {
            array_push($data["questions"],get_object_vars($question));
        }

        $subjects = NULL;
        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("Subject",$subjects);

        $data["subjects"] = array();
        foreach ($subjects as $subject) {
            array_push($data["subjects"],get_object_vars($subject));
        }

        if(isset($_SESSION["Admin"])){
            $data["admin"] = true;
        }else{
             $data["admin"] = false;
        }

        if($info === "QuestionCreated"){
            $info = "Votre question a bien été envoyée!";
        }
        if($info === "NULL"){
            $info = "";
        }

        $data["info"] = $info;
        $data["subject_id"] = $subject_id;
        $data["question_id"] = $question_id;
        $view = new View("questions", $data);
        $view->setTitle("questions");
        $view->show();
    }
    
    public function displayCreateQuestion(){
        if(!isset($_SESSION['User']))
            header('Location: /Login');
        $subjects = NULL;
        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("Subject",$subjects);

        $data = array();
        $data = Utils::SessionVariables();
        $info = $_GET["info"];
        $data["subjects"] = array();
        $data1 = array();
        $data1["questions"] = array();
        foreach ($subjects as $entry) {
            array_push($data["subjects"],get_object_vars($entry));
        }

        $data["info"] = $info;
        $view = new View("createQuestion", $data);
        $view->setTitle("createQuestion");
        $view->show();
    }

    public function createQuestion()
    {
        if(isset($_POST["subject"]))
            $subject_id = $_POST["subject"];
        if(isset($_POST["title"]))
            $title = $_POST["title"];
        if(isset($_POST["content"]))
            $content = $_POST["content"];

        $user_id = $_SESSION['User'];
        $points = 0;
        $reported = 0;
        $date = new DateTime();

        $storage = Engine::Instance()->Persistence("DatabaseStorage");
        $content = Utils::MakeTextSafe($content);
        $question = new Question($storage);
        $question->setSubjectId($subject_id);
        $question->setTitle($title);
        $question->setContent($content);
        $question->setPoints($points);
        $question->setReported($reported);
        $question->setUserId($user_id);
        $question->setDate($date);
        $storage->persist($question);
        $storage->flush();
        header('Location: /Question?action=displayQuestions&subjectId=NULL&questionId=NULL&info=QuestionCreated');
    }

    public function createResponse(){
        if(!isset($_SESSION['User']))
            header('Location: /Login');
        if(isset($_GET["questionId"]))
            $question_id = $_GET["questionId"];
        if(isset($_POST["content"]))
            $content = $_POST["content"];

        $user_id = $_SESSION['User'];
        $points = 0;
        $date = new DateTime();

        $content = Utils::MakeTextSafe($content);

        $storage = Engine::Instance()->Persistence("DatabaseStorage");
        $response = new Response($storage);
        $response->setContent($content);
        $response->setPoints($points);
        $response->setDate($date);
        $response->setUserId($user_id);
        $response->setQuestionId($question_id);

        $storage->persist($response);
        $storage->flush();

        $subject_id = $_GET["subjectId"];
        header('Location: /Question?action=displayQuestionContent&subjectId='.$subject_id.'&questionId='.$question_id.'&info=NULL');
    }

    public function displayQuestionContent(){
        $data = Utils::SessionVariables();
        $question_id = $_GET['questionId'];
        $subject_id = $_GET['subjectId'];
        $info = $_GET['info'];
        $condition = "question_id = ".$question_id;
        $storage = Engine::Instance()->Persistence("DatabaseStorage");
        $responses = NULL;
        $storage->findAll("Response",$responses,$condition);

        $data["responses"] = array();
        foreach ($responses as $response) {
            $user = new User($storage, $response->UserId());
            $user = $storage->find($user);
            $responsevalues = get_object_vars($response);
            $responsevalues["username"] = $user->Firstname().$user->Lastname();
            $date = $response->Date();
            $date = $date->format('d/m/Y à H:i');
            $responsevalues["datee"] = $date;
            $reported = $response->Reported();
            if($reported==0){
                $responsevalues["isreported"] = true;      
            }else{
                $responsevalues["isreported"] = false;      
            }
            $response_id = $response->Id();
            $responsevalues["subject_id"] = $subject_id;
            $responsevalues["question_id"] = $question_id;
            $responsevalues["response_id"] = $response_id;
            array_push($data["responses"],$responsevalues);
        }

        $questions = NULL;
        $condition = "id = ".$question_id;
        $storage = Engine::Instance()->Persistence("DatabaseStorage");
        $question = new Question($storage, $question_id);
        $question = $storage->find($question);

        $data["question_id"] = $question->Id();
        $data["question_title"] = $question->Title();
        $data["question_content"] = $question->Content();
        $user = new User($storage, $question->UserId());
        $user = $storage->find($user);
        $data["question_user"] = $user->Firstname().".".$user->Lastname();
        $data["question_date"] = $question->Date()->format('d/m/Y à H:i');


        /*foreach ($questions as $question) {
            $ques = get_object_vars($question);
            $user = new User($storage, $question->UserId());
            $user = $storage->find($user);
            $ques["user"] = $user->Firstname().".".$user->Lastname();
            $date = $question->Date();
            $date = $date->format('d/m/Y à H:i');
            $ques["datee"] = $date;

            $reported = $question->Reported();
            if($reported==0){
                $ques["isreported"] = true;      
            }else{
                $ques["isreported"] = false;      
            }
            $ques["subject_id"] = $subject_id;
            $ques["question_id"] = $question_id;
            array_push($data["questions"],$ques);
        }*/
        if(($info === "QuestionReported") || ($info === "ResponseReported")){
            $info = "Votre signalement a bien été pris en compte.";
        }
        if($info === "QuestionValidated"){
            $info = "La question a bien été validée.";
        }
        if($info === "ResponseValidated"){
            $info = "La réponse a bien été validée.";
        }
        if($info === "NULL"){
            $info = "";
        }

        $data["info"] = $info;
        $data["subject_id"] = $subject_id;
        $data["question_id"] = $question_id;

        $view = new View("questionContent", $data);
        $view->setTitle("questionContent");
        $view->show();
    }

    public function reportQuestion(){
        $data = Utils::SessionVariables();
        if(isset($_GET['questionId']) && isset($_GET['subjectId'])){
            $subject_id =  $_GET['subjectId'];
            $question_id = $_GET['questionId'];
            $storage = Engine::Instance()->Persistence("DatabaseStorage");
            $question = new Question($storage, $question_id);
            $question = $storage->find($question);
            if($question->Reported()==0){
                $question->setReported(1);
                $storage->persist($question, $state = StorageState::ToUpdate);
                $storage->flush();
            }
            header('Location: /Question?action=displayQuestionContent&subjectId='.$subject_id.'&questionId='.$question_id.'&info=QuestionReported');
        }else{
            header('Location: /Default');
        }
    }

    public function reportResponse(){
        $data = Utils::SessionVariables();
        if(isset($_GET['responseId']) && isset($_GET['questionId']) && isset($_GET['subjectId'])){
            $subject_id =  $_GET['subjectId'];
            $question_id = $_GET['questionId'];
            $response_id = $_GET['responseId'];
            $storage = Engine::Instance()->Persistence("DatabaseStorage");
            $response = new Response($storage, $response_id);
            $response = $storage->find($response);
            if($response->Reported()==0){
                $response->setReported(1);
                $storage->persist($response, $state = StorageState::ToUpdate);
                $storage->flush();
            }
            header('Location: /Question?action=displayQuestionContent&subjectId='.$subject_id.'&questionId='.$question_id.'&info=ResponseReported');
        }else{
            header('Location: /Default');
        }
    }
}