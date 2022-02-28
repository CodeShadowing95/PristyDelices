<?php

// Authorization
// Check whether the user is logged in or not
if(!isset($_SESSION['user'])) {
    // $_SESSION['login_fail'] = "<span style='color:red;font-weight:bold;'>Une connexion à votre session est requise!</span>";
    header("Location: auth/sign_in.php");
    exit();
}