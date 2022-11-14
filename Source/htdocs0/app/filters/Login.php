<?php

namespace app\filters;

#[\Attribute]
class Login extends \app\core\Filter
{
    public function execute()
    {
        if (!isset($_SESSION['UserId']))
        {
            header('location:/user');
            return true;
        }

        return false;
    }
}