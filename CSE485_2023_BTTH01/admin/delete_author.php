<?php 
include_once '../connect/conn.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $query_1 = "DELETE FROM baiviet WHERE ma_tgia = $id ";
    $conn -> query($query_1);

    $query = "DELETE FROM tacgia WHERE ma_tgia = $id ";
    $conn -> query($query);

    header("Location: ./author.php");
    exit();
}

$conn -> close();   