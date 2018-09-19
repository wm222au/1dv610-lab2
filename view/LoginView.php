<?php

namespace View;

class LoginView extends View
{
    private $user;
    private $model;

    private static $login = 'LoginView::Login';
    private static $logout = 'LoginView::Logout';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private static $messageId = 'LoginView::Message';

    public function __construct()
    {
        // $this->user = $toBeViewed;
    }

    public function userHasLoggedIn(): bool
    {
        return ($this->getUsername() !== null && $this->getPassword() !== null);
    }

    public function getLogin(): \Model\Login
    {
        $user = new \Model\User($this->getUsername(), $this->getPassword());
        $login = new \Model\Login($user);
        return $login;
    }

    public function getUsername()
    {
        return $_POST[self::$name];
    }
    public function getPassword()
    {
        return $_POST[self::$password];
    }

    public function toHTML($model): string
    {
        $this->model = $model;
        $html = '<a href="?register">Register a new user.</a>';
        $message = '';

        if ($this->model) {
            $message .= $this->response();
        }

        $html .= $this->generateLoginFormHTML($message);

        return $html;

    }

    /**
     * Create HTTP response
     *
     * Should be called after a login attempt has been determined
     *
     * @return  void BUT writes to standard output and cookies!
     */

    protected function response(): string
    {
        $response = '';

        if ($this->model->getIsUsernameEmpty()) {
            $response .= $this->generateUsernameIsEmptyHTML();
        } else if ($this->model->getIsPasswordEmpty()) {
            $response .= $this->generatePasswordIsEmptyHTML();
        } else if (!$this->model->getIsAuthenticated()) {
            $response .= $this->generateWrongCredentialsHTML();
        }

        return $response;
    }

    private function generateUsernameIsEmptyHTML()
    {
        return '<p>Username is missing</p>';
    }

    private function generatePasswordIsEmptyHTML()
    {
        return '<p>Password is missing</p>';
    }

    private function generateWrongCredentialsHTML()
    {
        return '<p>Wrong name or password</p>';
    }

    /**
     * Generate HTML code on the output buffer for the logout button
     * @param $message, String output message
     * @return  void, BUT writes to standard output!
     */
    private function generateLogoutButtonHTML($message)
    {
        return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message . '</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
    }

    /**
     * Generate HTML code on the output buffer for the logout button
     * @param $message, String output message
     * @return  void, BUT writes to standard output!
     */
    private function generateLoginFormHTML($message)
    {
        return '
			<form method="post" >
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>

					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />

					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
    }

    //CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
    private function getRequestUserName()
    {
        //RETURN REQUEST VARIABLE: USERNAME
    }

}
