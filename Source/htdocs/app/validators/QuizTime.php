<?php

namespace app\validators;

#[\Attribute]
class QuizTime extends \app\core\Validator
{
    function valid($quizTime)
    {
        $time = \DateTime::createFromFormat("h:m:s", $quizTime);

        if (!$time || ($time->format('h') > 3 && $time->format('m') > 0) || ($time->format('h') < 1 && $time->format('m') < 5))
        {
            header('location:?error=Quiz Time Doesn\'t Follow Guidelines.');
            return false;
        }

        return true;
    }
}