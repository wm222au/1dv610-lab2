<?php

namespace Controller;

class RegisterController implements Controller
{
    private $view;

    public function __construct()
    {
        $this->view = new \View\RegisterView();
    }

    public function index(): string
    {
        if ($this->view->userWillRegister()) {
            return $this->registerAccount($this->view->getRegistration());
        } else {
            return $this->showForm();
        }
    }

    public function registerAccount(\Model\RegisterFacade $registerModel)
    {
        if ($registerModel->registerUser()) {
            $login = $this->view->getUserLogin();
            $login->loginUser();
        }
        return $this->view->toHTML($registerModel);
    }

    public function showForm()
    {
        return $this->view->toHTML(null);
    }
}
