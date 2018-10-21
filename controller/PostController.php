<?php

namespace Controller;


class PostController implements Controller
{
    private $view;
    private $model;

    public function __construct(\View\PostView $view, \Model\PostFacade $toBeViewed)
    {
        $this->view = $view;
        $this->model = $toBeViewed;
    }

    public function index(): string
    {
        try {
            $this->handleUserAction();
        } catch (\Exception $e) {
            var_dump($e);
        }

        return $this->view->toHTML();
    }

    private function handleUserAction()
    {
        if($this->view->userWantsToPost()) {
            $this->createNewPost();
        }

        $this->getViewingMethod();
    }

    private function getViewingMethod()
    {
        if ($this->view->userHasSearched()) {
            var_dump(1);
            $this->model->retrieveSearchPosts($this->view->getSearch());
        } else {
            var_dump(2);
            $this->model->retrieveAllPosts();
        }
    }

    private function createNewPost()
    {
        $post = $this->view->getPost();

        $this->model->addPost($post);
    }
}