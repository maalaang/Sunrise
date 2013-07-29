<?php

require_once (dirname(__FILE__) . '/../controllers/session.php');
require_once (dirname(__FILE__) . '/../controllers/room.php');
require_once (dirname(__FILE__) . '/../controllers/lobby.php');
require_once (dirname(__FILE__) . '/../controllers/message.php');
require_once (dirname(__FILE__) . '/../controllers/admin.php');

/**
 * URL patterns and the associated controllers that are provided to the URL dispatcher.
 */
$url_patterns = array (
    "#^/$#" => room,
    "#^/room/$#" => room,
    "#^/room/join/$#" => room_join,
    "#^/lobby/$#" => lobby,
    "#^/message/demo/$#" => message_demo,
    "#^/session/open/$#" => session_open,
    "#^/session/close/$#" => session_close,
    "#^/session/join/$#" => session_join,
    "#^/session/exit/$#" => session_exit,
    "#^/session/init/$#" => session_init,
    "#^/admin/session/list/$#" => admin_session_list,

);

?>
