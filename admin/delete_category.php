<?php

include_once '../connect/conn.php';

$ma_tloai = $_GET['id'];
$query = "DELETE FROM theloai WHERE ma_tloai = $ma_tloai";
$conn -> query($query);

header("Location: ./category.php");
exit();

