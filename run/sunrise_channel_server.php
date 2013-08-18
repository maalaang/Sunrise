#!/usr/bin/env php

<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/../include/lib/SplClassLoader.php');
require_once(__DIR__ . '/../settings/config.php');

$classLoader = new SplClassLoader('Wrench', __DIR__ . '/../channel');
$classLoader->register();

$server = new \Wrench\Server('ws://172.27.254.4:8889/sunrise/channel/', array (
     'check_origin' => false,
));

$config = array();
$config['rest_server'] = $sr_channel_event_rest;

$server->registerApplication('sunrise/channel/', new \Wrench\Application\SunriseChannelServer($config));
$server->run();

?>
