<?php
/**
 * Created by PhpStorm.
 * User: josmu
 * Date: 05/10/2018
 * Time: 14:23
 */

class DbTable
{
    public function __construct(Array $properties=array()){
        foreach($properties as $key => $value){
            $this->{$key} = $value;
        }
    }
}