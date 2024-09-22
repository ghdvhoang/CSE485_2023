<?php

include_once '../connect/conn.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $ma_bviet = $_POST['txtId'];
    $tieude = $_POST['txtTitle'];
    $ten_bhat = $_POST['txtMusic'];
    $tomtat = $_POST['txtSummary'];
    $noidung = $_POST['txtContent'];
    $ngayviet = $_POST['date'];

    // Get ma_tgia
    $tacgia = $_POST['txtAuthor'];
    $query_get_tgia = "SELECT ma_tgia FROM tacgia WHERE ten_tgia = ?";
    $stmt_tgia = $conn->prepare($query_get_tgia);
    $stmt_tgia->bind_param("s", $tacgia);
    $stmt_tgia->execute();
    $result_get_tgia = $stmt_tgia->get_result();
    $ma_tgia = intval($result_get_tgia->fetch_assoc()['ma_tgia']);

    // Get ma_tloai
    $theloai = $_POST['txtCategory'];
    $query_get_tloai = "SELECT ma_tloai FROM theloai WHERE ten_tloai = ?";
    $stmt_tloai = $conn->prepare($query_get_tloai);
    $stmt_tloai->bind_param("s", $theloai);
    $stmt_tloai->execute();
    $result_get_tloai = $stmt_tloai->get_result();
    $ma_tloai = intval($result_get_tloai->fetch_assoc()['ma_tloai']);

    // Handle file upload
    $image_path = $_FILES['image']['name'];
    $ex = ['jpg', 'png', 'jpeg'];
    $file_type = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));

    if (in_array($file_type, $ex)) {
        // Upload file to dir songs
        $target_dir = "../images/songs/";
        $target_img = $target_dir . basename($image_path);
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_img)) {
            $hinhanh = "images/songs/" . basename($image_path);
            
            // UPDATE TABLE baiviet
            $query_update = "UPDATE baiviet 
                             SET tieude = ?, ten_bhat = ?, ma_tloai = ?, tomtat = ?, noidung = ?, ma_tgia = ?, ngayviet = ?, hinhanh = ? 
                             WHERE ma_bviet = ?";
            $stmt_update = $conn->prepare($query_update);
            $stmt_update->bind_param("ssisssssi", $tieude, $ten_bhat, $ma_tloai, $tomtat, $noidung, $ma_tgia, $ngayviet, $hinhanh, $ma_bviet);
            $stmt_update->execute();

            header("Location: ./article.php");
            exit();
        } else {
            echo "File upload failed.";
        }
    } else {
        echo "Invalid file type.";
    }
}

$conn->close();
