<?php

require_once (dirname(__FILE__) . '/../models/session.php');

/**
 * Send response with the specified view and the context.
 * @param view  the path of the view
 * @param context   the context for the view
 */
function sr_response($view, $context) {
    require($view);
    exit(0);
}

/**
 * Send HTTP error.
 * @param error HTTP error code - 404, 500, etc
 */
function sr_response_error($error) {
    switch ($error) {
    case 400:
        header('HTTP/1.0 400 Bad Request');
        sr_response('views/errors/400.php', null);
    case 404:
        header('HTTP/1.0 404 Not Found');
        sr_response('views/errors/404.php', null);
    }
    exit(0);
}

/**
 * Return PDO object created based on the database configuations.
 * @return  PDO object
 */
function sr_pdo() {
    global $sr_db_type;
    global $sr_db_host;
    global $sr_db_name;
    global $sr_db_charset;
    global $sr_db_user;
    global $sr_db_password;

    $db = new PDO("$sr_db_type:host=$sr_db_host; dbname=$sr_db_name; charset=$sr_db_charset", $sr_db_user, $sr_db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $db;
}

function sr_current_url() {
    $url = 'http';

    if ($_SERVER["HTTPS"] == "on") {
        $url .= "s";
    }

    $url .= "://";

    if ($_SERVER["SERVER_PORT"] != "80") {
        $url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $url .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $url;
}

?>
