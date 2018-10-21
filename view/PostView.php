<?php

namespace View;


use Model\DAL\DatabaseFailure;
use Model\PostValidation;
use Model\PostValidationFailure;

class PostView extends FormView
{
    private $model;

    private static $messageId = "PostView:Message";
    private static $form = "PostView:PostForm";
    private static $title = "PostView:Title";
    private static $content = "PostView:Content";
    private static $post = "PostView:Post";

    private static $search = "PostView:Search";
    private static $searchString = "PostView:SearchString";

    public function __construct(\Model\PostFacade $toBeViewed)
    {
        $this->model = $toBeViewed;
    }

    public function userHasSearched(): bool
    {
        return !empty($this->getSearch());
    }

    public function getSearch()
    {
        return $_GET[self::$searchString] ? $_GET[self::$searchString] : "";
    }

    public function userWantsToPost()
    {
        return $this->getTitle() !== null && $this->getContent() !== null;
    }

    public function getPost(): \Model\Post
    {
        $post = new \Model\Post();

        $timestamp = date('Y-m-d G:i:s');
        $userCredentials = $this->model->getUser();

        $post->setTitle($this->getTitle());
        $post->setContent($this->getContent());
        $post->setCreationDate($timestamp);
        $post->setAuthor($userCredentials->getUsername());

        return $post;
    }

    private function getTitle()
    {
        return $_POST[self::$title];
    }

    private function getContent()
    {
        return $_POST[self::$content];
    }

    public function validationErrorToHTML(\Model\PostCredentials $validation): string
    {
        $html = "";

        $html .= $this->generateSearchField();

        $message = $this->getValidationErrorsToHTML($validation);
        $html .= $this->generateNewPostHTML($message);

        $html .= $this->generatePostsHTML();

        return $html;
    }

    private function getValidationErrorsToHTML(\Model\PostCredentials $validation): string
    {
        $html = "";

        if($validation->isTitleTooShort()) {
            $html .= $this->generateFieldTooShortHTML("Title", $validation::$minTitleLength);
        }
        if($validation->isContentTooShort()) {
            $html .= $this->generateFieldTooShortHTML("Content", $validation::$minContentLength);
        }
        if($validation->isTitleCharactersInvalid()) {
            $html .= $this->generateFieldInvalidCharactersHTML("Title");
        }
        if($validation->isContentCharactersInvalid()) {
            $html .= $this->generateFieldInvalidCharactersHTML("Content");
        }

        return $html;
    }

    public function postErrorToHTML(\Exception $e): string
    {
        $html = "";

        $html .= $this->generateSearchField();

        $html .= $this->generateUnknownErrorHTML();

        $html .= $this->generatePostsHTML();

        return $html;
    }

    public function toHTML(): string
    {
        $html = "";

        $html .= $this->generateSearchField();

        if ($this->model->isLoggedIn()) {
            $html .= $this->generateNewPostHTML();
        } else {
            $html .= $this->generateNewPostRequiredPermissionsHTML();
        }
        $html .= $this->generatePostsHTML();
        return $html;
    }

    private function generateSearchField(): string
    {
        $html = '
			<form method="get">
			    <input hidden="hidden" name="guestbook"/>
			    
				<label for="' . self::$searchString . '">Search:</label>
				<input type="text" id="' . self::$searchString . '" name="' . self::$searchString . '" value="' . $this->getSearch() . '" />

				<input type="submit" name="' . self::$search . '" value="Search" />
			</form>
		';

        if ($this->userHasSearched()) {
            $html .= '<p>Found ' . count($this->model->getPosts()) . ' posts.</p>';
        }

        return $html;
    }

    private function generateNewPostHTML($message = ""): string
    {
        return '
			<form method="post" id="' . self::$form .'">
			    <fieldset>
					<legend>Create a new post</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>

                    <p>
					<h4>Title</h4>
					<input type="text" id="' . self::$title . '" name="' . self::$title . '" value="' . strip_tags($this->getTitle()) . '" />
					</p>
					
					<p>
					<h4>Content</h4>
					<textarea rows="5" cols="80" id="' . self::$content . '" name="' . self::$content . '" value="' . strip_tags($this->getContent()) . '" form="' . self::$form . '"></textarea>
					</p>
					
					<input type="submit" name="' . self::$post . '" value="Post" />
				</fieldset>
			</form>
		';
    }

    private function generateNoPostsHTML(): string
    {
        return "<p>No one has posted in the guestbook yet, maybe you could be the first?</p>";
    }

    private function generateNewPostRequiredPermissionsHTML(): string
    {
        return "<h4>You need to be logged in to post.</h4>";
    }

    private function generatePostsHTML(): string
    {
        $html = "";

        if (count($this->model->getPosts()) > 0) {
            foreach($this->model->getPosts() as $post) {
                $html .= $this->generatePostHTML($post);
            }
        } else {
            $html .= $this->generateNoPostsHTML();
        }

        return $html;
    }

    private function generatePostHTML(\Model\Post $toBeRendered): string
    {
        $html = "";

        $html .= "<h3>{$toBeRendered->getTitle()}</h3>";
        $html .= "<p>{$toBeRendered->getContent()}</p>";
        $html .= "<p>Created at {$toBeRendered->getCreationDate()}</p>";
        $html .= "<p>Posted by {$toBeRendered->getAuthor()}</p>";
        $html .= "<hr/>";

        return $html;
    }
}