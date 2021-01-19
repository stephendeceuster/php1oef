<?php
//error_reporting( E_ALL );
//ini_set( 'display_errors', 1 );
$public_access = true;
require_once ('./lib/autoload.php');

if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
}

// INSERT HEAD & JUMBO
printHead("Acces denied");
printJumbo("Geen toegang", "");
printNavbar();

?>

<div class="container">
    <div class="alert alert-warning" role="alert">
        U bent niet ingelogd. <a href="login.php">Probeer in te loggen</a>
    </div>
</div> <!-- end .container -->

<?php
printFooter();
?>