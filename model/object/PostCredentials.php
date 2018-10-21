<?php

namespace Model;

class PostValidationFailure extends \Exception
{
    public function __construct(\Model\PostCredentials $validation, string $message = "Post creation failed")
    {
        parent::__construct($message, 0, null);
        $this->validation = $validation;
    }

    public function getPostValidation(): \Model\PostCredentials
    {
        return $this->validation;
    }
}


class PostCredentials extends Post
{
    public static $minTitleLength = 5;
    public static $minContentLength= 30;

    public function isTitleTooShort(): bool
    {
        return strlen($this->title) < self::$minTitleLength;
    }

    public function isContentTooShort(): bool
    {
        return strlen($this->content) < self::$minContentLength;
    }

    public function isTitleCharactersInvalid(): bool
    {
        return strip_tags($this->title) != $this->title;
    }

    public function isContentCharactersInvalid(): bool
    {
        return strip_tags($this->content) != $this->content;
    }

    public function isValid(): bool
    {
        if(
            !$this->isTitleTooShort() &&
            !$this->isContentTooShort() &&
            !$this->isTitleCharactersInvalid() &&
            !$this->isContentCharactersInvalid()
        ) {
            return true;
        }

        return false;
    }
}