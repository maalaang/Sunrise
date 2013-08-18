<?php

require_once (dirname(__FILE__) . '/../controllers/room.php');
require_once (dirname(__FILE__) . '/../controllers/message.php');
require_once (dirname(__FILE__) . '/../controllers/admin.php');
require_once (dirname(__FILE__) . '/../controllers/main.php');
require_once (dirname(__FILE__) . '/../controllers/sns.php');
require_once (dirname(__FILE__) . '/../controllers/channel.php');

/**
 * URL patterns and the associated controllers that are provided to the URL dispatcher.
 */
$url_patterns = array (
    "#^/$#" => main,
    "#^/main/$#" => main,
    "#^/main/signup/$#" => signup,
    "#^/main/signin/$#" => signin,
    "#^/main/signout/$#" => signout,
    "#^/main/room/$#" => goto_room,
    "#^/room/$#" => room,
    "#^/room/join/$#" => room_join,
    "#^/channel/$#" => channel_event,
    "#^/admin/dashboard/$#" => dashboard,
    "#^/admin/rooms/$#" => rooms,
    "#^/admin/users/$#" => users,
    "#^/admin/settings/$#" => settings,
    "#^/admin/room/list/$#" => admin_room_list,
    "#^/message/demo/$#" => message_demo,
    "#^/sns/test/$#" => sns_test,
);

?>
