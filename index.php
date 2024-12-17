<?php

error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('log_errors', TRUE);
ini_set('error_log', dirname(__FILE__) . '/php_error.log');
set_time_limit(0);

define('__ROOT__', dirname(__FILE__));

require(__ROOT__ . '/classes.php');
require(__ROOT__ . '/app.php');
require(__ROOT__ . '/functions.php');

//--------------------------------------------------------------------------------------------------------
//start the stuff
$user_ip = '127.0.0.1';
if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} elseif (isset($_SERVER['REMOTE_ADDR'])) {
    $user_ip = $_SERVER['REMOTE_ADDR'];
}

if (!empty($config['restrict_ip']) && !Utils::checkIp($user_ip, $config['restrict_ip'])) {
    echo 'LIVE:' . $ip_addr;
    die();
}

if (!extension_loaded('mongodb')) {
    echo 'MongoDB extension not loaded';
    die();
}
$config = require(__ROOT__ . '/config.php');

$rock = new R($config);
$rock->start();
