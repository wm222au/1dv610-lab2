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
    private $loginView;
    private $registerView;

    private $user;

    public function __construct($layoutView)
    {
        $this->layoutView = $layoutView;
        $this->loginView = new \View\LoginView();
        $this->registerView = new \View\registerView();

        $this->user = new \Model\User();
    }
    public function route()
    {
        if (!empty($_GET)) {
            if (isset($_GET['register'])) {
                // reg form
                $this->contentView = new \Controller\RegisterController();
            }
        } else {
            // $this->loginController->index();
            $this->contentView = new \Controller\LoginController();
        }

        echo $this->layoutView->render($this->user->getUser(), $this->contentView);
    }
}
