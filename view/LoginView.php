<?php

namespace View;

class LoginView extends View
{
    public static $viewUrl = "./";

    private $userSession;
    private $viewModel;

    private static $login = 'LoginView::Login';
    private static $logout = 'LoginView::Logout';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private static $messageId = 'LoginView::Message';

    public function __construct(\Model\IViewModel $modelToBeViewed, \Model\Session $sessionToBeViewed)
    {
        $this->viewModel = $modelToBeViewed;
        $this->userSession = $sessionToBeViewed;
    }

    public function userWillLogout(): bool
    {
        return ($this->getLogout() !== null);
    }

    public function userWillLogin(): bool
    {
        return ($this->userWillLoginViaParameters() || $this->userWillLoginViaCookie());
    }

    public function getUserLogin(): \Model\User
    {
        if ($this->userWillLoginViaParameters()) {
            return $this->getUserLoginViaParameters();
        } else {
            return $this->getUserLoginViaCookie();
        }
    }

    private function userWillLoginViaParameters(): bool
    {
        return $this->getUsername() !== null && $this->getPassword() !== null;
    }

    private function userWillLoginViaCookie(): bool
    {
        return $this->getUserCookie() !== null;
    }

    private function getUserLoginViaParameters(): \Model\User
    {
        return new \Model\User(new \Model\Username($this->getUsername()), new \Model\Password($this->getPassword()));
    }

    private function getUserLoginViaCookie(): \Model\User
    {
        $cookie = $_COOKIE[$this->userSession->getSessionKey()];
        if (isset($cookie)) {
            return $cookie;
        } else {
            throw new \Exception("Could not retrieve user-cookie");
        }
    }

    public function getUserCookie()
    {
        return $_COOKIE[$this->userSession->getSessionKey()];
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

    public function toHTML(): string
    {
        $registerUrl = RegisterView::$viewUrl;
        $html = "<a href='?{$registerUrl}'>Register a new user</a>";
        $message = $this->response();

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

        if ($this->viewModel->getuserHasLoggedOut()) {
            $response .= $this->generateLogoutMessage();

        } else if ($this->viewModel->getIsUsernameEmpty()) {
            $response .= $this->generateUsernameIsEmptyHTML();

        } else if ($this->viewModel->getIsPasswordEmpty()) {
            $response .= $this->generatePasswordIsEmptyHTML();

        } else if ($this->viewModel->getIsCredentialsWrong()) {
            $response .= $this->generateWrongCredentialsHTML();

        } else if ($this->viewModel->getuserHasLoggedIn()) {
            $response .= $this->generateLoginMessage();
        }

        return $response;
    }

    private function generateLoginMessage()
    {
        // Check if via cookie or post
        // return "Welcome back with cookie";
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
