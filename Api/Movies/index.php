<?php
include_once '../../Classes/Initializer.php';

if(isset($_GET["id"])){
    $data = Db::getSingleRecord("movies", "Movie", $_GET["id"]);
    echo json_encode($data);
}else{
    $data = Db::getAllRecords("movies","Movie");
    echo json_encode($data);
}