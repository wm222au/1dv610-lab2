<?php

namespace Model;

use Exception;

class UsernameEmptyException extends Exception
{}
class UsernameTooShortException extends Exception
{}
class UsernameCharactersInvalidException extends Exception
{}
class PasswordEmptyException extends Exception
{}
class PasswordTooShortException extends Exception
{}

class User
{
    private $username;
    private $password;

    public static $minUsernameLength = 3;
    public static $minPasswordLength = 6;

    public function __construct(string $username, string $password)
    {
        $this->setUsername($username);
        $this->setPassword($password);
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    private function setUsername($username)
    {
        if (empty($username)) {
            throw new \Model\UsernameEmptyException();
        } else if (strlen($username) >= self::$minUsernameLength) {
            throw new \Model\UsernameTooShortException();
            // Check if username contains valid username tags
        } else if (strip_tags($username) !== $username) {
            throw new \Model\Model\UsernameCharactersInvalidException();
        }
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    private function setPassword($password)
    {
        if (empty($password)) {
            throw new \Model\PasswordEmptyException();
        } else if (strlen($password) >= self::$minPasswordLength) {
            throw new \Model\PasswordTooShortException();
        }
        $this->password = $password;
    }

    public function registerUserToDatabase(): bool
    {
        if (!$this->isUsernameValid() || !$this->isPasswordValid()) {
            throw new Exception('User credentials is not valid.');
        }

        global $db;

        $hashedPassword = self::hash($this->password);

        $escapedUsername = $db->real_escape_string($this->username);
        $queryString = "INSERT INTO users (username, password) VALUES ('$escapedUsername', '$hashedPassword')";

        return $db->query($queryString);
    }

    public function loginUser(): bool
    {
        global $db;

        $escapedUsername = $db->real_escape_string($this->username);
        $queryString = "SELECT * FROM users WHERE BINARY username = '" . $escapedUsername . "' LIMIT 1";
        $result = $db->query($queryString);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($this->password, $user['password'])) {
                $this->setUsername($user['username']);
                $this->setPassword($user['password']);
                $this->storage->saveEntry($this);
            } else {
                throw new Exception('Password did not match.');
            }

            return true;
        } else {
            return false;
        }
    }
}
