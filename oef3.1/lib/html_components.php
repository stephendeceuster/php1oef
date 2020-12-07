<?php
function printHead() {
    $head = file_get_contents("./templates/head.html");
    print $head;
}

function printJumbo() {
    $jumbo = file_get_contents("./templates/jumbo.html");
    print $jumbo;
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