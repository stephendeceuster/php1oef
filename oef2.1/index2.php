<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once("connection_data.php");

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function getData($sql) {

    global $mysqli;

    // Execute query
    $result = $mysqli -> query($sql);

    // Show result
    if ($result->num_rows > 0) {
        // output elke rij
        while ($row = $result->fetch_assoc()) {
            $output = '<div class="col-sm-4 mb-2">';
            $output .= '<div class="col-sm-12">';
            $output .= '<h3>' . $row["img_title"] . '</h3> ';
            $output .= '<p>' . $row["img_height"] . ' x ' . $row["img_width"] . ' pixels </p>';
            $output .= '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>';
            $output .= '<img src="./img/' . $row["img_filename"] . '" alt="A view from ' . $row["img_title"] . '" title ="A view from ' . $row["img_title"] . '">';
            $output .= '</div></div>';
            echo $output;
        }
    } else {
        echo "No records found";
    }
    // Free result set
    $result -> free_result();

    // close connection
    $mysqli -> close();

}

function getContinents() {

    global $mysqli;

    // Execute query
    $continents = "SELECT con_naam FROM continents";
    $result = $mysqli -> query($continents);

    if ($result->num_rows > 0) {
        // output elke rij
        while ($row = $result->fetch_assoc()) {
            $output = '<a class="btn btn-primary" role="button" href="index2.php?continent='. $row["con_naam"] . '" >' . $row["con_naam"] . '</a>';
            echo $output;
        }
    } else {
        echo "No records found";
    }
    // Free result set
    $result -> free_result();


}



?>

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
        img {
            width: 100%;
            height: auto;
        }
        .container {
            padding-bottom: 5rem;
        }
        div.col-sm-12 {
            transition: all 300ms ease-in-out;
            padding-bottom: 16px;
            border-radius: 4px;
            margin-bottom: 16px;
        }
        div.col-sm-12:hover {
            transform: scale(1.015);
            box-shadow: 0px 8px 9px -3px rgba(68,68,68,0.61);
            background-color: #eeeeee;
        }
        .btn {
            margin-right: 8px;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>


<div class="jumbotron text-center">
    <h1>Leuke plekken op de wereld</h1>
    <p>Tips voor citytrippers!</p>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <?php
            getContinents();
            ?>
        </div>
    </div>
    <div class="row">

        <?php

        $selectAll = 'SELECT * FROM images';
        getData($selectAll);
        ?>

    </div>
</div>

</body>
</html>

<?php
// close connection
$mysqli -> close();
?>