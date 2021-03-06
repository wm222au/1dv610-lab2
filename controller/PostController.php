<?php

namespace Controller;


use Model\DAL\DatabaseFailure;
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
        } catch (\Exception $exception) {
            $this->getViewingMethod();
            return $this->determineErrorRendering($exception);
        } catch (\Error $error) {
            $this->getViewingMethod();
            return $this->determineErrorRendering(new \Exception());
        }

        $this->getViewingMethod();
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
        } else {
            return $this->view->postErrorToHTML($e);
        }
    }

    private function getViewingMethod()
    {
        try {
            $this->retrievePosts();
        } catch (\Exception $e) {
            $this->determineErrorRendering($e);
        }
    }

    private function retrievePosts()
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

        $newPost = new \Model\PostCredentials();

        $newPost->setTitle($post->getTitle());
        $newPost->setContent($post->getContent());
        $newPost->setCreationDate($post->getCreationDate());
        $newPost->setAuthor($post->getAuthor());

        $this->model->addPost($newPost);
    }
}