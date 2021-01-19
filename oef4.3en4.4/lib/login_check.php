<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once "autoload.php";

if (loginCheck() ){
    $sql = "SELECT * FROM user WHERE usr_email = '" . $_POST['usr_email'] . "'";
    $user = getData($sql);
    $_SESSION['user'] = $user[0];
    $_SESSION['msgs']['success'] = "Welkom, " . $user[0]['usr_firstname'] . " !";
    header("Location: ./../steden.php");

} else {
    unset($_SESSION['user']);
    header("Location: ./../no_access.php");
}

function loginCheck()
{
    if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
        $usr_email = $_POST['usr_email'];
        $usr_password = $_POST['usr_password'];

        // controle CSRF token
        if ( ! key_exists("csrf", $_POST)) die("Missing CSRF");
        if ( ! hash_equals( $_POST['csrf'], $_SESSION['latest_csrf'] ) ) die("Problem with CSRF");

        $_SESSION['latest_csrf'] = "";

        // check if usr_email is already in DB
        $sql = "SELECT * FROM user WHERE usr_email = '" . $usr_email . "'";
        $user = getData($sql);
        if (count($user) === 0) {
            return false;
        }

        // check password
        $hash = $user[0]['usr_password'];
        if (password_verify($usr_password, $hash)) {
            return true;
        } else {
            return false;
        }
    }
}