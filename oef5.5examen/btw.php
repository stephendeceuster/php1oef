<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once "lib/autoload.php";

PrintHead();
PrintJumbo( $title = "BTW Codes in Europa" ,
    $subtitle = "" );
PrintNavbar();

$sql = 'SELECT * FROM eu_btw_codes';
$data = GetData( $sql );

$exportData = [];
$exportData[] = array('Land', 'BTW code', 'Hyperlink');

//create table
$table ='';
foreach ($data as $row) {
    $country = trim($row['eub_land']);
    $wiki = 'https://nl.wikipedia.org/wiki/' . str_replace(' ', '_', $country);
    $btw = $row['eub_code'];
    $id = $row['eub_id'];
    $table .= "<tr>";
    $table .= "<td><a href='" . $wiki . "' target='_blank'>$country</a></td>";
    $table .= "<td>" . $btw . "</td>";
    $table .= "<td><a class='btn btn-primary' href='edit_btw.php?eub_id=" . $id . "'>Edit</a>";
    $table .= "</tr>";
    $exportData[] = array($country, $btw, $wiki);
}

//create download button
$downloadBtn = "<form method='post' action='./lib/csv_export_functions.php'>";
$downloadBtn .= "<input class='btn btn-primary' type='submit' value='Export CSV' name='Export CSV'>";
$serialized = serialize($exportData);
$downloadBtn .= "<textarea name='export_data' style='display: none;'>$serialized</textarea>";
$downloadBtn .= "</form";
?>

<div class="container">
    <div class="row">
        <?php
        // print downloadBtn
        print $downloadBtn;
        ?>
    </div>
</div>
<div class="container">
    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Land</th>
                <th scope="col">BTW code</th>
                <th scope="col">Edit</th>
            </tr>
            </thead>
            <tbody>

            <?php
           // print generated table
            print $table;
            ?>
            </tbody>
        </table>

    </div>
</div>
</body>