<?php

namespace app\controllers;

/**
 * Quiz Controller
 */
class Quiz extends \app\core\Controller
{
    public function index()
    {

    }

    #[\app\filters\Login]
    public function create()
    {
        if (isset($_POST['submit']))
        {
            $quiz = new \app\models\Quiz();
            $quiz->userId = $_SESSION['UserId'];
            $quiz->quizName = $_POST['quiz-name'];
            $quiz->quizBanner = $_FILES['quiz-banner'];
            $quiz->quizDescription = $_POST['quiz-description'];
            $quiz->quizPrivacy = $_POST['quiz-privacy'];
            $quiz->quizTime = $_POST['quiz-time'];

            // If Quiz Successfully Inserted...
            if ($quiz->insertQuiz() > 0)
            {
                $quiz = $quiz->selectRecentQuizByUserId($_SESSION['UserId']);

                var_dump($quiz);

                $count = 0;

                while (isset($_POST['q'. $count]))
                {
                    $id = 'q' . $count;

                    $question = new \app\models\Question();
                    $question->quizId = $quiz['QuizId'];
                    $question->questionText = $_POST[$id . '-txt'];
                    $question->questionImage = $_FILES[$id . '-img'];
                    $question->questionHint = $_POST[$id . '-hint'];
                    $question->questionType = $_POST[$id . '-type'];



                    $count++;
                }

                /*
                if ($count != 0)
                {

                }

                else
                {
                    header('location:?error=There was an error parsing a question.');
                    return;
                }
                */
            }

            else
            {
                header('location:?error=There was an error creating quiz.');
                return;
            }
        }

        $this->view('Quiz/create');
    }

    #[\app\filters\Login]
    public function modify($id)
    {
        
    }

    #[\app\filters\Login]
    public function delete($id)
    {

    }
}