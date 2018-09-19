<?php

namespace Controller;

class RegisterController
{
    private $view;

    public function __construct()
    {
        $this->view = new \View\RegisterView();
    }

    public function index()
    {
        if ($this->view->userHasRegistered()) {
            return $this->registerAccount($this->view->getRegistration());
        } else {
            return $this->showForm();
        }
    }

    public function registerAccount(\Model\Register $registerModel)
    {
        $registerModel->registerUser();
        return $this->view->toHTML($registerModel);
    }

    public function showForm()
    {
        return $this->view->toHTML(null);
    }
}
