<?php

namespace app\models;

class Question extends \app\core\Model
{
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

        return $statement->rowCount();
    }

    public function deleteQuestionsByQuizId($quizId)
    {
        $sql = 'DELETE FROM Question WHERE QuizId = :quizId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['quizId' => $quizId]);

        return $statement->rowCount();
    }
}