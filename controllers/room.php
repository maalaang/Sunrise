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
    global $sr_default_chat_name;
    
    $db = sr_pdo();
    $browser = room_get_browser();

    if ($browser['name'] != 'Mozilla Firefox' && $browser['name'] != 'Google Chrome') {
        sr_redirect('/d/room/message/browser/');
    }

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
                // Room doesn't exist. Create a room using the requested name
                $room = new Room();
                $room->name = $_GET['name'];
                $room->title = '';
                $room->description = '';
                $room->password = '';
                $room->is_open = 1;

                $room->open($db);
            } else {
                $room->title = stripslashes($room->title);
                $room->description = stripslashes($room->description);
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
            $_SESSION['chat_name'] = $_SESSION['user_name'];
        } else {
            $context['chat_name'] = $sr_default_chat_name;
            $_SESSION['chat_name'] = $sr_default_chat_name;
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
    if ($_POST['is_registered_user'] == 'true') {
        $p->is_registered_user = 1;
    } else {
        $p->is_registered_user = 0;
    }
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
 * Save user's chat name.
 */
function room_chat_name_save() {
    $res = array();

    if ($_POST['id'] && isset($_POST['chat_name'])) {
        if (strlen($_POST['chat_name']) > 1) {
            $db = sr_pdo();
            if ($room = Participant::get($db, $_POST['id'])) {
                $room->name = $_POST['chat_name'];
                $room->save($db);
                $res['result'] = 0;

                $_SESSION['chat_name'] = $_POST['chat_name'];
            } else {
                $res['result'] = 2;
                $res['msg'] = "Couldn't find the participant";
            }
        } else {
            $res['result'] = 3;
            $res['msg'] = "Chat name should be longer than 2 characters.";
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
 * Show browser download guide page.
 */
function room_message_browser() {
    $context = array();

    $context['type'] = 1;
    $context['msg']  = '<h2>Sorry,</h2>
                        Sunrise VC works on <a href="http://chrome.google.com" target="_blank">Chrome</a> and <a href="http://www.mozilla.org/en-US/firefox" target="_blank">Firefox</a> supporting WebRTC.
                        Download and install either <a href="http://chrome.google.com" target="_blank">Chrome</a> or <a href="http://www.mozilla.org/en-US/firefox" target="_blank">Firefox</a> to have vido chat on Sunrise VC.';

    sr_response('views/room/message.php', $context);
}

/**
 * Send chat invitation emails.
 */
function room_invite_email() {
    global $sr_regex_email;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $failed = array();

        if (isset($_POST['emails'])) {
            $email_list = json_decode(stripslashes($_POST['emails']));

            if (count($email_list) > 0) {
                $content = room_invite_email_content();

                foreach ($email_list as $email) {
                    if (preg_match($sr_regex_email, $email)) {
                        if (($r = sr_send_mail($email, $content)) !== null) {
                            $failed[] = array(
                                'email' => $email,
                                'error' => $r
                            );
                        }
                    } else {
                        $failed[] = array(
                            'email' => $email,
                            'error' => 'Invalid email address format'
                        );
                    }
                }
                $failed_cnt = count($failed);
                if ($failed_cnt === 0) {
                    $result['result'] = 0;
                } else {
                    $result['result'] = 2;
                    if ($failed_cnt == 1) {
                        $result['msg'] = "Failed to send an invitation email to 1 person.";
                    } else {
                        $result['msg'] = "Failed to send invitation emails to $failed_cnt people.";
                    }
                    $result['failed'] = $failed;
                }
            } else {
                $result['result'] = 1;
                $result['msg'] = 'No email address was specified';
            }
        } else {
            sr_response_error(400);
        }

        echo json_encode($result);

    } else {
        sr_response_error(404);
    }
}

function room_invite_email_content () {
    global $sr_default_chat_name;

    $content = array();
    $room_link = $_SERVER['HTTP_REFERER'];

    if (($user_name = sr_user_first_name()) === null) {
        if (($user_name = sr_user_name()) === null) {
            $user_name = $_SESSION['chat_name'];
        }
    }

    if ($user_name != $sr_default_chat_name) {
        $content['subject'] = $user_name . ' is inviting you to join the Sunrise video conference room';
        $content['body'] = 'Hi,<br/><br/>' . $user_name . ' is waiting for you in the Sunrise video conference room.<br/>Click the link below to join.<br/><br/><a href="' . $room_link . '">' . $room_link . '</a><br/><br/>Best,<br/><br/>Sunrise VC';
    } else {
        $content['subject'] = 'You were invited to join the Sunrise video conference room';
        $content['body'] = 'Hi,<br/><br/>You were invited to join the Sunrise video conference room.<br/>Click the link below to join.<br/><br/><a href="' . $room_link .'">' . $room_link . '</a><br/><br/>Best,<br/><br/>Sunrise VC';
    }

    return $content;
}

/**
 * Get informations about a user's browser.
 */
function room_get_browser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 

    $bname    = 'Unknown';
    $version  = '';

    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) { 
        $bname = 'Internet Explorer'; 
        $ub = 'MSIE'; 
    } else if(preg_match('/Firefox/i',$u_agent)) { 
        $bname = 'Mozilla Firefox'; 
        $ub = 'Firefox'; 
    } else if(preg_match('/Chrome/i',$u_agent)) { 
        $bname = 'Google Chrome'; 
        $ub = 'Chrome'; 
    } else if(preg_match('/Safari/i',$u_agent)) { 
        $bname = 'Apple Safari'; 
        $ub = 'Safari'; 
    } else if(preg_match('/Opera/i',$u_agent)) { 
        $bname = 'Opera'; 
        $ub = 'Opera'; 
    } else if(preg_match('/Netscape/i',$u_agent)) { 
        $bname = 'Netscape'; 
        $ub = 'Netscape'; 
    }

    $known   = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';

    preg_match_all($pattern, $u_agent, $matches);

    $i = count($matches['browser']);

    if ($i != 1) {
        if (strripos($u_agent, 'Version') < strripos($u_agent,$ub)) {
            $version= $matches['version'][0];
        } else {
            $version= $matches['version'][1];
        }
    } else {
        $version= $matches['version'][0];
    }

    if ($version == null || $version == '') {
        $version = '?';
    }

    return array(
        'name'      => $bname,
        'version'   => $version,
    );
} 

?>
