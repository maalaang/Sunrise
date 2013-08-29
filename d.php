<?php

require_once(dirname(__FILE__) . '/settings/urls.php');
require_once(dirname(__FILE__) . '/settings/config.php');
require_once(dirname(__FILE__) . '/include/utils.php');

$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : $_SERVER['REDIRECT_URL'];

session_start();

// find the matched url pattern and execute the function associated with it
foreach ($url_patterns as $pattern => $func) {
    if (preg_match($pattern, $path)) {
        $func();
        exit();
    }
}

// send a 404 not found error
sr_response_error(404);

?>
