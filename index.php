<?php

//INCLUDE THE FILES NEEDED...
require_once 'env.php';

require_once 'view/View.php';
require_once 'view/LayoutView.php';
require_once 'view/LoginView.php';
require_once 'view/RegisterView.php';
require_once 'controller/Controller.php';
require_once 'controller/LoginController.php';
require_once 'controller/RegisterController.php';
require_once 'model/Register.php';
require_once 'model/User.php';
require_once 'model/SessionStorage.php';

require_once 'router.php';
require_once 'mysql.php';

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// My Code
// $db = new MySQL_Instance($_ENV['db_serverhost'], $_ENV['db_database'], $_ENV['db_username'], $_ENV['db_password']);
// $db->connect();

$db = new mysqli($_ENV['db_serverhost'], $_ENV['db_username'], $_ENV['db_password'], $_ENV['db_database']);

// $storage = new \Model\SessionStorage('User');
// $user = $storage->loadEntry();

$router = new Router(new \View\LayoutView());
$router->route();

// $storage->saveEntry($user);
