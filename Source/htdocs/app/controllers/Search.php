<?php

namespace app\controllers;

/**
 * Search Controller
 */
class Search extends \app\core\Controller
{
    public function index()
    {
        // $_GET['q']

        $this->view('Search/index');
    }
}