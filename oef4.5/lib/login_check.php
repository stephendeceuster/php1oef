<?php
//error_reporting( E_ALL );
//ini_set( 'display_errors', 1 );

$public_access = true;

require_once "autoload.php";

$user = loginCheck();

if ($user) {
    $_SESSION['user'] = $user;
    $_SESSION['msgs']['success'] = "Welkom, " . $user['usr_firstname'] . " !";
    header("Location: ../steden.php");
} else {
    unset( $_SESSION['user'] );
    $msg = 'Inloggen is niet gelukt.';
    $_SESSION['msgs']['danger'] = $msg;
    header("Location: ../login.php");
}


function loginCheck() {
    if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {

        // data from form
        $usr_email = $_POST['usr_email'];
        $usr_password = $_POST['usr_password'];

        // controle CSRF token
        if ( ! key_exists("csrf", $_POST)) die("Missing CSRF");
        if ( ! hash_equals( $_POST['csrf'], $_SESSION['latest_csrf'] ) ) die("Problem with CSRF");

        $_SESSION['latest_csrf'] = "";

        //sanitization
        $_POST = stripSpaces($_POST);
        $_POST = convertSpecialChars($_POST);

        //validation
        $sending_form_uri = $_SERVER['HTTP_REFERER'];

        //terugkeren naar afzender als er een fout is
        if ( key_exists("errors" , $_SESSION ) AND count($_SESSION['errors']) > 0 ) {
            //$_SESSION['OLD_POST'] = $_POST;
            header( "Location: " . $sending_form_uri ); exit();
        }


        // search user in db

        $sql = "SELECT * FROM user WHERE usr_email = '" . $usr_email . "'";
        $user = getData($sql);
        if (count($user) > 0) {
            // check password
            $hash = $user[0]['usr_password'];
            if (password_verify($usr_password, $hash)) {
                return $user[0];
            }
        }
    }
    return null;
}
