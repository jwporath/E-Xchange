<?php
    session_start();
    if(isset($_SESSION["username"])) 
    {
        $_SESSION = array(); // clear array data
        session_destroy(); // delete session
    }
    header("Location: index.php");
?>