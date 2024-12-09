<?php
    // connect to database : 
    $connect = mysqli_connect("localhost", "root", "", "restaurant");
    if(!$connect){
        // display error : 
        echo "Connection Failed: " . mysqli_error($connect);
    }
?>