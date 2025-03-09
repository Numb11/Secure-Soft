<?php

$host = "localhost";
$username = "root";
$password = "root";
$database = "fakebook";
$port = 3307;

try{
    $con = new mysqli($host, $username,$password,$database,$port);

}catch (Exception $e){
    {
        echo "DB Error, please check connection and retry";
        die();
    }
}
?>