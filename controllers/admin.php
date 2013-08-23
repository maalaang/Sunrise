<?php

require_once (dirname(__FILE__) . '/../models/user.php');
require_once (dirname(__FILE__) . '/../models/room.php');
require_once (dirname(__FILE__) . '/../models/room_log.php');
require_once (dirname(__FILE__) . '/../models/participant.php');
require_once (dirname(__FILE__) . '/../include/utils.php');

/**
 * Ajax request dispatcher 
 */
function admin_ajax_dispatcher() {
    switch ($_POST['page']) {
    case 'dashboard':
        admin_dashboard();
        break;
    case 'rooms':
        admin_rooms();
        break;
    case 'users':
        admin_users();
        break;
    case 'settings':
        admin_settings();
        break;
    }
}


function admin_dashboard() {
    global $sr_channel_server_uri;

    // Show Dashboard Page
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        session_start();

        if (!isset($_SESSION['is_logged']) || !$_SESSION['is_logged']) {
            $context = array();
            $context['error'] = 0;
            $context['msg'] = 'Admin authority is required to access admin pages. Please signin first.';
            sr_response('views/main/signin.php', $context);
        }

        try {
            $db = sr_pdo();

            $room_log_data = array();

            for ($i = 0; $i > -8; $i--) {
                $date = date('Y-m', strtotime($i . ' month'));
                $a_month_data = array();
                $a_month_data['period'] = $date;

                for ($j = 0; $j < 3; $j++) {
                    $filter = 'is_open=' . $j . ' AND';
                    if ($j == 0) {
                        $filter = '';
                    }

                    $stmt = $db->prepare("SELECT COUNT(*) FROM room_log
                        WHERE $filter DATE_FORMAT(start_time, '%Y-%m') BETWEEN '$date' AND '$date'");
                    $stmt->execute();

                    $result = $stmt->fetch();

                    switch ($j) {
                    case 0: $a_month_data['total'] = $result['COUNT(*)']; break;
                    case 1: $a_month_data['public'] = $result['COUNT(*)']; break;
                    case 2: $a_month_data['private'] = $result['COUNT(*)']; break;
                    }
                }

                array_push($room_log_data, $a_month_data);
            }

            $participant_log_data = array();

            for ($i = 0; $i > -8; $i--) {
                $date = date('Y-m', strtotime($i . ' month'));
                $a_month_data = array();
                $a_month_data['period'] = $date;

                for ($j = 0; $j < 3; $j++) {
                    $filter = 'is_registered_user=' . $j . ' AND';
                    if ($j == 2) {
                        $filter = '';
                    }

                    $stmt = $db->prepare("SELECT COUNT(*) FROM participant_log
                        WHERE $filter DATE_FORMAT(time, '%Y-%m') BETWEEN '$date' AND '$date'");
                    $stmt->execute();

                    $result = $stmt->fetch();

                    switch ($j) {
                    case 0: $a_month_data['non-member'] = $result['COUNT(*)']; break;
                    case 1: $a_month_data['member'] = $result['COUNT(*)']; break;
                    case 2: $a_month_data['total'] = $result['COUNT(*)']; break;
                    }
                }

                array_push($participant_log_data, $a_month_data);
            }
            $context = array(
                'room_log_data' => $room_log_data,
                'participant_log_data' => $participant_log_data,
                'sr_channel_server_uri' => $sr_channel_server_uri
            );

            sr_response('views/admin/dashboard.php', $context);

        } catch (PDOException $e) {

        }
    // Handling Ajax Request (Pagination)
    } else {

    }
}


function admin_rooms() {
    // Show Rooms Page
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        session_start();

        if (!isset($_SESSION['is_logged']) || !$_SESSION['is_logged']) {
            $context = array();
            $context['error'] = 0;
            $context['msg'] = 'Admin authority is required to access admin pages. Please signin first.';
            sr_response('views/main/signin.php', $context);
        }

        $db = sr_pdo();

        $stmt = $db->prepare('SELECT * FROM room LIMIT 10');
        $stmt->execute();

        $room_list = $stmt->fetchAll(PDO::FETCH_CLASS, 'Room');

        $stmt = $db->prepare('SELECT * FROM room_log LIMIT 10');
        $stmt->execute();

        $room_log_list = $stmt->fetchAll(PDO::FETCH_CLASS, 'RoomLog');

        $context = array(
            'room_list' => $room_list,
            'room_log_list' => $room_log_list
        );

        sr_response('views/admin/rooms.php', $context);

    // Handling Ajax Request
    } else {
        // Pagination or Filtering
        if ($_POST['type'] == 'pagination') {
            try {
                $db = sr_pdo();

                $json = $_POST['filter'];
                $json = stripslashes($json);
                $filter = json_decode($json);

                $where = '';
                $index = 0;
                foreach ($filter as $field => $value) {
                    if ($index++ == 0) {
                        $where .= 'WHERE ';
                    } else {
                        $where .= ' AND ';
                    }
                    $where .= $field . '=' . $value;
                }

                if ($_POST['table'] == 't1') {
                    $total_record_number = Room::getRecordNum($filter);
                } else {
                    $total_record_number = RoomLog::getRecordNum($filter);
                }

                if ($_POST['page_number'] == -1) {
                    $beginRecordNum = (int)($total_record_number / 10) * 10;
                } else {
                    $beginRecordNum = ($_POST['page_number'] - 1) * 10;
                }

                if ($_POST['table'] == 't1') {
                    $stmt = $db->prepare("SELECT * FROM room $where LIMIT $beginRecordNum, 10");
                    $stmt->execute();

                    $record_list = $stmt->fetchAll(PDO::FETCH_CLASS, 'Room');
                } else {
                    $stmt = $db->prepare("SELECT * FROM room_log $where LIMIT $beginRecordNum, 10");
                    $stmt->execute();

                    $record_list = $stmt->fetchAll(PDO::FETCH_CLASS, 'RoomLog');
                }

                $result = array(
                    'record_list' => $record_list,
                    'total_record_number' => $total_record_number
                );

                echo json_encode($result);

            } catch (PDOException $e) {

            }

        // Close Room Request
        } else {
            // TODO: Write History
            try {
                $db = sr_pdo();

                $stmt = $db->prepare('SELECT * FROM room WHERE id = :id');
                $stmt->bindParam(':id', $_POST['id']);
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'Room');
                $stmt->execute();

                $user = $stmt->fetch();

                $result = $user->close($db);

            } catch (PDOException $e) {

            }
        }
    }
}


function admin_users() {
    // Show Users Page
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        session_start();

        if (!isset($_SESSION['is_logged']) || !$_SESSION['is_logged']) {
            $context = array();
            $context['error'] = 0;
            $context['msg'] = 'Admin authority is required to access admin pages. Please signin first.';
            sr_response('views/main/signin.php', $context);
        }

        $db = sr_pdo();

        $stmt = $db->prepare('SELECT * FROM user LIMIT 10');
        $stmt->execute();

        $user_list = $stmt->fetchAll(PDO::FETCH_CLASS, 'User');

        $context = array(
            'user_list' => $user_list
        );

        sr_response('views/admin/users.php', $context);

    // Handling Ajax Request
    } else {
        // Pagination or Filtering
        if ($_POST['type'] == 'pagination') {
            try {
                $db = sr_pdo();

                $json = $_POST['filter'];
                $json = stripslashes($json);
                $filter = json_decode($json);

                $where = '';
                $index = 0;
                foreach ($filter as $field => $value) {
                    if ($index++ == 0) {
                        $where .= 'WHERE ';
                    } else {
                        $where .= ' AND ';
                    }
                    $where .= $field . '=' . $value;
                }

                $total_record_number = User::getRecordNum($filter);

                if ($_POST['page_number'] == -1) {
                    $beginRecordNum = (int)($total_record_number / 10) * 10;
                } else {
                    $beginRecordNum = ($_POST['page_number'] - 1) * 10;
                }

                $stmt = $db->prepare("SELECT * FROM user $where LIMIT $beginRecordNum, 10");
                $stmt->execute();

                $user_list = $stmt->fetchAll(PDO::FETCH_CLASS, 'User');

                $result = array(
                    'user_list' => $user_list,
                    'total_record_number' => $total_record_number
                );

                echo json_encode($result);

            } catch (PDOException $e) {

            }
        // Update Authorized or Admin Authority
        } else {
            try {
                $db = sr_pdo();

                $stmt = $db->prepare('SELECT * FROM user WHERE id = :id');
                $stmt->bindParam(':id', $_POST['id']);
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
                $stmt->execute();

                $user = $stmt->fetch();

                if ($_POST['type'] == 'authorized') {
                    if ($_POST['checked'] == 'checked') {
                        $user->is_authorized = 1;
                    } else {
                        $user->is_authorized = 0;
                    }
                } else {
                    if ($_POST['checked'] == 'checked') {
                        $user->is_admin = 1;
                    } else {
                        $user->is_admin = 0;
                    }
                }

                $result = $user->save($db);

            } catch (PDOException $e) {

            }
        }
    }
}


function admin_settings() {
    session_start();

    if (!isset($_SESSION['is_logged']) || !$_SESSION['is_logged']) {
        $context = array();
        $context['error'] = 0;
        $context['msg'] = 'Admin authority is required to access admin pages. Please signin first.';
        sr_response('views/main/signin.php', $context);
    }

    sr_response('views/admin/settings.php', null);
}


?>
