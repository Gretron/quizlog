<?php

namespace app\controllers;

/**
 * UserExample Controller
 */
class UserExample extends \app\core\Controller
{
    public function index()
    {
        if (isset($_POST['submit']))
        {
            if (!isset($_POST['username']) ||
                !isset($_POST['password']))
            {
                header('location:/user/login?error=Not All Required Fields Are Filled.');
                return;
            }

            $user = new \app\models\User();
            $user = $user->selectUserByUsername($_POST['username']);

            if ($user)
            {
                if (password_verify($_POST['password'], $user['passwordHash']))
                {
                    $_SESSION['userId'] = $user['userId'];
                    header('location:/');
                }

                else
                {
                    header('location:/user/login?error=Incorrect Username/Password Combination.');
                }
            }

            else
            {
                header('location:/user/login?error=Incorrect Username/Password Combination.');
            }
        }

        else
        {
            $this->view('UserExample/index');
        }
    }

    public function register()
    {
        if (isset($_POST['submit']))
        {
            if (!isset($_POST['username']) ||
                !isset($_POST['firstname']) ||
                !isset($_POST['lastname']) ||
                !isset($_POST['password']) ||
                !isset($_POST['confirmpassword']))
            {
                header('location:/user/register?error=Not All Required Fields Are Filled.');
                return;
            }

            if ($_POST['password'] == $_POST['confirmpassword'])
            {
                $user = new \app\models\User();
                $username = $user->selectUserByUsername($_POST['username']);

                if (!$username)
                {
                    $user->username = $_POST['username'];
                    $user->passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

                    if ($user->insertUser() > 0)
                    {
                        $user = $user->selectUserByUsername($_POST['username']);

                        $profile = new \app\models\Profile();
                        $profile->userId = $user['userId'];
                        $profile->firstName = $_POST['firstname'];
                        $profile->middleName = $_POST['middlename'];
                        $profile->lastName = $_POST['lastname'];

                        if ($profile->insertProfile() > 0)
                        {
                            header('location:/user/login');
                        }

                        else
                        {
                            header('location:/user/register?error=An Error Occured Whilst Creating UserExample.');
                        }
                    }

                    else
                    {
                        header('location:/user/register?error=An Error Occured Whilst Creating UserExample.');
                    }
                }
            }

            else
            {
                header('location:/user/register?error=Passwords Do Not Match.');
            }
        }

        else
        {
            $this->view('UserExample/register');
        }
    }

    public function logout()
    {
        session_destroy();
        header('location:/user');
    }
}