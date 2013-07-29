<?php

/**
 * Display session list.
 */
function admin_session_list() {
    $db = sr_pdo();

    $stmt = $db->prepare('SELECT * FROM session');
    $stmt->execute();

    $session_list = $stmt->fetchAll(PDO::FETCH_CLASS, 'Session');

    $context = array(
        'session_list' => $session_list,
    );

    sr_response('views/admin/session/session_list.php', $context);
}

?>
