<?php

/**
 * Class DbTable
 */
class DbTable
{
    public function __construct(Array $properties=array()){
        foreach($properties as $key => $value){
            $this->{$key} = $value;
        }
    }
}