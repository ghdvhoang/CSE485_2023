<?php 
include_once '../connect/conn.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $ten_tloai = $_POST['txtCatName'];
    $ma_tloai = $_POST['txtCatId'];
    
   $query = "UPDATE theloai SET ten_tloai = '$ten_tloai' WHERE ma_tloai = $ma_tloai";
   $conn -> query($query);

   header("Location: ./category.php");
   exit();
}

$conn -> close();