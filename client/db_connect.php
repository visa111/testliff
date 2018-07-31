<?php 


$link = mysqli_connect("localhost", "root", "tor111","helpdesk");

if (!$link->set_charset("utf8")) {
//    printf("Error loading character set utf8: %s\n", $mysqli->error);
    exit();
} else {
//    printf("Current character set: %s\n", $link->character_set_name());
}

date_default_timezone_set('Asia/Bangkok');
?>




