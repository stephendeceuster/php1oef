<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            padding: 2rem;
        }
        table td {
            padding: 0.75rem 1rem;
        }
        table tr:nth-child(odd) {
            background-color: #ededed;
        }
        table tr:nth-child(even) {
            background-color: #fefefe;
        }
        table {
            background-color: #ff33cc;
    </style>
</head>
<body>


<?php

$student =	array(
    "voornaam" =>  "Jan",
    "naam" =>  "Janssens",
    "straat" =>  "Oude baan",
    "huisnr" =>  "22",
    "postcode" =>  2800,
    "gemeente" =>  "Mechelen",
    "geboortedatum" =>  "14/05/1991",
    "telefoon" =>  "015 24 24 26",
    "e-mail" =>  "jan.janssens@gmail.com"
);

function studentToTable($a) {
    echo "<h1>Student</h1>";
    echo "<table>";
    foreach ($a as $x => $y) {
        echo "<tr><td>". ucfirst($x) ."</td><td>". $y ."</td>";
    }
    echo "</table>";
}

studentToTable($student);

?>

</body>
