<?php

require_once (dirname(__FILE__) . '/../controllers/room.php');
require_once (dirname(__FILE__) . '/../controllers/lobby.php');
require_once (dirname(__FILE__) . '/../controllers/message.php');
require_once (dirname(__FILE__) . '/../controllers/admin.php');
require_once (dirname(__FILE__) . '/../controllers/main.php');
require_once (dirname(__FILE__) . '/../controllers/sns.php');

/**
 * URL patterns and the associated controllers that are provided to the URL dispatcher.
 */
$url_patterns = array (
    "#^/$#" => main,
    "#^/main/$#" => main,
    "#^/main/signup/$#" => signup,
    "#^/main/signin/$#" => signin,
    "#^/main/signout/$#" => signout,
    "#^/room/$#" => room,
    "#^/room/open/$#" => room_open,
    "#^/room/join/$#" => room_join,
    "#^/room/exit/$#" => room_exit,
    "#^/room/close/$#" => room_close,
    "#^/room/init/$#" => room_init,
    "#^/admin/dashboard/$#" => dashboard,
    "#^/admin/sessions/$#" => sessions,
    "#^/admin/room/list/$#" => admin_room_list,
    "#^/lobby/$#" => lobby,
    "#^/message/demo/$#" => message_demo,
    "#^/sns/test/$#" => sns_test,
);

?>
