<?php
session_start();

function generateCSRF(string $formname = "noformname"):string {
    $csrf_key = bin2hex(random_bytes(32));
    $csrf = hash_hmac('sha256', 'PHP1CURSUS SECRET KEY'.$formname, $csrf_key);

    // store CSRF token in SESSION
    $SESSION['latest_csrf'] = $csrf;

    return $csrf;
}