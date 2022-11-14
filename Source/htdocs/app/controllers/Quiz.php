<?php

namespace app\controllers;

/**
 * Quiz Controller
 */
class Quiz extends \app\core\Controller
{
    public function index()
    {
        $this->view('Quiz/index');
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

            $time = \DateTime::createFromFormat("h:m:s", $_POST['quiz-time']);

            if (!$time || ($time->format('H') > 3 && $time->format('m') > 0))
            {
                header('location:?error=Inputted time is invalid.');
                return;
            }

            $quiz->quizTime = $_POST['quiz-time'];

            // If Quiz Successfully Inserted...
            if ($quiz->insertQuiz() > 0)
            {
                // Get Inserted Quiz
                $quiz = $quiz->selectRecentQuizByUserId($_SESSION['UserId']);

                // Start Count
                $count = 0;

                while (isset($_POST['q'. $count]))
                {
                    $qId = 'q' . $count;

                    $question = new \app\models\Question();
                    $question->quizId = $quiz->QuizId;
                    $question->questionText = $_POST[$qId . '-txt'];
                    $question->questionImage = $_FILES[$qId . '-img'];
                    $question->questionHint = $_POST[$qId . '-hint'];
                    $question->questionType = $_POST[$qId . '-type'];

                    if ($question->insertQuestion() > 0)
                    {
                        // Get Inserted Question
                        $question = $question->selectRecentQuestionByQuizId($quiz->QuizId);

                        if ($question->QuestionType == 'Multiple Choice')
                        {
                            // Start Answer Count
                            $index = 0;

                            while (isset($_POST[$qId . '-a' . $index]))
                            {
                                // If We've Inserted 6 Answers...
                                if ($index > 5)
                                    break;

                                $aId = 'a' . $index;

                                $answer = new \app\models\Answer();
                                $answer->questionId = $question->QuestionId;
                                $answer->answerText = $_POST[$qId . '-' . $aId . '-txt'];

                                // Check If Answer Is Correct
                                if ($_POST[$qId . '-c'] == $aId)
                                    $answer->answerCorrect = 1;

                                else
                                    $answer->answerCorrect = 0;

                                // Error Creating Answer
                                if ($answer->insertAnswer() < 1)
                                {
                                    // Delete Quiz
                                    $this->delete(array($quiz->QuizId));
                                    header('location:?error=There was an error creating an answer.');
                                    return;
                                }

                                $index++;
                            }

                            // Not Enough Answers
                            if ($index < 2)
                            {
                                // Delete Quiz
                                $this->delete(array($quiz->QuizId));
                                header('location:?error=You need a minimum of 2 answers per question.');
                                return;
                            }
                        }

                        // If Short Answer
                        else
                        {
                            $answer = new \app\models\Answer();
                            $answer->questionId = $question->QuestionId;
                            $answer->answerText = $_POST[$qId . '-a0-txt'];
                            $answer->answerCorrect = 1;

                            // Error Creating Answer
                            if ($answer->insertAnswer() < 1)
                            {
                                // Delete Quiz
                                $this->delete(array($quiz->QuizId));
                                header('location:?error=There was an error creating an answer.');
                                return;
                            }
                        }
                    }

                    // Error Creating Question
                    else
                    {
                        // Delete Quiz
                        $this->delete(array($quiz->QuizId));
                        header('location:?error=There was an error parsing a question.');
                        return;
                    }

                    $count++;
                }

                // If Everything Is Fine, Bring User to Quiz List
                if ($count > 0)
                {
                    header('location:/quiz');
                }

                // Not Enough Questions
                else
                {
                    // Delete Quiz
                    $this->delete(array($quiz->QuizId));
                    header('location:?error=You need a minimum of 1 question per quiz.');
                    return;
                }
            }

            else
            {
                header('location:?error=There was an error creating a quiz.');
                return;
            }
        }

        $this->view('Quiz/create');
    }

    #[\app\filters\Login]
    public function delete($id)
    {
        $id = $id[0];

        $quiz = new \app\models\Quiz();
        $quiz = $quiz->selectQuizById($id);

        if ($_SESSION['UserId'] == $quiz->UserId)
        {
            $questions = new \app\models\Question();
            $questions = $questions->selectQuestionsByQuizId($id);

            var_dump($questions);

            foreach ($questions as $question)
            {
                $answers = new \app\models\Answer();
                $answers->deleteAnswersByQuestionId($question->QuestionId);
            }

            $question = new \app\models\Question();
            $question->deleteQuestionsByQuizId($id);

            $quiz = new \app\models\Quiz();

            if ($quiz->deleteQuiz($id) < 1)
            {
                header('location:/home?error=There was an error deleting a quiz.');
            }

            else
            {
                header('Refresh: 0');
            }
        }

        else
        {
            header('location:/home?error=You cannot delete a quiz you haven\'t created.' . $quiz->QuizName);
        }
    }
}