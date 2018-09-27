<?php

namespace View;

class RegisterView extends View
{
    private static $register = 'RegisterView::Register';
    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $cookieName = 'RegisterView::CookieName';
    private static $cookiePassword = 'RegisterView::CookiePassword';
    private static $messageId = 'RegisterView::Message';

    private $model;
    private $user;

    public function __construct()
    {
        // $this->user = $toBeViewed;
    }

    public function userWillRegister(): bool
    {
        return ($this->getUsername() !== null && $this->getPassword() !== null && $this->getPasswordRepeat() !== null);
    }

    public function getRegistration(): \Model\Register
    {
        $user = new \Model\User($this->getUsername(), $this->getPassword());
        $register = new \Model\Register($user, $this->getPasswordRepeat());
        return $register;
    }

    public function getUserLogin(): \Model\Login
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
    public function getPasswordRepeat()
    {
        return $_POST[self::$passwordRepeat];
    }

    public function toHTML($model): string
    {
        $this->model = $model;
        $html = '<a href="./">Back to login</a>';
        $message = '';

        if ($this->model) {
            $message .= $this->response();
        }

        $html .= $this->generateRegisterFormHTML($message);

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

        if ($this->model->getUserRegistration()) {
            $response .= $this->generateUserRegistered();
        } else if ($this->model->getUserExists()) {
            $response .= $this->generateUserExists();
        } else {
            if (!$this->model->getUsernameLengthValid()) {
                $response .= $this->generateUsernameTooShort();
            }
            if (!$this->model->getPasswordLengthValid()) {
                $response .= $this->generatePasswordTooShort();
            }
            if (!$this->model->getPasswordsEqual()) {
                $response .= $this->generatePasswordNotEqual();
            }
        }

        return $response;
    }

    private function generateUserRegistered()
    {
        return 'Registered new user. ';
    }

    private function generateUserExists()
    {
        return 'User exists, pick another username. ';
    }

    private function generateUsernameTooShort()
    {
        return 'Username has too few characters, at least ' . $this->model->getMinUsernameLength() . ' characters. ';
    }

    private function generatePasswordTooShort()
    {
        return 'Password has too few characters, at least ' . $this->model->getMinPasswordLength() . ' characters. ';
    }

    private function generatePasswordNotEqual()
    {
        return 'Passwords do not match. ';
    }

    /**
     * Generate HTML code on the output buffer for the logout button
     * @param $message, String output message
     * @return  void, BUT writes to standard output!
     */

    private function generateRegisterFormHTML($message)
    {
        return '
			<form method="post" >
				<fieldset>
					<legend>Register a new user - Write username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>

          <p>
					<label for="' . self::$name . '">Username :</label>
          <input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getUsername() . '" />
          </p>

					<label for="' . self::$password . '">Password :</label>
          <input type="password" id="' . self::$password . '" name="' . self::$password . '" value="' . $this->getPassword() . '" />

					<label for="' . self::$passwordRepeat . '">Repeat Password :</label>
					<input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" value="' . $this->getPasswordRepeat() . '" />

          <input type="submit" name="' . self::$register . '" value="Register" />
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
