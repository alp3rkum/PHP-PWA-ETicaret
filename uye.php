<?php
    if (!isset($_SESSION['user_id'])) {
        header("Location: /");
        exit();
    }
    else
    {
        $userid = $_SESSION['user_id'];
        $user = $database->select("* FROM kullanicilar WHERE id = $userid");
        if(!$user)
        {
            session_start();
            session_destroy();
            header("Location: /giris");
            exit();
        }
    }
?>