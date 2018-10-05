<?php
/**
 * Created by PhpStorm.
 * User: Jos Mutter
 * Date: 05/10/2018
 * Time: 17:48
 */

class Location extends DbTable
{
    public $Id;
    public $Street;
    public $HouseNumber;
    public $City;
    public $PostalCode;
    public $Telephone;
    public $Email;

    public function __construct(Array $properties=array()){
        parent::__construct($properties);
    }
}