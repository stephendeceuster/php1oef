<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );


require_once 'autoload.php';

saveFormData();

function saveFormData()
{
    global $mysqli;
    if ( $_SERVER['REQUEST_METHOD'] == "POST" )
    {

        // security csrf
        if (!key_exists("csrf", $_POST)) {
            die("Missing CSRF");
        };
        if (!hash_equals($_POST['csrf'], $_SESSION['latest_csrf'])) {
            die("Problem with CSRF");
        }
        // make latest csrf empty
        $_SESSION['latest_csrf'] = '';

        // sanitization
        $_POST = stripSpaces($_POST);
        $_POST = convertSpecialChars($_POST);

        $update = $insert = $where = $str_keys_values = "";

        // get meta data
        if ( ! key_exists("table", $_POST)) {
            die("Missing table");
        }
        if ( ! key_exists("pkey", $_POST)) {
            die("Missing pkey");
        }

        $table = $_POST['table'];
        $pkey = $_POST['pkey'];

        //validation
        $sending_form_uri = $_SERVER['HTTP_REFERER'];
        compareWithDatabase( $table, $pkey );

        //terugkeren naar afzender als er een fout is
        if ( count($_SESSION['errors']) > 0 ) { header( "Location: " . $sending_form_uri ); exit(); }

        //insert or update?
        if ( $_POST["$pkey"] > 0 ) {
            $update = true;
        } else {
            $insert = true;
        }

        if ( $update ) {
            $sql = "UPDATE $table SET ";
        }
        if ( $insert ) {
            $sql = "INSERT INTO $table SET ";
        }
        //make key-value string part of SQL statement
        $keys_values = [];

        foreach ( $_POST as $field => $value )
        {
            //skip non-data fields
            if ( in_array( $field, [ 'table', 'pkey', 'afterinsert', 'afterupdate', 'csrf' ] ) ) {
                continue;
            }
            //handle primary key field
            if ( $field == $pkey ) {
                if ( $update ) {
                    $where = " WHERE $pkey = $value ";
                }
                continue;
            }

            //all other data-fields
            $keys_values[] = " $field = '$value' " ;


        }

        $str_keys_values = implode(" , ", $keys_values );

        //extend SQL with key-values
        $sql .= $str_keys_values;
        //extend SQL with WHERE
        $sql .= $where;

        //run SQL
        $result = $mysqli -> query($sql);
        var_dump($result);

        //redirect after insert or update
        //if ( $insert AND $_POST["afterinsert"] > "" ) header("Location: ../" . $_POST["afterinsert"] );
        //if ( $update AND $_POST["afterupdate"] > "" ) header("Location: ../" . $_POST["afterupdate"] );

    }
}
