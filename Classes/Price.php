<?php
/**
 * Created by PhpStorm.
 * User: Jos Mutter
 * Date: 05/10/2018
 * Time: 18:09
 */

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