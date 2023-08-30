<?php
require_once("DbConfig.php");

class Crud
{
    // This can only be accessed inside the class because it is private
    private $conn;

    public function __construct()
    {
        // A __construct() is a piece of code that runs automatically
        //  whenever you create an instance of a class

        // Whenever you create an instance of a Crud class
        // The $conn property will always hold the database
        // connection object which is getDbConnection();
        $this->conn = getDbConnection();
        var_dump($this->conn);
    }

    // The create method takes two parameters
    // The data-array and the table
    public function create($data_array, $table)
    {
        $column = implode(',', array_keys($data_array));
        $placeholders = ":" . implode(',:', array_keys($data_array));
        // var_dump($placeholders);

        // SQL statement
        $sql = "INSERT INTO $table ($column) VALUES($placeholders)";

        // Prepare the statement
        $stmt = $this->conn->prepare($sql);

        // Execute the query
        // This is the part that add the data into the database
        $stmt->execute($data_array);
        return $this->conn->lastInsertId();
    }

    // This methods help to read data from the database
    public function read($sql_query)
    {

        $stmt = $this->conn->prepare($sql_query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // This method help to update the data from the database
    public function update($sql_query)
    {

        $stmt = $this->conn->prepare($sql_query);
        $stmt->execute();
    }

    // This method help to delete the data from the database
    public function delete($sql_query)
    {

        $stmt = $this->conn->prepare($sql_query);
        $stmt->execute();
    }
}