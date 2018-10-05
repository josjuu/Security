<?php

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