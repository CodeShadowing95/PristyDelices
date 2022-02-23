<?php
    // Include constants.php file
    include("config/constants.php");

    // Destroy the session
    session_destroy(); #unset the session user

    header("Location:".HOME_URL);
?>