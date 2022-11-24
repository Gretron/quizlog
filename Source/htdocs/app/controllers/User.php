<?php

namespace app\controllers;

/**
 * User Controller
 */
class User extends \app\core\Controller
{
    public function index()
    {
        if (isset($_SESSION['UserId']))
        {
            header('location:/home');
        }

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
        if (isset($_SESSION['UserId']))
        {
            header('location:/home');
        }

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

    #[\app\filters\Login]
    #[\app\filters\Perform]
    public function profile($id)
    {
        $id = $id[0];

        $quizzes = new \app\models\Quiz();

        if ($id == $_SESSION['UserId'])
        {
            $quizzes = $quizzes->selectQuizzesByUserId($id);
        }
        
        else 
        {
            $quizzes = $quizzes->selectPublicQuizzesByUserId($id);
        }

        $this->view('User/profile', ['userId' => $id, 'quizzes' => $quizzes]);
    }

    #[\app\filters\Login]
    #[\app\filters\Perform]
    public function logout()
    {
        session_destroy();
        header('location:/user');
    }
}