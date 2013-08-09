<?php

session_start();

if ($_SESSION['isLogged']) {
    $userName = $_SESSION['name'];
    $userEmail = $_SESSION['email'];
} else {
    $userName = 'Unknown';
    $userEmail = 'Unknown';
}

?>
