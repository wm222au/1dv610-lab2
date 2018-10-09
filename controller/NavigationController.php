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
        if ($this->view->getUserNavigationRegister) {
            $this->createRegisterPage();
        } else {
            $this->createLoginPage();
        }
    }

    private function createLoginPage()
    {

    }

    private function createRegisterPage()
    {

    }
}
