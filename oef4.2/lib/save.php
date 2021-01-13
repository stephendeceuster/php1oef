<?php
require_once "autoload.php";
//var_dump($_POST['csrf']);
//var_dump($_SESSION['lastest_csrf']);

saveFormData();

function saveFormData()
{
    if ( $_SERVER['REQUEST_METHOD'] == "POST" )
    {
        //controle CSRF token
        if ( ! key_exists("csrf", $_POST)) die("Missing CSRF");
        // CSRF FIXEN!!!!!!!!!!
        //if ( ! hash_equals( $_POST['csrf'], $_SESSION['lastest_csrf'] ) ) die("Problem with CSRF");

        $_SESSION['lastest_csrf'] = "";

        //sanitization
        $_POST = stripSpaces($_POST);
        $_POST = convertSpecialChars($_POST);

        $table = $pkey = $update = $insert = $where = $str_keys_values = "";

        //get important metadata
        if ( ! key_exists("table", $_POST)) die("Missing table");
        if ( ! key_exists("pkey", $_POST)) die("Missing pkey");

        $table = $_POST['table'];
        $pkey = $_POST['pkey'];

        //validation
        $sending_form_uri = $_SERVER['HTTP_REFERER'];
        compareWithDatabase( $table, $pkey );
        //check if valid email
        if (isset($_POST['usr_email'])) {
            $email = $_POST['usr_email'];
            validateEmail($email);
        }
        // check if password is long enough
        if (isset($_POST['usr_password'])) {
            $pw = $_POST['usr_password'];
            validateUsrPassword($pw);
        }

        //terugkeren naar afzender als er een fout is
        if ( count($_SESSION['errors']) > 0 ) {
            $_SESSION['old_post'] = $_POST;
            header( "Location: " . $sending_form_uri );
            exit();
        }

        //insert or update?
        if ( $_POST["$pkey"] > 0 ) $update = true;
        else $insert = true;

        if ( $update ) $sql = "UPDATE $table SET ";
        if ( $insert ) $sql = "INSERT INTO $table SET ";

        //make key-value string part of SQL statement
        $keys_values = [];

        foreach ( $_POST as $field => $value )
        {
            //skip non-data fields
            if ( in_array( $field, [ 'table', 'pkey', 'afterinsert', 'afterupdate', 'csrf' ] ) ) continue;

            //handle primary key field
            if ( $field == $pkey )
            {
                if ( $update ) $where = " WHERE $pkey = $value ";
                continue;
            }

            //hash password
            if ( $field == 'usr_password') {
                $hash = password_hash($value, PASSWORD_DEFAULT);
                $keys_values[] = " $field = '$hash' ";
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
        $result = ExecuteSQL( $sql );
        var_dump($result);

        //output if not redirected
        print $sql ;
        print "<br>";
        print $result->rowCount() . " records affected";

        //succes from script
        $_SESSION['msgs'] = "Bedankt, voor uw registratie.";

        //redirect after insert or update
        if ( $insert AND $_POST["afterinsert"] > "" ) header("Location: ../" . $_POST["afterinsert"] );
        if ( $update AND $_POST["afterupdate"] > "" ) header("Location: ../" . $_POST["afterupdate"] );
    }
}