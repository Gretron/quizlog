<?php

namespace app\validators;

#[\Attribute]
class Username extends \app\core\Validator
{
    function valid($username)
    {
        if (!preg_match("/^(?=[a-zA-Z0-9._]{4,48}$)(?!.*[_.]{2})[^_.].*[^_.]$/", $username))
        {
            header('location:?error=Username Doesn\'t Follow Guidelines.');
            return false;
        }

        $user = new \app\models\User();
        $user = $user->selectUserByUsername($username);

        // If User with Username Exists...
        if ($user)
        {
            header('location:?error=User \''. $username .'\' Already Exists.');
            return false;
        }

        return true;
    }
}