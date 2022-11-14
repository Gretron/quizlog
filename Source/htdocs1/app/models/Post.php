<?php

namespace app\models;

class Post extends \app\core\Model
{
    public function selectPosts()
    {
        $sql = 'SELECT * FROM Post ORDER BY dateTime DESC';

        $statement = self::$database->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectPostsByQuery($query)
    {
        $sql = 'SELECT * FROM Post WHERE caption LIKE :query ORDER BY dateTime DESC';

        $statement = self::$database->prepare($sql);
        $statement->execute(['query' => '%' . $query . '%']);

        return $statement->fetchAll();
    }

    public function selectPostById($postId)
    {
        $sql = 'SELECT * FROM Post WHERE postId = :postId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['postId' => $postId]);

        return $statement->fetch();
    }

    public function selectPostsByProfileId($profileId)
    {
        $sql = 'SELECT * FROM Post WHERE profileId = :profileId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['profileId' => $profileId]);

        return $statement->fetchAll();
    }

    public function selectRecentPost($profileId)
    {
        $sql = 'SELECT * FROM Post WHERE  profileId = :profileId ORDER  BY dateTime DESC LIMIT 1';

        $statement = self::$database->prepare($sql);
        $statement->execute(['profileId' => $profileId]);

        return $statement->fetch();
    }

    public function insertPost()
    {
        $sql = 'INSERT INTO Post (profileId, picture, caption, dateTime) VALUES (:profileId, :picture, :caption, :dateTime)';

        $statement = self::$database->prepare($sql);
        $statement->execute(['profileId' => $this->profileId,
            'picture' => $this->picture,
            'caption' => $this->caption,
            'dateTime' => $this->dateTime]);

        return $statement->rowCount();
    }

    public function updatePost()
    {
        $sql = 'UPDATE Post SET caption = :caption WHERE postId = :postId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['caption' => $this->caption, 'postId' => $this->postId]);

        return $statement->rowCount();
    }

    public function deletePost()
    {
        $sql = 'DELETE FROM Post WHERE postId = :postId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['postId' => $this->postId]);

        return $statement->rowCount();
    }
}