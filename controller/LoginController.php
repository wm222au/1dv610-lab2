<?php

namespace Controller;

class LoginController extends Controller
{
    private $user;
    private $view;

    public function __construct()
    {
        // $this->user = $user;
        $this->view = new \View\LoginView();
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
