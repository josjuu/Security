<?php
/**
 * Created by PhpStorm.
 * User: Jos Mutter
 * Date: 05/10/2018
 * Time: 18:02
 */

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