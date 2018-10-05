<?php
/**
 * Created by PhpStorm.
 * User: josmu
 * Date: 05/10/2018
 * Time: 13:26
 */

class Movie extends DbTable
{
    public $Id;
    public $Name;
    public $PegiRating;
    public $Length;
    public $ReleaseDate;
    public $Expiration;

    public function __construct(Array $properties=array()){
        parent::__construct($properties);
    }
}