<?php

namespace app\models;

class Answer extends \app\core\Model
{
    #[\app\validators\AnswerText]
    public $answerText;

    public function selectAnswersByQuestionId($questionId)
    {
        $sql = 'SELECT * FROM Answer WHERE QuestionId = :questionId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['questionId' => $questionId]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\User');

        return $statement->fetchAll();
    }

    protected function insertAnswer()
    {
        $sql = 'INSERT INTO Answer (QuestionId, AnswerText, AnswerCorrect) VALUES (:questionId, :answerText, :answerCorrect)';

        $statement = self::$database->prepare($sql);
        $statement->execute(['questionId' => $this->questionId, 'answerText' => $this->answerText, 'answerCorrect' => $this->answerCorrect]);

        return $statement->rowCount();
    }

    public function duplicateAnswersByQuestionId($newQuestionId, $oldQuestionId)
    {
        $sql = 'INSERT INTO Answer (QuestionId, AnswerText, AnswerCorrect) 
                SELECT :newQuestionId, AnswerText, AnswerCorrect
                FROM Answer WHERE QuestionId = :oldQuestionId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['newQuestionId' => $newQuestionId, 'oldQuestionId' => $oldQuestionId]);

        return $statement->rowCount();
    }

    public function deleteAnswersByQuestionId($questionId)
    {
        $sql = 'DELETE FROM Answer WHERE QuestionId = :questionId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['questionId' => $questionId]);

        return $statement->rowCount();
    }
}