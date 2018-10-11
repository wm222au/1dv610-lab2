<?php

class MySQL_Instance
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

    public function query(string $queryString = '')
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
}
