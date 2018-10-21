<?php

namespace View;


class SetupView implements View
{
    private static $setup = "SetupView:Setup";
    private static $host = "SetupView:Host";
    private static $username = "SetupView:Username";
    private static $password = "SetupView:Password";
    private static $database = "SetupView:Database";
    private static $messageId = 'SetupView::Message';

    public function __construct()
    {
    }

    public function userWantsToConnectDB()
    {
        return $this->getHost() !== null &&
            $this->getUsername() !== null &&
            $this->getPassword() !== null &&
            $this->getDatabase() !== null;
    }

    public function getDBConfig(): array
    {
        $dbConfig = array(
            "db_serverhost" => $this->getHost(),
            "db_username" => $this->getUsername(),
            "db_password" => $this->getPassword(),
            "db_database" => $this->getDatabase(),
        );

        return $dbConfig;
    }

    private function getHost()
    {
        return $_POST[self::$host];
    }

    private function getUsername()
    {
        return $_POST[self::$username];
    }

    private function getPassword()
    {
        return $_POST[self::$password];
    }

    private function getDatabase()
    {
        return $_POST[self::$database];
    }

    public function toHTML(): string
    {
        $html = "";

        $html .= $this->generateDatabaseSetupHTML();

        return $html;
    }

    public function errorToHTML(): string
    {
        $html = "";

        $html .= $this->generateDatabaseSetupHTML("An error occurred when setting up the database with the given parameters");

        return $html;
    }

    private function generateDatabaseSetupHTML($message = ""): string
    {
        return '
			<form method="post">
			    <fieldset>
					<legend>Setup database</legend>
					
					<p id="' . self::$messageId . '">' . $message . '</p>

                    <p>
					<h4>Host (IP / URL)</h4>
					<input type="text" id="' . self::$host . '" name="' . self::$host . '" value="' . $this->getHost() . '" />
					</p>
					
					<p>
					<h4>Username</h4>
					<input type="text" id="' . self::$username . '" name="' . self::$username . '" value="' . $this->getUsername() . '"/>
					</p>
					
					<p>
					<h4>Password</h4>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" value="' . $this->getPassword() . '" />
					</p>
					
					<p>
					<h4>Database</h4>
					<input type="text" id="' . self::$database . '" name="' . self::$database . '" value="' . $this->getDatabase() . '"/>
					</p>
					
					<input type="submit" name="' . self::$setup . '" value="Setup application" />
				</fieldset>
			</form>
		';
    }
}