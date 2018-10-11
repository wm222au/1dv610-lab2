<?php

namespace Database;

class UserNotFoundException extends \Exception
{}

class UserAlreadyExistsException extends \Exception
{}

class PersitentUserRegistryMySQL extends PersistentRegistryMySQL implements \Inter\IPersistentUserRegistry
{
    public function getUser($user): \Model\User
    {
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE BINARY username = ? LIMIT 1");
        $stmt->bind_param("s", $user->getUsername());
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new \Model\Registry\UserNotFoundException();
        }

        return $this->createUserFromDbOject($result->fetch_object());
    }

    private function createUserObjectFromAssoc($user)
    {
        return new \Model\User($user->username, $user->password);
    }

    public function hasUser($user): bool
    {

    }

    public function addUser($user)
    {
        $token = 12;
        $hashedPassword = \Helpers\Auth::hash($user->getPassword());

        try {
            $stmt = $db->prepare("INSERT INTO Users (username, password, tokenId) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $user->getUsername(), $hashedPassword, $token);
            $stmt->execute();
            $stmt->close();
        } catch (Exception $e) {
            if ($mysqli->errno === 1062) {
                // Duplicate
                throw new \Model\Registry\UserAlreadyExistsException();
            }
        }
    }
}
