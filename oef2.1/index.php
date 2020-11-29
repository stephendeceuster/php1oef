<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once("connection_data.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

function getData($sql) {
    global $conn;

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Execute query
    $result = $conn -> query($sql);

    // Show result
    if ($result->num_rows > 0) {
        // output elke rij
        while ($row = $result->fetch_assoc()) {
            $output = '<div class="col-sm-4">';
            $output .= '<h3>' . $row["img_title"] . '</h3> ';
            $output .= '<p>' . $row["img_height"] . ' x ' . $row["img_width"] . ' pixels </p>';
            $output .= '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>';
            $output .= '<img src="./img/' . $row["img_filename"] . '" alt="A view from ' . $row["img_title"] . '" title ="A view from ' . $row["img_title"] . '">';
            $output .= '</div>';
            echo $output;
        }
    } else {
        echo "No records found";
    }
    // Free result set
    $result -> free_result();
    // close connection
    $conn -> close();
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
    </style>
</head>
<body>


<div class="jumbotron text-center">
    <h1>Leuke plekken in Europa</h1>
    <p>Tips voor citytrippers!</p>
</div>

<div class="container">
    <div class="row">

        <?php
        $selectAll = "SELECT * from images";
        getData($selectAll);
        ?>

    </div>
</div>

</body>
</html>