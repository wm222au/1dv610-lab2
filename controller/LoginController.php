<?php

namespace Controller;

class LoginController extends Controller
{
    private $view;
    private $viewModel;
    private $userSession;
    private $userRegistry;
    private $tokenRegistry;

    public function __construct(\Database\PersistentRegistryFactory $factory)
    {
        $this->userSession = new \model\Session($this->getClassName(\Model\User::class));
        $this->userRegistry = $factory->build($this->getClassName(\Model\User::class));
        $this->tokenRegistry = $factory->build($this->getClassName(\Model\Token::class));

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
        }
    }

    private function attemptLogout()
    {
        return $this->showForm();
    }

    private function showForm(): \View\View
    {
        return $this->view;
    }
}
