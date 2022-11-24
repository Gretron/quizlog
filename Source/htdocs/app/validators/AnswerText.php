<?php

namespace app\validators;

#[\Attribute]
class AnswerText extends \app\core\Validator
{
    function valid($answerText)
    {
        if (!preg_match("/^.{1,}/", $answerText))
        {
            header('location:?error=Answer Text Doesn\'t Follow Guidelines.');
            return false;
        }

        return true;
    }
}