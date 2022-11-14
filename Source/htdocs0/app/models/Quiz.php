<?php

namespace app\models;

class Quiz extends \app\core\Model
{
    public function selectPublicQuizzes()
    {

    }

    public function selectQuizzesByUserId($userId)
    {

    }

    public function selectQuizById($quizId)
    {

    }

    public function selectRecentQuizByUserId($userId)
    {
        $sql = 'SELECT * FROM Quiz WHERE UserId = :userId0 AND QuizId = (SELECT MAX(QuizId) FROM Quiz WHERE UserId = :userId1)';

        $statement = self::$database->prepare($sql);
        $statement->execute(['userId0' => $userId, 'userId1' => $userId]);

        return $statement->fetch();
    }

    public function insertQuiz()
    {
        $sql = 'INSERT INTO Quiz (UserId, QuizName, QuizBanner, QuizDescription, QuizPrivacy, QuizTime) 
                VALUES (:userId, :quizName, :quizBanner, :quizDescription, :quizPrivacy, :quizTime)';

        $statement = self::$database->prepare($sql);
        $statement->execute(['userId' => $this->userId, 'quizName' => $this->quizName, 'quizBanner' => $this->quizBanner,
            'quizDescription' => $this->quizDescription, 'quizPrivacy' => $this->quizPrivacy, 'quizTime' => $this->quizTime]);

        return $statement->rowCount();
    }

    public function updateQuiz()
    {

    }

    public function deleteQuiz()
    {

    }
}