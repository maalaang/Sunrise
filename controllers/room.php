<?php

require_once (dirname(__FILE__) . '/../models/room.php');
require_once (dirname(__FILE__) . '/../models/participant.php');
require_once (dirname(__FILE__) . '/../models/participant_log.php');
require_once (dirname(__FILE__) . '/../include/utils.php');

function room() {
    global $sr_root;
    global $sr_channel_server_uri;
    global $sr_room_ui_title;
    
    $db = sr_pdo();

    if (isset($_GET['name']) && strlen($_GET['name']) > 0) {
        try {
            $context = array();

            // check if the room with the specified name exists
            $stmt = $db->prepare('SELECT * FROM room WHERE name = :name');
            $stmt->bindParam(':name', $_GET['name']);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Room');
            $stmt->execute();

            $room = $stmt->fetch();

            if ($room === False) {
                // room doesn't exist. create a room using the requested name
                $room = new Room();
                $room->name = $_GET['name'];
                $room->title = '';
                $room->description = '';
                $room->password = '';
                $room->is_open = 1;

                $room->open($db);
            }

        } catch (PDOException $e) {
            sr_response_error(500);
        }

        $context['channel_server'] = $sr_channel_server_uri;
        $context['room'] = $room;
        $context['room_link'] = sr_current_url();
        $context['room_api'] = $sr_root;
        $context['room_ui_title'] = $sr_room_ui_title;

        if ($_SESSION['is_logged'] === true) {
            $context['user_id'] = $_SESSION['user_id'];
            $context['is_registered_user'] = 'true';
        } else {
            $context['user_id'] = 0;
            $context['is_registered_user'] = 'false';
        }

        $context['user_name'] = $_SESSION['user_name'];
        $context['chat_name'] = $_SESSION['chat_name'];

        sr_response('views/room/room.php', $context);

    } else {
        sr_response_error(400);
    }
}

/**
 * A participant joins to the room.
 */
function room_join() {
    $db = sr_pdo();

    $p = new Participant();
    $p->id = $_POST['participant_id'];
    $p->room_id = $_POST['room_id'];
    $p->is_registered_user = $_POST['is_registered_user'];
    $p->name = $_POST['user_name'];
    $p->user_id = $_POST['user_id'];
    $p->ip_address = $_SERVER['REMOTE_ADDR'];

    $result = array();

    try {
        $p->add($db);
        $result['result'] = 0;
        $result['participant_id'] = $p->id;
        echo json_encode($result);

        room_join_log($p);

    } catch (PDOException $e) {
        $result['result'] = 1;
        $result['msg'] = 'Server error. ' . $e->getMessage();
        echo json_encode($result);
    }

}

/**
 * Write a log that the participant joined the room.
 */
function room_join_log($participant) {
    $db = sr_pdo();

    $p_log = new ParticipantLog();
    $p_log->type = 1;
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
    }
}

/**
 * Save room title.
 */
function room_title_save() {
    $res = array();

    if ($_POST['id'] && isset($_POST['title'])) {
        $db = sr_pdo();
        if ($room = Room::get($db, $_POST['id'])) {
            $room->title = $_POST['title'];
            $room->save($db);
            $res['result'] = 0;

        } else {
            $res['result'] = 2;
            $res['msg'] = "Couldn't find the room";
        }
    } else {
        $res['result'] = 1;
        $res['msg'] = "Invalid request";
    }

    echo json_encode($res);
}

/**
 * Save room description.
 */
function room_description_save() {
    $res = array();

    if ($_POST['id'] && isset($_POST['description'])) {
        $db = sr_pdo();
        if ($room = Room::get($db, $_POST['id'])) {
            $room->description = $_POST['description'];
            $room->save($db);
            $res['result'] = 0;

        } else {
            $res['result'] = 2;
            $res['msg'] = "Couldn't find the room";
        }
    } else {
        $res['result'] = 1;
        $res['msg'] = "Invalid request";
    }

    echo json_encode($res);
}

?>
