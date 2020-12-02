<?php

require_once "connection.php";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli -> connect_error) {
    die("Connection failed: " . $mysqli -> connect_error);
}

function getData($sql) {
    global $mysqli;

    // Execute query
    $result = $mysqli -> query($sql);
    return $result;

}