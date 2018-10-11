<?php

namespace Controller;

class RegisterController
{
    private $view;
    private $userRegistry;

    public function __construct(\Inter\IPersistentUserRegistry $registry)
    {
        $this->view = new \View\RegisterView();
        $this->userRegistry = $registry;
    }

    public function index()
    {
        if ($this->view->userWillRegister()) {
            return $this->registerAccount($this->view->getRegistration());
        } else {
            return $this->showForm();
        }
    }

    public function registerAccount(\Model\Register $registerModel)
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
