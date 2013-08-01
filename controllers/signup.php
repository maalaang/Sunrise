<?php

require_once (dirname(__FILE__) . '/../models/user.php');
require_once (dirname(__FILE__) . '/../include/utils.php');

$user = new User();

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$repeat_password = $_POST['repeat_password'];

$db = sr_pdo();
$stmt = $db->prepares('SELECT * FROM user');
$stmt->execute();

$query =
    "INSERT INTO user (first_name, last_name, email, password)" .
    "VALUES ('$first_name', '$last_name', '$email', '$password')";

$stmt = $db->query($query);

?>
