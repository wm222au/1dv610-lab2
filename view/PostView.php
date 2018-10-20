<?php

namespace View;


class PostView
{
    private $model;

    public function __construct(\Model\PostFacade $toBeViewed)
    {
        $this->model = $toBeViewed;
    }

    public function toHTML()
    {
        $html = "";
        if ($this->model->isLoggedIn()) {
            $html .= $this->generateNewPostHTML();
        } else {
            $html .= "<h2>You need to be logged in to post.</h2>";
        }
        $html .= $this->generatePostsHTML($this->model->getAllPosts());
        return $html;
    }

    public function generateNewPostHTML()
    {
        return "<h2>Formulär</h2>";
    }

    public function generatePostsHTML(array $posts)
    {
        $html = "";

        foreach($posts as $post) {
            $html .= $this->generatePostHTML($post);
        }

        return $html;
    }

    private function generatePostHTML(\Model\Post $toBeRendered)
    {
        $html = "";

        $user = $toBeRendered->getUser();

        $html .= "<h4>{$toBeRendered->getTitle()}</h4>";
        $html .= "<p>{$toBeRendered->getContent()}</p>";
        $html .= "<p>Created at {$toBeRendered->getCreationDate()}</p>";
        $html .= "<p>Posted by {$user->getUsername()}</p>";
        $html .= "<hr/>";

        return $html;
    }
}