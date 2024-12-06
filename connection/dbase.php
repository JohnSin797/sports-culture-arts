<?php
/*fixed, no need to debug */
    $db_host = "127.0.0.1";
    $user = "root";
    $pass = "";
    $db_name = "sports_culture_arts";
    $CON = "";

    try {
    $CON = mysqli_connect($db_host, $user, $pass, $db_name);

    }
    catch(mysqli_sql_exception){
        echo "Your Offline";
    }
        if($CON){
        }
?>    