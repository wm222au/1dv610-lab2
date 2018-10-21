<?php

namespace Controller;

use Helpers\AuthUtilities;
use Model\DAL\DatabaseFailure;
use Model\UserValidationFailure;

class RegisterController implements Controller
{
    private $view;
    private $model;

    public function __construct(\View\RegisterView $view, \Model\RegisterFacade $toBeViewed)
    {
        $this->view = $view;
        $this->model = $toBeViewed;
    }

    public function index(): string
    {
        try {
            $this->handleUserAction();
        } catch (\Exception $exception) {
            return $this->determineErrorRendering($exception);
        } catch (\Error $error) {
            return $this->determineErrorRendering(new \Exception());
        }

        return $this->view->toHTML();
    }

    private function handleUserAction()
    {
        if ($this->view->userWillRegister()) {
            $this->registerAccount();
        }
    }

    private function determineErrorRendering(\Exception $e): string
    {
        if ($e instanceof UserValidationFailure) {
            return $this->view->validationErrorToHTML($e->getUserValidation());
        } else {
            return $this->view->registrationErrorToHTML($e);
        }
    }

    public function registerAccount()
    {
        $user = $this->view->getUserObject();
        $repeatedPassword = $this->view->getPasswordRepeat();

        $userCredentials = new \Model\UserCredentials();
        $userCredentials->setUsername($user->getUsername());
        $userCredentials->setPassword($user->getPassword());
        $userCredentials->setToken(AuthUtilities::randomString());

        $this->model->registerAccount($userCredentials, $repeatedPassword);
    }
}
