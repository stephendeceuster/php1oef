<?php

//print json_encode($_POST);

require_once "mysqli.php";

SaveFormData();

function SaveFormData()
{
    if ( $_SERVER['REQUEST_METHOD'] == "POST" )
    {
        //var_dump($_POST);
        $update = $insert = $where = $str_keys_values = "";

        if ( ! key_exists("table", $_POST)) {
            die("Missing table");
        }
        if ( ! key_exists("pkey", $_POST)) {
            die("Missing pkey");
        }

        $table = $_POST['table'];
        $pkey = $_POST['pkey'];

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
        //var_dump($sql);
        //make key-value string part of SQL statement
        $keys_values = [];

        foreach ( $_POST as $field => $value )
        {
            //skip non-data fields
            if ( in_array( $field, [ 'table', 'pkey', 'afterinsert', 'afterupdate' ] ) ) {
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

        if ( $insert AND $_POST["afterinsert"] > "" ) header("Location: ../" . $_POST["afterinsert"] );
        if ( $update AND $_POST["afterupdate"] > "" ) header("Location: ../" . $_POST["afterupdate"] );

    }
}
