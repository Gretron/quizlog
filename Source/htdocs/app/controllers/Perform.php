<?php

namespace app\controllers;

/**
 * Perform Controller
 */
class Perform extends \app\core\Controller
{
    #[\app\filters\Login]
    public function index()
    {
        $result = new \app\models\Result();
        $result = $result->selectIncompleteResult($_SESSION['UserId']);

        // If No Results
        if (!$result)
        {
            header('location:/home');
            return;
        }

        $choice = new \app\models\Choice();
        $choice = $choice->selectChoicesByResultId($result->ResultId)[$result->CurrentQuestion];

        // If Multiple Choice
        if (isset($_POST['choice']) && $choice->ChoiceType == 'Multiple Choice')
        {
            $choiceId = $choice->ChoiceId;

            $choice = new \app\models\Choice();
            $choice->choiceId = $choiceId;
            $choice->choiceText = $_POST['choice'];

            $choice->updateChoiceTextById();
        }

        // If Short Answer
        else if (isset($_POST['submit']))
        {
            $choiceId = $choice->ChoiceId;

            $choice = new \app\models\Choice();
            $choice->choiceId = $choiceId;
            $choice->choiceText = $_POST['text'];

            $choice->updateChoiceTextById();
        }

        $question = new \app\models\Question();
        $questions = $question->selectQuestionsByQuizId($result->QuizId);
        $question = $questions[$result->CurrentQuestion];
        $count = count($questions) - 1;

        $answers = new \app\models\Answer();
        $answers = $answers->selectAnswersByQuestionId($question->QuestionId);

        $choice = new \app\models\Choice();
        $choice = $choice->selectChoicesByResultId($result->ResultId)[$result->CurrentQuestion];

        $this->view('Perform/index', ['result' => $result, 
        'question' => $question, 
        'answers' => $answers, 
        'count' => $count,
        'choice' => $choice]);
    }

    #[\app\filters\Login]
    public function next()
    {
        $result = new \app\models\Result();
        $result = $result->selectIncompleteResult($_SESSION['UserId']);

        $questions = new \app\models\Question();
        $questions = $questions->selectQuestionsByQuizId($result->QuizId);

        if (count($questions) - 1 > $result->CurrentQuestion)
        {
            $resultId = $result->ResultId;

            $result = new \app\models\Result();
            $result->incrementResultQuestionById($resultId);
        }

        header('location:/perform');
        return;
    }

    #[\app\filters\Login]
    public function previous()
    {
        $result = new \app\models\Result();
        $result = $result->selectIncompleteResult($_SESSION['UserId']);

        $questions = new \app\models\Question();
        $questions = $questions->selectQuestionsByQuizId($result->QuizId);

        if ($result->ResultMode == 'Practice')
        {
            if ($result->CurrentQuestion > 0)
            {
                $resultId = $result->ResultId;

                $result = new \app\models\Result();
                $result->decrementResultQuestionById($resultId);
            }

            header('location:/perform');
            return;
        }

        else
        {
            header('location:/perform?error=You cannot go to the previous question in exam mode.');
            return;
        }
    }

    #[\app\filters\Login]
    #[\app\filters\Perform]
    public function practice($id)
    {    
        $id = $id[0];

        $quiz = new \app\models\Quiz();
        $quizId = $quiz->duplicateQuizById($id);

        // If Quiz Was Successfully Duplicated
        if ($quizId > 0)
        {
            $quiz = new \app\models\Quiz();
            $quiz = $quiz->selectQuizById($quizId);

            $result = new \app\models\Result();
            $result->userId = $_SESSION['UserId'];
            $result->quizId = $quizId;
            $result->resultName = $quiz->QuizName;
            $result->resultMode = 'Practice';
            $result->resultImage = $quiz->QuizBanner;
            $result->currentQuestion = 0;

            $quiz = $quiz->selectQuizById($quizId);

            $time = explode(':', $quiz->QuizTime);
            $date = date_create(date('Y-m-d H:i:s', strtotime("+{$time[0]} hours {$time[1]} minutes {$time[2]} seconds")));
            $result->completedTime = $date->format('Y-m-d H:i:s');

            $resultId = $result->insertResult();

            // If Result Inserted
            if ($resultId > 0)
            {
                $choices = new \app\models\Choice();
                $choices = $choices->insertChoicesByResultId($resultId);

                header('location:/home');
                return;
            }

            else
            {
                $quiz = new \app\models\Quiz();
                $quiz->deleteQuizById($quizId);
            }
        }

        else
        {
            header('location:/home?error=An error occurred while trying to take a quiz.');
            return;
        }
    }

    #[\app\filters\Login]
    #[\app\filters\Perform]
    public function exam($id)
    {
        $id = $id[0];

        $quiz = new \app\models\Quiz();
        $quizId = $quiz->duplicateQuizById($id);

        // If Quiz Was Successfully Duplicated
        if ($quizId > 0)
        {
            $quiz = new \app\models\Quiz();
            $quiz = $quiz->selectQuizById($quizId);

            $result = new \app\models\Result();
            $result->userId = $_SESSION['UserId'];
            $result->quizId = $quizId;
            $result->resultName = $quiz->QuizName;
            $result->resultMode = 'Exam';
            $result->resultImage = $quiz->QuizBanner;
            $result->currentQuestion = 0;

            $quiz = $quiz->selectQuizById($quizId);

            $time = explode(':', $quiz->QuizTime);
            $date = date_create(date('Y-m-d H:i:s', strtotime("+{$time[0]} hours {$time[1]} minutes {$time[2]} seconds")));
            $result->completedTime = $date->format('Y-m-d H:i:s');

            $resultId = $result->insertResult();

            // If Result Inserted
            if ($resultId > 0)
            {
                $choices = new \app\models\Choice();
                $choices = $choices->insertChoicesByResultId($resultId);

                header('location:/home');
                return;
            }

            else
            {
                $quiz = new \app\models\Quiz();
                $quiz->deleteQuizById($quizId);
            }
        }

        else
        {
            header('location:/home?error=An error occurred while trying to take a quiz.');
            return;
        }
    }
}