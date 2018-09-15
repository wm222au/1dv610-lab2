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

    public function __construct($layoutView)
    {
        $this->layoutView = $layoutView;
    }
    public function route($user)
    {
        if (!empty($_GET)) {
            if (isset($_GET['register'])) {
                // reg form
                $this->contentView = new \Controller\RegisterController($user);
            } else if (isset($_GET['account'])) {
                // show account
            } else if (isset($_GET['logout'])) {
                // logout
            }
        } else {
            // $this->loginController->index();
            $this->contentView = new \Controller\LoginController($user);
        }

        $this->layoutView->render($this->contentView->index());
    }
}
