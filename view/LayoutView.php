<?php

namespace View;

require_once 'DateTimeView.php';

class LayoutView
{

    // private $user;
    private $dayTimeView;

    public function __construct()
    {
        // $this->user = $user;
        $this->dayTimeView = new DateTimeView();
    }

    public function render($user, $view)
    {

        $body = $view->index();

        echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn($user->getIsLoggedIn()) . '

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
            return '<h2>Logged in</h2>
            <form method="post">
                <input type="hidden" name="LoginView::Logout" value="1"/>
                <input type="submit" value="Logout">
            </form>';
        } else {
            return '<h2>Not logged in</h2>';
        }
    }
}
