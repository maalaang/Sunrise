<?php

require_once (dirname(__FILE__) . '/../models/room.php');
require_once (dirname(__FILE__) . '/../models/participant.php');
require_once (dirname(__FILE__) . '/../models/participant_log.php');
require_once (dirname(__FILE__) . '/../include/utils.php');

function room() {
    global $sr_root;
    global $sr_channel_server_uri;
    global $sr_room_ui_title;
    global $sr_join_anonymous;
    global $sr_join_non_authorized;
    
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

        //IF he is registered user
        if (sr_is_signed_in()) {
            //IF server allow non-authorized user to join
            if ($sr_join_non_authorized) {
                $context['user_id'] = $_SESSION['user_id'];
                $context['is_registered_user'] = 'true';
            //IF server allow only authorized user to join
            } else {
                //IF he is authorized user
                if (sr_is_authorized()) {
                    $context['user_id'] = $_SESSION['user_id'];
                    $context['is_registered_user'] = 'true';
                //IF he is non-authorized user
                } else {
                    sr_redirect('/d/room/message/auth/');
                }
            }
        //IF he is anonymous user
        } else {
            //IF server allow anonymous user to join
            if ($sr_join_anonymous) {
                $context['user_id'] = 0;
                $context['is_registered_user'] = 'false';
            //IF server not allow anonymous user to join
            } else {
                $_SESSION['next_page'] = 1;
                $_SESSION['room_name'] = $_GET['name'];
                $context['info'] = 'Only registered users can join the room.';
                sr_response('views/main/signin.php', $context);
            }
        }

        $context['user_name'] = $_SESSION['user_name'];
        $context['chat_name'] = $_SESSION['chat_name'];

        if ($_SESSION['chat_name']) {
            $context['chat_name'] = $_SESSION['chat_name'];
        } else if ($_SESSION['user_name']) {
            $context['chat_name'] = $_SESSION['user_name'];
        } else {
            $context['chat_name'] = 'Anonymous';
        }

        if ($room->is_open == 1) {
            sr_response('views/room/room.php', $context);
        //IF locked room
        } else {
            if (isset($_SESSION['is_checked_password']) && $_SESSION['is_checked_password'] == $_SESSION['room_name']) {
                unset($_SESSION['is_checked_password']);
                unset($_SESSION['room_name']);
                sr_response('views/room/room.php', $context);
            } else {
                $_SESSION['room_name'] = $_GET['name'];
                sr_redirect('/d/room/message/pswd/');
            }
        }

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

/**
 * Save room open status, public or private, and the password.
 */
function room_open_status_save() {
    $res = array();

    if ($_POST['id'] && ($_POST['open'] == 'true' || $_POST['open'] == 'false') && isset($_POST['password'])) {
        $db = sr_pdo();
        if ($room = Room::get($db, $_POST['id'])) {
            $room->is_open = $_POST['open'] == 'true' ? 1 : 0;
            $room->password = $_POST['password'];
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
 * Show message page for non-authorized user.
 */
function room_message_auth() {
    global $sr_admin_email;
    $context = array();

    $context['type'] = 1;
    $context['msg']  = '<h2>Sorry,</h2>
                        Only authorized users are allowed to join the room.<br/>
                        Please contact the <a href="mailto:' . $sr_admin_email . '">administrator.</a>';

    sr_response('views/room/message.php', $context);
}

/**
 * Show page for input password.
 */
function room_message_pswd() {
    // Show input password page
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $context = array();
    
        $context['type'] = 2; 
        $context['msg']  = '<h2>Password required</h2>
                            Please enter the password to get into the private room.';
    
        sr_response('views/room/message.php', $context);
        
    // Ajax password check
    } else {
        try {
            $db = sr_pdo();

            $result = array();

            $stmt = $db->prepare('SELECT * FROM room WHERE name = :name');
            $stmt->bindParam(':name', $_SESSION['room_name']);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Room');
            $stmt->execute();

            $room = $stmt->fetch();

            if ($room->password == $_POST['input_password']) {
                $_SESSION['is_checked_password'] = $_SESSION['room_name'];
                $result['result'] = 1;
            } else {
                $result['result'] = 0;
            }

            echo json_encode($result);

        } catch (PDOException $e) {

        }
    }
}

/**
 * Send chat invitation emails.
 */

function room_invite_email() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $result['result'] = 0;
        echo json_encode($result);

    } else {
        sr_response_error(404);
    }
}

?>
