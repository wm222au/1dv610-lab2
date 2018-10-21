<?php

namespace View;


class PostView
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
        $user = $this->model->getUser();

        $post->setTitle($this->getTitle());
        $post->setContent($this->getContent());
        $post->setCreationDate($timestamp);
        $post->setAuthor($user->getUsername());

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

    public function toHTML()
    {
        $html = "";

        $html .= $this->generateSearchField();

        if ($this->model->isLoggedIn()) {
            $html .= $this->generateNewPostHTML();
        } else {
            $html .= $this->generateNewPostRequiredPermissionsHTML();
        }
        $html .= $this->generatePostsHTML($this->model->getPosts());
        return $html;
    }

    private function generateSearchField(): string
    {
        return '
			<form method="get">
			    <input hidden="hidden" name="guestbook"/>
			    
				<label for="' . self::$searchString . '">Search:</label>
				<input type="text" id="' . self::$searchString . '" name="' . self::$searchString . '" value="' . $this->getSearch() . '" />

				<input type="submit" name="' . self::$search . '" value="Search" />
			</form>
		';
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

    private function generateNewPostRequiredPermissionsHTML(): string
    {
        return "<h4>You need to be logged in to post.</h4>";
    }

    private function generatePostsHTML(array $posts): string
    {
        $html = "";

        foreach($posts as $post) {
            $html .= $this->generatePostHTML($post);
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