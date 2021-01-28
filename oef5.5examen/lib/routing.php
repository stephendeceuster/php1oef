<?php

function GoToNoAccess()
{
    global $app_root;

    header("Location: " . $app_root . "/no_access.php");
    exit;
}

function GoHome($url = "steden.php")
{
    global $app_root;

    header("Location: " . $app_root . "/" . $url);
    exit;
}

