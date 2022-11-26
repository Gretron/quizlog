<?php

namespace app\core;

class Model
{
    protected static $database;

    public function __construct()
    {
        $server = 'localhost';
        $name = 'quizlog';
        $username = 'root';
        $password = '';

        try
        {
            self::$database = new \PDO("mysql:host=$server;dbname=$name", $username, $password);
            self::$database->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        catch (\Exception $e)
        {
            echo 'Error occurred whilst attempting to connect to the database...';
            exit(0);
        }
    }

    public function isImageInUse($image)
    {
        $sql = 'SELECT QuizBanner FROM Quiz WHERE QuizBanner = :quizBanner';

        $statement = self::$database->prepare($sql);
        $statement->execute(['quizBanner' => $image]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Quiz');
        $rows = $statement->fetchAll();

        if ($rows)
        {
            return true;
        }

        $sql = 'SELECT QuestionImage FROM Question WHERE QuestionImage = :questionImage';

        $statement = self::$database->prepare($sql);
        $statement->execute(['questionImage' => $image]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Question');
        $rows = $statement->fetchAll();

        if ($rows)
        {
            return true;
        }

        $sql = 'SELECT ResultImage FROM Result WHERE ResultImage = :resultImage';

        $statement = self::$database->prepare($sql);
        $statement->execute(['resultImage' => $image]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Result');
        $rows = $statement->fetchAll();

        if ($rows)
        {
            return true;
        }

        $sql = 'SELECT QuestionImage FROM Choice WHERE QuestionImage = :questionImage';

        $statement = self::$database->prepare($sql);
        $statement->execute(['questionImage' => $image]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\Choice');
        $rows = $statement->fetchAll();

        if ($rows)
        {
            return true;
        }

        return false;
    }

    public function isValid()
    {
        $reflection = new \ReflectionObject($this);
        $classProperties = $reflection->getProperties();

        foreach ($classProperties as $property)
        {
            $propertyAttributes = $property->getAttributes();

            foreach ($propertyAttributes as $attribute)
            {
                $test = $attribute->newInstance();

                if (!$test->valid($property->getValue($this)))
                {
                    return false;
                }
            }
        }

        return true;
    }

    public function __call($method, $arguments){
        if ($this->isValid())
            return call_user_func_array([$this, $method], $arguments);
    }
}
