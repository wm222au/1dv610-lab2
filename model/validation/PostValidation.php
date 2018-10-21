<?php
/**
 * Created by PhpStorm.
 * User: william
 * Date: 2018-10-19
 * Time: 19:32
 */

namespace Model;

use Throwable;

class PostValidationFailure extends \Exception
{
    public function __construct(\Model\PostValidation $validation, string $message = "Post creation failed")
    {
        parent::__construct($message, 0, null);
        $this->validation = $validation;
    }

    public function getPostValidation(): \Model\PostValidation
    {
        return $this->validation;
    }
}


class PostValidation extends Post
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
        // If all validations pass, user is valid
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