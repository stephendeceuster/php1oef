<?php

function PrintHead() {
    echo file_get_contents("./templates/head.html");
}

function PrintJumbo() {
    echo file_get_contents("./templates/jumbo.html");
}