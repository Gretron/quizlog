<?php

namespace app\controllers;

/**
 * User Controller
 */
class User extends \app\core\Controller
{
    public function index()
    {
        if (isset($_POST['submit']))
        {
            // Get Inputs
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Get User
            $user = new \app\models\User();
            $user = $user->selectUserByUsername($username);

            if ($user)
            {
                // If Password Is Correct...
                if (password_verify($password, $user->PasswordHash))
                {
                    $_SESSION['UserId'] = $user->UserId;
                    $_SESSION['Username'] = $user->Username;

                    header('location:/home');
                    return;
                }

                else
                {
                    header('location:?error=Incorrect Password for User \''. $username .'\'.');
                    return;
                }
            }

            else
            {
                header('location:?error=User \''. $username .'\' Already Exists.');
                return;
            }
        }

        $this->view('User/login');
    }

    public function register()
    {
        // If Submit Was Clicked...
        if (isset($_POST['submit']))
        {
            // Get Passwords
            $password = $_POST['password'];
            $confirm = $_POST['confirm-password'];

            // If Password Doesn't Match Confirm Password...
            if ($password != $confirm)
            {
                header('location:?error=Confirm Password Doesn\'t Match Password.');
                return;
            }

            $username = $_POST['username'];

            $user = new \app\models\User();
            $user->username = $username;
            $user->password = $password;

            // If Inserting User Works...
            if ($user->insertUser() > 0)
            {
                $user = $user->selectUserByUsername($username);

                $_SESSION['UserId'] = $user->UserId;
                $_SESSION['Username'] = $user->Username;

                header('location:/home');
                return;
            }

            else
            {
                header('location:?error=There was an error registering user.');
                return;
            }
        }

        $this->view('User/register');
    }

    public function profile($id)
    {
        $quizzes = new \app\models\Quiz();
        $quizzes = $quizzes->selectQuizzesByUserId($id[0]);

        $this->view('User/profile', ['userId' => $id[0], 'quizzes' => $quizzes]);
    }

    #[\app\filters\Login]
    public function logout()
    {
        session_destroy();
        header('location:/user');
    }
}