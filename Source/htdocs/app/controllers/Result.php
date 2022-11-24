<?php

namespace app\controllers;

/**
 * Result Controller
 */
class Result extends \app\core\Controller
{
    #[\app\filters\Login]
    #[\app\filters\Perform]
    public function index()
    {
        $results = new \app\models\Result();
        $results = $results->selectCompleteResultsByUserId($_SESSION['UserId']);

        foreach ($results as &$result)
        {
            if ($result->QuizId > 0)
            {
                $quiz = new \app\models\Quiz();
                $count = $quiz->deleteQuizById($result->QuizId);

                if ($count > 0)
                {
                    $result->updateResultQuizIdById($result->ResultId);
                }
            }

            $choices = new \app\models\Choice();
            $choices = $choices->selectChoicesByResultId($result->ResultId);
            
            $count = count($choices);
            $score = 0;

            foreach ($choices as $choice)
            {
                if ($choice->ChoiceType == 'Multiple Choice')
                {
                    if ($choice->ChoiceText == $choice->CorrectText)
                    {
                        $score++;
                    }
                }

                else
                {
                    $matches = explode(',', $choice->CorrectText);

                    $correct = true;

                    foreach ($matches as $match)
                    {
                        if (stripos($choice->ChoiceText, $match) === false)
                        {
                            $correct = false;
                            break;
                        }
                    }

                    if ($correct)
                    {
                        $score++;
                    }
                }
            }

            $result->ResultScore = (int)(($score / $count) * 100);
            $result->RightAnswers = $score;
            $result->QuestionCount = $count;
        }

        $this->view('Result/index', ['results' => $results]);
    }

    #[\app\filters\Login]
    #[\app\filters\Perform]
    public function details($id)
    {
        $id = $id[0];

        $result = (new \app\models\Result())->selectCompleteResultById($id);

        // If Result Doesn't Exist or Doesn't Belong to Logged In User...
        if (!$result || $result->UserId != $_SESSION['UserId'])
        {
            header('location:/result?error=Result either doesn\'t exist or doesn\'t belong to you.');
            return;
        }

        // Get Result Choices
        $choices = (new \app\models\Choice())->selectChoicesByResultId($id);

        $count = count($choices);
        $score = 0;

        foreach ($choices as $choice)
        {
            if ($choice->ChoiceType == 'Multiple Choice')
            {
                if ($choice->ChoiceText == $choice->CorrectText)
                {
                    $score++;
                }
            }

            else
            {
                $matches = explode(',', $choice->CorrectText);

                $correct = true;

                foreach ($matches as $match)
                {
                    if (stripos($choice->ChoiceText, $match) === false)
                    {
                        $correct = false;
                        break;
                    }
                }

                if ($correct)
                {
                    $score++;
                }
            }
        }

        $result->ResultScore = (int)(($score / $count) * 100);
        $result->RightAnswers = $score;
        $result->QuestionCount = $count;

        $this->view('Result/details', ['result' => $result, 'choices' => $choices]);
    }

    #[\app\filters\Login]
    public function complete($id)
    {   
        $id = $id[0];

        // Select Result That Is To Be Checked
        $checkResult = new \app\models\Result();
        $checkResult = $checkResult->selectResultById($id);

        // If Result Belongs to User...
        if ($checkResult->UserId == $_SESSION['UserId'])
        {
            // Complete Result
            $completeResult = new \app\models\Result();
            $completeResult->completeResultById($id);

            // Delete All Quizzes Linked to Complete Results
            $results = new \app\models\Result();
            $results = $results->selectCompleteResultsByUserId($_SESSION['UserId']);

            foreach ($results as $result)
            {
                if ($result->QuizId > 0)
                {
                    $quiz = new \app\models\Quiz();
                    $count = $quiz->deleteQuizById($result->QuizId);

                    if ($count > 0)
                    {
                        $result->updateResultQuizIdById($result->ResultId);
                    }
                }
            }

            // Redirect to Result
            header('location:/result');
            return;
        }

        else
        {
            header('location:/home?=You cannot complete a quiz that isn\'t yours.');
            return;
        }
    }

    #[\app\filters\Login]
    #[\app\filters\Perform]
    public function delete($id)
    {

    }
}