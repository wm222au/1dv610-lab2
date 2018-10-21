<?php

class Router
{
    private $db;
    private $userSession;

    private $contentView;
    private $layoutView;

    public static $homeUrl = '/';
    public static $registerUrl = 'register';
    public static $postUrl = 'guestbook';

    public function __construct()
    {
        $this->userSession = new \Model\SessionHandler("User");
    }

    public function getDatabase(): mysqli
    {
        return $this->db;
    }

    public function setDatabase(mysqli $database)
    {
        $this->db = $database;
    }

    public function route()
    {
        if (!empty($_GET)) {
            if (isset($_GET[self::$registerUrl])) {
                $userRegistry = new \Model\DAL\UserDALMySQL($this->db);

                $model = new \Model\RegisterFacade($userRegistry, $this->userSession);
                $view = new \View\RegisterView($model);

                $this->contentView = new \Controller\RegisterController($view, $model);

            } else if(isset($_GET[self::$postUrl])) {
                $postRegistry = new \Model\DAL\PostDALMySQL($this->db);

                $model = new \Model\PostFacade($postRegistry, $this->userSession);
                $view = new \View\PostView($model);
                $this->contentView = new \Controller\PostController($view, $model);

            } else {
                echo "404 – page not found";
            }
        } else {
            $userRegistry = new \Model\DAL\UserDALMySQL($this->db);

            $model = new \Model\LoginFacade($userRegistry, $this->userSession);
            $view = new \View\LoginView($model, self::$registerUrl);
            $this->contentView = new \Controller\LoginController($view, $model);
        }

        $this->layoutView = new \View\LayoutView($this->userSession, $this->contentView);

        echo $this->layoutView->toHTML();
    }
}
