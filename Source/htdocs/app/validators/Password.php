<?php

namespace app\validators;

#[\Attribute]
class Password extends \app\core\Validator
{
    function valid($password)
    {
        if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $password))
        {
            header('location:?error=Password Doesn\'t Follow Guidelines.');
            return false;
        }

        return true;
    }
}