<?php

namespace View;

use Model\DAL\DatabaseFailure;
use Model\WrongLoginCredentials;

class LoginView extends FormView
{
    private $model;
    private $cookie;

    private static $login = 'LoginView::LoginFacade';
    private static $logout = 'LoginView::Logout';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private static $messageId = 'LoginView::Message';

    public function __construct(\Model\LoginFacade $toBeViewed)
    {
        $this->model = $toBeViewed;
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

    public function getUserObject(): \Model\User
    {
        $user = new \Model\User();
        $user->setUsername($this->getUsername());
        $user->setPassword($this->getPassword());
        return $user;
    }

    public function getCookieToken(): string
    {
        return $this->cookie->loadEntry();
    }

    public function getUserLogout()
    {
        $user = new \Model\User();
        $login = new \Model\LoginFacade($user->getUser());
        return $login;
    }

    public function getCookieName()
    {
        return $_POST[self::$cookieName];
    }

    public function setCookie(string $data)
    {
        $this->cookie->saveEntry($data);
    }

    public function unsetCookie()
    {
        $this->cookie->deleteEntry();
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

    public function userWantsToBeRemembered(): bool
    {
        return isset($_POST[self::$keep]);
    }

    public function toHTML(): string
    {
        $html = "";

        if ($this->model->isLoggedIn()){
            $html .= $this->loginSuccessToHTML();
        } else {
            $html .= $this->generateLoginFormHTML("");
        }

        return $html;
    }

    public function loginSuccessToHTML(): string
    {
        $message = "";

        if($this->model->loggedInByToken()) {
            $message .= $this->generateTokenLoginMessageHTML();
        } else {
            $message .= $this->generateLoginMessageHTML();
        }

        $html = $this->generateLogoutButtonHTML($this->model->wasLoggedOut() ? $this->generateLogoutMessageHTML() : "");

        return $html;
    }

    public function validationErrorToHTML(\Model\UserCredentials $invalidUser): string
    {
        $message = "";
        
        if($invalidUser->isUsernameEmpty()) {
            $message .= $this->generateFieldIsEmptyHTML("Username");

        } else if ($invalidUser->isPasswordEmpty()) {
            $message .= $this->generateFieldIsEmptyHTML("Password");

        } else {
            $message .= $this->generateWrongCredentialsHTML();
        }

        $html = $this->generateLoginFormHTML($message);
        
        return $html;
    }

    public function loginErrorToHTML(\Exception $e): string
    {
        $message = "";

        $message .= $this->generateWrongCredentialsHTML();

        $html = $this->generateLoginFormHTML($message);

        return $html;
    }

    private function generateLoginMessageHTML()
    {
        return 'Welcome';
    }

    private function generateTokenLoginMessageHTML()
    {
        return 'Welcome back with cookie';
    }

    private function generateLogoutMessageHTML()
    {
        return "Bye bye!";
    }

    private function generateWrongCredentialsHTML(): string
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
				<input type="submit" name="' . self::$logout . '" value="Logout"/>
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

					<input type="submit" name="' . self::$login . '" value="Login" />
				</fieldset>
			</form>
		';
    }
}
