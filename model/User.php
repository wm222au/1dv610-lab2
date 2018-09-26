<?php

namespace Model;

use Exception;

class User
{
    private $username;
    private $password;

    private $storage;

    private static $hashOptions = ['cost' => 12];

    public static $minUsernameLength = 3;
    public static $minPasswordLength = 6;

    public function __construct(string $username = '', string $password = '')
    {
        $this->username = $username;
        $this->password = $password;

        $this->storage = new \Model\SessionStorage('User', 'user');
    }

    public function getIsLoggedIn(): bool
    {
        return $this->storage->exists();
    }

    public function getUser(): \Model\User
    {
        return $this->storage->loadEntry();
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    private function setUsername($username)
    {
        if ($this->isUsernameValid($username)) {
            $this->username = $username;
        } else {
            throw new Exception("Username didn't fulfill conditions.");
        }
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    private function setPassword($password)
    {
        if ($this->isPasswordValid($password)) {
            $this->password = $password;
        } else {
            throw new Exception("Password didn't fulfill conditions.");
        }
    }

    public function isUsernameEmpty(): bool
    {
        return empty($this->username);
    }

    public function isPasswordEmpty(): bool
    {
        return empty($this->password);
    }

    public function isUsernameValid(): bool
    {
        return (strlen($this->username) >= self::$minUsernameLength);
    }

    public function isPasswordValid(): bool
    {
        return (strlen($this->password) >= self::$minPasswordLength);
    }

    private static function hash(string $clearTextPassword): string
    {
        return password_hash($clearTextPassword, PASSWORD_BCRYPT, SELF::$hashOptions);
    }

    public function registerUserToDatabase(): bool
    {
        if (!$this->isUsernameValid() || !$this->isPasswordValid()) {
            throw new Exception('User credentials is not valid.');
        }

        global $db;

        $hashedPassword = self::hash($this->password);

        $queryString = "INSERT INTO Users (username, password) VALUES ('$this->username', '$hashedPassword')";

        return $db->query($queryString);
    }

    public function loginUser(): bool
    {
        global $db;

        $queryString = "SELECT * FROM Users WHERE username = '" . $this->username . "' LIMIT 1";
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

    public function logoutUser(): bool
    {
        // global $db;

        // $queryString = "SELECT * FROM Users WHERE username = $this->username LIMIT 1";
        // $result = $db->query($queryString);

        // if ($result && $result->num_rows > 0) {
        //     $user = mysql_fetch_assoc($result);

        //     if (password_verify($this->password, $user['password'])) {
        //         $this->setUsername($user['username']);
        //         $this->setPassword($user['password']);
        //     } else {
        //         throw new Exception('Password did not match.');
        //     }

        //     return true;
        // } else {
        //     return false;
        // }
        $this->storage->saveEntry($this);
    }

    public function isUserLoggedIn(): bool
    {
        // Check if this class equals cookie(?)
        return true;
    }
}
