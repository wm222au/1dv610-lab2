<?php

namespace View;

use Controller\Controller;

class LayoutView implements View
{
    private $userSession;
    private $view;
    private $dayTimeView;

    public function __construct(\model\SessionHandler $user, Controller $view)
    {
        $this->userSession = $user;
        $this->view = $view;

        $this->dayTimeView = new DateTimeView();
    }

    public function toHTML(): string
    {
        $body = $this->view->index();

        return '<!DOCTYPE html>
      <html lang="en">
        <head>
          <meta charset="utf-8">
          <title>Lab 3</title>
        </head>
        <body>
          <h1>Assignment 3</h1>
          ' . $this->renderIsLoggedIn($this->userSession->exists()) . '

          <div class="container">
              ' . $this->routesToHTML() . '
              ' . $body . '

              ' . $this->dayTimeView->toHTML() . '
          </div>
         </body>
      </html>
    ';
    }

    private function routesToHTML(): string
    {
        $router = new \Router();

        $homeUrl = $router::$homeUrl;
        $registerUrl = $router::$registerUrl;
        $postUrl = $router::$postUrl;

        $html = "<ul>";
        var_dump($_GET);

        if (!empty($_GET)) {
            $html .= "<li><a href=." . $homeUrl . ">Back to login</a></li>";
        }
        if (!array_key_exists($registerUrl, $_GET)) {
            $html .= "<li><a href=?" . $registerUrl . ">Register a new user</a></li>";
        }
        if (!array_key_exists($postUrl, $_GET)) {
            $html .= "<li><a href=?" . $postUrl . ">Guest book</a></li>";
        }


        $html .= "</ul>";

        return $html;
    }

    private function notAtLogin(): bool
    {
        return !empty($_GET);
    }
    
    private function renderIsLoggedIn($isLoggedIn): string
    {
        if ($isLoggedIn) {
            return "<h2>Logged in</h2>";
        } else {
            return "<h2>Not logged in</h2>";
        }
    }
}
