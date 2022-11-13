<?php

namespace app\models;

class Question extends \app\core\Model
{
    protected function insertQuestion()
    {
        $sql = 'INSERT INTO Question (QuizId, QuestionText, QuestionImage, QuestionHint, QuestionType) 
                VALUES (:quizId, :questionText, :questionImage, :questionHint, :questionType)';

        $statement = self::$database->prepare($sql);
        $statement->execute(['quizId' => $this->quizId, 'questionText' => $this->questionText, 'questionImage' => $this->questionImage,
            'questionHint' => $this->questionHint, 'questionType' => $this->questionType]);

        return $statement->rowCount();
    }

    public function deleteQuestion()
    {

    }
}