<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once ('./lib/autoload.php');
//echo '<br>var dump session error <br>';
//var_dump($_SESSION['errors']);
//echo '<br>var dump errors <br>';
//var_dump($errors);
//echo '<br>var dump session post <br>';
//var_dump($_SESSION['post']);
//$_SESSION['postpost'] = null;
//echo '<br>var dump session post after empty <br>';
//var_dump($_SESSION['postpost']);
//var_dump($old_post);

// INSERT HEAD & JUMBO
printHead("Registreer");
printJumbo("Registreer je hier!", "");
printNavbar();

?>

<div class="container">
    <div class="row">

<?php
// Insert register form
// get data
// SQL $userdata = "SELECT * FROM images JOIN countries ON cou_id = img_cou_id WHERE img_id =" . $img_id;
// $data = getData($cityForm);
if (isset($old_post)) {
    $data = [0 => $old_post];
} else {
    $data = [0 => ['usr_firstname' => '', 'usr_lastname' => '', 'usr_email' => '', 'usr_password' => '']];
}
// add CSRF token to data
$extra_elements['csrf_token'] = generateCSRF('registerform');
//var_dump($extra_elements['csrf_token']);
//var_dump($_SESSION['latest_csrf']);
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