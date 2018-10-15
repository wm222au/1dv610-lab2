<?php

namespace Controller;

class NavigationController
{
    private $db;
    private $view;
    private $userSession;

    public function __construct(\View\LayoutView $view, $db)
    {
        $this->userSession = new \model\Session(\helpers\PathUtilities::getClassName(\Model\User::class));
        $this->db = $db;
        $this->view = $view;
    }

    public function index()
    {
        if ($this->view->getUserPageRequest(\View\RegisterView::$viewUrl)) {
            $controller = $this->createRegisterPage();
        } else {
            $controller = $this->createLoginPage();
        }

        $this->view->render($this->userSession, $controller->index());
    }

    private function createLoginPage()
    {
        return new \Controller\LoginController(new \Database\PersistentRegistryMySQLFactory($this->db), $this->userSession);
    }

    private function createRegisterPage()
    {
        return new \Controller\RegisterController(new \Database\PersistentRegistryMySQLFactory($this->db));
    }
}
