<?php 
include_once '../connect/conn.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $query = "DELETE FROM baiviet WHERE ma_bviet = $id ";
    $conn -> query($query);

    header("Location: ./article.php");
    exit();
}

$conn -> close();  