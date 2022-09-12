<?php
    $servername = "localhost";
    $username = "UserManager";
    $password = "codingParina#23931";
    $dbname = "user";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    error_reporting(0);

    session_start();

    if (isset($_SESSION['username'])) {
        header("Location: ../Profile/index.php");
    }


?>