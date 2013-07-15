<?php

function sr_response($view, $context) {
    require($view);
}

function sr_response_error($error) {
    switch ($error) {
    case 404:
        header('HTTP/1.0 404 Not Found');
        sr_response('views/errors/404.php', null);
    }
}

?>
