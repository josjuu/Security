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