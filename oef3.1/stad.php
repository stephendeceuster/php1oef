<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once ("./lib/mysqli.php");
require_once ("./lib/html_components.php");

// INSERT HEAD & JUMBO
printHead("Cityguide");
printJumbo("Ontdek de stad", "");

?>

<div class="container">
    <div class="row">

<?php

// INSERT CITYINFO
// Check if img_id is an integer
$img_id = $_GET['img_id'];
if ( ! is_numeric( $img_id ) ) {
    die("Ongeldig argument " . $_GET['img_id'] . " opgegeven");
}
// get data
$cityQuery = "SELECT * FROM images JOIN continents ON con_id = img_con_id WHERE img_id =" . $img_id;
$rows = getData($cityQuery);
// get template
$template = file_get_contents('./templates/citypage.html');
// merge data & template
$html = mergeDataTemplate($rows, $template);
echo $html;
// return link
$referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);
if (!empty($referer)) {
    echo '<p><a href=" '. $referer .' " title="Terug naar overzicht">Terug naar overzicht</a></p>';
} else {
    echo '<p><a href="javascript:history.go(-1)" title="Terug naar overzichte">Terug naar overzicht</a></p>';
}
?>

    </div> <!-- end .row -->
</div> <!-- end .container -->

<?php
$mysqli -> close();
?>
</body>