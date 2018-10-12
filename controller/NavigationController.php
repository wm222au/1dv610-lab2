<?php

namespace Controller;

class NavigationController
{
    private $view;
    private $db;

    public function __construct(\View\LayoutView $view, $db)
    {
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
        $this->view->render(false, $controller->index());
    }

    private function createLoginPage()
    {
        return new \Controller\LoginController(new \Database\PersistentRegistryMySQLFactory($this->db));
    }

    private function createRegisterPage()
    {
        return new \Controller\RegisterController(new \Database\PersistentRegistryMySQLFactory($this->db));
    }
}
