<?php

require_once 'includes.php';

if (file_exists('./env.php')) {
    route();
} else {
    setupDatabase();
}

function setupDatabase()
{
    $view = new \View\SetupView();
    $controller = new \Controller\SetupController($view);

    echo $controller->index();
}

function route()
{
    require_once 'config.php';
    $db = new mysqli($_ENV['db_serverhost'], $_ENV['db_username'], $_ENV['db_password'], $_ENV['db_database']);

    $router = new Router(new \View\LayoutView(), $db);
    $router->route();
}
