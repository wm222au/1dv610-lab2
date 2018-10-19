<?php

function RouterRedirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);

    exit();
}

class Router
{
    private $layoutView;
    private $contentView;
    private $db;

    private $userSession;

    public function __construct(\View\LayoutView $layoutView, mysqli $database)
    {
        $this->layoutView = $layoutView;
        $this->db = $database;

        $this->userSession = new \Model\SessionHandler("User");
    }

    public function route()
    {
        if (!empty($_GET)) {
            if (isset($_GET['register'])) {
                // reg form
                $this->contentView = new \Controller\RegisterController();
            } else if(isset($_GET['posts'])) {
                $this->contentView = new \Controller\PostController();
            } else {
                echo "404 not found";
            }
        } else {
            $model = new \Model\LoginFacade($this->userSession);
            $view = new \View\LoginView();
            $this->contentView = new \Controller\LoginController($view, $model);
        }

        echo $this->layoutView->render($this->userSession, $this->contentView);
    }
}
