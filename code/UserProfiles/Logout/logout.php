<?php 

include '../../LibraryFiles/DatabaseConnection/config.php';
session_destroy();

header("Location: ../../index.php");

?>