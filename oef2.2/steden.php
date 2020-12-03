<?php

error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once "functions.php";
require_once ("./templates/html_components.php");

PrintHead();
PrintJumbo();
?>

<div class="container">
    <div class="row">
        <div class="col-12 buttonbar">
            <?php
            $contQuery = "SELECT con_naam AS cont FROM continents";
            $rows = getData($contQuery);

            if ($rows->num_rows > 0) {
                $output = "";
                while ($row = $rows->fetch_assoc()) {
                    $output .= '<a class="btn btn-primary" role="button" href="steden.php?continent='. $row['cont'] . '" >' . $row['cont'] . '</a>';
                }
                $output .= '<a class="btn btn-primary" role="button" href="steden.php" >Wereld</a>';
                echo $output;
            }
            ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <?php
        $imgQuery = 'SELECT * FROM images';
        if (isset($_GET['continent'])) {
            $imgQuery = 'SELECT * FROM images JOIN continents ON img_con_id = con_id WHERE con_naam LIKE "%'.$_GET['continent'].'%"';
        }

        $rows = getData($imgQuery);
        include "./templates/cityblock.php";

        ?>
    </div>
</div>
<?php
$mysqli -> close();
?>
</body>