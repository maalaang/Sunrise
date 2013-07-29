<?php

require_once (dirname(__FILE__) . '/../models/session.php');
require_once (dirname(__FILE__) . '/../models/participant.php');
require_once (dirname(__FILE__) . '/../include/utils.php');

function room() {
    $db = sr_pdo();

    if (isset($_GET['name']) && strlen($_GET['name']) > 0) {
        try {
            $context = array();

            // check if the session with the specified name exists
            $stmt = $db->prepare('SELECT * FROM session WHERE name = :name');
            $stmt->bindParam(':name', $_GET['name']);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Session');
            $stmt->execute();

            $session = $stmt->fetch();

            $context['initiator'] = 1;

            if ($session === False) {
                // session doesn't exist. create a session using the requested name
                $session = new Session();
                $session->name = $_GET['name'];
                $session->title = '';
                $session->description = '';
                $session->start_time = Model::getCurrentTime();
                $session->password = '';
                $session->is_open = 1;

                $session->open_session($db);

                $context['initiator'] = 0;
            }

            /* 
             * TODO
             * This should be updated after user session logic is implemented.
             */
            $p = new Participant();
            $p->session_id = $session->id;
            $p->is_registered_user = 0;
            $p->name = 'anonymous';
            $p->user_id = null;
            $p->ip_address = $_SERVER['REMOTE_ADDR'];

            $p->join_session($db);

        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                // the name of the room is in use.
                sr_response('views/lobby/main.php', null);
            } else {
                // other database exception
                sr_response('views/lobby/main.php', null);
            }
        }

        $context['session'] = $session;
        $context['participant'] = $p;
        $context['room_link'] = sr_current_url();

        sr_response('views/room/room.php', $context);

    } else {
        sr_response_error(400);
    }
}

?>
