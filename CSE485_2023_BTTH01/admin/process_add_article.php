<?php 
include_once '../connect/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the number of articles
    do {
        $ma_bviet = rand(1, 1000); // Adjust range as needed
        $check_query = "SELECT COUNT(*) AS count FROM baiviet WHERE ma_bviet = $ma_bviet";
        $check_result = $conn->query($check_query);
        $count = $check_result->fetch_assoc()['count'];
    } while ($count > 0);

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

    // Handle image upload
    $image_path = $_FILES['image']['name'];
    $ex = ['jpg', 'png', 'jpeg'];
    $file_type = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));

    if (in_array($file_type, $ex)) {
        $target_dir = '../images/songs/';
        $target_img = $target_dir . basename($image_path);

        // Move the uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_img)) {
            // Prepare to insert the article
            $hinhanh = 'images/songs/' . basename($image_path);
            $query_them_bviet = "INSERT INTO baiviet (ma_bviet, tieude, ten_bhat, ma_tloai, tomtat, noidung, ma_tgia, ngayviet, hinhanh) 
                                 VALUES ($ma_bviet, '$tieude', '$ten_bhat', $ma_tloai, '$tomtat', '$noidung', $ma_tgia, '$ngayviet', '$hinhanh')";
            
            if ($conn->query($query_them_bviet) === TRUE) {
                header("Location: ./article.php");
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Error uploading image.";
        }
    } else {
        echo "Invalid file format. Only jpg, png, jpeg are allowed.";
    }
}

$conn->close();
