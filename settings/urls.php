<?php

require_once (dirname(__FILE__) . '/../controllers/session.php');
require_once (dirname(__FILE__) . '/../controllers/room.php');
require_once (dirname(__FILE__) . '/../controllers/message.php');

$url_patterns = array (
    "#^/$#" => room,
    "#^/room/$#" => room,
    "#^/message/demo/$#" => message_demo,
    "#^/session/open/$#" => session_open,
    "#^/session/close/$#" => session_close,

);
?>
