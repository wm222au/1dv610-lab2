<?php

namespace Controller;

class LoginController extends Controller
{
    private $view;

    public function __construct()
    {
        $this->view = new \View\LoginView();
    }

    public function index(): string
    {
        if ($this->view->userHasLoggedin()) {
            return $this->loginUser($this->view->getLogin());
        } else {
            return $this->showForm();
        }
    }

    private function loginUser(\Model\Login $loginModel)
    {
        $loginModel->loginUser();
        return $this->view->toHTML($loginModel);
    }

    private function showForm(): string
    {
        return $this->view->toHTML(null);
    }
}
