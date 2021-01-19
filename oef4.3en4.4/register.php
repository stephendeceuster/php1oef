<?php
//error_reporting( E_ALL );
//ini_set( 'display_errors', 1 );
$public_access = true;

require_once ('./lib/autoload.php');

// INSERT HEAD & JUMBO
printHead("Registreer");
printJumbo("Registreer je hier!", "");
printNavbar();

?>

<div class="container">
    <div class="row">

<?php
// get data
if (isset($old_post)) {
    $data = [0 => ['usr_firstname' => $old_post['usr_firstname'], 'usr_lastname' => $old_post['usr_lastname'], 'usr_email' => $old_post['usr_email'], 'usr_password' => $old_post['usr_password'], 'usr_password2' => $old_post['usr_password2']]];
} else {
    $data = [0 => ['usr_firstname' => '', 'usr_lastname' => '', 'usr_email' => '', 'usr_password' => '', 'usr_password2'=>'']];
}
// add CSRF token to data
$extra_elements['csrf_token'] = generateCSRF('registerform');

// get template
$html = file_get_contents('./templates/register.html');

// merge data & template
$html = mergeDataTemplate($data, $html);
$html = mergeExtraElementsTemplate($extra_elements, $html);
$html = mergeErrorsTemplate($errors, $html);
$html = removeEmptyErrors( $data, $html );
echo $html;
?>

    </div> <!-- end .row -->
</div> <!-- end .container -->

<?php
printFooter();
?>