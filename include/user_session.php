<?php

session_start();

if ($_SESSION['isLogged']) {
    $userName = $_SESSION['name'];
    $userEmail = $_SESSION['email'];
} else {
    sr_response('views/main/signin.php', null);
}

?>
