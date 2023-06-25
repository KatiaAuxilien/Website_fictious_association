<?php
require_once 'lib/modele.php';
session_start();

if (isset($_SESSION['usr_auth'])) { 
    header("Location: index.php");
    session_destroy();
    exit();
}

?>