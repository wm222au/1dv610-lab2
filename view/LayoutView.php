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

    public function render($isLoggedIn, $view)
    {
        echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn(false) . '

          <div class="container">
              ' . $view . '

              ' . $this->dayTimeView->show() . '
          </div>
         </body>
      </html>
    ';
    }

    private function renderIsLoggedIn($isLoggedIn)
    {
        if ($isLoggedIn) {
            return '<h2>Logged in</h2>';
        } else {
            return '<h2>Not logged in</h2>';
        }
    }
}
