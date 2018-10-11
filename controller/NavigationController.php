<?php

namespace Controller;

class NavigationController extends Controller
{
    private $view;

    public function __construct(\View\LayoutView $view)
    {
        $this->view = $view;
    }

    public function index(): string
    {
        if ($this->view->getUserRequestsRegister()) {
            $controller = $this->createRegisterPage();
        } else {
            $controller = $this->createLoginPage();
        }
        $controller->index();
    }

    private function createLoginPage()
    {
        return new \Controller\LoginController();
    }

    private function createRegisterPage()
    {
        return new \Controller\RegisterController();
    }
}
