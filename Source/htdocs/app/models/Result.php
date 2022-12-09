<?php

namespace app\models;

class Result extends \app\core\Model
{
    public function selectResultById($resultId)
    {
        $sql = 'SELECT * FROM Result WHERE ResultId = :resultId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['resultId' => $resultId]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Result');

        return $statement->fetch();
    }

    public function selectCompleteResultById($resultId)
    {
        $sql = 'SELECT * FROM Result WHERE ResultId = :resultId AND CompletedTime <= :currentTime';

        $statement = self::$database->prepare($sql);
        $statement->execute(['resultId' => $resultId, 'currentTime' => date('Y-m-d H:i:s')]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Result');

        return $statement->fetch();
    }

    public function selectCompleteResultsByUserId($userId)
    {
        $sql = 'SELECT * FROM Result WHERE UserId = :userId AND CompletedTime < :currentTime ORDER BY ResultId DESC';

        $statement = self::$database->prepare($sql);
        $statement->execute(['userId' => $userId, 'currentTime' => date('Y-m-d H:i:s')]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Result');

        return $statement->fetchAll();
    }

    public function selectIncompleteResult($userId)
    {
        $sql = 'SELECT * FROM Result WHERE CompletedTime > :currentTime AND UserId = :userId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['currentTime' => $date = date('Y-m-d H:i:s'), 'userId' => $userId]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Result');

        return $statement->fetch();
    }

    protected function insertResult()
    {
        $sql = 'INSERT INTO Result (UserId, QuizId, ResultName, ResultMode, ResultImage, CurrentQuestion, CompletedTime) 
                VALUES (:userId, :quizId, :resultName, :resultMode, :resultImage, :currentQuestion, :completedTime)';

        $statement = self::$database->prepare($sql);
        $statement->execute(['userId' => $this->userId, 'quizId' => $this->quizId, 'resultName' => $this->resultName, 'resultMode' => $this->resultMode,
            'resultImage' => $this->resultImage, 'currentQuestion' => $this->currentQuestion, 'completedTime' => $this->completedTime]);

        return self::$database->lastInsertId();
    }

    public function removeResultImageById($resultId)
    {
        $sql = 'UPDATE Result SET ResultImage = "" WHERE ResultId = :resultId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['resultId' => $resultId]);

        return $statement->rowCount();
    }

    public function updateResultQuizIdById($resultId)
    {
        $sql = 'UPDATE Result SET QuizId = "0" WHERE ResultId = :resultId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['resultId' => $resultId]);

        return $statement->rowCount();
    }

    public function completeResultById($resultId)
    {
        $sql = 'UPDATE Result SET CompletedTime = :completedTime WHERE ResultId = :resultId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['completedTime' => date('Y-m-d H:i:s'), 'resultId' => $resultId]);

        return $statement->rowCount();
    }

    public function incrementResultQuestionById($resultId)
    {
        $sql = 'UPDATE Result SET CurrentQuestion = CurrentQuestion + 1 WHERE ResultId = :resultId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['resultId' => $resultId]);

        return $statement->rowCount();
    }

    public function decrementResultQuestionById($resultId)
    {
        $sql = 'UPDATE Result SET CurrentQuestion = CurrentQuestion - 1 WHERE ResultId = :resultId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['resultId' => $resultId]);

        return $statement->rowCount();
    }

    public function deleteResultById($resultId)
    {
        $result = $this->selectResultById($resultId);
        $this->removeResultImageById($resultId);

        if (!$this->isImageInUse($result->ResultImage) && !empty($result->ResultImage))
        {
            unlink('img/' . $result->ResultImage);
        }

        $choices = new \app\models\Choice();
        $choices->deleteChoicesByResultId($resultId);

        $sql = 'DELETE FROM Result WHERE ResultId = :resultId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['resultId' => $resultId]);

        return $statement->rowCount();       
    }
}