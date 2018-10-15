<?php

namespace Controller;

class RegisterController implements IController
{
    private $view;
    private $userRegistry;

    public function __construct(\Database\PersistentRegistryFactory $factory)
    {
        $this->userRegistry = $factory->build($this->getClassName(\Model\User::class));
        $this->tokenRegistry = $factory->build($this->getClassName(\Model\Token::class));

        $this->viewModel = new \model\RegisterViewModel();
        $this->view = new \View\RegisterView($this->viewModel);
    }

    public function index(): \View\View
    {
        if ($this->view->userWillRegister()) {
            return $this->attemptRegisterAccount();
        }
        return $this->showForm();
    }

    private function attemptRegisterAccount(): \View\View
    {
        try {
            $user = $this->view->getRegistration();
            $this->createNewUser($user);
        } catch (\Exception $e) {
            $this->viewModel->handleError($e);
        }
        return $this->showForm();
    }

    private function createNewUser(\Model\User $user)
    {
        $this->userRegistry->add($user);
    }

    private function showForm(): \View\View
    {
        return $this->view;
    }
}
