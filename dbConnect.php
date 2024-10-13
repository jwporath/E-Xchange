<?php
    $conn = mysqli_connect("localhost","root","","E-Xchange");
    // Check connection
    if (mysqli_connect_errno())
    {
        die("Connection failed: ".$conn->connect_error);
    }
?>