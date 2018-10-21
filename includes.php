<?php

//INCLUDE THE FILES NEEDED...

require_once 'view/CookieHandler.php';
require_once 'view/View.php';
require_once 'view/SetupView.php';
require_once 'view/FormView.php';
require_once 'view/LayoutView.php';
require_once 'view/DateTimeView.php';
require_once 'view/LoginView.php';
require_once 'view/RegisterView.php';
require_once 'view/PostView.php';

require_once 'controller/Controller.php';
require_once 'controller/SetupController.php';
require_once 'controller/LoginController.php';
require_once 'controller/RegisterController.php';
require_once 'controller/PostController.php';

require_once 'model/LoginFacade.php';
require_once 'model/PostFacade.php';

require_once 'model/DAL/IUserDAL.php';
require_once 'model/DAL/IPostDAL.php';
require_once 'model/DAL/mysql/DALMySQL.php';
require_once 'model/DAL/mysql/UserDALMySQL.php';
require_once 'model/DAL/mysql/PostDALMySQL.php';

require_once 'model/object/User.php';
require_once 'model/object/Post.php';
require_once 'model/object/UserCredentials.php';

require_once 'model/validation/UserValidation.php';
require_once 'model/validation/PostValidation.php';

require_once 'model/session/SessionHandler.php';

require_once 'router.php';

require_once 'helpers/AuthUtilities.php';