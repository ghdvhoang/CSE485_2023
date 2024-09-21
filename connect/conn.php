<?php

$host = "localhost";
$dbname = "btth01_cse485";
$dbusername = "root";
$dbpassword = "";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if($conn -> connect_errno){
    die("Connection failed: " .$conn -> connect_errno);   
}