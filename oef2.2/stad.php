<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once ("functions.php");
require_once ("./templates/html_components.php");

$imgId = $_GET['img_id'];
$sql = "SELECT * FROM images JOIN continents ON con_id = img_con_id WHERE img_id =". $imgId;



// get query with city data
$result = $mysqli -> query($sql);

// Show result
if ($result -> num_rows > 0) {
    // put data in variables
    while ($row = $result->fetch_assoc()) {
        $title = $row["img_title"];
        $file = $row["img_filename"];
        $width = $row["img_width"];
        $height = $row["img_height"];
        $continent = $row["con_naam"];
    }
} else {
    echo "No records found";
}

// Free result set
$result -> free_result();

PrintHead();
PrintJumbo();
?>

<div class="container">
    <div class="row">
        <div class="col-9">
            <?php
            // print de content
            echo '<h4>' . $title . ' - ' . $continent . '</h4>';
            echo '<p>filename : ' . $file . '</p>';
            echo '<p>' . $width . ' x ' . $height . ' pixels</p>';
            echo '<img src="./img/' . $file . '" alt="A view from ' . $title . '" title ="A view from ' . $title . '">';
            // ga terug link
            $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);
            if (!empty($referer)) {
                echo '<p><a href="'. $referer .'" title="Terug naar overzicht">Terug naar overzicht</a></p>';
            } else {
                echo '<p><a href="javascript:history.go(-1)" title="Terug naar overzichte">Terug naar overzicht</a></p>';
            }
            ?>

        </div>
    </div>
</div>


</body>
</html>

<?php
// close connection
$mysqli -> close();
?>
