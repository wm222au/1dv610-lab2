<?php

namespace Controller;

class RegisterController
{
    private $view;
    private $user;

    public function __construct()
    {
        // $this->user = $user;
        $this->view = new \View\RegisterView();
    }

    public function index()
    {
        if (isset($_POST['RegisterView::UserName']) && isset($_POST['RegisterView::Password']) && isset($_POST['RegisterView::PasswordRepeat'])) {
            return $this->registerAccount($_POST['RegisterView::UserName'], $_POST['RegisterView::Password'], $_POST['RegisterView::PasswordRepeat']);
        } else {
            return $this->showForm();
        }
    }

    public function registerAccount($username, $password, $repeatedPassword)
    {
        $message = '';
        $user = new \Model\User($username, $password);
        $model = new \Model\Register($user, $repeatedPassword);
        if ($model->getPasswordsEqual()) {
            try {
                if ($user->registerToDatabase()) {
                    $message .= 'Registered new user.';
                } else {
                    $message .= 'User exists, pick another username.';
                }
            } catch (Exception $error) {
                $message .= $error->getMessage();
            }
        }
        return $this->view->toHTML($model, $message);
    }

    public function showForm()
    {
        return $this->view->toHTML(null, '');
    }
}
