<?php
include_once '../connect/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get article ID
    $ma_bviet = $_POST['id'];

    // Get author ID
    $tacgia = $_POST['txtAuthor'];
    $query_2 = "SELECT ma_tgia FROM tacgia WHERE ten_tgia = '$tacgia'";
    $result_2 = $conn->query($query_2);
    if ($result_2->num_rows > 0) {
        $ma_tgia = intval($result_2->fetch_assoc()['ma_tgia']);
    } else {
        die("Author not found.");
    }

    // Get category ID
    $theloai = $_POST['txtCategory'];
    $query_3 = "SELECT ma_tloai FROM theloai WHERE ten_tloai = '$theloai'";
    $result_3 = $conn->query($query_3);
    if ($result_3->num_rows > 0) {
        $ma_tloai = intval($result_3->fetch_assoc()['ma_tloai']);
    } else {
        die("Category not found.");
    }

    // Get other form data
    $tieude = $_POST['txtTitle'];
    $ten_bhat = $_POST['txtMusic'];
    $tomtat = $_POST['txtSummary'];
    $noidung = $_POST['txtContent'];
    $ngayviet = $_POST['date'];

    // Get the uploaded file information
    $img_path = $_FILES['image']['name'];
    $target_img = null;

    // Check if an image was uploaded
    if (!empty($img_path)) {
        $ex = ['jpg', 'png', 'jpeg']; // Fix the valid extensions
        $file_type = strtolower(pathinfo($img_path, PATHINFO_EXTENSION)); // Use correct variable $img_path

        // Validate the file type
        if (in_array($file_type, $ex)) {
            $target_dir = '../images/songs/';
            $target_img = $target_dir . basename($img_path);

            // Move the uploaded file to the directory
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_img)) {
                echo "ERROR: Failed to upload the image.";
                exit();
            } else {
                $hinhanh = 'images/songs/' . basename($img_path);
            }
        } else {
            echo "Lỗi định dạng file.";
            exit();
        }
    }

    // Prepare the query based on whether an image was uploaded
    if ($target_img) {
        $query = "UPDATE baiviet 
                  SET tieude = '$tieude', ten_bhat = '$ten_bhat', ma_tloai = $ma_tloai, 
                      ma_tgia = $ma_tgia, ngayviet = '$ngayviet', noidung = '$noidung', 
                      tomtat = '$tomtat', hinhanh = '$hinhanh' 
                  WHERE ma_bviet = '$ma_bviet'";
    } else {
        $query = "UPDATE baiviet 
                  SET tieude = '$tieude', ten_bhat = '$ten_bhat', ma_tloai = $ma_tloai, 
                      ma_tgia = $ma_tgia, ngayviet = '$ngayviet', noidung = '$noidung', 
                      tomtat = '$tomtat' 
                  WHERE ma_bviet = '$ma_bviet'";
    }

    // Execute the query
    if ($conn->query($query) === TRUE) {
        header("Location: ./article.php");
        exit();
    } else {
        echo "ERROR: " . $conn->error;
    }
}

$conn->close();