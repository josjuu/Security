<?php
/**
 * Author: josmu
 * Date: 06/10/2018
 */

include_once '../../Classes/Initializer.php';

//for($i = 0; $i < 10; $i++) {
//    $price = new Price();
//    $price->Name = "test $i";
//    $price->NormalPrice = Rand(1,25);
//    $price->PrimeTimePrice = Rand(1,25);
//
//    try {
//        Db::addRecord("prices", $price);
//    } catch (ConnectionFailedException $e) {
//        echo ResponseJson::createFailedResponseMessage($e->getMessage());
//    }
//}

$ids = Array(9, 25, 15);

try {
    Db::deleteRecords("prices", "Price", $ids);
} catch (Exception $e) {
    echo ResponseJson::createFailedResponseMessage($e->getMessage());
}