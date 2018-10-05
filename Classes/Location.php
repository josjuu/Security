<?php

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