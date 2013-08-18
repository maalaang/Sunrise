<?php

session_start();

if ($_SESSION['is_logged']) {
    $userName = $_SESSION['user_name'];
    $userEmail = $_SESSION['user_email'];
} else {
    sr_response('views/main/signin.php', null);
}

?>
