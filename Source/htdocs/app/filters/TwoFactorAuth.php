<?php

namespace app\filters;

#[\Attribute]
class TwoFactorAuth extends \app\core\Filter
{
    public function execute()
    {
        if (isset($_SESSION['SecretKey']))
        {
            header('location:/user/enter2FA');
            return true;
        }

        return false;
    }
}