<?php
include_once '../../Classes/Initializer.php';

if(isset($_GET["id"])){
    $data = Db::getSingleRecord("movietimes", "MovieTime", $_GET["id"]);
    echo json_encode($data);
}else{
    $data = Db::getAllRecords("movietimes","MovieTime");
    echo json_encode($data);
}