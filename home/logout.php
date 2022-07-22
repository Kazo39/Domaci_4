<?php

    include "../backend/config.php";
    session_start();
    session_destroy();
    header("location:$app_link/home/login.php");
    exit;
?>