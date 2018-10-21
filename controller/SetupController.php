<?php

namespace Controller;

class SetupController
{
    private $view;

    public function __construct(\View\SetupView $toBeViewed)
    {
        $this->view = $toBeViewed;
    }

    public function index(): string
    {
        try {
            $this->handleUserAction();
        } catch (\Exception $e) {
            var_dump($e);
        }

        return $this->view->toHTML();
    }

    private function handleUserAction()
    {
        if ($this->view->userWantsToConnectDB()) {
            $this->createDatabaseSetup();
        }
    }

    private function createDatabaseSetup()
    {
        $dbConfig = $this->view->getDBConfig();

        $db = $this->connectToDatabase($dbConfig);
        $this->createTables($db);

        $this->createEnvironmentFile($dbConfig);
    }

    private function connectToDatabase(array $dbConfig): \mysqli
    {
        $db = new \mysqli($dbConfig['db_serverhost'], $dbConfig['db_username'], $dbConfig['db_password'], $dbConfig['db_database']);
        if ($db->connect_errno) {
            throw new \Exception("Connection error");
        }

        return $db;
    }

    private function createEnvironmentFile(array $dbConfig)
    {
        $file = fopen("env.php", "w");

        $env = "";

        foreach($dbConfig as $dbKey => $dbValue) {
            $env .= "\$_ENV['" . $dbKey . "'] = '" . $dbValue . "'; \n";
        }

        fwrite($file, $env) or die("Cannot write environment file");

        fclose($file);
    }

    private function createTables(\mysqli $db)
    {
        $userRegistry = new \Model\DAL\UserDALMySQL($db);
        $postRegistry = new \Model\DAL\PostDALMySQL($db);

        // It is important that the tables be created in this order because of Primary / Foreign Key relationship
        $userRegistry->createTable();
        $postRegistry->createTable();
    }
}