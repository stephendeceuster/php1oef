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