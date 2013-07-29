#!/usr/bin/env php

<?php

/* This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://sam.zoy.org/wtfpl/COPYING for more details. */

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/../include/lib/SplClassLoader.php');
require_once(__DIR__ . '/../settings/config.php');

$classLoader = new SplClassLoader('Wrench', __DIR__ . '/../message');
$classLoader->register();

$server = new \Wrench\Server('ws://172.27.254.4:8889/sunrise/message/', array (
     'check_origin' => false,
));

$config = array();
$config['session_server'] = $sr_msg_session_server;
$config['session_api_open'] = $sr_msg_session_api_open;
$config['session_api_close'] = $sr_msg_session_api_close;
$config['session_api_join'] = $sr_msg_session_api_join;
$config['session_api_exit'] = $sr_msg_session_api_exit;

$server->registerApplication('sunrise/message/', new \Wrench\Application\SunriseSignalingApplication($config));
$server->run();

?>
