<?php

class Staff extends DbTable
{
    public $Id;
    public $LocationId;
    public $Firstname;
    public $Infix;
    public $Surname;
    public $Telephone;
    public $Email;
    public $DateOfBirth;
    public $Street;
    public $HouseNumber;
    public $City;
    public $PostalCode;

    public function __construct(Array $properties=array()){
        parent::__construct($properties);
    }
}