<?php

namespace \Model\DAL;

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

class DALMySQL
{
    protected $db;
    protected $dbTable = "";

    public function __construct(mysqli $database)
    {
        $this->db = $database;
    }

    protected function checkStatementForErrors($errCode)
    {
        if ($errCode) {
            throw new DatabaseFailure($errCode);
        }
    }
}