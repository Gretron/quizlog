<?php

namespace app\controllers;

/**
 * Home Controller
 */
class Home extends \app\core\Controller
{
    #[\app\filters\Login]
    #[\app\filters\Perform]
    public function index()
    {
        $quizzes = new \app\models\Quiz();
        $quizzes = $quizzes->selectPublicQuizzes();

        $this->view('Home/index', $quizzes);
    }
}