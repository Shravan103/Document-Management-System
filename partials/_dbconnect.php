<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "dms";
    $conn = mysqli_connect($servername, $username, $password, $db);
    if(!$conn)
    {
        die("connection to database $db failed.<br>Error type --> ".mysqli_connect_error());
    }

?>