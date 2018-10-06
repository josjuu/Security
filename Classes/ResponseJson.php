<?php
/**
 * User: Jos Mutter
 * Date: 06/10/2018
 */

/**
 * Class ResponseJson
 *
 * TODO Inserted comment
 *
 * @auther Jos Mutter
 */
class ResponseJson
{
    /**
     * Makes a json to return to the user.
     *
     * @param $resultName
     *      The name you want to give the $results in the json.
     * @param $results
     *      The results you are going to return.
     * @return string
     *      Returns a json in a string.
     */
    public static function createResponseMessage($resultName, $results)
    {
        $response = isset($results) ? Array("status" => "OK", $resultName => $results) : Array("status" => "ERROR");
        return json_encode($response);
    }

    /**
     * Makes a json to return to the user. This is only a failed response.
     * With this you can return a message in your response.
     *
     * @param $message
     *      The message you want to sent back to the user.
     * @return string
     *      Returns a json in a string.
     */
    public static function createFailedResponseMessage($message)
    {
        $response = Array("status" => "FAILED", "message" => $message);
        return json_encode($response);
    }
}