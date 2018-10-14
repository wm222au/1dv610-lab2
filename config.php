<?php
// Locales
require_once 'env.php';

// Database
require_once 'database/IPersistentRegistry.php';
require_once 'database/PersistentRegistryFactory.php';
require_once 'database/PersistentRegistryMySQLFactory.php';
require_once 'database/mysql/PersistentRegistryMySQL.php';
require_once 'database/mysql/PersistentTokenRegistryMySQL.php';
require_once 'database/mysql/PersistentUserRegistryMySQL.php';

// Helpers
require_once 'helpers/AuthUtilities.php';

// Controllers
require_once 'controller/Controller.php';
require_once 'controller/NavigationController.php';
require_once 'controller/LoginController.php';
require_once 'controller/RegisterController.php';

// Models
require_once 'model/object/User.php';
require_once 'model/object/Username.php';
require_once 'model/object/Password.php';
require_once 'model/object/Token.php';
require_once 'model/layer/IViewModel.php';
require_once 'model/layer/LoginViewModel.php';
require_once 'model/layer/RegisterViewModel.php';
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
