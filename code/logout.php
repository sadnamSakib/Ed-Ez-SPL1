<?php 

include 'config.php';
$conn->close();
session_start();
session_destroy();

header("Location: index.php");

?>