<?php

    // Authorization
    // Check whether the user is logged in or not
    if (!isset($_SESSION['user'])) { #If user is not set
        // User is not logged in
        $_SESSION['login-fail'] = "<div id='message_error'>Une connexion à votre session est requise</div>";
        header("Location:".HOME_URL."manager/login.php");
    }

?>