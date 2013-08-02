<?php

require_once (dirname(__FILE__) . '/../models/user.php');
require_once (dirname(__FILE__) . '/../include/utils.php');

$user = new User();
$user->first_name = $_POST['first_name'];
$user->last_name = $_POST['last_name'];
$user->email = $_POST['email'];
$user->password = $_POST['password'];
$user->is_authorized = 1;
$user->join_date = $user->getCurrentTime();
$user->last_active_date = $user->getCurrentTime();

try {
    $db = sr_pdo();
    $user->add($db);

} catch (PDOException $e) {

}

?>
