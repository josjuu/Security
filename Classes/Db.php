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
     * @return PDO
     *      Returns an active connection with the database.
     * @throws ConnectionFailedException
     *      Throws an exception if it fails to connect.
     */
    public static function getConnection()
    {
        $dsn = "mysql:dbname=josmutter_movies;host=localhost";
        $username = "root";
        $password = "";

        try {
            $conn = new PDO($dsn, $username, $password);
            return $conn;
        } catch (PDOException $e) {
            $exception = new ConnectionFailedException("Failed to connect to the database");
            $exception->dsn = $dsn;
            $exception->username = $username;
            $exception->password = $password;
            throw $exception;
        }
    }

    /**
     * Gets all the records of the given table name.
     * Serializes the record in the given class.
     *
     * @param $tableName
     *      The name of the table in the database.
     * @param $className
     *      The name of the class name that represents a record in the database.
     * @return array
     *      Returns a array of the given class.
     * @throws ConnectionFailedException
     *      Throws an exception if it failed to connect to the database.
     * @throws NullException
     *      Throws an exception if there were no records found in the table.
     */
    public static function getAllRecords($tableName, $className)
    {
        $db = self::getConnection();

        $stmt = $db->prepare("SELECT * FROM " . $tableName);
        $stmt->execute();

        if ($stmt->rowCount() <= 0) {
            throw new NullException("No records found.");
        }

        $stmt->setFetchMode(PDO::FETCH_INTO, new $className());
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sth = null;
        $dbh = null;

        return $records;
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
     *      Returns a object of the given table and id.
     * @throws ConnectionFailedException
     *      Throws an exception if it failed to connect to the database.
     * @throws NullException
     *      Throws an exception if there was no record or more than 1 records.
     */
    public static function getSingleRecord($tableName, $className, $id)
    {
        $db = self::getConnection();

        $stmt = $db->prepare("SELECT * FROM " . $tableName . " WHERE Id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();

        if ($stmt->rowCount() < 1) {
            throw new NullException("No record found.");
        } else if ($stmt->rowCount() > 1) {
            throw  new NullException("Multiple records found");
        }

        $stmt->setFetchMode(PDO::FETCH_INTO, new $className());
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        $sth = null;
        $dbh = null;

        return $record;
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

        try {
            $db = self::getConnection();
        } catch (ConnectionFailedException $e) {
            echo $e->__toString();
            return;
        }

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
     * @throws ConnectionFailedException
     *      Throws an exception if the connection failed.
     */
    public static function updateRecord($tableName, $object)
    {
        if ($tableName == "" || $tableName == null || $object == null || $object->Id == null || $object->Id <= 0) {
            throw new NotSetException("Some fields are not set or null");
        }

        try {
            $db = self::getConnection();
        } catch (ConnectionFailedException $e) {
            throw $e;
        }

        foreach ($object as $column => $value) {
            $stmt = $db->prepare("UPDATE $tableName SET $column = ? WHERE Id = {$object->Id}");
            $stmt->bindParam(1, $value);
            $stmt->execute();
            $stmt = null;
        }
        $db = null;
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
        try {
            foreach ($objects as $object) {
                try {
                    self::updateRecord($tableName, $object);
                } catch (NotSetException $e) {
                    echo $e->__toString();
                }
            }
        } catch (ConnectionFailedException $e) {
            echo $e->__toString();
        }
    }
}