<?php
/**
 * Created by PhpStorm.
 * User: Jos Mutter
 * Date: 05/10/2018
 * Time: 18:20
 */

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