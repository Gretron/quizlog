<?php

namespace app\controllers;

/**
 * Search Controller
 */
class Search extends \app\core\Controller
{
    public function index()
    {
        if (isset($_GET['q']))
        {
            $quizzes = new \app\models\Quiz();
            $quizzes = $quizzes->selectQuizzesByQuery($_GET['q']);

            $this->view('Search/index', $quizzes);
        }

        else
        {
            $this->view('Search/index');
        }
    }
}