<?php

include_once '../connect/conn.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $name = $_POST['txtCatName'];
    $ma_tgia = $_POST['txtCatId'];

    // Lấy đường dẫn của file
    $image_path = $_FILES['image']['name'];

    $ex = ['jpg', 'png', 'jpeg'];
    $file_type = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));

    if (in_array($file_type, $ex)) {
        $target_dir = '../images/author/';
        $target_img = $target_dir . basename($image_path);

        // Di chuyển file upload vào thư mục đích
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_img)) {
            // Sửa tác giả
            $query_1 = "UPDATE tacgia SET ten_tgia = '$name', hinh_anh = '$target_img' WHERE ma_tgia = $ma_tgia";
            $conn->query($query_1);
        }

        header('Location: ./author.php');
        exit();
    } else {
        echo "Định dạng file không hợp lệ. Chỉ chấp nhận jpg, png, jpeg.";
    }
}

$conn->close();

