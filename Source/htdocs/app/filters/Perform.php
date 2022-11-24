<?php

namespace app\filters;

#[\Attribute]
class Perform extends \app\core\Filter
{
    public function execute()
    {
        if (isset($_SESSION['UserId']))
        {
            $result = new \app\models\Result();
            $result = $result->selectIncompleteResult($_SESSION['UserId']);

            if ($result)
            {
                header('location:/perform');
                return true;
            }
        }
        
        return false;
    }
}