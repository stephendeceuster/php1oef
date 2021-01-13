<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once ('./lib/autoload.php');

// INSERT HEAD & JUMBO
printHead("Cityguide bewerken");

printJumbo("Bewerk afbeelding", "");

printNavbar();

?>

<div class="container">
    <div class="row">

<?php

// INSERT CITYFORM

$img_id = $_GET['img_id'];

// Check if img_id is an integer
if ( ! is_numeric( $img_id ) ) {
    die("Ongeldig argument " . $img_id . " opgegeven");
}
// get data
$cityForm = "SELECT * FROM images JOIN countries ON cou_id = img_cou_id WHERE img_id =" . $img_id;
$data = getData($cityForm);

// add CSRF token to data
$extra["csrf_token"] = generateCSRF("cityform");
$extra["select"] = makeSelect($fkey = 'img_cou_id', $value = $data[0]['img_cou_id'], $sql = 'SELECT cou_id, cou_');

// get template
$template = file_get_contents('./templates/cityform.html');

// merge data & template
$html = mergeDataTemplate($data, $template);

// dynamische landenlijst
$optionsCountries = "SELECT * FROM countries ORDER BY cou_name";
$rows = getData($optionsCountries);
$options = '';
foreach ($rows as $row) {
    $selected = '';
    if ($data[0]['img_cou_id'] == $row['cou_id']) $selected = ' selected ';
    $options .= '<option ' . $selected . ' value ="' . $row['cou_id'] . '">' . $row['cou_name'] . '</option> ';
}
$html = str_replace('%options%', $options , $html);
echo $html;
?>

    </div> <!-- end .row -->
</div> <!-- end .container -->

<?php
printFooter();
?>