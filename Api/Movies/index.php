<?php
include_once '../../Classes/Initializer.php';

if(isset($_GET["id"])){

}else{
    $data = Db::getAllRecords("movies","Movie");
    echo json_encode($data);
}