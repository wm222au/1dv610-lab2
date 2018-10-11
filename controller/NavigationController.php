<?php

namespace Controller;

class NavigationController extends Controller
{
    private $view;
    private $db;

    public function __construct(\View\LayoutView $view, $db)
    {
        $this->db = $db;
        $this->view = $view;
    }

    public function index(): string
    {
        if ($this->view->getUserRequestsRegister()) {
            $controller = $this->createRegisterPage();
        } else {
            $controller = $this->createLoginPage();
        }
        $view->render(false, $controller->index());
    }

    private function createLoginPage()
    {
        return new \Controller\LoginController(new \Model\Registry\PersistentUserRegistryMySQL($this->db));
    }

    private function createRegisterPage()
    {
        return new \Controller\RegisterController();
    }
}
