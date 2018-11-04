<?php
include_once '../../Classes/Initializer.php';

$authentication = new Authentication();
$authentication->setDomainById($authentication->headers["Origin"]);

$authentication->verifyApiKey();
$authentication->verifyLevel();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET["id"])) {
        try {
            $data = Db::getSingleRecord("movies", "Movie", $_GET["id"]);
        } catch (Exception $e) {
            $response = ResponseJson::createFailedResponseMessage($e->getMessage());
        }

        if (!isset($response)) {
            $response = ResponseJson::createResponseMessage("record", $data);
        }

        echo $response;
    } else {
        try {
            $data = Db::getAllRecords("movies", "Movie");
        } catch (Exception $e) {
            $response = ResponseJson::createFailedResponseMessage($e->getMessage());
        }

        if (!isset($response)) {
            $response = ResponseJson::createResponseMessage("records", $data);
        }

        echo $response;
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo ResponseJson::createResponseMessage("message", "TODO: Insert post method.");
} else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    echo ResponseJson::createResponseMessage("message", "TODO: Insert put method.");
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    echo ResponseJson::createResponseMessage("message", "TODO: Insert delete method.");
}