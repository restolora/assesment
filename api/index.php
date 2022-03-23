<?php
     require('./includes/class-autoloader.inc.php');
    $conn = new dbconnect();
    if($conn) echo 'connected';
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");

?>