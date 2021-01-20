<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once ('./lib/autoload.php');

unset($_SESSION['user']);
//echo 'unset user';
session_destroy();
//echo 'session destroy';
session_regenerate_id('user');
//echo 'regenerate';
header("Location: ./login.php?logout=true");



