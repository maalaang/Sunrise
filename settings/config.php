<?
/**
 * The base configuration of the Sunrise VC.
 */
$sr_db_type         = '';
$sr_db_host         = '';
$sr_db_name         = '';
$sr_db_user         = '';
$sr_db_password     = '';
$sr_db_charset      = '';

/**
 * Sunrise VC home directory from the web server root.
 */
$sr_root        = '';

$sr_room_ui_title   = 'Sunrise - Video Conference Room';

$sr_logo = "/img/sunrise-logo.png";
$sr_logo_lg = "/img/sunrise-logo-lg.png";

$sr_admin_name = 'Sunrise Administrator';
$sr_admin_email = '';

$sr_email_addr = '';
$sr_email_smtp = array(
    'host' => '',
    'port' => '',
    'auth' => true,
    'username' => '',
    'password' => ''
);

/**
 * User authorization configuration
 */
$sr_default_authority   = 1;
$sr_join_anonymous      = 1;
$sr_join_non_authorized = 1;

/**
 * Channel server configuration.
 */
$sr_channel_server_key = 'sunrise/channel/';
$sr_channel_server_ip = '';
$sr_channel_server_port = '';
$sr_channel_server_uri  = 'ws://dev.maalaang.com:' . $sr_channel_server_port .'/' . $sr_channel_server_key;
$sr_channel_server_uri_internal = 'ws://' . $sr_channel_server_ip . ':' . $sr_channel_server_port .'/' . $sr_channel_server_key;

$sr_channel_event_rest          = 'http://' . $sr_channel_server_ip . $sr_root . '/d/channel/';

$sr_channel_local_installation  = true;
$sr_channel_run_script          = '/run/sunrise_channel_server.php';

$sr_default_chat_name = 'Anonymous';

/**
 * Facebook configuration.
 */
$sr_facebook_app_id = '';

/**
 * Regular expressions for validation.
 */
$sr_regex_name      = '/^[a-zA-Z]+$/';
$sr_regex_email     = '/^([0-9a-zA-Z_-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/';
$sr_regex_password  = '/^[a-zA-Z0-9]+$/';

/**
 * Logger configuration - Apache log4php
 */
$sr_channel_log_file = '/var/log/sunrise/sunrise-channel.log';
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

/**
 * Content settings.
 */
$sr_main_content = array(
    'title' => 'Sunrise Video Conference',
    'description' => 'Sunrise is an open video conference solution based on <a href="http://www.webrtc.org" target="_blank">HTML5 WebRTC</a>.
                You can use this software for online meeting at your company or for talking to your friends.
                Moreover, you may provide more enhanced customer service using video chat.
                Enjoy the next generation of the Web with Sunrise VC.
                It is an open source sofrware licensed under <a href="http://www.apache.org/licenses/LICENSE-2.0.html" target="_blank">Apache License, Version 2.0</a>.',
    'info1' => '<div class="content-image" style="margin-top:10px;">
                    <img src="' . $sr_root . '/img/example/webrtc_logo.png" width="300px"/>
                </div>
                <div class="content-desc">
                    Sunrise VC is built based on <a href="http://www.webrtc.org" target="_blank">WebRTC</a>. WebRTC is an open project that enables web browsers with Real-Time Communication capabilities.
                </div>',
    'info2' => '<div class="content-image" style="margin-top:35px; margin-bottom:35px;">
                    <img src="' . $sr_root . '/img/example/chrome_firefox.png" width="220px"/>
                </div>
                <div class="content-desc">
                    Sunrise VC works on latest <a href="http://chrome.google.com" target="_blank">Chrome</a> and <a href="http://www.mozilla.org/en-US/firefox" target="_blank">Firefox</a>. Download and install or upgrade either <a href="http://chrome.google.com" target="_blank">Chrome</a> or <a href="http://www.mozilla.org/en-US/firefox" target="_blank">Firefox</a> to have video chat on Sunrise VC.
                </div>
                ',
    'info3' => '<div class="content-image">
                    <img src="' . $sr_root . '/img/example/maalaang.png" width="200px"/>
                </div>
                <div class="content-desc">
                    NGC Group in <a href="https://www.facebook.com/maalaang" target="_blank">Maalaang Labs</a> started the project and manages it on <a href="https://github.com/maalaang/Sunrise" target="_blank">GitHub</a>. Check <a href="http://maalaang.com/video/1/" target="_blank">this video</a> out to know more about Maalaang Labs.
                </div>
                    ',

);

?>
