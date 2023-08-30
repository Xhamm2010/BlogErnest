<?php

function getDbConnection()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "blog_test";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // var_dump($conn);
        // If the connection succeed it returns an instance of  PDO
        return $conn;
    } catch (PDOException $e) {
        // If the connection fail it return an error with a more detailed message
        echo "Connection failed: " . $e->getMessage();
    }
}
