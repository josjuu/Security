<?php
/**
 * Author: josmu
 * Date: 05/10/2018
 */

class NotSetException extends Exception
{
    public function __toString()
    {
        $message = "<b>Warning:</b> $this->message.<br>";
        $message .= "This exception occurred at $this->file:$this->line.<br><br>";

        return $message;
    }
}

class ConnectionFailedException extends Exception
{
    public $password;
    public $username;
    public $dsn;

    public function __toString()
    {
        $message = "<b>Error:</b> $this->message.<br>";
        $message .= "This exception occurred at $this->file:$this->line.<br><br>";

        return $message;
    }

    public function getExtraDataMessage()
    {
        $message = "<b>Error:</b> $this->message.<br>";
        $message .= "Dsn: '$this->dsn', username: '$this->username', password: '$this->password'<br>";
        $message .= "This exception occurred at $this->file:$this->line.<br><br>";

        return $message;
    }
}

class NullException extends Exception
{
    public function __toString()
    {
        $message = "<b>Warning:</b> $this->message.<br>";
        $message .= "This exception occurred at $this->file:$this->line.<br><br>";

        return $message;
    }
}