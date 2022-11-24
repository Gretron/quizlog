<?php

namespace app\validators;

#[\Attribute]
class QuestionText extends \app\core\Validator
{
    function valid($questionText)
    {
        if (!preg_match("/^.{8,}/", $questionText))
        {
            header('location:?error=Question Text Doesn\'t Follow Guidelines.');
            return false;
        }

        return true;
    }
}