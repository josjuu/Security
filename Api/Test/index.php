<?php
/**
 * User: Jos Mutter
 * Date: 09/11/2018
 */

include_once '../../Classes/Initializer.php';

$authentication = new Authentication();

$token = array();
$token['id'] = "username_here";

$jwtToken = jwt::encode($token, $authentication->getKey());
echo $jwtToken . "<br>";

$response = "";

try {
    $response = json_encode(jwt::decode($jwtToken, "", true));
} catch (Exception $e) {
    $response = "Invalid authentication key.";
}

echo $response;