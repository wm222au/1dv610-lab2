<?php

namespace Helpers;

class DatabaseFailure extends \Exception
{
    private $faultCode;

    public function __construct(int $errNo, string $message = "Something went wrong", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->faultCode = $errNo;
    }

    public function isDuplicate(): bool
    {
        return $this->faultCode == 1062;
    }

    public function noResults(): bool
    {
        return $this->faultCode == -1;
    }
}

class MySQL_Instance implements IDAL
{
    private $connection;

    private $serverhost;
    private $database;
    private $username;
    private $password;

    public $result = array();

    public function __construct(string $serverhost, string $database, string $username, string $password)
    {
        $this->serverhost = $serverhost;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    public function connect()
    {
        $this->connection = new mysqli($this->serverhost, $this->username, $this->password, $this->database);
    }

    public function disconnect()
    {
        $this->connection->close();
    }

    public function query($queryString = '')
    {
        if (!$this->connection || empty($queryString)) {
            return false;
        }

        $result = $this->connection->query($queryString);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->result[] = $row;
            }
        } else {
            return false;
        }

        return true;
    }

    private function throwDBError(\Exception $e)
    {

    }
}
