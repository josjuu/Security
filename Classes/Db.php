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
}