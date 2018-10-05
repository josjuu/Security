<?php

class Price extends DbTable
{
    public $Id;
    public $Name;
    public $PrimeTimePrice;
    public $NormalPrice;

    public function __construct(Array $properties=array()){
        parent::__construct($properties);
    }
}