<?php
/**
 * Author: josmu
 * Date: 06/10/2018
 */

include_once '../../Classes/Initializer.php';

$price = new Price();
$price->Name = "Test";
$price->NormalPrice = 5.50;
$price->PrimeTimePrice = 7.50;

Db::insert("prices", $price);