<?php

namespace Model;


class PostFacade
{
    private $userRegistry;
    private $postRegistry;
    private $userSession;

    private $posts = array();

    public function __construct(\Model\DAL\PostDALMySQL $postRegistry, \Model\SessionHandler $userSession)
    {
        $this->postRegistry = $postRegistry;
        $this->userSession = $userSession;
    }

    public function isLoggedIn(): bool
    {
        return $this->userSession->exists();
    }

    public function getUser(): \Model\User
    {
        $userCredentials = $this->userSession->loadEntry();

        return $userCredentials->getUser();
    }

    public function addPost(\Model\Post $post)
    {
        $newPost = new \Model\PostValidation();

        $newPost->setTitle($post->getTitle());
        $newPost->setContent($post->getContent());
        $newPost->setCreationDate($post->getCreationDate());
        $newPost->setAuthor($post->getAuthor());

        if ($newPost->isValid()) {
            $this->postRegistry->add($post);
        } else {
            throw new PostValidationFailure($newPost);
        }
    }

    public function getPosts(): array
    {
        return $this->posts;
    }

    public function retrieveSearchPosts(string $searchQuery)
    {
        $postList = $this->postRegistry->search($searchQuery);

        foreach ($postList as $post) {
            $postArray[] = $this->createPostObject($post);
        }

        $this->posts = $postArray;
    }

    public function retrieveAllPosts()
    {
        $postList = $this->postRegistry->getAll();

        foreach ($postList as $post) {
            $postArray[] = $this->createPostObject($post);
        }

         $this->posts = $postArray;
    }

    private function createPostObject(array $dbPost): \Model\Post
    {
        $post = new Post();
        $post->setTitle($dbPost['title']);
        $post->setContent($dbPost['content']);
        $post->setCreationDate($dbPost['date_created']);
        $post->setAuthor($dbPost['username']);

        return $post;
    }
}