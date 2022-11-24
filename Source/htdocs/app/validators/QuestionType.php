<?php

namespace app\validators;

#[\Attribute]
class QuestionType extends \app\core\Validator
{
    function valid($questionType)
    {
        if ($questionType != 'Multiple Choice' && $questionType != 'Short Answer')
        {
            header('location:?error=Question Type Doesn\'t Follow Guidelines.');
            return false;
        }

        return true;
    }
}