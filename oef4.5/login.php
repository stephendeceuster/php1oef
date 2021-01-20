<?php
//error_reporting( E_ALL );
//ini_set( 'display_errors', 1 );
$public_access = true;

require_once ('./lib/autoload.php');

// INSERT HEAD & JUMBO
printHead("Login");
printJumbo("Login", "");
printNavbar();

if (key_exists("logout",$_GET) && $_GET['logout'] == true) {
    $msg = 'U bent uitgelogd.';
    printAlert($msg);
}

?>

<div class="container">
    <div class="row">

<?php
// get data
$data = [0 => ["usr_email" => "", "usr_password" => ""]];
// add CSRF token to data
$extra_elements['csrf_token'] = generateCSRF('loginform');

// get template
$html = file_get_contents('./templates/login.html');

// merge data & template
$html = mergeDataTemplate($data, $html);
$html = mergeExtraElementsTemplate($extra_elements, $html);

echo $html;
?>

    </div> <!-- end .row -->
</div> <!-- end .container -->

<?php
printFooter();
?>