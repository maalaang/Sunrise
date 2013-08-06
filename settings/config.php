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
 * Message server configuration.
 */
$sr_msg_session_server          = 'http://localhost' . $sr_root;
$sr_msg_session_api_open        = '/d/session/open/';
$sr_msg_session_api_close       = '/d/session/close/';
$sr_msg_session_api_join        = '/d/session/join/';
$sr_msg_session_api_exit        = '/d/session/exit/';
$sr_msg_session_api_init        = '/d/session/init/';

/**
 * Regular expressions for validation.
 */
$sr_regex_name      = '/^[a-zA-Z]+$/';
$sr_regex_email     = '/^([0-9a-zA-Z_-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/';
$sr_regex_password  = '/^[a-zA-Z0-9]+$/';

?>
