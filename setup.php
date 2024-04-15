<?php
    $server= "localhost";
    $user ="root";
    $password = "root";
    $DB = "lab3";
    // if (!mysqli_connect($server, $user,$password))
    //     {
    //         echo "База не подключилась";
    //     }
    $obj = mysqli_connect($server, $user,$password);
    mysqli_select_db($obj, "lab3");

?>