<?php

class Db
{
    public static function getConnection(){
        $conn = new mysqli('localhost', 'root', '', 'josmutter_movies');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    public static function getAllRecords($tableName, $className)
    {
        $conn = self::getConnection();

        $stmt = $conn->prepare("SELECT * FROM " . $tableName);
        $stmt->execute();
        $records = $stmt->get_result();

        $stmt->close();
        $conn->close();

        if($records->num_rows <=0){
            return null;
        }

        $classes = Array();

        foreach($records as $record){
            $class = new $className($record);
            array_push($classes, $class);
        }

        return $classes;
    }

    public static function getSingleRecord($tableName, $className, $id){
        $conn = self::getConnection();

        $stmt = $conn->prepare("SELECT * FROM " . $tableName . " WHERE Id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $records = $stmt->get_result();

        $stmt->close();
        $conn->close();

        if($records->num_rows != 1){
            return null;
        }

        foreach($records as $record){
            $class = new $className();

            $properties = get_object_vars($class);
            foreach($properties as $name => $value)
            {
                $class->$name = $record[$name];
            }

            return $class;
        }
    }
}