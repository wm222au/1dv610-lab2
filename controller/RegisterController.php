<?php

namespace Controller;

class RegisterController
{
    private $view;
    private $user;

    public function __construct(\Model\User $user)
    {
        $this->user = $user;
        $this->view = new \View\RegisterView($this->user);
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
        $model = new \Model\Register($user, $pw, $pwr);
        $message = '';
        if ($model->isRegistrationValid()) {
            $message = 'Account registered';
        }
        return $this->view->toHTML($model, $message);
    }

    public function showForm()
    {
        return $this->view->toHTML(null, '');
    }
}
