<?php
/**
 * Created by PhpStorm.
 * User: josmu
 * Date: 05/10/2018
 * Time: 13:26
 */

class Movie
{
    public $Id;
    public $Name;
    public $PegiRating;
    public $Length;
    public $ReleaseDate;
    public $Expiration;

    public function __construct(Array $properties=array()){
        foreach($properties as $key => $value){
            $this->{$key} = $value;
        }
    }
}