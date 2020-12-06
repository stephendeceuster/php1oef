<?php
require_once "connectioncredentials.php";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function getData($sql) {
    global $mysqli;

    //define & execute query
    $result = $mysqli -> query($sql);

    if ($result -> num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    } else {
        $rows = [];
    }
    return $rows;
}