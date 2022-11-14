<?php

if (!isset($_GET['url']))
{
    header('location:/');
    exit();
}

require('app/core/init.php');

new app\core\App();