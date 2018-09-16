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

    public function registerAccount($username, $password, $repeatedPassword)
    {
        $model = new \Model\Register($username, $password, $repeatedPassword);
        $message = '';
        if ($model->isRegistrationValid()) {
            $user = new \Model\User();
            try {
                if ($user->registerToDatabase($username, $password)) {
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
