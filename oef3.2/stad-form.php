<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once ("./lib/security.php");
require_once ("./lib/mysqli.php");
require_once ("./lib/html_components.php");

var_dump($_SESSION);

// INSERT HEAD & JUMBO
printHead("Cityguide bewerken");
printJumbo("Bewerk afbeelding", "");

?>

<div class="container">
    <div class="row">

<?php

// INSERT CITYFORM
// Check if img_id is an integer
$img_id = $_GET['img_id'];
if ( ! is_numeric( $img_id ) ) {
    die("Ongeldig argument " . $_GET['img_id'] . " opgegeven");
}
// get data
$cityForm = "SELECT * FROM images JOIN countries ON cou_id = img_cou_id WHERE img_id =" . $img_id;
$data = getData($cityForm);
// add CSRF token to data
$data[0]["csrf_token"] = generateCSRF("cityform");
// get template
$template = file_get_contents('./templates/cityform.html');
// merge data & template
$html = mergeDataTemplate($data, $template);
// dynamische landenlijst
$optionsCountries = "SELECT * FROM countries ORDER BY cou_name";
$rows = getData($optionsCountries);
$options = '<option value ="NULL">Kies een land</option>';
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
$mysqli -> close();
?>
</body>