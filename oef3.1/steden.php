<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once ("./lib/mysqli.php");
require_once ("./lib/html_components.php");

// INSERT HEAD & JUMBO
printHead();
printJumbo();

?>
<div class="container">
    <div class="row">
        <div class="col-12 buttonbar">
<?php

// INSERT CONTINENT BUTTONS
// the query
$contQuery = "SELECT con_name FROM continents";
// get the data
$rows = getData($contQuery);
// the template
$template = '<a class="btn btn-primary" role="button" href="steden.php?continent=%con_name%">%con_name%</a>';
$html = mergeDataTemplate($rows, $template);
if ($html != '') {
    $html .= '<a class="btn btn-primary" role="button" href="steden.php">Bekijk alle steden</a>';
}
echo $html;
?>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">

<?php

// INSERT CITYCARDS
// get the query
$cityQuery = 'SELECT * FROM images JOIN continents ON img_con_id = con_id';
if (isset($_GET['continent'])) {
    $cityQuery .= ' WHERE con_name LIKE "%'.$_GET['continent'].'%"';
}
// get data
$rows = getData($cityQuery);
// get template
$template = file_get_contents('./templates/citycard.html');
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
