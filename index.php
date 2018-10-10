<?php

require_once 'config.php';

$db = new mysqli($_ENV['db_serverhost'], $_ENV['db_username'], $_ENV['db_password'], $_ENV['db_database']);

// echo \Helpers\Auth::hash("bla");

// $router = new Router(new \View\LayoutView());
// $router->route();

$view = new \View\LoginView();

try {
    $user = $view->getUserLogin();
} catch (\Exception $e) {
    echo $e->getMessage();
}

echo $view->toHTML();
