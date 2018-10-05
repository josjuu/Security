<?php
/**
 * Created by PhpStorm.
 * User: josmu
 * Date: 05/10/2018
 * Time: 13:32
 */

class Db
{
    public static function getAllRecords($tableName, $className)
    {
        $conn = new mysqli('localhost', 'root', '', 'josmutter_movies');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

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
        $conn = new mysqli('localhost', 'root', '', 'josmutter_movies');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT * FROM " . $tableName . " WHERE Id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($ID, $FirstName, $LastName, $Email);
            $stmt->fetch();

            echo $FirstName; // Outputs the first name
        }

        $stmt->close();
        $conn->close();
    }
}