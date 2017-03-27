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
        if(!isset($_SESSION['User']))
            header('Location: /Login');

        if(!isset($_GET["action"])){
            $this->display();
        }else{
            $action = $_GET["action"];
            switch($action){
                case 'displayCreateQuestion':
                    $this->displayCreateQuestion();
                    return;
                case 'createQuestion':
                    $this->createQuestion();
                    return;
                case 'displaySubjects':
                    $this->displaySubjects();
                    return;
            }
        }
    }

    public function displaySubjects(){
        $subjects = NULL;
        $questions = NULL;
        $tabQuestions = NULL;

        $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("Subject",$subjects);

        foreach ($subjects as $subject) {
            $subjectId= $subject->Id();
            $condition = "subject_id = ".$subjectId;
            $storage = Engine::Instance()->Persistence("DatabaseStorage")->findAll("Question",$questions,$condition);
            foreach ($questions as $question) {
                $questionId= $question->Id();
                $tabQuestions[$subjectId][$questionId] = $question;
            }
        }

        $data = array();
        $data["subjects"] = array();
        foreach ($subjects as $subject) {
            array_push($data["subjects"],get_object_vars($subject));
        }
        $data["questions"] = array();
        foreach ($questions as $question) {
            array_push($data["questions"],get_object_vars($question));
        }
        $view = new View("questions", $data);
        $view->setTitle("questions");
        $view->show();
    }
    
    public function displayCreateQuestion(){
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
    }
}