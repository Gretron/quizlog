<?php

namespace app\models;

class Profile extends \app\core\Model
{
    public function selectProfileById($profileId)
    {
        $sql = 'SELECT * FROM Profile WHERE profileId = :profileId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['profileId' => $profileId]);

        return $statement->fetch();
    }

    public function selectProfileByUserId($userId)
    {
        $sql = 'SELECT * FROM Profile WHERE userId = :userId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['userId' => $userId]);

        return $statement->fetch();
    }

    public function insertProfile()
    {
        $sql = 'INSERT INTO Profile (userId, firstName, middleName, lastName) VALUES (:userId, :firstName, :middleName, :lastName)';

        $statement = self::$database->prepare($sql);
        $statement->execute(['userId' => $this->userId,
            'firstName' => $this->firstName,
            'middleName' => $this->middleName,
            'lastName' => $this->lastName]);

        return $statement->rowCount();
    }

    public function updateProfile()
    {
        $sql = 'UPDATE Profile SET firstName = :firstName, middleName = :middleName, lastName = :lastName WHERE profileId = :profileId';

        $statement = self::$database->prepare($sql);
        $statement->execute(['firstName' => $this->firstName,
            'middleName' => $this->middleName,
            'lastName' => $this->lastName,
            'profileId' => $this->profileId]);

        return $statement->rowCount();
    }
}