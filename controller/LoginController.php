<?php

namespace Controller;

use Helpers\AuthUtilities;

class LoginController implements Controller
{
    private $view;
    private $model;

    public function __construct(\View\LoginView $view, \Model\LoginFacade $toBeViewed)
    {
        $this->view = $view;
        $this->model = $toBeViewed;
    }

    public function index(): string
    {
        try {
            $this->handleUserAction();
        } catch(\Exception $e) {
            error_log($e->getMessage());
        }

        return $this->view->toHTML();
    }

    private function handleUserAction()
    {
        if ($this->view->userWillLoginViaForm()) {
            $this->loginViaForm();
        }
        else if ($this->view->userWillLoginViaCookie()) {
            return $this->loginWithToken($this->view->getCookieToken());

        } else if ($this->view->userWillLogout()) {
            return $this->logoutUser($this->view->getUserLogout());
        }
    }

    private function loginViaForm()
    {
        $user = $this->view->getUserObject();

        $userCredentials = new \Model\UserCredentials();
        $userCredentials->setUser($user);
        $userCredentials->setToken(AuthUtilities::randomString());

        $this->model->loginUserThrowsOnFail($userCredentials);

        if($this->view->userWantsToBeRemembered()) {
            $this->view->setCookie($userCredentials->getToken());
        }
    }
}
