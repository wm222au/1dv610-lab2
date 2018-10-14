<?php

require_once 'config.php';

$db = new mysqli($_ENV['db_serverhost'], $_ENV['db_username'], $_ENV['db_password'], $_ENV['db_database']);

$view = new \View\LayoutView();
$controller = new \Controller\NavigationController($view, $db);

$controller->index();
