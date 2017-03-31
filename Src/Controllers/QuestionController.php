<?php
include_once "Core/Controller.php";
include_once "Session.php";
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
            }
        }
    }

    public function displayQuestions(){
        $data = sessionVariables();
        $subject_id = $_GET['subjectId'];
        $question_id = $_GET['questionId'];
        $condition = "subject_id = ".$subject_id;
        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("Question",$questions,$condition);

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
        $data["subject_id"] = $subject_id;
        $data["question_id"] = $question_id;
        $view = new View("questions", $data);
        $view->setTitle("questions");
        $view->show();
    }
    
    public function displayCreateQuestion(){
        $data = sessionVariables();
        if(!isset($_SESSION['User']))
            header('Location: /Login');
        $subjects = NULL;
        $questions=NULL;
        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("Subject",$subjects);
        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("Question",$questions);

        $data = array();
        $data["subjects"] = array();
        $data1 = array();
        $data1["questions"] = array();
        foreach ($subjects as $entry) {
            array_push($data["subjects"],get_object_vars($entry));
        }
        foreach ($questions as $entry) {
            array_push($data1["questions"],get_object_vars($entry));
        }
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
        header('Location: /Question?action=displayQuestions&subjectId=NULL&questionId=NULL');

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

        // content replace()
        // '' -> \''
        // "" -> \""
        // < -> &lt;
        // > -> &gt;

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
        header('Location: /Question?action=displayQuestionContent&subjectId='.$subject_id.'&questionId='.$question_id);
    }

    public function displayQuestionContent(){
        $data = sessionVariables();
        $question_id = $_GET['questionId'];
        $subject_id = $_GET['subjectId'];
        $condition = "question_id = ".$question_id;
        $storage = Engine::Instance()->Persistence("DatabaseStorage");
        $storage->findAll("Response",$responses,$condition);

        $data["responses"] = array();
        foreach ($responses as $response) {
            $user = new User($storage, $response->UserId());
            $user = $storage->find($user);
            $responsevalues = get_object_vars($response);
            $responsevalues["username"] = $user->Firstname().$user->Lastname();
            array_push($data["responses"],$responsevalues);
        }

        $condition = "id = ".$question_id;
        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("Question",$questions,$condition);

        $data["questions"] = array();
        foreach ($questions as $question) {
            array_push($data["questions"],get_object_vars($question));
        }

        $data["subject_id"] = $subject_id;
        $data["question_id"] = $question_id;
        $view = new View("questionContent", $data);
        $view->setTitle("questionContent");
        $view->show();
    }
}