#!/usr/bin/env php

<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/../include/lib/SplClassLoader.php');
require_once(__DIR__ . '/../include/lib/log4php/Logger.php');
require_once(__DIR__ . '/../settings/config.php');

Logger::configure($sr_channel_logger_config);
$logger = Logger::getLogger("channel");

$classLoader = new SplClassLoader('Wrench', __DIR__ . '/../channel');
$classLoader->register();

$server = new \Wrench\Server($sr_channel_server_uri_internal, array (
     'check_origin' => false,
     'logger' => $logger,
     'connection_manager_options' => array (
         'logger' => $logger,
     ),
));

$config = array();
$config['rest_server'] = $sr_channel_event_rest;
$config['logger'] = $logger;

$logger->info($sr_channel_event_rest);

$logger->info('Start channel server - ' . $sr_channel_server_uri);
$server->registerApplication($sr_channel_server_key, new \Wrench\Application\SunriseChannelServer($config));
$server->run();

?>
