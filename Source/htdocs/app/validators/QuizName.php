<?php

namespace app\validators;

#[\Attribute]
class QuizName extends \app\core\Validator
{
    function valid($quizName)
    {
        if (!preg_match("/^.{8,128}/", $quizName))
        {
            header('location:?error=Quiz Name Doesn\'t Follow Guidelines.');
            return false;
        }

        return true;
    }
}