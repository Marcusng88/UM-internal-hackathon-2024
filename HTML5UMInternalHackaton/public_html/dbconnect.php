<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "kimseng";

    $connect = mysqli_connect($host,$user,$password,$dbname);

    if(!$connect){
        die("Failed to connct to database");
    }
?>