<?php

session_start();

if (!isset($_SESSION['u_id'])) {
    header("Location: ../login.php");
}

if ($_SESSION['type'] == 1) {
    session_destroy();
    header("Location: index.php");
} else {
    session_destroy();
    if (isset($_SERVER['HTTP_REFERER'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        header('Location: index.php');
    }
}



?>
