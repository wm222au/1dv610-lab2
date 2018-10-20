<?php

namespace Model;

class Post
{
    private $title;
    private $content;
    private $creationDate;
    private $user;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }

    public function getCreationDate(): string
    {
        return $this->creationDate;
    }

    public function setCreationDate(string $creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function getUser(): \Model\User
    {
        return $this->user;
    }

    public function setUser(\Model\User $user)
    {
        $this->user = $user;
    }
}