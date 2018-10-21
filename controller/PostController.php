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

        $this->model->retrieveAllPosts();

        return $this->view->toHTML();
    }

    private function handleUserAction()
    {
        if($this->view->userWantsToPost()) {
            $this->createNewPost();
            // TODO add user search
        } else {
        }
    }

    private function createNewPost()
    {
        $post = $this->view->getPost();

        $this->model->addPost($post);
    }
}