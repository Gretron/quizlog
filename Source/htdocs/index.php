<?php

if (!isset($_GET['url']))
{
    header('location:/');
    exit();
}

if(isset($_GET['lang'])){ //if there is a language choice in the querystring
    $lang = $_GET['lang'];//use this language 
    setcookie("lang",$lang,time()+31536000,'/'); //set a cookie
}

else
    $lang=(isset($_COOKIE["lang"])?$_COOKIE["lang"]:'en'); //from cookie or default 

//extract the root language from the complete locale to use with strftime
$rootlang = preg_split('/_/', $lang);
$rootlang = (is_array($rootlang)?$rootlang[0]:$rootlang);

setlocale(LC_ALL, $rootlang.".UTF8");//which locale to use. .UTF8 is to ensure proper encoding of output 
bindtextdomain($lang, "locale"); //pointing to the locale folder for the language of choice 
textdomain($lang); //what is the file name to find translations

require('app/core/init.php');

new app\core\App();