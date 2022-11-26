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
            $quiz->quizTime = date('H:i:s', strtotime("{$_POST['quiz-hour']}:{$_POST['quiz-minute']}:{$_POST['quiz-second']}"));
            $quiz->quizDatetime = date("Y-m-d H:i:s");

            $quizId = $quiz->insertQuiz();

            // If Quiz Successfully Inserted...
            if ($quizId > 0)
            {
                // Make Sure Questions Exist & There Are More Than 0 Questions
                if (isset($_POST['question']) && is_array($_POST['question']) && count($_POST['question']) > 0)
                {
                    $questions = $_POST['question'];
                    $questionCount = 0;

                    if (count($questions) > 32)
                    {
                        $quiz->deleteQuizById($quizId);

                        header('location:?error=You can only have a maximum of 32 questions.');
                        return;
                    }

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
                                if (count($answers) > 8)
                                {
                                    $quiz->deleteQuizById($quizId);

                                    header('location:?error=You can only have a maximum of 8 answers per question.');
                                    return;
                                }

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

        $modifyQuiz = (new \app\models\Quiz())->selectQuizById($id);

        if ($modifyQuiz->UserId != $_SESSION['UserId'])
        {
            header('location:/quiz');
            return;
        }

        if (isset($_POST['submit']))
        {
            $quiz = new \app\models\Quiz();
            $quiz->quizId = $id;
            $quiz->quizName = $_POST['quiz-name'];

            // If New Quiz Banner Is Selected...
            if (!empty($_FILES['quiz-banner']['tmp_name']))
            {
                $quiz->quizBanner = $this->saveImage($_FILES['quiz-banner']['tmp_name']);
                unlink('img/' . $modifyQuiz->QuizBanner);
            }

            else 
            {
                // Set to Old Quiz Banner
                $quiz->quizBanner = $_POST['quiz-banner'];
            }

            $quiz->quizDescription = $_POST['quiz-description'];
            $quiz->quizPrivacy = $_POST['quiz-privacy'] == 0 ? 0 : 1;
            $quiz->quizTime = date('H:i:s', strtotime("{$_POST['quiz-hour']}:{$_POST['quiz-minute']}:{$_POST['quiz-second']}"));

            $quiz->updateQuiz();

            $oldQuestions = (new \app\models\Question())->selectQuestionsByQuizId($id);

            // Make Sure Questions Exist & There Are More Than 0 Questions
            if (isset($_POST['question']) && is_array($_POST['question']) && count($_POST['question']) > 0)
            {
                $questions = $_POST['question'];
                $questionCount = 0;

                $questionIds = [];

                if (count($questions) > 32)
                {
                    header('location:?error=You can only have a maximum of 32 questions.');
                    return;
                }

                foreach ($questions as $question)
                {
                    $newQuestion = new \app\models\Question();
                    $newQuestion->quizId = $id;
                    $newQuestion->questionText = $question['text'];
                    

                    // If New Question Image Is Set...
                    if (!empty($_FILES['question']['tmp_name'][$questionCount]['image']))
                    {
                        $newQuestion->questionImage = $this->saveImage($_FILES['question']['tmp_name'][$questionCount]['image']);
                    }

                    else
                    {
                        // Set to Old Question Image
                        if (isset($question['image']))
                        {
                            $newQuestion->questionImage = $question['image'];
                        }
                        
                        else
                        {
                            $newQuestion->questionImage = '';
                        }
                    }

                    $newQuestion->questionHint = $question['hint'];
                    $newQuestion->questionType = $question['type'];

                    $questionId = $newQuestion->insertQuestion();

                    // If Question Successfully Inserted...
                    if ($questionId > 0)
                    {
                        array_push($questionIds, $questionId);

                        $answers = $question['answer'];
                        $answerCount = 0;

                        if ($question['type'] == 'Multiple Choice')
                        {
                            if (count($answers) > 8)
                            {
                                foreach($questionIds as $id)
                                {
                                    (new \app\models\Question())->deleteQuestionById($id);
                                }

                                header('location:?error=You can only have a maximum of 8 answers per question.');
                                return;
                            }

                            if (count($answers) < 2)
                            {
                                foreach($questionIds as $id)
                                {
                                    (new \app\models\Question())->deleteQuestionById($id);
                                }

                                header('location:?error=You need atleast 2 answers per multiple choice question.');
                                return;
                            }

                            if (count($answers) - 1 < $question['correct'] || $question['correct'] < 0)
                            {
                                foreach($questionIds as $id)
                                {
                                    (new \app\models\Question())->deleteQuestionById($id);
                                }

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
                                    foreach($questionIds as $id)
                                    {
                                        (new \app\models\Question())->deleteQuestionById($id);
                                    }

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
                                foreach($questionIds as $id)
                                {
                                    (new \app\models\Question())->deleteQuestionById($id);
                                }

                                header('location:?error=There was an error adding an answer.');
                                return;
                            }
                        }
                    }

                    else
                    {
                        foreach($questionIds as $id)
                        {
                            (new \app\models\Question())->deleteQuestionById($id);
                        }

                        header('location:?error=There was an error creating a question.');
                        return;
                    }

                    $questionCount++;
                }
            }

            else
            {
                header('location:?error=You need atleast 1 question per quiz.');
                return;
            }

            // Delete Old Questions
            foreach($oldQuestions as $oldQuestion)
            {
                (new \app\models\Question())->deleteQuestionById($oldQuestion->QuestionId);
            }

            header('location:/quiz/details/' . $id . '?error=Successfully Modified Quiz \'' . $quiz->quizName . '\'.');
        }

        $questions = (new \app\models\Question())->selectQuestionsByQuizId($modifyQuiz->QuizId);

        foreach($questions as &$question)
        {
            $question->Answers = (new \app\models\Answer())->selectAnswersByQuestionId($question->QuestionId);
        }

        $this->view('Quiz/modify', ['quiz' => $modifyQuiz, 'questions' => $questions]);
    }

    #[\app\filters\Login]
    #[\app\filters\Perform]
    public function details($id) 
    {
        $id = $id[0];

        $quiz = (new \app\models\Quiz())->selectQuizById($id);

        if ($quiz->UserId != $_SESSION['UserId'] && $quiz->QuizPrivacy != '1')
        {
            header('location:/home?error=You cannot view a quiz that is private.');
            return;
        }

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