<?php
function printHead($title = "Cityguide") {
    $head = file_get_contents("./templates/head.html");
    $head = str_replace("%title%", $title, $head);
    print $head;
}

function printJumbo($title = "Leuke plekken op de wereld", $tagline = "Tips voor citytrippers!") {
    //get template
    $jumbo = file_get_contents("./templates/jumbo.html");
    $jumbo = str_replace("%jumboTitle%", "$title", $jumbo);
    $jumbo = str_replace("%jumboTagline%", "$tagline", $jumbo);
    print $jumbo;
}

function printAlert($msgs) {
    $alert = file_get_contents("./templates/alert.html");
    $alert = str_replace("%msgs%", "$msgs", $alert);
    print $alert;
}

function printFooter() {
    $footer = file_get_contents('./templates/footer.html');
    print $footer;
}

function printNavbar() {
    $navbar = file_get_contents("./templates/navbar.html");
    print $navbar;
}

function mergeDataTemplate($data, $template) {
    $returnValue = "";

    foreach ($data as $row) {
        $output = $template;
        foreach (array_keys($row) as $field) {
            $output = str_replace("%$field%", $row["$field"], $output);
        }
        $returnValue .= $output;
    }
    return $returnValue;
}

function makeSelect($fkey, $value, $sql) {
    $select = '<select id="' . $fkey . '" name="' . $fkey . '" value="' . $value . '">';
    $select .= '<option value="0"></option>';

    $data = getData($sql);

    foreach ( $data as $row ) {
        if ($row[0] == $value) {
            $selected = 'selected';
        } else {
            $selected = '';
        }
        $select .= '<option ' . $selected . ' value="' . $row[0] . '>' . $row[1] . '"</option>';
    }
    $select .= '</select>';
    return $select;
}

function mergeExtraElementsTemplate($elements, $template) {
    foreach ($elements as $key => $element) {
        $template = str_replace("%$key%", $element, $template);
    }
    return $template;
}

function mergeErrorsTemplate($errors, $template) {
    foreach ( $errors as $key => $error) {
        $template = str_replace("%$key%", "<p style='color:#ff0000'>$error</p>", $template);
    }
    return $template;
}

function removeEmptyErrors( $data, $template ) {
    foreach ( $data as $row ) {
        foreach( array_keys($row) as $field ) {  //eerst "img_id", dan "img_title", ...
            $template = str_replace( "%$field" . "_error%", "", $template );
        }
    }
    return $template;
}