<?php

namespace View;

class LayoutView
{
    private $dayTimeView;

    public function __construct()
    {
        $this->dayTimeView = new DateTimeView();
    }

    public function render(\model\SessionHandler $user, $view)
    {

        $body = $view->index();

        echo '<!DOCTYPE html>
      <html lang="en">
        <head>
          <meta charset="utf-8">
          <title>LoginFacade Example</title>
        </head>
        <body>
          <h1>Assignment 3</h1>
          <ul>
            <li><a href="./">Home</a></li>
            <li><a href="./?guestbook">Guest book</a></li>
          </ul>
          ' . $this->renderIsLoggedIn($user->exists()) . '

          <div class="container">
              ' . $body . '

              ' . $this->dayTimeView->show() . '
          </div>
         </body>
      </html>
    ';
    }

    private function renderIsLoggedIn($isLoggedIn)
    {
        if ($isLoggedIn) {
            return "<h2>Logged in</h2>";
        } else {
            return "<h2>Not logged in</h2>";
        }
    }
}
