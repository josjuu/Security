<?php
include_once '../../Classes/Initializer.php';

if(isset($_GET["id"])){
    $data = Db::getSingleRecord("locations", "Location", $_GET["id"]);
    echo json_encode($data);
}else{
    $data = Db::getAllRecords("locations","Location");
    echo json_encode($data);
}