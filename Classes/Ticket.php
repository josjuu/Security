<?php
/**
 * Created by PhpStorm.
 * User: Jos Mutter
 * Date: 05/10/2018
 * Time: 18:34
 */

class Ticket extends DbTable
{
    public $Id;
    public $MovieTimeId;
    public $PriceId;
    public $Seat;

    public function __construct(Array $properties=array()){
        parent::__construct($properties);
    }
}