<?php

class MovieTime extends DbTable
{
    public $Id;
    public $MovieId;
    public $StaffId;
    public $ScreenId;
    public $Time;
    public $Date;

    public function __construct(Array $properties=array()){
        parent::__construct($properties);
    }
}