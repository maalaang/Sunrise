<?php

function session_open() {
    echo 'session_open';
    global $sr_db_type;
    global $sr_db_host;
    global $sr_db_name;
    global $sr_db_charset;
    global $sr_db_user;
    global $sr_db_password;

    $db = new PDO("$sr_db_type:host=$sr_db_host; dbname=$sr_db_name; charset=$sr_db_charset", $sr_db_user, $sr_db_password);

    try {
        $stmt = $db->query('SELECT * FROM session');

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            print_r($row);
        }

    } catch(PDOException $ex) {
        echo 'error';
    }
}

function session_close() {
    echo 'session_close';
}

?>
