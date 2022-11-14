<?php

namespace app\models;

class Answer extends \app\core\Model
{
    public function selectAnswersByQuestionId($questionId)
    {

    }

    public function selectUserByUsername($username)
    {
        $sql = 'SELECT * FROM User WHERE Username = :username';

        $statement = self::$database->prepare($sql);
        $statement->execute(['username' => $username]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\User');

        return $statement->fetch();
    }

    protected function insertAnswer()
    {
        $sql = 'INSERT INTO Answer (QuestionId, AnswerText, AnswerCorrect) VALUES (:questionId, :answerText, :answerCorrect)';

        $statement = self::$database->prepare($sql);
        $statement->execute(['questionId' => $this->questionId, 'answerText' => $this->answerText, 'answerCorrect' => $this->answerCorrect]);

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