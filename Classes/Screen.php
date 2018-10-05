<?php

class Screen extends DbTable
{
    public $Id;
    public $LocationId;
    public $Name;
    public $Rows;
    public $SeatsPerRow;
    public $ScreenQuality;

    public function __construct(Array $properties=array()){
        parent::__construct($properties);
    }
}