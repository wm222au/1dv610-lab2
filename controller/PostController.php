<?php

namespace Controller;


use Model\PostValidationFailure;

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
            $this->getPostsToView();
        } catch (\Exception $e) {
            $this->getPostsToView();
            return $this->determineErrorRendering($e);
        }

        return $this->view->toHTML();
    }

    private function handleUserAction()
    {
        if($this->view->userWantsToPost() && $this->model->isLoggedIn()) {
            $this->createNewPost();
        }
    }

    private function determineErrorRendering(\Exception $e): string
    {
        if ($e instanceof PostValidationFailure) {
            return $this->view->validationErrorToHTML($e->getPostValidation());
        } else if ($e instanceof  \DatabaseFailure){
            // return $this->view->loginErrorToHTML($e);
        }
    }

    private function getPostsToView()
    {
        try {
            $this->getViewingMethod();
        } catch (\Exception $e) {
            $this->determineErrorRendering($e);
        }
    }

    private function getViewingMethod()
    {
        if ($this->view->userHasSearched()) {
            $this->model->retrieveSearchPosts($this->view->getSearch());
        } else {
            $this->model->retrieveAllPosts();
        }
    }

    private function createNewPost()
    {
        $post = $this->view->getPost();

        $this->model->addPost($post);
    }
}