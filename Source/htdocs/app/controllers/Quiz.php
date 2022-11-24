<?php

namespace app\controllers;

/**
 * Quiz Controller
 */
class Quiz extends \app\core\Controller
{
    #[\app\filters\Login]
    #[\app\filters\Perform]
    public function index()
    {
        $quizzes = new \app\models\Quiz();
        $quizzes = $quizzes->selectQuizzesByUserId($_SESSION['UserId']);

        $this->view('Quiz/index', ['quizzes' => $quizzes]);
    }

    #[\app\filters\Login]
    #[\app\filters\Perform]
    public function create()
    {
        if (isset($_POST['submit']))
        {
            $quiz = new \app\models\Quiz();
            $quiz->userId = $_SESSION['UserId'];
            $quiz->quizName = $_POST['quiz-name'];
            $quiz->quizBanner = $this->saveImage($_FILES['quiz-banner']['tmp_name']);
            $quiz->quizDescription = $_POST['quiz-description'];
            $quiz->quizPrivacy = $_POST['quiz-privacy'] == 0 ? 0 : 1;

            $quiz->quizTime = date('h:m:s', strtotime("{$_POST['quiz-hour']}:{$_POST['quiz-minute']}:{$_POST['quiz-second']}"));

            $quizId = $quiz->insertQuiz();

            // If Quiz Successfully Inserted...
            if ($quizId > 0)
            {
                // Make Sure Questions Exist & There Are More Than 0 Questions
                if (isset($_POST['question']) && is_array($_POST['question']) && count($_POST['question']) > 0)
                {
                    $questions = $_POST['question'];
                    $questionCount = 0;

                    foreach ($questions as $question)
                    {
                        $newQuestion = new \app\models\Question();
                        $newQuestion->quizId = $quizId;
                        $newQuestion->questionText = $question['text'];
                        $newQuestion->questionImage = $this->saveImage($_FILES['question']['tmp_name'][$questionCount]['image']);
                        $newQuestion->questionHint = $question['hint'];
                        $newQuestion->questionType = $question['type'];

                        $questionId = $newQuestion->insertQuestion();

                        // If Question Successfully Inserted...
                        if ($questionId > 0)
                        {
                            $answers = $question['answer'];
                            $answerCount = 0;

                            if ($question['type'] == 'Multiple Choice')
                            {
                                if (count($answers) < 2)
                                {
                                    $quiz->deleteQuizById($quizId);

                                    header('location:?error=You need atleast 2 answers per multiple choice question.');
                                    return;
                                }

                                if (count($answers) - 1 < $question['correct'] || $question['correct'] < 0)
                                {
                                    $quiz->deleteQuizById($quizId);

                                    header('location:?error=1 answer must be correct in a multiple choice.');
                                    return;
                                }

                                foreach ($answers as $answer)
                                {
                                    $newAnswer = new \app\models\Answer();
                                    $newAnswer->questionId = $questionId;
                                    $newAnswer->answerText = $answer['text'];
                                    $newAnswer->answerCorrect = $question['correct'] == $answerCount ? 1 : 0;
                                    
                                    $answerId = $newAnswer->insertAnswer();

                                    // If Answer Unsuccesfully Inserted...
                                    if ($answerId < 0)
                                    {
                                        $quiz->deleteQuizById($quizId);

                                        header('location:?error=There was an error adding an answer.');
                                        return;
                                    }

                                    $answerCount++;
                                }
                            }

                            else 
                            {
                                $newAnswer = new \app\models\Answer();
                                $newAnswer->questionId = $questionId;
                                $newAnswer->answerText = $answers['text'];
                                $newAnswer->answerCorrect = 1;

                                $answerId = $newAnswer->insertAnswer();

                                // If Answer Unsuccesfully Inserted...
                                if ($answerId < 1)
                                {
                                    $quiz->deleteQuizById($quizId);

                                    header('location:?error=There was an error adding an answer.');
                                    return;
                                }
                            }
                        }

                        else
                        {
                            header('location:?error=There was an error creating a question.');
                            return;
                        }

                        $questionCount++;
                    }

                    header('location:/quiz/details/' . $quizId);
                    return;
                }

                else
                {
                    $quiz->deleteQuizById($quizId);

                    header('location:?error=You need atleast 1 question per quiz.');
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
    #[\app\filters\Perform]
    public function modify($id) 
    {
        $id = $id[0];

        $quiz = (new \app\models\Quiz())->selectQuizById($id);

        if ($quiz->UserId != $_SESSION['UserId'])
        {
            header('location:/quiz?error=You cannot modify a quiz you haven\'t created.');
            return;
        }

        $questions = (new \app\models\Question())->selectQuestionsByQuizId($quiz->QuizId);

        foreach($questions as &$question)
        {
            $question->Answers = (new \app\models\Answer())->selectAnswersByQuestionId($question->QuestionId);
        }

        $this->view('Quiz/modify', ['quiz' => $quiz, 'questions' => $questions]);
    }

    #[\app\filters\Login]
    #[\app\filters\Perform]
    public function details($id) 
    {
        $id = $id[0];

        $quiz = new \app\models\Quiz();
        $quiz = $quiz->selectQuizById($id);

        $this->view('Quiz/details', ['quiz' => $quiz]);
    }

    #[\app\filters\Login]
    #[\app\filters\Perform]
    public function delete($id)
    {
        $id = $id[0];

        $quiz = new \app\models\Quiz();
        $quiz = $quiz->selectQuizById($id);

        if ($_SESSION['UserId'] == $quiz->UserId)
        {
            if ($quiz->deleteQuizById($id) > 0)
            {
                header('location:/quiz?error=Succesfully deleted quiz \''. $quiz->QuizName . '\'.');
                return;
            }

            else
            {
                header('location:/quiz?error=There was an error while deleting\''. $quiz->QuizName . '\'.');
                return;
            }
        }

        else
        {
            header('location:/quiz?error=You cannot delete a quiz you haven\'t created.');
            return;
        }
    }
}