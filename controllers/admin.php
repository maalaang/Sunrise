<?php

function dashboard() {
    sr_response('views/admin/dashboard.php', null);
}

function sessions() {
    sr_response('views/admin/sessions.php', null);
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
