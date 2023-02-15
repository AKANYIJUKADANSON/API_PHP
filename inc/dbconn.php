<?php

    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "api";

    $conn = mysqli_connect($host, $user, $password, $dbname);

    // Check if the connection is okay
    // if ($conn) {
    //     echo "Connected successfully";
    // }else {
    //     die("Db connection failure: ".mysqli_connect_error());
    // }
?>