<?php

require_once (dirname(__FILE__) . '/../models/user.php');
require_once (dirname(__FILE__) . '/../include/utils.php');

$user = new User();

$user->first_name = $_POST['first_name'];
$user->last_name = $_POST['last_name'];
$user->email = $_POST['email'];
$user->password = $_POST['password'];
$user->is_authorized = 1;
$user->join_date = Model::getCurrentTime();
$user->last_active_date = Model::getCurrentTime();

$db = sr_pdo();

$id = $user->add($db);

if(!is_numeric($id)) {

    $user->reorder_id($db);

    if($id == '#23000') {
        echo 'Error 23000: The Email Adrress is Already Exist.';
    }
}

?>
