<?php

require_once (dirname(__FILE__) . '/../models/room.php');
require_once (dirname(__FILE__) . '/../models/participant.php');
require_once (dirname(__FILE__) . '/../include/utils.php');

function room() {
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

            $context['initiator'] = 1;

            if ($room === False) {
                // room doesn't exist. create a room using the requested name
                $room = new Room();
                $room->name = $_GET['name'];
                $room->title = '';
                $room->description = '';
                $room->password = '';
                $room->is_open = 1;

                $room->open($db);

                $context['initiator'] = 0;
            }

            /* 
             * TODO
             * This should be updated after user room logic is implemented.
             */
            $p = new Participant();
            $p->room_id = $room->id;
            $p->is_registered_user = 0;
            $p->name = 'anonymous';
            $p->user_id = null;
            $p->ip_address = $_SERVER['REMOTE_ADDR'];

            $p->joinRoom($db);

        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                // the name of the room is in use.
                sr_response('views/lobby/main.php', null);
            } else {
                // other database exception
                sr_response('views/lobby/main.php', null);
            }
        }

        $context['room'] = $room;
        $context['participant'] = $p;
        $context['room_link'] = sr_current_url();

        sr_response('views/room/room.php', $context);

    } else {
        sr_response_error(400);
    }
}

/**
 * Open a new room.
 *
 * Method: POST
 *  name - the name of the room to open which should be unique
 *
 * @return result(integer) - 0 success, otherwise failed
 * @return name(string) - room name newly created (optional; when result is 0)
 * @return msg(string) - error message when failed (optional; when result is not 0)
 */
function room_open() {
    $result = array();

    // parameter check
    if (!isset($_POST['name']) || strlen($_POST['name']) < 1) {
        $result['result'] = 1;
        $result['msg'] = 'Invalid request';
        echo json_encode($result);
        return;
    }

    $db = sr_pdo();

    // create a room with the requested name
    $room = new Room();
    $room->name = $_POST['name'];
    $room->title = '';
    $room->description = '';
    $room->password = '';
    $room->is_open = 1;

    //$room->password = crypt('my password');

    try {
        $room->add($db);
        $result['result'] = 0;
        $result['name'] = $room->name;
        echo json_encode($result);

    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            $result['result'] = 2;
            $result['msg'] = 'The name of the room is in use. Try again with another room name';
        } else {
            $result['result'] = 3;
            $result['msg'] = 'Server error. Please try again.';
        }
        echo json_encode($result);
    }
}

/**
 * A user joins to the room.
 */
function room_join() {
    $db = sr_pdo();

    $p = new Participant();
    $p->room_id = $_POST['room_id'];
    $p->is_registered_user = $_POST['is_registered_user'];
    $p->name = $_POST['user_name'];
    $p->user_id = $_POST['user_id'];
    $p->ip_address = $_POST['ip_address'];

    $result = array();

    try {
        $p->add($db);
        $result['result'] = 0;
        $result['participant_id'] = $p->id;
        echo json_encode($result);

    } catch (PDOException $e) {
        $result['result'] = 1;
        $result['msg'] = 'Server error. ' . $e->getMessage();
        echo json_encode($result);
    }

}

/**
 * A user exits from the room.
 */
function room_exit() {
    $db = sr_pdo();

    $p = new Participant();
    $p->id = $_POST['participant_id'];

    $result = array();

    try {
        $p->delete($db);

        $result['result'] = 0;
        echo json_encode($result);

    } catch (PDOException $e) {
        $result['result'] = 1;
        $result['msg'] = 'Server error.';
        echo json_encode($result);
    }
}

/**
 * Close the specified room.
 *
 * Method: POST
 *  name - the name of the room to close
 *
 * @return result(integer) - 0 success, otherwise failed
 * @return msg(string) - error message when failed (optional; when result is not 0)
 */
function room_close() {
    $db = sr_pdo();

    $room = new Room();
    $room->id = $_POST['room_id'];

    $result = array();

    try {
        $room->delete($db);

        $result['result'] = 0;
        echo json_encode($result);

    } catch (PDOException $e) {
        $result['result'] = 1;
        $result['msg'] = 'Server error.';
        echo json_encode($result);
    }
}

/**
 * Initialize database for room information.
 *
 * Method: POST
 *
 * @return result(integer) - 0 success, otherwise failed
 * @return msg(string) - error message when failed (optional; when result is not 0)
 */
function room_init() {
    $db = sr_pdo();

    $result = array();

    try {
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

function room_temp() {
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

            /* 
             * TODO
             * This should be updated after user room logic is implemented.
             */
//            $p = new Participant();
//            $p->room_id = $room->id;
//            $p->is_registered_user = 0;
//            $p->name = 'anonymous';
//            $p->user_id = null;
//            $p->ip_address = $_SERVER['REMOTE_ADDR'];

//            $p->joinRoom($db);

        } catch (PDOException $e) {
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            echo $e;
            if ($e->errorInfo[1] == 1062) {
                // the name of the room is in use.
//                sr_response('views/lobby/main.php', null);
            } else {
                // other database exception
//                sr_response('views/lobby/main.php', null);
            }
        }

        $context['room'] = $room;
//        $context['participant'] = $p;
        $context['room_link'] = sr_current_url();
        $context['user_name'] = 'Anonymous';

        sr_response('views/room/room_temp.php', $context);

    } else {
        sr_response_error(400);
    }
}

?>
