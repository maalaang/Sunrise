<?php

require_once (dirname(__FILE__) . '/../models/user.php');
require_once (dirname(__FILE__) . '/../include/utils.php');

if (fetchUser($user)) {
    echo 'Login Success';
}

function fetchUser($user) {
    $db = sr_pdo();

    try {
        $stmt = $db->prepare('SELECT * FROM user WHERE email = :email');
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $stmt->execute();

        $user = $stmt->fetch();

    } catch (PDOException $e) {
        echo 'Exception';
        return false;
    }

    if ($user == Null || $user == false) {
        echo 'Couldn\'t Find Email Address';
        return false;
    } 

    if ($user->password != $_POST['password']) {
        echo 'Wrong Password';
        return false;
    }
    
    return true;
}

?>
