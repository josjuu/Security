<?php
include_once '../../Classes/Initializer.php';

if(isset($_GET["id"])){
    $data = Db::getSingleRecord("screens", "Screen", $_GET["id"]);
    echo json_encode($data);
}else{
    $data = Db::getAllRecords("screens","Screen");
    echo json_encode($data);
}