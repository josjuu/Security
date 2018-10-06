<?php

/**
 * Class Db
 *
 * @author Jos Mutter
 * @since 05-10-2018
 *
 * This class will handle the database related methods, but only generic methods.
 */
class Db
{
    /**
     * Gets a connection with the database.
     *
     * @return mysqli
     *      Returns an active connection with the database.
     */
    public static function getConnection()
    {
        $conn = new mysqli('localhost', 'root', '', 'josmutter_movies');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    /**
     * Gets all the records of the given table name.
     * Serializes the record in the given class.
     *
     * @param $tableName
     *      The name of the table in the database.
     * @param $className
     *      The name of the class name that represents a record in the database.
     * @return array|null
     *      Returns a array of the given class. Or returns null if there were no records found in the table.
     */
    public static function getAllRecords($tableName, $className)
    {
        $conn = self::getConnection();

        $stmt = $conn->prepare("SELECT * FROM " . $tableName);
        $stmt->execute();
        $records = $stmt->get_result();

        $stmt->close();
        $conn->close();

        if ($records->num_rows <= 0) {
            return null;
        }

        $classes = Array();

        foreach ($records as $record) {
            $class = new $className($record);
            array_push($classes, $class);
        }

        return $classes;
    }

    /**
     * Gets a single record of the given table by the id.
     * Serializes the record in the given class.
     *
     * @param $tableName
     *      The name of the table in the database.
     * @param $className
     *      The name of the class that represents a record in the database.
     * @param $id
     *      The id of the record you want to get.
     * @return object|null
     *      Returns a object of the given table and id. It can return null if nothing was found or more than 1 was found.
     */
    public static function getSingleRecord($tableName, $className, $id)
    {
        $conn = self::getConnection();

        $stmt = $conn->prepare("SELECT * FROM " . $tableName . " WHERE Id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $records = $stmt->get_result();

        $stmt->close();
        $conn->close();

        if ($records->num_rows != 1) {
            return null;
        }

        foreach ($records as $record) {
            $class = new $className();

            $properties = get_object_vars($class);
            foreach ($properties as $name => $value) {
                $class->$name = $record[$name];
            }

            return $class;
        }
    }

    /**
     * Adds a single record to the given table.
     *
     * @param $tableName
     *      The name of the table.
     * @param $object
     *      The object you wish to add.
     */
    public static function addRecord($tableName, $object)
    {
        //Creates an array of the object and removes the Id.
        $object = (Array)$object;
        unset($object["Id"]);

        //Initializing variables
        $columnNames = Array();
        $values = Array();
        $amountOfQuestionmarks = 0;
        $columns = "";
        $questionmarks = "";

        //Setting variables
        foreach ($object as $column => $value) {
            $amountOfQuestionmarks++;
            array_push($values, $value);
            array_push($columnNames, $column);
        }

        //Setting the strings
        for ($i = 0; $i < $amountOfQuestionmarks; $i++) {
            $columns .= $i != 0 ? ", $columnNames[$i]" : $columnNames[$i];
            $questionmarks .= $i != 0 ? ", ?" : "?";
        }

        $sql = "INSERT INTO $tableName ($columns) VALUES ($questionmarks)";

        echo $sql;

        $db = new PDO('mysql:host=localhost;dbname=josmutter_movies', 'root', '');
        $stmt = $db->prepare($sql);

        for ($i = 0; $i < $amountOfQuestionmarks; $i++) {
            $stmt->bindParam($i + 1, $values[$i], PDO::PARAM_STR);
        }

        $stmt->execute();

    }

    /**
     * Updates a single record of the given table.
     *
     * @param $tableName
     *      The name of the table.
     * @param $object
     *      The object you wish to update.
     * @throws NotSetException
     *      Throws an exception if an important field is not set or is null.
     */
    public static function updateRecord($tableName, $object)
    {
        if ($tableName == "" || $tableName == null || $object == null || $object->Id == null || $object->Id <= 0) {
            throw new NotSetException("Some fields are not set or null");
        }

        $db = self::getConnection();
        foreach ($object as $column => $value) {
            echo "$column = $value<br>";
            $stmt = $db->prepare("UPDATE $tableName SET $column = ? WHERE Id = {$object->Id}");
            $stmt->bind_param("s", $value);
            $stmt->execute();
            $stmt->close();
        }
        $db->close();
    }

    /**
     * Updates multiple records from the given table
     *
     * @param $tableName
     *      The name of the table
     * @param $objects
     *      An array of objects of wish you want to update.
     */
    public static function updateRecords($tableName, $objects)
    {
        foreach ($objects as $object) {
            try {
                self::updateRecord($tableName, $object);
            } catch (NotSetException $e) {
                echo $e->__toString();
            }
        }
    }
}