<?
/**
 * The base configuration of the Sunrise VC.
 */
$sr_db_type         = 'mysql';
$sr_db_host         = 'dev.maalaang.com';
$sr_db_name         = 'sunrise';
$sr_db_user         = 'sunrise';
$sr_db_password     = 'sunrisedb3533';
$sr_db_charset      = 'utf8';

/**
 * Sunrise VC home directory from the web server root.
 */
$sr_root        = '/workspace/husky/Sunrise';

/**
 * Channel server configuration.
 */
$sr_channel_server_key = 'sunrise/channel/';
$sr_channel_server_port = '8889';
$sr_channel_server_uri  = 'ws://dev.maalaang.com:' . $sr_channel_server_port .'/' . $sr_channel_server_key;
$sr_channel_server_uri_internal = 'ws://172.27.254.4:' . $sr_channel_server_port .'/' . $sr_channel_server_key;

$sr_channel_event_rest          = 'http://localhost' . $sr_root . '/d/channel/';

$sr_channel_local_installation  = true;
$sr_channel_run_script          = '/run/sunrise_channel_server.php';

/**
 * Regular expressions for validation.
 */
$sr_regex_name      = '/^[a-zA-Z]+$/';
$sr_regex_email     = '/^([0-9a-zA-Z_-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/';
$sr_regex_password  = '/^[a-zA-Z0-9]+$/';

/**
 * Logger configuration - Apache log4php
 */
$sr_channel_log_file = '/var/log/sunrise/sunrise-channel-blackhat.log';
$sr_channel_logger_config = array(
    'appenders' => array(
        'default' => array(
            'class' => 'LoggerAppenderRollingFile',
            'layout' => array(
                'class' => 'LoggerLayoutPattern',
                'params' => array(
                    'conversionPattern' => '%date %logger %-5level %location%newline%msg%newline%ex%newline',
                ),
            ),
            'params' => array(
                'file' => $sr_channel_log_file,
                'maxFileSize' => '1MB',
                'maxBackupIndex' => 5,
            ),
        ),
    ),
    'rootLogger' => array(
        'appenders' => array('default'),
    ),
);

?>
