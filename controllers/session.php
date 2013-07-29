<?php

require_once (dirname(__FILE__) . '/../models/session.php');
require_once (dirname(__FILE__) . '/../models/participant.php');

/**
 * Open a new session.
 *
 * Method: POST
 *  name - the name of the session to open which should be unique
 *
 * @return result(integer) - 0 success, otherwise failed
 * @return name(string) - session name newly created (optional; when result is 0)
 * @return msg(string) - error message when failed (optional; when result is not 0)
 */
function session_open() {
    $result = array();

    // parameter check
    if (!isset($_POST['name']) || strlen($_POST['name']) < 1) {
        $result['result'] = 1;
        $result['msg'] = 'Invalid request';
        echo json_encode($result);
        return;
    }

    $db = sr_pdo();

    // create a session with the requested name
    $session = new Session();
    $session->name = $_POST['name'];
    $session->title = '';
    $session->description = '';
    $session->start_time = Model::getCurrentTime();
    $session->password = '';
    $session->is_open = 1;

    //$session->password = crypt('my password');

    try {
        $session->add($db);
        $result['result'] = 0;
        $result['name'] = $session->name;
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
 * A user joins to the session.
 */
function session_join() {
    $db = sr_pdo();

    $p = new Participant();
    $p->session_id = $_POST['session_id'];
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
 * A user exits from the session.
 */
function session_exit() {
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
 * Close the specified session.
 *
 * Method: POST
 *  name - the name of the session to close
 *
 * @return result(integer) - 0 success, otherwise failed
 * @return msg(string) - error message when failed (optional; when result is not 0)
 */
function session_close() {
    $db = sr_pdo();

    $session = new Session();
    $session->id = $_POST['session_id'];

    $result = array();

    try {
        $session->delete($db);

        $result['result'] = 0;
        echo json_encode($result);

    } catch (PDOException $e) {
        $result['result'] = 1;
        $result['msg'] = 'Server error.';
        echo json_encode($result);
    }
}

/**
 * Initialize database for session information.
 *
 * Method: POST
 *
 * @return result(integer) - 0 success, otherwise failed
 * @return msg(string) - error message when failed (optional; when result is not 0)
 */
function session_init() {
    $db = sr_pdo();

    $result = array();

    try {
        Session::delete_all($db);
        Participant::delete_all($db);

        $result['result'] = 0;
        echo json_encode($result);

    } catch (PDOException $e) {
        $result['result'] = 1;
        $result['msg'] = 'Server error. ' . $e->getMessage();
        echo json_encode($result);
    }
}


?>
