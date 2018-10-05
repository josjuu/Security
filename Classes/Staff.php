<?php
/**
 * Created by PhpStorm.
 * User: Jos Mutter
 * Date: 05/10/2018
 * Time: 18:28
 */

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