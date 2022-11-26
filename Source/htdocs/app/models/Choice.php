<?php

namespace app\models;

class Choice extends \app\core\Model
{
    public function selectChoiceById($choiceId)
    {
        $sql = 'SELECT * FROM Choice WHERE ChoiceId = :choiceId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['choiceId' => $choiceId]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Choice');

        return $statement->fetch();
    }

    public function selectChoicesByResultId($resultId)
    {
        $sql = 'SELECT * FROM Choice WHERE ResultId = :resultId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['resultId' => $resultId]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Choice');

        return $statement->fetchAll();
    }

    public function insertChoicesByResultId($resultId)
    {
        $sql = 'INSERT INTO Choice (ResultId, ChoiceType, QuestionText, QuestionImage, CorrectText) 
                SELECT :resultId0, q.QuestionType, q.QuestionText, q.QuestionImage, a.AnswerText
                FROM Result AS r, Question AS q, Answer AS a
                WHERE r.resultId = :resultId1
                AND q.QuizId = r.QuizId
                AND a.QuestionId = q.QuestionId
                AND a.AnswerCorrect = "1"';

        $statement = self::$database->prepare($sql);
        $statement->execute(['resultId0' => $resultId, 'resultId1' => $resultId]);

        $count = $statement->rowCount();

        return $count;
    }

    public function removeQuestionImageById($choiceId)
    {
        $sql = 'UPDATE Choice SET QuestionImage = "" WHERE ChoiceId = :choiceId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['choiceId' => $choiceId]);

        return $statement->rowCount();
    }

    public function updateChoiceTextById()
    {
        $sql = 'UPDATE Choice SET ChoiceText = :choiceText WHERE ChoiceId = :choiceId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['choiceText' => $this->choiceText, 'choiceId' => $this->choiceId]);

        return $statement->rowCount();   
    }

    public function deleteChoicesByResultId($resultId)
    {
        $choices = $this->selectChoicesByResultId($resultId);

        foreach($choices as $choice)
        {
            $this->removeQuestionImageById($choice->ChoiceId);

            if (!$this->isImageInUse($choice->QuestionImage) && !empty($choice->QuestionImage))
            {
                unlink('img/' . $choice->QuestionImage);
            }
        }

        $sql = 'DELETE FROM Choice WHERE ResultId = :resultId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['resultId' => $resultId]);

        return $statement->rowCount();
    }
}
