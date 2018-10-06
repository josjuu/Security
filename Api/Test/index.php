<?php
/**
 * Author: josmu
 * Date: 06/10/2018
 */

include_once '../../Classes/Initializer.php';

$prices = Array();

array_push($prices, Db::getSingleRecord("prices", "Price", 5));
array_push($prices, Db::getSingleRecord("prices", "Price", 6));
array_push($prices, Db::getSingleRecord("prices", "Price", 7));
array_push($prices, Db::getSingleRecord("prices", "Price", 8));

foreach ($prices as $price) {
    $price->PrimeTimePrice = Rand(1.50, 15.50);
    $price->NormalPrice = Rand(1.50, 15.50);
}

Db::updateRecords("prices", $prices);
echo json_encode(Db::getAllRecords("prices", "Price"));