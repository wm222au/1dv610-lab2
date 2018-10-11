<?php
// Locales
require_once 'env.php';

// Helpers
require_once 'helpers/Auth.php';
require_once 'helpers/mysql.php';

// Controllers
require_once 'controller/Controller.php';
require_once 'controller/LoginController.php';
require_once 'controller/RegisterController.php';

// Models
require_once 'model/Register.php';
require_once 'model/Login.php';
require_once 'model/component/User.php';
require_once 'model/Session.php';

// Views
require_once 'view/View.php';
require_once 'view/LayoutView.php';
require_once 'view/LoginView.php';
require_once 'view/RegisterView.php';

// Enable errors if in development environment
if ($_ENV['environment'] == 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
} else {
    error_reporting(false);
    ini_set('display_errors', 'Off');
}
