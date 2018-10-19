<?php

require_once 'config.php';

$db = new mysqli($_ENV['db_serverhost'], $_ENV['db_username'], $_ENV['db_password'], $_ENV['db_database']);

$router = new Router(new \View\LayoutView(), $db);
$router->route();
