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
        $img = array("paris", "london", "rome") ;

        for ($i = 0; $i < count($img); $i++ ) {
            echo '<div class="col-sm-4">';
            echo '<h3>Column ' . ($i+1) . '</h3>';
            echo '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>';
            echo '<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>';
            echo '<img src="./img/' . $img[$i] . '.jpg">';
            echo '</div>';
        }
        ?>

    </div>
</div>

</body>
</html>

