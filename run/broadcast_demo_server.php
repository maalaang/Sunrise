#!/usr/bin/env php
<?php

/* This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://sam.zoy.org/wtfpl/COPYING for more details. */

ini_set('display_errors', 1);
error_reporting(E_ALL);

require(__DIR__ . '/../include/lib/SplClassLoader.php');

$classLoader = new SplClassLoader('Wrench', __DIR__ . '/../message');
$classLoader->register();

$server = new \Wrench\Server('ws://172.27.254.4:8890/', array(
     'check_origin'               => false,
));

$server->registerApplication('broadcast', new \Wrench\Application\SunriseMessageBroadcastDemoServer());
$server->run();
