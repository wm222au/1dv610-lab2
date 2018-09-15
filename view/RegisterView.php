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
    private static $minUsernameLength = 3;
    private static $minPasswordLength = 6;

    private $model;
    private $user;

    public function __construct(\Model\User $toBeViewed)
    {
        $this->user = $toBeViewed;
    }

    public function toHTML(array $data)
    {
        $this->model = $data['model'];
        return $this->response();
    }

    /**
     * Create HTTP response
     *
     * Should be called after a login attempt has been determined
     *
     * @return  void BUT writes to standard output and cookies!
     */
    public function response()
    {
        $message = '';

        $response = '<a href="./">Back to login</a>';

        if ($this->model->usernameTooShort) {
            $response .= $this->generateUsernameTooShort();
        }
        if ($this->model->passwordTooShort) {
            $response .= $this->generatePasswordTooShort();
        }
        if ($this->model->passwordNotEqual) {
            $response .= $this->generatePasswordNotEqual();
        }

        $response .= $this->generateRegisterFormHTML($message);

        return $response;
    }

    private function generateUsernameTooShort()
    {
        return '<p>Username has too few characters, at least ' . self::$minUsernameLength . ' characters.</p>';
    }

    private function generatePasswordTooShort()
    {
        return '<p>Password has too few characters, at least ' . self::$minPasswordLength . ' characters.</p>';
    }

    private function generatePasswordNotEqual()
    {
        return '<p>Passwords do not match.</p>';
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
					<legend>Register - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>

          <p>
					<label for="' . self::$name . '">Username :</label>
          <input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />
          </p>

					<label for="' . self::$password . '">Password :</label>
          <input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$passwordRepeat . '">Repeat Password :</label>
					<input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" />

          <input type="submit" name="' . self::$register . '" value="login" />
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
