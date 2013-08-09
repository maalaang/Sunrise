<?php

function dashboard() {
    sr_response('views/admin/dashboard.php', null);
}

function rooms() {
    sr_response('views/admin/rooms.php', null);
}

function users() {
    $db = sr_pdo();

    $stmt = $db->prepare('SELECT * FROM user');
    $stmt->execute();

    $user_list = $stmt->fetchAll(PDO::FETCH_CLASS, 'User');

    $context = array(
        'user_list' => $user_list
    );

    sr_response('views/admin/users.php', $context);
}

function settings() {
    sr_response('views/admin/settings.php', null);
}

/**
 * Display room list.
 */
function admin_room_list() {
    $db = sr_pdo();

    $stmt = $db->prepare('SELECT * FROM room');
    $stmt->execute();

    $room_list = $stmt->fetchAll(PDO::FETCH_CLASS, 'Room');

    $context = array(
        'room_list' => $room_list,
    );

    sr_response('views/admin/room/room_list.php', $context);
}

?>
