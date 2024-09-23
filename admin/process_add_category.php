<?php

include_once '../connect/conn.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $ten_tloai = $_POST['txtCatName'];
    //đếm số lượng thê loại
    $query = "SELECT COUNT(ma_tloai) AS so_luong_tloai FROM theloai";
    $result = $conn -> query($query);

    if($result -> num_rows > 0){
        $so_luong_tloai = $result -> fetch_assoc();
        $ma_tloai = $so_luong_tloai['so_luong_tloai'] + 1;

        $query_2 = "INSERT INTO theloai(ma_tloai, ten_tloai) VALUES($ma_tloai, '$ten_tloai')";
        $conn -> query($query_2);

        header("Location: ./category.php");
        exit();
    }
}
$conn -> close();