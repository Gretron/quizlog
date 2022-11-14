<?php

namespace app\controllers;

/**
 * Home Controller
 */
class Home extends \app\core\Controller
{
    public function index()
    {
        $this->view('Home/index');
    }
}