<?php
    // ini_set('display_errors', 0);
    // error_reporting(0);
    
    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['id'])){
        header("Location: index.php");
        exit();
    }
?> 