<?php

print json_encode($_POST);

include_once "./lib/mysqli.php";

$sql = 'UPDATE images SET ';
$sql .= 'img_title = "' . $_POST["img_title"] . '", ';
$sql .= 'img_filename = "' . $_POST["img_filename"] . '", ';
$sql .= 'img_width = "' . $_POST["img_width"] . '", ';
$sql .= 'img_height = "' . $_POST["img_height"] . '" ';
$sql .= 'WHERE img_id = ' . $_POST["img_id"] ;
echo $sql;

$result = $mysqli -> query($sql);

