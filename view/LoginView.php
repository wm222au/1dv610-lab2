<?php

namespace View;

class LoginView extends View
{
    private $user;
    private $cookie;
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
        $this->user = new \Model\SessionHandler();
        $this->cookie = new \View\CookieHandler(self::$cookieName);
    }

    public function userWillLogout(): bool
    {
        return ($this->getLogout() !== null);
    }

    public function userWillLoginViaForm(): bool
    {
        return ($this->getUsername() !== null && $this->getPassword() !== null);
    }

    public function userWillLoginViaCookie(): bool
    {
        return $this->cookie->exists();
    }

    public function getUserObject(): \Model\Login
    {
        $user = new \Model\User($this->getUsername(), $this->getPassword());
        $login = new \Model\Login($user);
        return $login;
    }

    public function getCookieToken(): string
    {
        return $this->cookie->loadEntry();
    }

    public function getUserLogout()
    {
        $user = new \Model\User();
        $login = new \Model\Login($user->getUser());
        return $login;
    }

    public function getCookieName()
    {
        return $_POST[self::$cookieName];
    }

    public function getLogout()
    {
        return $_POST[self::$logout];
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
        $html = '<a href="?register">Register a new user</a>';
        $message = '';

        if ($this->model) {
            $message .= $this->response();
        }

        if ($this->user->exists()) {
            $html .= $this->generateLogoutButtonHTML($message);
        } else {
            $html .= $this->generateLoginFormHTML($message);
        }

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

        if ($this->model->getIsLoggedOut()) {
            $response .= $this->generateLogoutMessage();
        } else if ($this->model->getIsUsernameEmpty()) {
            $response .= $this->generateUsernameIsEmptyHTML();
        } else if ($this->model->getIsPasswordEmpty()) {
            $response .= $this->generatePasswordIsEmptyHTML();
        } else if (!$this->model->getIsAuthenticated()) {
            $response .= $this->generateWrongCredentialsHTML();
        } else {
            $response .= $this->generateLoginMessage();
        }

        return $response;
    }

    public function showValidationError()
    {

    }

    public function showRegistrationError()
    {

    }

    private function generateLoginMessage()
    {
        return 'Welcome';
    }

    private function generateLogoutMessage()
    {
        return "Bye bye!";
    }

    private function generateUsernameIsEmptyHTML()
    {
        return 'Username is missing';
    }

    private function generatePasswordIsEmptyHTML()
    {
        return 'Password is missing';
    }

    private function generateWrongCredentialsHTML()
    {
        return 'Wrong name or password';
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
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getUsername() . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" value="' . $this->getPassword() . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />

					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
    }
}
