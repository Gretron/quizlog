<?php

namespace app\models;

class Comment extends \app\core\Model
{
    public function selectCommentById($commentId)
    {
        $sql = 'SELECT * FROM Comment WHERE commentId = :commentId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['commentId' => $commentId]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\User');

        return $statement->fetch();
    }

    public function selectCommentsByPostId($postId)
    {
        $sql = 'SELECT * FROM Comment WHERE postId = :postId ORDER BY dateTime DESC';

        $statement = self::$database->prepare($sql);
        $statement->execute(['postId' => $postId]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\User');

        return $statement->fetchAll();
    }

    public function insertComment()
    {
        $sql = 'INSERT INTO Comment (postId, profileId, comment, dateTime) VALUES (:postId, :profileId, :comment, :dateTime)';

        $statement = self::$database->prepare($sql);
        $statement->execute(['postId' => $this->postId,
            'profileId' => $this->profileId,
            'comment' => $this->comment,
            'dateTime' => $this->dateTime]);

        return $statement->rowCount();
    }

    public function updateComment()
    {
        $sql = 'UPDATE Comment SET comment = :comment WHERE commentId = :commentId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['comment' => $this->comment, 'commentId' => $this->commentId]);

        return $statement->rowCount();
    }

    public function deleteComment()
    {
        $sql = 'DELETE FROM Comment WHERE commentId = :commentId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['commentId' => $this->commentId]);

        return $statement->rowCount();
    }

    public function deleteCommentsByPostId()
    {
        $sql = 'DELETE FROM Comment WHERE postId = :postId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['postId' => $this->postId]);

        return $statement->rowCount();
    }
}