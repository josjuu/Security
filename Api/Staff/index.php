<?php
include_once '../../Classes/Initializer.php';

if(isset($_GET["id"])){
    $data = Db::getSingleRecord("staff", "Staff", $_GET["id"]);
    echo json_encode($data);
}else{
    $data = Db::getAllRecords("staff","Staff");
    echo json_encode($data);
}