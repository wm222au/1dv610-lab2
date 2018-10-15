<?php

namespace Controller;

class LoginController implements IController
{
    private $view;
    private $viewModel;
    private $userSession;
    private $userRegistry;
    private $tokenRegistry;

    public function __construct(\Database\PersistentRegistryFactory $factory, \model\Session $userSession)
    {
        $this->userSession = $userSession;

        $this->userRegistry = $factory->build(\helpers\PathUtilities::getClassName(\Model\User::class));
        $this->tokenRegistry = $factory->build(\helpers\PathUtilities::getClassName(\Model\Token::class));

        $this->viewModel = new \model\LoginViewModel();
        $this->view = new \View\LoginView($this->viewModel, $this->userSession);
    }

    public function index(): \View\View
    {
        if ($this->view->userWillLogin()) {
            return $this->attemptLogin();
        } else if ($this->view->userWillLogout()) {
            return $this->attemptLogout();
        }

        return $this->showForm();
    }

    private function attemptLogin()
    {
        try {
            $user = $this->view->getUserLogin();
            $this->authenticateClient($user);
        } catch (\Exception $e) {
            $this->viewModel->handleError($e);
        }
        return $this->showForm();
    }

    private function authenticateClient($user)
    {
        if ($this->userRegistry->compare($user)) {
            $this->userSession->saveEntry($user);
            $this->viewModel->setUserHasLoggedIn();
            // set cookie
        }
    }

    private function attemptLogout()
    {
        $this->userSession->deleteEntry($user);
        $this->viewModel->setUserHasLoggedOut();
        // unset cookie

        return $this->showForm();
    }

    private function showForm(): \View\View
    {
        return $this->view;
    }
}
