<?php

namespace Model\DAL;


class UserDALMySQL extends DALMySQL implements \Model\DAL\IUserDAL
{
    protected $dbTable = "Users";

    public function getById(string $id): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->dbTable} WHERE id = ? LIMIT 1");
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $this->checkStatementForErrors($stmt->errno);

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new \DatabaseFailure(-1);
        }

        $stmt->close();

        return $result->fetch_assoc();
    }

    public function add(\Model\UserCredentials $userCredentials)
    {
        $token = $userCredentials->getToken();
        $username = $userCredentials->getUsername();
        $hashedPassword = \Helpers\AuthUtilities::hash($userCredentials->getPassword());

        try {
            $stmt = $this->db->prepare("INSERT INTO {$this->dbTable} (username, password, token) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashedPassword, $token);
            $stmt->execute();

            $this->checkStatementForErrors($stmt->errno);

            $stmt->close();
        } catch (Exception $e) {
            throw new \Exception(0);
        }
    }

    public function compareUser(\Model\UserCredentials $userCredentials): bool
    {
        try {
            $user = $userCredentials->getUser();

            $dbUser = $this->queryWithUsername($user->getUsername());

            return password_verify($user->getPassword(), $dbUser['password']);

        } catch (Exception $e) {
            throw new \DatabaseFailure(0);
        }
    }

    public function compareToken(string $token): bool
    {
        try {
            return $this->queryWithToken($token);
        } catch (Exception $e) {
            throw new \DatabaseFailure(0);
        }
    }

    public function updateToken(\Model\UserCredentials $userCredentials)
    {
        $token = $userCredentials->getToken();
        $user = $userCredentials->getUser();
        $username = $user->getUsername();

        try {
            $stmt = $this->db->prepare("UPDATE {$this->dbTable} SET token=? WHERE username=?");
            $stmt->bind_param("ss", $token, $username);
            $stmt->execute();

            $this->checkStatementForErrors($stmt->errno);

            $stmt->close();
        } catch (Exception $e) {
            throw new \Exception(0);
        }
    }

    private function queryWithUsername(string $username)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->dbTable} WHERE BINARY username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $this->checkStatementForErrors($stmt->errno);

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new \DatabaseFailure(-1);
        }

        $stmt->close();

        return $result->fetch_assoc();
    }

    private function queryWithToken(string $token)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->dbTable} WHERE BINARY token= ? LIMIT 1");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        $this->checkStatementForErrors($stmt->errno);

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new \DatabaseFailure(-1);
        }

        $stmt->close();

        return $result->fetch_assoc();
    }
}
