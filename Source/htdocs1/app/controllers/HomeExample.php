<?php

namespace app\controllers;

/**
 * HomeExample Controller
 */
#[\app\filters\Login]
class HomeExample extends \app\core\Controller
{
    public function index()
    {
        if (isset($_GET['q'])) { header('location:/search?q=' . $_GET['q']); }

        $posts = new \app\models\Post();
        $posts = $posts->selectPosts();

        if (isset($_POST['postcomment']))
        {
            if (!isset($_POST['commenttext']) || !isset($_POST['postid']))
            {
                header('location:/');
                return;
            }

            $profile = new \app\models\Profile();
            $profile = $profile->selectProfileByUserId($_SESSION['userId']);

            $comment = new \app\models\Comment();
            $comment->postId = $_POST['postid'];
            $comment->profileId = $profile['profileId'];
            $comment->comment = $_POST['commenttext'];
            $comment->dateTime = date('Y-m-d H:i:s');

            if ($comment->insertComment() > 0)
            {
                header('location:/post/details/'. $_POST['postid']);
            }

            else
            {
                header('location:/post/details/'. $_POST['postid'] .'?error=An Error Occurred While Creating the Comment.');
            }
        }

        else if (isset($_POST['editcaption']))
        {
            if (!isset($_POST['captiontext']) || !isset($_POST['postid']))
            {
                header('location:/post/create?error=Not All Required Fields Are Filled.');
                return;
            }

            $profile = new \app\models\Profile();
            $profile = $profile->selectProfileByUserId($_SESSION['userId']);

            $post = new \app\models\Post();
            $post = $post->selectPostById($_POST['postid']);

            if ($post['profileId'] == $profile['profileId'])
            {
                $post = new \app\models\Post();
                $post->postId = $_POST['postid'];
                $post->caption = $_POST['captiontext'];

                if ($post->updatePost() > 0)
                {
                    header('location:/post/details/'. $_POST['postid']);
                }

                else
                {
                    header('location:/post/details/'. $_POST['postid'] .'?error=An Error Occurred While Updating the Post.');
                }
            }

            else
            {
                header('location:/post/details/'. $_POST['postid'] .'?error=You Are Not The Author of this Post.');
            }
        }

        else if (isset($_POST['deletepost']))
        {
            if (!isset($_POST['postid']))
            {
                header('location:/');
                return;
            }

            $profile = new \app\models\Profile();
            $profile = $profile->selectProfileByUserId($_SESSION['userId']);

            $post = new \app\models\Post();
            $post = $post->selectPostById($_POST['postid']);

            if ($post['profileId'] == $profile['profileId'])
            {
                $post = new \app\models\Post();
                $post->postId = $_POST['postid'];

                $picture = $post->selectPostById($_POST['postid']);
                $picture = 'img/' . $picture['picture'];

                $comments = new \app\models\Comment();
                $comments->postId = $_POST['postid'];
                $comments->deleteCommentsByPostId();

                if ($post->deletePost() > 0)
                {
                    unlink($picture);
                    header('location:/');
                }

                else
                {
                    header('location:/post/details/'. $_POST['postid'] .'?error=An Error Occurred While Deleting the Post.');
                }
            }

            else
            {
                header('location:/post/details/'. $_POST['postid'] .'?error=You Are Not The Author of this Comment.');
            }
        }

        $this->view('HomeExample/index', ['posts' => $posts]);
    }

    public function search()
    {
        $this->view('HomeExample/index');
    }
}
