<?php

namespace Controller;

class LoginController extends Controller
{
    private $user;
    private $view;

    public function __construct(\Model\User $user)
    {
        $this->user = $user;
        $this->view = new \View\LoginView($this->user);
    }

    public function index(): string
    {
        return $this->showForm();
    }

    private function showForm(): string
    {
        return $this->view->toHTML(null, '');
    }
}
