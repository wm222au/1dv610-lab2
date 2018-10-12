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
        $this->loginView = new \View\LoginView();
        $this->dayTimeView = new DateTimeView();
    }

    public function getUserPageRequest($getParam): bool
    {
        return isset($_GET[$getParam]);
    }

    public function render($user, $view)
    {
        echo '<!DOCTYPE html>
      <html lang="en">
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn(false) . '

          <div class="container">
              ' . $view->toHTML() . '

              ' . $this->dayTimeView->show() . '
          </div>
         </body>
      </html>
    ';
    }

    public function renderIsLoggedIn($isLoggedIn)
    {
        $logoutName = $this->loginView->getLogoutName();
        if ($isLoggedIn) {
            return "<h2>Logged in</h2>
            <form method='post' action='./'>
                <input type='hidden' name='$logoutName' value='1'/>
                <input type='submit' value='Logout'>
            </form>";
        } else {
            return "<h2>Not logged in</h2>";
        }
    }
}
