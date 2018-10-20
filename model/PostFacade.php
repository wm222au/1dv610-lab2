<?php

namespace Model;


class PostFacade
{
    private $userRegistry;
    private $postRegistry;
    private $userSession;

    public function __construct(\Model\DAL\PostDALMySQL $postRegistry, \Model\SessionHandler $userSession)
    {
        $this->postRegistry = $postRegistry;
        $this->userSession = $userSession;
    }

    public function isLoggedIn(): bool
    {
        return $this->userSession->exists();
    }

    public function addPost()
    {

    }

    public function getAllPosts(): array
    {
        $dbArray = $this->postRegistry->getAll();

        $postArray = array();
//        foreach($dbArray->fetch_assoc() as $dbPost => $postValue) {
//            var_dump($dbArray);
//            var_dump($dbPost);
//            var_dump($postValue);
//            $postArray[] = $this->createPostObject($dbPost);
//        }

        while ($row = $dbArray->fetch_assoc()) {
            $postArray[] = $this->createPostObject($row);
        }
//        var_dump($dbArray);
//        while ($row = $dbArray->fetch_assoc()) {
//            var_dump($row);
//            $postArray[] = $this->createPostObject($row);
//        }

        return $postArray;
    }

    private function createPostObject(array $dbPost): \Model\Post
    {
        $user = new User();
        $user->setUsername($dbPost['username']);

        $post = new Post();
        $post->setTitle($dbPost['title']);
        $post->setContent($dbPost['content']);
        $post->setCreationDate($dbPost['date_created']);
        $post->setUser($user);

        return $post;
    }
}