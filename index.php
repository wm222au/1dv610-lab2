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
require_once 'model/Login.php';
require_once 'model/components/User.php';
require_once 'model/session/UserStorage.php';

require_once 'helpers/Auth.php';

require_once 'router.php';
require_once 'mysql.php';

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
if ($_ENV['environment'] == 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
} else {
    error_reporting(false);
    ini_set('display_errors', 'Off');
}

$db = new mysqli($_ENV['db_serverhost'], $_ENV['db_username'], $_ENV['db_password'], $_ENV['db_database']);

// echo \Helpers\Auth::hash("bla");

$router = new Router(new \View\LayoutView());
$router->route();
