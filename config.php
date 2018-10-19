<?php

//INCLUDE THE FILES NEEDED...
require_once 'env.php';

require_once 'view/CookieHandler.php';
require_once 'view/View.php';
require_once 'view/LayoutView.php';
require_once 'view/DateTimeView.php';
require_once 'view/LoginView.php';
require_once 'view/RegisterView.php';

require_once 'controller/Controller.php';
require_once 'controller/LoginController.php';
require_once 'controller/RegisterController.php';

require_once 'model/RegisterFacade.php';
require_once 'model/LoginFacade.php';

require_once 'model/DAL/IUserDAL.php';
require_once 'model/DAL/IPostDAL.php';
require_once 'model/DAL/mysql/UserDALMySQL.php';
require_once 'model/DAL/mysql/PostDALMySQL.php';

require_once 'model/object/User.php';
require_once 'model/object/Post.php';
require_once 'model/session/SessionHandler.php';

require_once 'router.php';

require_once 'helpers/AuthUtilities.php';
require_once 'helpers/IDAL.php';
require_once 'helpers/IDALMySQL.php';

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
if ($_ENV['environment'] == 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
} else {
    error_reporting(false);
    ini_set('display_errors', 'Off');
}
