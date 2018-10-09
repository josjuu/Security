<?php
include_once '../../Classes/Initializer.php';

if (isset($_GET["id"])) {
    try {
        $data = Db::getSingleRecord("staff", "Staff", $_GET["id"]);
    } catch (Exception $e) {
        $response = ResponseJson::createFailedResponseMessage($e->getMessage());
    }

    if (!isset($response)) {
        $response = ResponseJson::createResponseMessage("record", $data);
    }

    echo $response;
} else {
    try {
        $data = Db::getAllRecords("staff", "Staff");
    } catch (Exception $e) {
        $response = ResponseJson::createFailedResponseMessage($e->getMessage());
    }

    if (!isset($response)) {
        $response = ResponseJson::createResponseMessage("records", $data);
    }

    echo $response;
}