<?php
    // Start the session
    session_start();


    // Create the constants to store non repeating values
    define('HOME_URL', 'http://127.0.0.1/PristyDelices/');
    define('LOCALHOST', '127.0.0.1');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'pristydelices');



    // Connection to the database
    $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error($conn));
    // Selecting the database
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));
?>