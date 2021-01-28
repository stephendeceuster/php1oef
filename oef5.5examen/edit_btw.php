<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once "lib/autoload.php";

PrintHead();
PrintJumbo( $title = "Detail EU BTW code", $subtitle = "" );
?>

<div class="container">
    <div class="row">

        <?php
            if ( ! is_numeric( $_GET['eub_id']) ) die("Ongeldig argument " . $_GET['eub_id'] . " opgegeven");

            //get data
            $data = GetData( "select * from eu_btw_codes where eub_id=" . $_GET['eub_id'] );
            $row = $data[0]; //there's only 1 row in data

            //add extra elements
            $extra_elements['csrf_token'] = GenerateCSRF( "edit_btw.php"  );


            //get template
            $output = file_get_contents("templates/edit_btw.html");

            //merge
            $output = MergeViewWithData( $output, $data );
            $output = MergeViewWithExtraElements( $output, $extra_elements );
            $output = MergeViewWithErrors( $output, $errors );
            $output = RemoveEmptyErrorTags( $output, $data );

            print $output;
        ?>

    </div>
</div>

</body>
</html>