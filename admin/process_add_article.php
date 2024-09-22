<?php 
include_once '../connect/conn.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //Lấy mã bài viết
    $query_1 = "SELECT COUNT(ma_bviet) AS so_luong_bviet FROM baiviet";
    $result_1 = $conn -> query($query_1);
    $so_luong_bviet = $result_1 -> fetch_assoc()['so_luong_bviet'];
    $ma_bviet = intval($so_luong_bviet) + 1;

    //Lấy mã tác giả
    $tacgia = $_POST['txtAuthor'];
    $query_2 = "SELECT ma_tgia FROM tacgia WHERE ten_tgia = '$tacgia'";
    $result_2 = $conn -> query($query_2);
    $ma_tgia = intval($result_2 -> fetch_assoc()['ma_tgia']);

    //Lấy mã thể loại
    $theloai = $_POST['txtCategory'];
    $query_3 = "SELECT ma_tloai FROM theloai WHERE ten_tloai = '$theloai'";
    $result_3 = $conn -> query($query_3);
    $ma_tloai = intval($result_3 -> fetch_assoc()['ma_tloai']);

    $tieude = $_POST['txtTitle'];
    $ten_bhat = $_POST['txtMusic'];
    $tomtat = $_POST['txtSummary'];
    $noidung = $_POST['txtContent'];
    $ngayviet = $_POST['date'];

    $image_path = $_FILES['image']['name'];

    $ex = ['jpg', 'png', 'jpeg'];
    $file_type = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));
    if(in_array($file_type, $ex)){
        $target_dir = '../images/songs/';
        $target_img = $target_dir . basename($image_path);

        // Di chuyển file upload vào thư mục đích
        move_uploaded_file($_FILES['image']['tmp_name'], $target_img);
        //Thêm bài viết
        $hinhanh = 'images/songs/' .basename($image_path);
        $query_them_bviet = "INSERT INTO baiviet(ma_bviet, tieude, ten_bhat, ma_tloai, tomtat, noidung, ma_tgia, ngayviet, hinhanh)
                            VALUES
                            ($ma_bviet, '$tieude', '$ten_bhat', $ma_tloai, '$tomtat', '$noidung', $ma_tgia, '$ngayviet', '$hinhanh')";
        $conn->query($query_them_bviet);
        header("Location: ./article.php");
        exit();
    }

}

$conn -> close();