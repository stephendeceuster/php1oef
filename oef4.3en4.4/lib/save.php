<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once "autoload.php";

saveFormData();

function saveFormData()
{
    if ( $_SERVER['REQUEST_METHOD'] == "POST" )
    {
        //controle CSRF token
        if ( ! key_exists("csrf", $_POST)) die("Missing CSRF");
        // CSRF FIXEN!!!!!!!!!!
        if ( ! hash_equals( $_POST['csrf'], $_SESSION['latest_csrf'] ) ) die("Problem with CSRF");

        $_SESSION['latest_csrf'] = "";

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

        if ($table == 'user') {
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

            // check bevestig password
            if ($_POST['usr_password'] !== $_POST['usr_password2']) {
                $msg = "Gelieve 2x hetzelfde wachtwoord te geven.";
                $_SESSION['errors']["usr_password2" . "_error"] = $msg;
            }

            // naam & voornaam is verplicht
            if (empty($_POST['usr_firstname'])) {
                $msg = 'Gelieve uw voornaam in te geven.';
                $_SESSION['errors']["usr_firstname" . "_error"] = $msg;
            }

            if (empty($_POST['usr_lastname'])) {
                $msg = 'Gelieve uw achternaam in te geven';
                $_SESSION['errors']["usr_lastname" . "_error"] = $msg;
            }
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
            if ( in_array( $field, [ 'table', 'pkey', 'afterinsert', 'afterupdate', 'csrf', 'usr_password2' ] ) ) continue;

            //handle primary key field
            if ( $field == $pkey )
            {
                if ( $update ) $where = " WHERE $pkey = $value ";
                continue;
            }

            //hash password
            if ( $field == 'usr_password') {
                $value = password_hash($value, PASSWORD_DEFAULT);
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
        $result = executeSQL( $sql );

        // if update is succesfull for update user table
        if ($result && $table == 'user') {
            $_SESSION['msgs']['success'] = "Bedankt, voor uw registratie.";
        }
        if (!$result) {
            $_SESSION['msgs']['danger'] = "Er is iets misgelopen met het registreren.";
            header( "Location: " . $sending_form_uri );
        }

        //output if not redirected
        print $sql ;
        print "<br>";
        print $result->rowCount() . " records affected";

        //redirect after insert or update
        if ( $insert AND $_POST["afterinsert"] > "" ) header("Location: ../" . $_POST["afterinsert"] );
        if ( $update AND $_POST["afterupdate"] > "" ) header("Location: ../" . $_POST["afterupdate"] );
    }
}