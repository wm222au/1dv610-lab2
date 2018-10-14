<?php

namespace Database;

class UserNotFoundException extends \Exception
{}

class UserAlreadyExistsException extends \Exception
{}

class PersistentUserRegistryMySQL extends PersistentRegistryMySQL
{
    private $dbTable = "Users";

    public function get($user): \Model\User
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->dbTable} WHERE BINARY username = ? LIMIT 1");
        $stmt->bind_param("s", $user->getUsername());
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new \Database\UserNotFoundException();
        }

        return $this->createUserFromDbOject($result->fetch_object());
    }

    private function createUserObjectFromAssoc($user)
    {
        return new \Model\User($user->username, $user->password);
    }

    public function exists($user): bool
    {

    }

    public function compare($user): bool
    {}

    public function add($user)
    {
        $token = 1;
        $hashedPassword = \Helpers\AuthUtilities::hash($user->getPassword());

        $db = new \mysqli($_ENV['db_serverhost'], $_ENV['db_username'], $_ENV['db_password'], $_ENV['db_database']);

        try {
            $stmt = $db->prepare("INSERT INTO {$this->dbTable} (username, password, tokenId) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $user->getUsername(), $hashedPassword, $token);
            $stmt->execute();

            $this->checkForErrors($stmt->errno);

            $stmt->close();
        } catch (Exception $e) {
            throw new \Exception("DB Error occured");
        }
    }

    private function checkForErrors($errorNumber)
    {
        switch ($errorNumber) {
            case 1062:
                throw new \Database\UserAlreadyExistsException();
        }
    }
}
