<?php
include_once '../../Classes/Initializer.php';

if(isset($_GET["id"])){
    $data = Db::getSingleRecord("prices", "Price", $_GET["id"]);
    echo json_encode($data);
}else{
    $data = Db::getAllRecords("prices","Price");
    echo json_encode($data);
}