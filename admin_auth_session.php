<?php
    if(!isset($_SESSION["username"])) 
    {
        header("Location: signin.php");
        exit();
    }
    else if ($_SESSION["username"] != "admin")
    {
        header("Location: index.php");
        exit();
    }
?>