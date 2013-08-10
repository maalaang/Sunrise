<?php

require_once (dirname(__FILE__) . '/../models/user.php');
require_once (dirname(__FILE__) . '/../include/utils.php');

try {
    $db = sr_pdo();

    $stmt = $db->prepare('SELECT * FROM user WHERE id = :id');
    $stmt->bindParam(':id', $_POST['userId']);
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
    // Update Failed
}

?>
