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
        $dbUser = $this->getUserAsObject($user);

        return $this->createUserFromDbOject($dbUser);
    }

    private function createUserObjectFromAssoc($user)
    {
        return new \Model\User($user->username, $user->password);
    }

    public function exists($user): bool
    {

    }

    public function compare($user): bool
    {

        try {
            $dbUser = $this->getUserAsObject($user);
            return $this->comparePasswords($user->getPassword(), $dbUser->password);
        } catch (Exception $e) {
            throw new \Exception("DB Error occured");
        }
    }

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

    private function getUserAsObject($user)
    {

        $db = new \mysqli($_ENV['db_serverhost'], $_ENV['db_username'], $_ENV['db_password'], $_ENV['db_database']);

        $stmt = $db->prepare("SELECT password FROM {$this->dbTable} WHERE BINARY username = ? LIMIT 1");
        $stmt->bind_param("s", $user->getUsername());
        $stmt->execute();

        $this->checkForErrors($stmt->errno);

        if ($result->num_rows === 0) {
            throw new \Database\UserNotFoundException();
        }

        $result = $stmt->get_result();

        $stmt->close();

        return $result->fetch_object();
    }

    private function comparePasswords($passedPW, $dbPW)
    {
        return password_verify($passedPW, $dbPW);
    }

    private function checkForErrors($errorNumber)
    {
        switch ($errorNumber) {
            case 1062:
                throw new \Database\UserAlreadyExistsException();
        }
    }
}
