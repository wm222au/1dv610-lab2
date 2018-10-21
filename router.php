<?php

class Router
{
    private static $registerUrl = 'register';
    private static $postUrl = 'guestbook';

    private $layoutView;
    private $db;

    private $userSession;

    private $contentView;

    public function __construct(\View\LayoutView $layoutView, mysqli $database)
    {
        $this->layoutView = $layoutView;
        $this->db = $database;

        $this->userSession = new \Model\SessionHandler("User");
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
            $view = new \View\LoginView($model);
            $this->contentView = new \Controller\LoginController($view, $model);
        }

        echo $this->layoutView->render($this->userSession, $this->contentView);
    }
}
