<?php

error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once "functions.php";

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
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>


<div class="jumbotron text-center">
    <h1>Leuke plekken op de wereld</h1>
    <p>Tips voor citytrippers!</p>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 buttonbar">
            <?php
            $contQuery = "SELECT con_naam AS cont FROM continents";
            $rows = getData($contQuery);

            if ($rows->num_rows > 0) {
                $output = "";
                while ($row = $rows->fetch_assoc()) {
                    $output .= '<a class="btn btn-primary" role="button" href="steden.php?continent='. $row['cont'] . '" >' . $row['cont'] . '</a>';
                }
                $output .= '<a class="btn btn-primary" role="button" href="steden.php" >Wereld</a>';
                echo $output;
            }
            ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <?php
        $imgQuery = 'SELECT * FROM images';
        if (isset($_GET['continent'])) {
            $imgQuery = 'SELECT * FROM images JOIN continents ON img_con_id = con_id WHERE con_naam LIKE "%'.$_GET['continent'].'%"';
        }

        $rows = getData($imgQuery);

        if ($rows->num_rows > 0) {
            // output elke rij
            while ($row = $rows->fetch_assoc()) {
                $output = '<div class="col-sm-4 mb-2">';
                $output .= '<div class="col-sm-12">';
                $output .= '<h3>' . $row["img_title"] . '</h3> ';
                $output .= '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>';
                $output .= '<img src="./img/' . $row["img_filename"] . '" alt="A view from ' . $row["img_title"] . '" title ="A view from ' . $row["img_title"] . '">';
                $output .= '<a href="stad.php?img_id=' . $row["img_id"] . '">Meer info over '. $row["img_title"] . '</a>';
                $output .= '</div></div>';
                echo $output;
            }
        } else {
            echo "No records found";
        }
        ?>
    </div>
</div>
<?php
$mysqli -> close();
?>
</body>