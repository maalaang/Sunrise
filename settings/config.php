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
$sr_root        = '/workspace/whale/Sunrise';


/**
 * Message server configuration.
 */
$sr_rest_server                 = 'http://localhost' . $sr_root;
$sr_rest_room_open              = '/d/room/open/';
$sr_rest_room_close             = '/d/room/close/';
$sr_rest_room_join              = '/d/room/join/';
$sr_rest_room_exit              = '/d/room/exit/';
$sr_rest_room_init              = '/d/room/init/';

/**
 * Regular expressions for validation.
 */
$sr_regex_name      = '/^[a-zA-Z]+$/';
$sr_regex_email     = '/^([0-9a-zA-Z_-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/';
$sr_regex_password  = '/^[a-zA-Z0-9]+$/';

?>
