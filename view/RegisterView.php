<?php

namespace View;

use Model\DAL\DatabaseFailure;
use Model\RegisterPasswordsNotEqual;

class RegisterView extends FormView
{
    private static $register = 'RegisterView::Register';
    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $messageId = 'RegisterView::Message';

    private $model;

    public function __construct(\Model\RegisterFacade $toBeViewed)
    {
        $this->model = $toBeViewed;
    }

    public function userWillRegister(): bool
    {
        return ($this->getUsername() !== null && $this->getPassword() !== null && $this->getPasswordRepeat() !== null);
    }

    public function getUserObject(): \Model\User
    {
        $user = new \Model\User();
        $user->setUsername($this->getUsername());
        $user->setPassword($this->getPassword());
        return $user;
    }

    private function getUsername()
    {
        return $_POST[self::$name];
    }

    private function getPassword()
    {
        return $_POST[self::$password];
    }
    public function getPasswordRepeat()
    {
        return $_POST[self::$passwordRepeat];
    }

    public function toHTML(): string
    {
        $html = '<a href="./">Back to login</a>';

        if($this->model->registrationWasSuccessful()) {
            $html .= $this->registrationSuccess();
        } else {
            $html .= $this->generateRegisterFormHTML("");
        }

        return $html;
    }

    private function registrationSuccess(): string
    {
        $message = $this->generateUserRegistered();
        return $this->generateRegisterFormHTML($message);
    }

    public function validationErrorToHTML(\Model\UserCredentials $invalidUser): string
    {
        $message = "";

        if($invalidUser->isUsernameTooShort()) {
            $message .= $this->generateFieldTooShortHTML("Username", $invalidUser::$minUsernameLength);

        }
        if ($invalidUser->isPasswordTooShort()) {
            $message .= $this->generateFieldTooShortHTML("Password", $invalidUser::$minPasswordLength);
        }
        if ($invalidUser->isUsernameCharactersInvalid()){
            $message .= $this->generateFieldInvalidCharactersHTML("Username");
        }

        return $this->generateRegisterFormHTML($message);
    }

    public function registrationErrorToHTML(\Exception $e): string
    {
        $message = "";

        if ($e instanceof DatabaseFailure) {
            if ($e->isDuplicate()) {
                $message .= $this->generateUserExists();
            } else if ($e instanceof RegisterPasswordsNotEqual) {
                $message .= $this->generatePasswordsNotEqual();
            } else {
                $message .= $this->generateUnknownErrorHTML();
            }
        }

        return $this->generateRegisterFormHTML($message);
    }

    private function generateUserRegistered()
    {
        return 'Registered new user. ';
    }

    private function generateUserExists()
    {
        return 'User exists, pick another username. ';
    }

    private function generatePasswordsNotEqual()
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
