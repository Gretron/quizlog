<?php

namespace app\models;

class Quiz extends \app\core\Model
{
    #[\app\validators\QuizName]
    public $quizName;

    #[\app\validators\QuizTime]
    public $quizTime;

    public function selectPublicQuizzes()
    {
        $sql = 'SELECT * FROM Quiz WHERE QuizPrivacy = "1" ORDER BY QuizId DESC';

        $statement = self::$database->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Question');

        return $statement->fetchAll();
    }

    public function selectQuizzesByQuery($query)
    {
        $sql = 'SELECT * FROM Quiz WHERE QuizPrivacy = "1" AND (QuizName LIKE :query0 OR QuizDescription LIKE :query1) ORDER BY QuizId DESC';

        $statement = self::$database->prepare($sql);
        $statement->execute(['query0' => '%' . $query . '%', 'query1' => '%' . $query . '%']);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Quiz');

        return $statement->fetchAll();
    }

    public function selectQuizzesByUserId($userId)
    {
        $sql = 'SELECT * FROM Quiz WHERE UserId = :userId AND QuizPrivacy != "2" ORDER BY QuizId DESC';

        $statement = self::$database->prepare($sql);
        $statement->execute(['userId' => $userId]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Quiz');

        return $statement->fetchAll();
    }

    public function selectPublicQuizzesByUserId($userId)
    {
        $sql = 'SELECT * FROM Quiz WHERE UserId = :userId AND QuizPrivacy = "1" ORDER BY QuizId DESC';

        $statement = self::$database->prepare($sql);
        $statement->execute(['userId' => $userId]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Quiz');

        return $statement->fetchAll();
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

    protected function insertQuiz()
    {
        $sql = 'INSERT INTO Quiz (UserId, QuizName, QuizBanner, QuizDescription, QuizPrivacy, QuizTime) 
                VALUES (:userId, :quizName, :quizBanner, :quizDescription, :quizPrivacy, :quizTime)';

        $statement = self::$database->prepare($sql);
        $statement->execute(['userId' => $this->userId, 'quizName' => $this->quizName, 'quizBanner' => $this->quizBanner,
            'quizDescription' => $this->quizDescription, 'quizPrivacy' => $this->quizPrivacy, 'quizTime' => $this->quizTime]);

        return self::$database->lastInsertId();
    }

    protected function updateQuiz()
    {
        $sql = 'UPDATE Quiz SET 
                QuizName = :quizName,
                QuizBanner = :quizBanner,
                QuizDescription = :quizDescription,
                QuizPrivacy = :quizPrivacy,
                QuizTime = :quizTime
                WHERE QuizId = :quizId';
        
        $statement = self::$database->prepare($sql);
        $statement->execute([
            'quizName' => $this->quizName,
            'quizBanner' => $this->quizBanner,
            'quizDescription' => $this->quizDescription,
            'quizPrivacy' => $this->quizPrivacy,
            'quizTime' => $this->quizTime,
            'quizId' => $this->quizId,
        ]);

        return $statement->rowCount();
    }

    public function removeQuizImageById($quizId)
    {
        $sql = 'UPDATE Quiz SET QuizBanner = "" WHERE QuizId = :quizId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['quizId' => $quizId]);

        return $statement->rowCount();
    }

    public function duplicateQuizById($quizId)
    {
        $sql = 'INSERT INTO Quiz (UserId, QuizName, QuizBanner, QuizDescription, QuizPrivacy, QuizTime) 
                SELECT UserId, QuizName, QuizBanner, QuizDescription, "2", QuizTime
                FROM Quiz WHERE QuizId = :quizId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['quizId' => $quizId]);

        $newQuizId = self::$database->lastInsertId();

        // If Quiz Successfully Cloned
        if ($newQuizId > 0)
        {
            $question = new \app\models\Question();
            $question->duplicateQuestionsByQuizId($newQuizId, $quizId);
        }

        return $newQuizId;
    }

    public function deleteQuizById($quizId)
    {
        $quiz = $this->selectQuizById($quizId);
        $this->removeQuizImageById($quizId);

        if (!$this->isImageInUse($quiz->QuizBanner) && !empty($quiz->QuizBanner))
        {
            unlink('img/' . $quiz->QuizBanner);
        }

        $questions = new \app\models\Question();
        $questions->deleteQuestionsByQuizId($quizId);

        $sql = 'DELETE FROM Quiz WHERE QuizId = :quizId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['quizId' => $quizId]);

        return $statement->rowCount();
    }
}