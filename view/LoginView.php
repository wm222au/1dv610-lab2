<?php

namespace View;

class LoginView
{
    private $user;
    private $model;

    private $errors = array();

    private static $login = 'LoginView::Login';
    private static $logout = 'LoginView::Logout';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private static $messageId = 'LoginView::Message';

    public function userWillLogout(): bool
    {
        return ($this->getLogout() !== null);
    }

    public function userWillLogin(): bool
    {
        return ($this->getUsername() !== null && $this->getPassword() !== null);
    }

    // public function getUserLogin(): \Model\Login
    public function getUserLogin(): \Model\User
    {

        // One catch and then determine fault, or like this?
        try {
            return new \Model\User($this->getUsername(), $this->getPassword());
        } catch (\Exception $e) {
            $this->getErrorMessages($e);
        }
    }

    private function getErrorMessages(\Exception $e)
    {
        if ($e instanceof \Model\UsernameEmptyException) {
            $this->errors[] = $this->generateUsernameIsEmptyHTML();
        } else if ($e instanceof \Model\PasswordEmptyException) {
            $this->errors[] = $this->generatePasswordIsEmptyHTML();
        } else {
            $this->errors[] = $this->generateWrongCredentialsHTML();
        }
        throw new \Exception("Could not create usermodel");
    }

    public function getUserLogout()
    {
        // $user = new \Model\User();
        // $login = new \Model\Login($user->getUser());
        // return $login;
    }

    public function getCookieName()
    {
        return self::$cookieName;
    }

    public function getLogoutName()
    {
        return self::$logout;
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
        $html = '<a href="?register">Register a new user</a>';
        $message = '';

        foreach ($this->errors as $error) {
            $message .= $error . ". ";
        }

        $html .= $this->generateLoginFormHTML($message);

        return $html;
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
