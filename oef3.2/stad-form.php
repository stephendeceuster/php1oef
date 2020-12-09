<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once ("./lib/mysqli.php");
require_once ("./lib/html_components.php");

$updated = '';
if ($_POST != []) {
    $sql = 'UPDATE images SET ';
    $sql .= 'img_title = "' . $_POST["img_title"] . '", ';
    $sql .= 'img_filename = "' . $_POST["img_filename"] . '", ';
    $sql .= 'img_width = "' . $_POST["img_width"] . '", ';
    $sql .= 'img_height = "' . $_POST["img_height"] . '" ';
    $sql .= 'WHERE img_id = ' . $_POST["img_id"] ;


    $result = $mysqli -> query($sql);

    $updated = '<div class="alert alert-success" role="alert">De databank is aangepast!</div>';
}

// INSERT HEAD & JUMBO
printHead("Cityguide bewerken");
printJumbo("Bewerk afbeelding", "");

?>

<div class="container">
    <div class="row">

<?php
// INSERT SUCCES MESSAGE
if ($updated) {
    echo $updated;
}


// INSERT CITYFORM
// Check if img_id is an integer
$img_id = $_GET['img_id'];
if ( ! is_numeric( $img_id ) ) {
    die("Ongeldig argument " . $_GET['img_id'] . " opgegeven");
}
// get data
$cityForm = "SELECT * FROM images JOIN continents ON con_id = img_con_id WHERE img_id =" . $img_id;
$rows = getData($cityForm);
// get template
$template = file_get_contents('./templates/cityform.html');
// merge data & template
$html = mergeDataTemplate($rows, $template);
echo $html;
?>

    </div> <!-- end .row -->
</div> <!-- end .container -->

<?php
$mysqli -> close();
?>
</body>