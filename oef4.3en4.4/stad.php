<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once ('./lib/autoload.php');

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
$cityQuery = "SELECT * FROM images JOIN countries ON img_cou_id = cou_id JOIN continents ON cou_con_id = con_id WHERE img_id =" . $img_id;
$rows = getData($cityQuery);
// get template
$template = file_get_contents('./templates/citypage.html');
// merge data & template
$html = mergeDataTemplate($rows, $template);
echo $html;
// return link

?>

    </div> <!-- end .row -->
</div> <!-- end .container -->

<?php
$mysqli -> close();
?>
</body>