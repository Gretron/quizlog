<?php

namespace app\models;

class User extends \app\core\Model
{
    #[\app\validators\Username]
    public $username;

    #[\app\validators\Password]
    public $password;

    public function selectUsers()
    {
        $sql = 'SELECT * FROM UserExample';

        $statement = self::$database->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(\PDO::FETCH_CLASS, 'app\models\User');

        return $statement->fetchAll();
    }

    public function selectUserById($userId)
    {
        $sql = 'SELECT * FROM User WHERE UserId = :userId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['userId' => $userId]);

        return $statement->fetch();
    }

    public function selectUserByUsername($username)
    {
        $sql = 'SELECT * FROM User WHERE Username = :username';

        $statement = self::$database->prepare($sql);
        $statement->execute(['username' => $username]);

        return $statement->fetch();
    }

    protected function insertUser()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        $sql = 'INSERT INTO User (Username, PasswordHash) VALUES (:username, :passwordHash)';

        $statement = self::$database->prepare($sql);
        $statement->execute(['username' => $this->username, 'passwordHash' => $this->password]);

        return $statement->rowCount();
    }
}