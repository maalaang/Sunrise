<?php

require_once (dirname(__FILE__) . '/../models/room.php');
require_once (dirname(__FILE__) . '/../settings/config.php');
require_once ("Mail.php");
require_once ("Mail/mime.php");

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
    case 500:
        header('HTTP/1.0 500 Internal Server Error');
        sr_response('views/errors/500.php', null);
    }
    exit(0);
}

function sr_home_path() {
    global $sr_root;
    return $sr_root;
}

function sr_server_url() {
    $url = 'http';
    if ($_SERVER["HTTPS"] == "on") {
        $url .= "s";
    }
    $url .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"];
    } else {
        $url .= $_SERVER["SERVER_NAME"];
    }
    return $url;
}

function sr_home_url() {
    return sr_server_url() . sr_home_path();
}

function sr_current_url() {
    return sr_server_url() . $_SERVER["REQUEST_URI"];
}

function sr_redirect($path) {
    header('Location: ' . sr_home_path() . $path);
    exit(0);
}

function sr_is_signed_in() {
    if ($_SESSION['is_logged']) {
        return true;
    } else {
        return false;
    }
}

function sr_user_name() {
    if ($_SESSION['is_logged']) {
        return $_SESSION['user_name'];
    } else {
        return null;
    }
}

function sr_user_first_name() {
    if ($_SESSION['is_logged']) {
        return $_SESSION['user_first_name'];
    } else {
        return null;
    }
}

function sr_user_last_name() {
    if ($_SESSION['is_logged']) {
        return $_SESSION['user_last_name'];
    } else {
        return null;
    }
}

function sr_user_email() {
    if ($_SESSION['is_logged']) {
        return $_SESSION['user_email'];
    } else {
        return null;
    }
}

function sr_user_id() {
    if ($_SESSION['is_logged']) {
        return $_SESSION['user_id'];
    } else {
        return null;
    }
}

function sr_is_admin() {
    if ($_SESSION['is_admin']) {
        return true;
    } else {
        return false;
    }
}

function sr_is_authorized() {
    if ($_SESSION['is_authorized']) {
        return true;
    } else {
        return false;
    }
}

function sr_set_user_first_name($user_first_name) {
    $_SESSION['user_first_name'] = $user_first_name;
}

function sr_set_user_last_name($user_last_name) {
    $_SESSION['user_last_name'] = $user_last_name;
}

function sr_set_user_name($user_name) {
    $_SESSION['user_name'] = $user_name;
}

function sr_set_user_email($user_email) {
    $_SESSION['user_email'] = $user_email;
}

function sr_set_admin($is_admin) {
    $_SESSION['is_admin'] = $is_admin;
}

function sr_set_authorized($is_authorized) {
    $_SESSION['is_authorized'] = $is_authorized;
}

/**
 * Return PDO object created based on the database configuations.
 * @return  PDO object
 */
function sr_pdo() {
    global $sr_db_type;
    global $sr_db_host;
    global $sr_db_port;
    global $sr_db_name;
    global $sr_db_charset;
    global $sr_db_user;
    global $sr_db_password;

    $db = new PDO("$sr_db_type:host=$sr_db_host; port=$sr_db_port; dbname=$sr_db_name; charset=$sr_db_charset", $sr_db_user, $sr_db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $db;
}

/**
 * Return regular expression for validation.
 * @param type  the type of the form 
 * @return regular expression 
 */
function sr_regex($type) {
    switch ($type) {
    case 'name'     : return $GLOBALS['sr_regex_name'];
    case 'email'    : return $GLOBALS['sr_regex_email'];
    case 'password' : return $GLOBALS['sr_regex_password'];
    }
}

function sr_signin($user) {
    $_SESSION['is_logged'] = true;
    $_SESSION['user_email'] = $user->email;
    $_SESSION['user_name'] = $user->first_name . ' ' . $user->last_name;
    $_SESSION['user_first_name'] = $user->first_name;
    $_SESSION['user_last_name'] = $user->last_name;
    $_SESSION['user_id'] = $user->id;
    $_SESSION['is_admin'] = $user->is_admin;
    $_SESSION['is_authorized'] = $user->is_authorized;
}

function sr_signout() {
    unset($_SESSION['is_logged']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_first_name']);
    unset($_SESSION['user_last_name']);
    unset($_SESSION['user_id']);
    unset($_SESSION['is_admin']); 
    unset($_SESSION['is_authorized']);
    session_destroy();
}

function sr_facebook_app_id() {
    global $sr_facebook_app_id;
    return $sr_facebook_app_id;
}

function sr_logo() {
    global $sr_logo;
    return sr_home_path() . $sr_logo;
}

function sr_logo_lg() {
    global $sr_logo_lg;
    return sr_home_path() . $sr_logo_lg;
}

function sr_logo_url() {
    global $sr_logo;
    return sr_home_url() . $sr_logo();
}

function sr_logo_lg_url() {
    global $sr_logo_lg;
    return sr_home_url() . $sr_logo_lg;
}

function sr_send_mail($to, $content) {
    global $sr_email_addr;
    global $sr_email_smtp;

    $headers = array(
        'From' => $sr_email_addr,
        'To' => $to,
        'Subject' => $content['subject']
    );

    $mime = new Mail_mime("\n");
    $mime->setHTMLBody($content['body']);

    $smtp = Mail::factory('smtp', $sr_email_smtp);

    $mail = $smtp->send($to, $mime->headers($headers), $mime->get());

    if (PEAR::isError($mail)) {
        return $mail->getMessage();
    } else {
        return null;
    }
}
?>
