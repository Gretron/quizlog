<?php

namespace app\models;

class Quiz extends \app\core\Model
{
    public function selectPublicQuizzes()
    {
        $sql = 'SELECT * FROM Quiz WHERE QuizPrivacy > 0 ORDER BY QuizId DESC';

        $statement = self::$database->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Question');

        return $statement->fetchAll();
    }

    public function selectQuizzesByQuery($query)
    {
        $sql = 'SELECT * FROM Quiz WHERE QuizName LIKE :query0 OR QuizDescription LIKE :query1 ORDER BY QuizId DESC';

        $statement = self::$database->prepare($sql);
        $statement->execute(['query0' => '%' . $query . '%', 'query1' => '%' . $query . '%']);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Quiz');

        return $statement->fetchAll();
    }

    public function selectQuizzesByUserId($userId)
    {
        $sql = 'SELECT * FROM Quiz WHERE UserId = :userId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['userId' => $userId]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Quiz');

        return $statement->fetch();
    }

    public function selectQuizById($quizId)
    {
        $sql = 'SELECT * FROM Quiz WHERE QuizId = :quizId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['quizId' => $quizId]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Quiz');

        return $statement->fetch();
    }

    public function selectRecentQuizByUserId($userId)
    {
        $sql = 'SELECT * FROM Quiz WHERE UserId = :userId0 AND QuizId = (SELECT MAX(QuizId) FROM Quiz WHERE UserId = :userId1)';

        $statement = self::$database->prepare($sql);
        $statement->execute(['userId0' => $userId, 'userId1' => $userId]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Quiz');

        return $statement->fetch();
    }

    public function insertQuiz()
    {
        $sql = 'INSERT INTO Quiz (UserId, QuizName, QuizBanner, QuizDescription, QuizPrivacy, QuizTime) 
                VALUES (:userId, :quizName, :quizBanner, :quizDescription, :quizPrivacy, :quizTime)';

        $statement = self::$database->prepare($sql);
        $statement->execute(['userId' => $this->userId, 'quizName' => $this->quizName, 'quizBanner' => $this->quizBanner,
            'quizDescription' => $this->quizDescription, 'quizPrivacy' => $this->quizPrivacy, 'quizTime' => $this->quizTime]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Quiz');

        return $statement->rowCount();
    }

    public function deleteQuiz($quizId)
    {
        $sql = 'DELETE FROM Quiz WHERE QuizId = :quizId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['quizId' => $quizId]);

        return $statement->rowCount();
    }
}