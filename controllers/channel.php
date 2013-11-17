<?php
require_once (dirname(__FILE__) . '/../models/room.php');
require_once (dirname(__FILE__) . '/../models/room_log.php');
require_once (dirname(__FILE__) . '/../models/participant.php');
require_once (dirname(__FILE__) . '/../models/participant_log.php');
require_once (dirname(__FILE__) . '/../include/utils.php');

function channel_event() {
    switch ($_POST['type']) {
    case 'server_start':
        channel_server_start();
        break;
    case 'client_disconnected':
        channel_client_disconnected();
        break;
    case 'channel_destroyed':
        channel_destroyed();
        break;
    }
}

function channel_server_start() {
    $db = sr_pdo();

    $result = array();

    try {
        $room_list = Room::fetchAll();
        foreach ($room_list as $room) {
            channel_destroyed_log($room);
        }

        $participant_list = Participant::fetchAll();
        foreach ($participant_list as $p) {
            channel_client_disconnected_log($p);
        }

        Room::delete_all($db);
        Participant::delete_all($db);

        $result['result'] = 0;
        echo json_encode($result);

    } catch (PDOException $e) {
        $result['result'] = 1;
        $result['msg'] = 'Server error. ' . $e->getMessage();
        echo json_encode($result);
    }
}

function channel_client_disconnected() {
    $db = sr_pdo();

    $result = array();

    try {
        $stmt = $db->prepare('SELECT * FROM participant WHERE id = :id');
        $stmt->bindParam(':id', $_POST['client_id']);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Participant');
        $stmt->execute();

        $p = $stmt->fetch();

        if ($p) {
            channel_client_disconnected_log($p);
            $p->delete($db);

            $result['result'] = 0;
            echo json_encode($result);
        }

    } catch (PDOException $e) {
        $result['result'] = 1;
        $result['msg'] = 'Server error.';
        echo json_encode($result);
    }
}

function channel_client_disconnected_log($participant) {
    $db = sr_pdo();

    $p_log = new ParticipantLog();
    $p_log->type = 2;
    $p_log->room_id = $participant->room_id;
    $p_log->participant_name = $participant->name;
    $p_log->user_id = $participant->user_id;
    $p_log->is_registered_user = $participant->is_registered_user;
    $p_log->ip_address = $participant->ip_address;
    $p_log->time = $p_log->getCurrentTime();

    try {
        $p_log->add($db);
    } catch (PDOException $e) {
        // failed to write the log
        echo $e;
    }
}

function channel_destroyed() {
    $db = sr_pdo();

    $result = array();

    try {
        $stmt = $db->prepare('SELECT * FROM room WHERE channel_token = :channel_token');
        $stmt->bindParam(':channel_token', $_POST['channel_token']);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Room');
        $stmt->execute();

        $r = $stmt->fetch();

        if ($r) {
            channel_destroyed_log($r);
            $r->delete($db);

            $result['result'] = 0;
            echo json_encode($result);
        }

    } catch (PDOException $e) {
        $result['result'] = 1;
        $result['msg'] = 'Server error.';
        echo json_encode($result);
    }
}

function channel_destroyed_log($room) {
    $db = sr_pdo();

    $r_log = new RoomLog();
    $r_log->room_id = $room->id;
    $r_log->name = $room->name;
    $r_log->title = $room->title;
    $r_log->description = $room->description;
    $r_log->is_open = $room->is_open;
    $r_log->start_time = $room->start_time;
    $r_log->end_time = $r_log->getCurrentTime();

    try {
        $r_log->add($db);
    } catch (PDOException $e) {
        // failed to write the log
        echo $e;
    }
}

?>
