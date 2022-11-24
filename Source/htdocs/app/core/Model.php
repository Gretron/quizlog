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

    public function duplicateImage($file)
    {
        $file = 'img/' . $file;
        $info = pathinfo($file);
        $newFile = uniqid() . '.' . $info['extension'];

        if (copy($file, 'img/' . $newFile))
        {
            return $newFile;
        }

        else
        {
            return '';
        }
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
