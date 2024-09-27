<?php
include_once '../connect/conn.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $name = $_POST['txtCatName'];
    //Lấy đường dẫn của file
    $image_path = $_FILES['image']['name'];

    $ex = ['jpg', 'png', 'jpeg'];
    $file_type = strtolower(pathinfo($image_path,PATHINFO_EXTENSION));
    if(in_array($file_type, $ex)){
        $target_dir = '../images/author/';
        $target_img = $target_dir . basename($image_path);

        move_uploaded_file($_FILES['image']['tmp_name'], $target_img);
        
        // Lấy số lượng tác giả
        $query = "SELECT COUNT(ma_tgia) AS so_luong_tgia from tacgia";
        $result = $conn -> query($query);
        $so_luong_tgia = $result -> fetch_assoc();
        $ma_tgia = intval($so_luong_tgia['so_luong_tgia']) + 1;
        //Thêm tác giả
        $query_1 = "INSERT INTO tacgia(ma_tgia, ten_tgia, hinh_anh) VALUES ($ma_tgia, '$name' ,'$target_img')";
        $conn -> query($query_1);

        header('Location: ./author.php');
        exit();
    }
}

$conn -> close();
