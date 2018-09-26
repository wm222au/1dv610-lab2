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

    private $user;

    public function __construct($layoutView)
    {
        $this->layoutView = $layoutView;
        $this->user = new \Model\User();
    }
    public function route()
    {
        if (!empty($_GET)) {
            if (isset($_GET['register'])) {
                // reg form
                $this->contentView = new \Controller\RegisterController();
            } else if (isset($_GET['account'])) {
                // show account
            } else if (isset($_GET['logout'])) {
                // logout
            }
        } else {
            // $this->loginController->index();
            $this->contentView = new \Controller\LoginController();
        }

        echo $this->layoutView->render($this->user->getUser(), $this->contentView->index());
    }
}
