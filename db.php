<?php
$servername = "localhost";
$username = "root";
$password = ""; // Không có mật khẩu (trên localhost mặc định là vậy)
$dbname = "btth01_cse485_ex"; // Tên của cơ sở dữ liệu

// Kết nối tới MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
} else {
    echo "Kết nối thành công với cơ sở dữ liệu";
}

$conn->close();
