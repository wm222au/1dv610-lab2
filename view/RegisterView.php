<?php

namespace View;

class RegisterView extends View
{
    public static $viewUrl = "register";

    private $viewModel;

    private static $register = 'RegisterView::Register';
    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $cookieName = 'RegisterView::CookieName';
    private static $cookiePassword = 'RegisterView::CookiePassword';
    private static $messageId = 'RegisterView::Message';

    public function __construct(\Model\IViewModel $modelToBeViewed)
    {
        $this->viewModel = $modelToBeViewed;
    }

    public function userWillRegister(): bool
    {
        return ($this->getUsername() !== null && $this->getPassword() !== null && $this->getPasswordRepeat() !== null);
    }

    public function getRegistration(): \Model\User
    {
        $password = new \Model\Password($this->getPassword());
        $passwordRepeat = new \Model\Password($this->getPasswordRepeat());

        if ($password->get() === $passwordRepeat->get()) {
            return new \Model\User(new \Model\Username($this->getUsername()),
                new \Model\Password($this->getPassword()));
        } else {
            throw new \Exception("Passwords not alike");
        }

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

    public function toHTML(): string
    {
        $loginUrl = LoginView::$viewUrl;
        $html = "<a href='{$loginUrl}'>Back to login</a>";
        $message = '';

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
        if ($this->viewModel->getHasLoggedOut()) {
            $response .= $this->generateLogoutMessage();

        } else if ($this->viewModel->getIsUsernameEmpty()) {
            $response .= $this->generateUsernameIsEmptyHTML();

        } else if ($this->viewModel->getIsPasswordEmpty()) {
            $response .= $this->generatePasswordIsEmptyHTML();

        } else if ($this->viewModel->getIsCredentialsWrong()) {
            $response .= $this->generateWrongCredentialsHTML();

        } else {
            $response .= $this->generateLoginMessage();
        }
        return $response;
    }

    private function generateUserRegistered()
    {
        return 'Registered new user. ';
    }

    private function generateInvalidUsernameChars()
    {
        return 'Username contains invalid characters.';
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
}
