<?php

namespace Controller;

class RegisterController
{
    private $view;
    private $user;
    private $model;

    public function __construct(\Model\User $user)
    {
        $this->user = $user;
        $this->view = new \View\RegisterView($this->user);

        $this->model = (object) ['usernameTooShort' => false, 'passwordTooShort' => false, 'passwordNotEqual' => false];
    }

    public function index()
    {
        if (isset($_POST['RegisterView::UserName']) && isset($_POST['RegisterView::Password']) && isset($_POST['RegisterView::PasswordRepeat'])) {
            return $this->registerAccount($_POST['RegisterView::UserName'], $_POST['RegisterView::Password'], $_POST['RegisterView::PasswordRepeat']);
        } else {
            return $this->showForm();
        }
    }

    public function registerAccount($user, $pw, $pwr)
    {
        if (strlen($user) < 3) {
            $$this->model->usernameTooShort = true;
        }
        if (strlen($pw) < 6) {
            $this->model->passwordTooShort = true;
        }
        if ($pw != $pwr) {
            $this->model->passwordNotEqual = true;
        }
        return $this->view->toHTML(null);
    }

    public function showForm()
    {
        return $this->view->toHTML(null);
    }
}
