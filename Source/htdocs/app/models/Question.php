<?php

namespace app\models;

class Question extends \app\core\Model
{
    #[\app\validators\QuestionText]
    public $questionText;

    #[\app\validators\QuestionType]
    public $questionType;

    public function selectQuestionById($questionId)
    {
        $sql = 'SELECT * FROM Question WHERE QuestionId = :questionId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['questionId' => $questionId]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Question');

        return $statement->fetch();
    }

    public function selectQuestionCountByQuizId($quizId)
    {
        $sql = 'SELECT COUNT(QuestionId) FROM Question WHERE QuizId = :quizId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['quizId' => $quizId]);

        return $statement->fetchColumn();
    }

    public function  selectQuestionsByQuizId($quizId)
    {
        $sql = 'SELECT * FROM Question WHERE QuizId = :quizId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['quizId' => $quizId]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Question');

        return $statement->fetchAll();
    }

    public function selectRecentQuestionByQuizId($quizId)
    {
        $sql = 'SELECT * FROM Question WHERE QuestionId = (SELECT MAX(QuestionId) FROM Question WHERE QuizId = :quizId)';

        $statement = self::$database->prepare($sql);
        $statement->execute(['quizId' => $quizId]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Question');

        return $statement->fetch();
    }

    protected function insertQuestion()
    {
        $sql = 'INSERT INTO Question (QuizId, QuestionText, QuestionImage, QuestionHint, QuestionType) 
                VALUES (:quizId, :questionText, :questionImage, :questionHint, :questionType)';

        $statement = self::$database->prepare($sql);
        $statement->execute(['quizId' => $this->quizId, 'questionText' => $this->questionText, 'questionImage' => $this->questionImage,
            'questionHint' => $this->questionHint, 'questionType' => $this->questionType]);

        return self::$database->lastInsertId();
    }

    public function removeQuestionImageById($questionId)
    {
        $sql = 'UPDATE Question SET QuestionImage = "" WHERE QuestionId = :questionId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['questionId' => $questionId]);

        return $statement->rowCount();
    }

    public function duplicateQuestionsByQuizId($newQuizId, $oldQuizId)
    {
        $sql = 'INSERT INTO Question (QuizId, QuestionText, QuestionImage, QuestionHint, QuestionType) 
                SELECT :newQuizId, QuestionText, QuestionImage, QuestionHint, QuestionType
                FROM Question WHERE QuizId = :oldQuizId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['newQuizId' => $newQuizId, 'oldQuizId' => $oldQuizId]);

        // If Successfully Duplicated Questions
        if ($statement->rowCount() > 0)
        {
            $newQuestions = $this->selectQuestionsByQuizId($newQuizId);
            $oldQuestions = $this->selectQuestionsByQuizId($oldQuizId);

            for ($i = 0; $i < count($newQuestions); $i++)
            {
                $answer = new \app\models\Answer();
                $answer->duplicateAnswersByQuestionId($newQuestions[$i]->QuestionId, $oldQuestions[$i]->QuestionId);
            }
        }

        else
        {
            $quiz = new \app\models\Quiz();
            $quiz->deleteQuizById($newQuizId);
        }

        return $statement->rowCount();
    }

    public function deleteQuestionsByQuizId($quizId)
    {
        $questions = $this->selectQuestionsByQuizId($quizId);

        foreach($questions as $question)
        {
            $this->removeQuestionImageById($question->QuestionId);

            if (!$this->isImageInUse($question->QuestionImage) && !empty($question->QuestionImage))
            {
                unlink('img/' . $question->QuestionImage);
            }

            $answers = new \app\models\Answer();
            $answers->deleteAnswersByQuestionId($question->QuestionId);
        }

        $sql = 'DELETE FROM Question WHERE QuizId = :quizId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['quizId' => $quizId]);

        return $statement->rowCount();
    }

    public function deleteQuestionById($questionId)
    {
        $question = $this->selectQuestionById($questionId);
        $this->removeQuestionImageById($question->QuestionId);

        if (!$this->isImageInUse($question->QuestionImage) && !empty($question->QuestionImage))
        {
            unlink('img/' . $question->QuestionImage);
        }

        $answers = new \app\models\Answer();
        $answers->deleteAnswersByQuestionId($question->QuestionId);

        $sql = 'DELETE FROM Question WHERE QuestionId = :questionId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['questionId' => $questionId]);

        return $statement->rowCount();
    }
}