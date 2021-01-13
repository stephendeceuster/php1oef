<?php

require_once 'autoload.php';

function stripSpaces( array $arr ) : array {
    foreach ($arr as $key => $value) {
        $arr[$key] = trim($value);
    }
    return $arr;
}

function convertSpecialChars( array $arr ) : array {
    foreach ($arr as $key => $value) {
        $arr[$key] = htmlspecialchars($value, ENT_QUOTES);
    }
    return $arr;
}